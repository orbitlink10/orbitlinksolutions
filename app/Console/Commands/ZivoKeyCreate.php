<?php

namespace App\Console\Commands;

use App\Models\ZivoApiKey;
use Illuminate\Console\Command;

class ZivoKeyCreate extends Command
{
    protected $signature = 'zivo:key-create {name=Zivo integration} {--days=30 : Expiry in days (1-365)}';

    protected $description = 'Create a store-only read key; print the secret once to this terminal';

    public function handle(): int
    {
        $days = filter_var($this->option('days'), FILTER_VALIDATE_INT);
        if ($days === false || $days < 1 || $days > 365 || ! config('zivo.store_id')) {
            $this->error('Use --days=1 through 365 and configure ZIVO_STORE_ID.');

            return self::FAILURE;
        }

        $secret = 'zivo_'.bin2hex(random_bytes(32));
        $key = ZivoApiKey::create([
            'name' => $this->argument('name'),
            'store_id' => config('zivo.store_id'),
            'key_hash' => hash('sha256', $secret),
            'expires_at' => now()->addDays($days),
        ]);

        $this->info('Key ID: '.$key->id.'; expires: '.$key->expires_at->toIso8601String());
        $this->line($secret);
        $this->comment('Shown once. Share using a password manager or another agreed secure channel.');

        return self::SUCCESS;
    }
}
