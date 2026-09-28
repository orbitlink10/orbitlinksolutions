<?php

namespace App\Observers;

use App\Models\Product;
use App\Services\Zivo\WebhookOutbox;

class ZivoProductObserver
{
    public function created(Product $product): void
    {
        if (($product->product_type ?? 'product') === 'product') {
            app(WebhookOutbox::class)->record($product, 'product.created');
        }
    }

    public function updated(Product $product): void
    {
        $outbox = app(WebhookOutbox::class);
        if (($product->product_type ?? 'product') !== 'product') {
            if ($product->getOriginal('product_type') === 'product') {
                $outbox->record($product, 'product.deleted');
            }

            return;
        }
        $outbox->record($product, 'product.updated');
        if ($product->wasChanged(['quantity', 'stock', 'stock_status'])) {
            $outbox->record($product, 'inventory.updated');
        }
    }

    public function deleted(Product $product): void
    {
        if (($product->product_type ?? 'product') === 'product') {
            app(WebhookOutbox::class)->record($product, 'product.deleted');
        }
    }
}
