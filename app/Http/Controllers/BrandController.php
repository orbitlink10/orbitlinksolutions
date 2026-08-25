<?php

namespace App\Http\Controllers;

use App\Models\Product;

class BrandController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->where('product_type', 'product')
            ->get();

        $brands = $products
            ->groupBy(fn ($product) => orbit_product_brand($product) ?: 'Other')
            ->forget('Other')
            ->map(fn ($items, $brand) => [
                'name' => $brand,
                'slug' => \Illuminate\Support\Str::slug($brand),
                'count' => $items->count(),
                'sample' => $items->first(),
            ])
            ->sortBy('name')
            ->values();

        return view('theme.' . get_option('theme') . '.brands', compact('brands'));
    }

    public function show(string $brand)
    {
        $label = $this->labelFromSlug($brand);
        $needles = $this->needlesForLabel($label);

        $products = Product::with(['mediaFiles', 'category'])
            ->where('product_type', 'product')
            ->where(function ($query) use ($label, $needles) {
                $query->where('brand_name', 'like', '%' . $label . '%');

                foreach ($needles as $needle) {
                    $query->orWhere('name', 'like', '%' . $needle . '%')
                        ->orWhere('description', 'like', '%' . $needle . '%');
                }
            })
            ->latest('id')
            ->paginate(12);

        abort_if($products->total() === 0, 404);

        return view('theme.' . get_option('theme') . '.brand', compact('products', 'label', 'brand'));
    }

    private function labelFromSlug(string $slug): string
    {
        foreach (orbit_brand_candidates() as $needle => $label) {
            if (\Illuminate\Support\Str::slug($label) === $slug || \Illuminate\Support\Str::slug($needle) === $slug) {
                return $label;
            }
        }

        return \Illuminate\Support\Str::headline(str_replace('-', ' ', $slug));
    }

    private function needlesForLabel(string $label): array
    {
        $needles = [$label];

        foreach (orbit_brand_candidates() as $needle => $candidateLabel) {
            if ($candidateLabel === $label) {
                $needles[] = $needle;
            }
        }

        return array_values(array_unique($needles));
    }
}
