<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Product;
use App\Services\Zivo\ProductPayload;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ZivoController extends Controller
{
    public function index(Request $request, ProductPayload $payload)
    {
        $timestamp = function ($attribute, $value, $fail) {
            if (! is_string($value) || ! preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}(?:\.\d{1,6})?(?:Z|[+-]\d{2}:\d{2})$/D', $value)) {
                $fail('Use an ISO-8601 timestamp with a timezone.');

                return;
            }
            $parsed = date_parse($value);
            if ($parsed['error_count'] || $parsed['warning_count']) {
                $fail('The timestamp is not a valid date.');
            }
        };
        $input = $request->validate([
            'search' => ['sometimes', 'required', 'string', 'max:200'],
            'page' => ['sometimes', 'required', 'integer', 'min:1', 'max:1000000'],
            'per_page' => ['sometimes', 'required', 'integer', 'min:1', 'max:100'],
            'updated_since' => ['sometimes', 'required', $timestamp],
            'updated_until' => ['sometimes', 'required', $timestamp],
            'after_id' => ['sometimes', 'required', 'integer', 'min:0'],
            'max_id' => ['sometimes', 'required', 'integer', 'min:0'],
        ]);
        $until = isset($input['updated_until']) ? CarbonImmutable::parse($input['updated_until'])->utc() : CarbonImmutable::now('UTC');
        $since = isset($input['updated_since']) ? CarbonImmutable::parse($input['updated_since'])->utc() : null;
        if ($since && $since->greaterThan($until)) {
            throw ValidationException::withMessages(['updated_since' => 'Must be before or equal to updated_until.']);
        }

        $query = Product::withTrashed()->where('product_type', 'product');
        $maxId = $input['max_id'] ?? ((clone $query)->max('id') ?? 0);
        $query->where('id', '<=', $maxId)->where('updated_at', '<=', $until->format('Y-m-d H:i:s'));
        if ($since) {
            // Inclusive seconds deliberately replay boundary updates instead of losing them.
            $query->where('updated_at', '>=', $since->format('Y-m-d H:i:s'));
        }
        if (isset($input['search'])) {
            $search = '%'.str_replace(['!', '%', '_'], ['!!', '!%', '!_'], trim($input['search'])).'%';
            $query->where(function ($query) use ($search) {
                foreach (['name', 'sku', 'description', 'brand_name', 'model_number'] as $column) {
                    $query->orWhereRaw($column." LIKE ? ESCAPE '!'", [$search]);
                }
            });
        }

        $total = (clone $query)->count();
        $page = (int) ($input['page'] ?? 1);
        $perPage = (int) ($input['per_page'] ?? 20);
        if (isset($input['after_id'])) {
            $query->where('id', '>', $input['after_id']);
        } else {
            $query->skip(($page - 1) * $perPage);
        }
        $products = $query->with(['category', 'sizes', 'mediaFiles'])->orderBy('id')->take($perPage + 1)->get();
        $hasMore = $products->count() > $perPage;
        $products = $products->take($perPage);
        $next = $hasMore ? $payload->url('/api/zivo/v1/products').'?'.http_build_query(array_merge($input, [
            'page' => $page + 1,
            'per_page' => $perPage,
            'after_id' => $products->last()->id,
            'max_id' => $maxId,
            'updated_until' => $until->toIso8601ZuluString(),
        ])) : null;

        return response()->json([
            'data' => $payload->collection($products),
            'meta' => [
                'store_id' => config('zivo.store_id'),
                'page' => $page,
                'per_page' => $perPage,
                'total' => $total,
                'last_page' => max(1, (int) ceil($total / $perPage)),
                'sync_until' => $until->toIso8601ZuluString(),
            ],
            'links' => ['next' => $next],
        ]);
    }

    public function show(string $id, ProductPayload $payload)
    {
        $product = Product::withTrashed()->with(['category', 'sizes', 'mediaFiles'])
            ->where('product_type', 'product')->findOrFail($id);

        return response()->json(['data' => $payload->collection(collect([$product]))[0]]);
    }

    public function policies()
    {
        $contacts = Option::whereIn('option_key', ['contact_phone', 'whatsapp_phone', 'contact_email', 'address'])
            ->pluck('option_value', 'option_key');

        return response()->json(['data' => array_merge(config('zivo-policies'), [
            'store_id' => config('zivo.store_id'),
            'support_contacts' => [
                'phone' => $contacts->get('contact_phone') ?: null,
                'whatsapp' => $contacts->get('whatsapp_phone') ?: null,
                'email' => $contacts->get('contact_email') ?: null,
                'address' => $contacts->get('address') ?: null,
            ],
        ])]);
    }
}
