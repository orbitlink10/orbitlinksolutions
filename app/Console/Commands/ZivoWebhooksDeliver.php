<?php

namespace App\Console\Commands;

use App\Models\ZivoWebhookEvent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Throwable;

class ZivoWebhooksDeliver extends Command
{
    protected $signature = 'zivo:webhooks-deliver {--limit=100} {--retry-failed : Requeue exhausted events for this store}';

    protected $description = 'Deliver due Zivo outbox events using signed HTTPS requests and bounded retries';

    public function handle(): int
    {
        if (! config('zivo.webhooks.enabled')) {
            $this->comment('Zivo webhooks are disabled.');

            return self::SUCCESS;
        }
        $url = config('zivo.webhooks.url');
        $secret = config('zivo.webhooks.secret');
        if (! is_string($url) || ! filter_var($url, FILTER_VALIDATE_URL)
            || parse_url($url, PHP_URL_SCHEME) !== 'https'
            || parse_url($url, PHP_URL_USER) || parse_url($url, PHP_URL_FRAGMENT)
            || ! is_string($secret) || strlen($secret) < 32) {
            $this->error('Configure an HTTPS ZIVO_WEBHOOK_URL and a ZIVO_WEBHOOK_SECRET of at least 32 characters.');

            return self::FAILURE;
        }
        $limit = filter_var($this->option('limit'), FILTER_VALIDATE_INT);
        if ($limit === false || $limit < 1 || $limit > 1000) {
            $this->error('Use --limit=1 through 1000.');

            return self::FAILURE;
        }
        if ($this->option('retry-failed')) {
            ZivoWebhookEvent::where('store_id', config('zivo.store_id'))->whereNotNull('failed_at')
                ->update(['failed_at' => null, 'attempts' => 0, 'available_at' => now(), 'locked_until' => null]);
        }

        $delivered = 0;
        $failed = 0;
        for ($i = 0; $i < $limit; $i++) {
            // Lease rows in a short transaction; crashed workers can be retried after two minutes.
            $event = DB::transaction(function () {
                $event = ZivoWebhookEvent::where('store_id', config('zivo.store_id'))
                    ->whereNull('delivered_at')->whereNull('failed_at')
                    ->where('available_at', '<=', now())
                    ->where(fn ($query) => $query->whereNull('locked_until')->orWhere('locked_until', '<=', now()))
                    ->orderBy('available_at')->orderBy('id')->lockForUpdate()->first();
                if ($event) {
                    $event->update(['locked_until' => now()->addMinutes(2), 'attempts' => $event->attempts + 1]);
                }

                return $event;
            });
            if (! $event) {
                break;
            }

            $timestamp = (string) now()->timestamp;
            $signature = hash_hmac('sha256', $timestamp.'.'.$event->payload, $secret);
            $error = null;
            try {
                $response = Http::connectTimeout(5)->timeout(15)->withoutRedirecting()
                    ->withHeaders([
                        'X-Zivo-Event-Id' => $event->id,
                        'X-Zivo-Timestamp' => $timestamp,
                        'X-Zivo-Signature' => 'sha256='.$signature,
                    ])->withBody($event->payload, 'application/json')->post($url);
                if (! $response->successful()) {
                    $error = 'HTTP '.$response->status();
                }
            } catch (Throwable $exception) {
                // Do not persist response bodies, secrets or destination query strings.
                $error = class_basename($exception);
            }

            if ($error === null) {
                $event->update(['delivered_at' => now(), 'locked_until' => null, 'last_error' => null]);
                $delivered++;

                continue;
            }
            $backoff = config('zivo.webhooks.backoff');
            $event->update([
                'last_error' => $error,
                'locked_until' => null,
                'failed_at' => $event->attempts >= config('zivo.webhooks.max_attempts') ? now() : null,
                'available_at' => now()->addSeconds($backoff[min($event->attempts - 1, count($backoff) - 1)]),
            ]);
            $failed++;
        }
        $this->info("Delivered: {$delivered}; failed attempts: {$failed}.");

        return $failed ? self::FAILURE : self::SUCCESS;
    }
}
