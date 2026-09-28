<?php

namespace App\Services\Zivo;

use App\Models\Option;
use App\Models\Product;
use Illuminate\Support\Collection;

class ProductPayload
{
    public function collection(Collection $products): array
    {
        $keys = $products->map(fn ($product) => product_additional_information_option_key($product->id));
        $specifications = $keys->isEmpty() ? collect() : Option::whereIn('option_key', $keys)
            ->pluck('option_value', 'option_key');

        return $products->map(function (Product $product) use ($specifications) {
            $rows = parse_product_additional_information(
                $specifications->get(product_additional_information_option_key($product->id))
            );

            return [
                'id' => (string) $product->id,
                'sku' => $product->sku ?: null,
                'name' => $product->name,
                'description' => $this->plainText($product->description),
                'category' => $product->category?->name,
                'price' => $product->has_price && $product->price !== null
                    ? number_format((float) $product->price, 2, '.', '') : null,
                'currency' => config('zivo.currency'),
                'tax_included' => config('zivo.tax_included') === null ? null
                    : filter_var(config('zivo.tax_included'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
                'availability' => $this->availability($product),
                'stock_quantity' => $product->quantity !== null && $product->quantity >= 0
                    ? (int) $product->quantity : null,
                'product_url' => $product->slug
                    ? $this->url(route('product_details', $product->slug, false)) : null,
                'image_url' => $this->imageUrl($product),
                'specifications' => (object) collect($rows)->pluck('value', 'label')->all(),
                // Existing sizes have no independent SKU, price or stock fields.
                'variants' => $product->sizes->map(fn ($size) => [
                    'id' => (string) $size->id,
                    'sku' => null,
                    'options' => ['size' => $size->name],
                    'price' => null,
                    'availability' => null,
                ])->values()->all(),
                'is_active' => ! $product->trashed() && (bool) $product->is_active,
                'updated_at' => $product->updated_at?->copy()->utc()->toIso8601ZuluString(),
                'deleted_at' => $product->deleted_at?->copy()->utc()->toIso8601ZuluString(),
            ];
        })->values()->all();
    }

    public function url(string $path): string
    {
        return rtrim(config('zivo.public_url'), '/').'/'.ltrim($path, '/');
    }

    private function availability(Product $product): string
    {
        $status = str_replace(' ', '_', strtolower(trim((string) $product->stock_status)));
        switch ($status) {
            case 'in_stock':
            case 'low_stock':
                return 'in_stock';
            case 'out_of_stock':
                return 'out_of_stock';
            case 'preorder':
                return 'preorder';
            case 'available_on_request':
                return 'unknown';
        }
        if ($product->quantity === null || $product->quantity < 0) {
            return 'unknown';
        }

        return $product->quantity == 0 ? 'out_of_stock' : 'in_stock';
    }

    private function plainText(?string $html): ?string
    {
        if ($html === null) {
            return null;
        }
        $text = preg_replace('~<(script|style)\b[^>]*>.*?</\1>~is', '', $html);
        $text = preg_replace('~<(?:br\s*/?|/p|/div|/li|/tr)>~i', "\n", $text);

        return trim(html_entity_decode(strip_tags($text), ENT_QUOTES | ENT_HTML5, 'UTF-8')) ?: null;
    }

    private function imageUrl(Product $product): ?string
    {
        $paths = collect([$product->photo])->merge($product->mediaFiles
            ->filter(fn ($media) => $media->media_type !== 'product_brochure')
            ->pluck('file_path'));
        foreach ($paths->filter() as $path) {
            $extension = strtolower(pathinfo(parse_url($path, PHP_URL_PATH) ?: $path, PATHINFO_EXTENSION));
            if (! in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif'], true)) {
                continue;
            }
            $relative = uploaded_image_relative_path($path);
            if ($relative && uploaded_image_file_path($relative)) {
                return $this->url('/images').'?path='.rawurlencode($relative);
            }
            if (filter_var($path, FILTER_VALIDATE_URL) && in_array(parse_url($path, PHP_URL_SCHEME), ['http', 'https'], true)) {
                return $path;
            }
        }

        return null;
    }
}
