<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\CouponRedemption;
use App\Models\FootballCouponEntitlement;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CouponService
{
    public function normalizeCode(?string $code): string
    {
        return strtoupper(preg_replace('/[^A-Za-z0-9]/', '', (string) $code));
    }

    public function cartSubtotal(array $cart): float
    {
        if (empty($cart)) {
            return 0.0;
        }

        $productIds = collect($cart)
            ->pluck('id')
            ->filter()
            ->unique()
            ->values();

        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $subtotal = collect($cart)->sum(function (array $item) use ($products) {
            $product = $products->get($item['id'] ?? null);
            $quantity = max(1, (int) ($item['quantity'] ?? 1));
            $price = $product ? (float) $product->price : (float) ($item['price'] ?? 0);

            return $price * $quantity;
        });

        return round((float) $subtotal, 2);
    }

    public function quote(string $code, User $user, float $subtotal): array
    {
        $coupon = $this->validatedCoupon($code, $user, $subtotal);
        $discountAmount = $this->calculateDiscount($coupon, $subtotal);

        return [
            'coupon' => $coupon,
            'code' => $coupon->code,
            'discount_amount' => $discountAmount,
            'subtotal' => round($subtotal, 2),
            'total' => max(0, round($subtotal - $discountAmount, 2)),
        ];
    }

    public function redeemForOrder(string $code, User $user, Order $order, float $subtotal): array
    {
        return DB::transaction(function () use ($code, $user, $order, $subtotal) {
            $coupon = $this->validatedCoupon($code, $user, $subtotal, true);
            $discountAmount = $this->calculateDiscount($coupon, $subtotal);
            $now = now();

            CouponRedemption::create([
                'coupon_id' => $coupon->id,
                'user_id' => $user->id,
                'order_id' => $order->id,
                'discount_amount' => $discountAmount,
                'redeemed_at' => $now,
            ]);

            if ($coupon->isFootballCoupon()) {
                $entitlement = FootballCouponEntitlement::where('coupon_id', $coupon->id)
                    ->where('user_id', $user->id)
                    ->lockForUpdate()
                    ->first();

                if (! $entitlement || $entitlement->redeemed_at !== null) {
                    throw ValidationException::withMessages([
                        'coupon_code' => 'This football reward has already been redeemed.',
                    ]);
                }

                $entitlement->forceFill([
                    'order_id' => $order->id,
                    'redeemed_at' => $now,
                ])->save();
            }

            $coupon->used_count = $coupon->used_count + 1;

            if (! $coupon->isFootballCoupon()) {
                $coupon->redeemed_by_user_id = $user->id;
                $coupon->redeemed_order_id = $order->id;
                $coupon->redeemed_at = $now;
            }

            $coupon->save();

            $order->forceFill([
                'coupon_id' => $coupon->id,
                'coupon_code' => $coupon->code,
                'discount_amount' => $discountAmount,
                'subtotal_before_discount' => round($subtotal, 2),
                'total_after_discount' => max(0, round($subtotal - $discountAmount, 2)),
                'total_amount' => max(0, round($subtotal - $discountAmount, 2)),
            ])->save();

            return [
                'coupon' => $coupon->fresh(),
                'discount_amount' => $discountAmount,
                'total' => $order->total_amount,
            ];
        });
    }

    public function calculateDiscount(Coupon $coupon, float $subtotal): float
    {
        $subtotal = max(0, $subtotal);
        $value = (float) $coupon->discount_value;

        if ($subtotal <= 0 || $value <= 0) {
            return 0.0;
        }

        if ($coupon->discount_type === Coupon::TYPE_PERCENTAGE) {
            $amount = $subtotal * min($value, 100) / 100;
        } elseif ($coupon->discount_type === Coupon::TYPE_FIXED) {
            $amount = $value;
        } else {
            throw ValidationException::withMessages([
                'coupon_code' => 'This coupon has an invalid discount type.',
            ]);
        }

        return round(min($amount, $subtotal), 2);
    }

    public function validatedCoupon(string $code, User $user, float $subtotal, bool $lock = false): Coupon
    {
        $normalizedCode = $this->normalizeCode($code);

        if ($normalizedCode === '') {
            throw ValidationException::withMessages([
                'coupon_code' => 'Enter a coupon code.',
            ]);
        }

        $query = Coupon::where('code', $normalizedCode);

        if ($lock) {
            $query->lockForUpdate();
        }

        $coupon = $query->first();

        if (! $coupon) {
            throw ValidationException::withMessages([
                'coupon_code' => 'This coupon code was not found.',
            ]);
        }

        if (! $coupon->is_active) {
            throw ValidationException::withMessages([
                'coupon_code' => 'This coupon is not active.',
            ]);
        }

        if ($coupon->isExpired()) {
            throw ValidationException::withMessages([
                'coupon_code' => 'This coupon has expired.',
            ]);
        }

        if (! in_array($coupon->discount_type, [Coupon::TYPE_PERCENTAGE, Coupon::TYPE_FIXED], true)) {
            throw ValidationException::withMessages([
                'coupon_code' => 'This coupon has an invalid discount type.',
            ]);
        }

        if ((float) $coupon->discount_value <= 0) {
            throw ValidationException::withMessages([
                'coupon_code' => 'This coupon has an invalid discount value.',
            ]);
        }

        if ($subtotal <= 0) {
            throw ValidationException::withMessages([
                'coupon_code' => 'A coupon can only be applied to a cart with a positive total.',
            ]);
        }

        if ($coupon->isFootballCoupon()) {
            $entitlementQuery = FootballCouponEntitlement::where('coupon_id', $coupon->id)
                ->where('user_id', $user->id);

            if ($lock) {
                $entitlementQuery->lockForUpdate();
            }

            $entitlement = $entitlementQuery->first();

            if (! $entitlement) {
                throw ValidationException::withMessages([
                    'coupon_code' => 'This football reward is only available to winning predictions.',
                ]);
            }

            if ($entitlement->redeemed_at !== null) {
                throw ValidationException::withMessages([
                    'coupon_code' => 'This football reward has already been redeemed.',
                ]);
            }
        } elseif (! $coupon->hasRemainingGlobalUses()) {
            throw ValidationException::withMessages([
                'coupon_code' => 'This coupon has already been redeemed.',
            ]);
        }

        return $coupon;
    }
}
