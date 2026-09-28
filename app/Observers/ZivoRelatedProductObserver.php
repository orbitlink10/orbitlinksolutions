<?php

namespace App\Observers;

use App\Models\Category;
use App\Models\Option;
use App\Models\Product;
use App\Services\Zivo\WebhookOutbox;
use Illuminate\Database\Eloquent\Model;

class ZivoRelatedProductObserver
{
    public function saved(Model $model): void
    {
        $this->touchProducts($model);
    }

    public function deleted(Model $model): void
    {
        if (! $model instanceof Category) {
            $this->touchProducts($model);
        }
    }

    public function deleting(Model $model): void
    {
        // Database cascades don't fire Product observers.
        if (config('zivo.webhooks.enabled') && $model instanceof Category) {
            Product::where('category_id', $model->id)->where('product_type', 'product')
                ->eachById(fn ($product) => app(WebhookOutbox::class)->record($product, 'product.deleted'));
        }
    }

    private function touchProducts(Model $model): void
    {
        // Keep updated_since accurate even while outbound delivery is disabled.
        $query = Product::where('product_type', 'product');
        if ($model instanceof Category) {
            $query->where('category_id', $model->id);
        } elseif ($model instanceof Option) {
            $ids = [];
            foreach ([$model->option_key, $model->getOriginal('option_key')] as $key) {
                if (preg_match('/^product_additional_information_(\d+)$/D', (string) $key, $matches)) {
                    $ids[] = $matches[1];
                }
            }
            if (! $ids) {
                return;
            }
            $query->whereIn('id', array_unique($ids));
        } else {
            $query->whereIn('id', array_filter([$model->product_id, $model->getOriginal('product_id')]));
        }
        $query->eachById(function ($product) {
            $product->touch();
            // MySQL timestamps have second precision; two changes may share a timestamp.
            if (! $product->wasChanged('updated_at')) {
                app(WebhookOutbox::class)->record($product, 'product.updated');
            }
        });
    }
}
