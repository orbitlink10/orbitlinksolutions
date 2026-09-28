<?php

namespace App\Services\Zivo;

use App\Models\Product;
use App\Models\ZivoWebhookEvent;
use Illuminate\Support\Str;

class WebhookOutbox
{
    public function record(Product $product, string $type): void
    {
        if (! config('zivo.webhooks.enabled')) {
            return;
        }
        $id = (string) Str::uuid();
        $payload = [
            'event_id' => $id,
            'store_id' => config('zivo.store_id'),
            'type' => $type,
            'product_id' => (string) $product->id,
            'timestamp' => now()->utc()->toIso8601ZuluString(),
        ];
        ZivoWebhookEvent::create([
            'id' => $id,
            'store_id' => $payload['store_id'],
            'product_id' => $product->id,
            'type' => $type,
            'payload' => json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR),
            'available_at' => now(),
        ]);
    }
}
