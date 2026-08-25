<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CouponService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    public function __construct(private CouponService $couponService)
    {
    }
    
    // Add to Cart
    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $quantity = max(1, (int) ($request->quantity ?? 1));
        $size_id = $request->size_id ?? 0;

        // Get cart from session
        $cart = session()->get('cart', []);

        // If product already in cart, increment quantity
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            // Add new product to cart
            $cart[$product->id] = [
                "id" => $product->id,
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => effective_product_price($product, $quantity, Auth::user()),
                "retail_price" => (float) $product->price,
                "installer_price_applied" => installer_price_for_product($product, $quantity, Auth::user()) !== null,
                "size_id" => $size_id,
                "photo" => $product->photo,
                "slug" => $product->slug,
            ];
        }

        // Save cart to session
        session()->put('cart', $this->refreshCartPrices($cart));

        return redirect()->route('cart.view')->with('success', 'Product added to cart successfully!');
    }

    public function updateCart(Request $request)
{
    $cart = session()->get('cart', []);

    if (isset($cart[$request->id])) {
        if ($request->action == 'increase') {
            $cart[$request->id]['quantity'] += 1;
        } elseif ($request->action == 'decrease') {
            $cart[$request->id]['quantity'] -= 1;

            // Remove item if quantity falls below 1
            if ($cart[$request->id]['quantity'] < 1) {
                unset($cart[$request->id]);
            }
        }
        
        // Update the session with the new cart data
        session()->put('cart', $this->refreshCartPrices($cart));
    }

    return redirect()->route('cart.view')->with('success', 'Cart updated successfully!');
}


    // View Cart
    public function viewCart()
    {
        $cart = $this->refreshCartPrices(session()->get('cart', []));
        session()->put('cart', $cart);
        return view('cart.view', compact('cart'));
    }

    // Remove from Cart
    public function removeFromCart(Request $request)
    {
        $cart = session()->get('cart');

        if(isset($cart[$request->id])) {
            unset($cart[$request->id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.view')->with('success', 'Product removed from cart successfully!');
    }

    // Checkout (Optional)
    public function checkout()
    {
        $cart = session()->get('cart', []);
        $cart = $this->refreshCartPrices($cart);
        session()->put('cart', $cart);
        $couponQuote = null;
        $couponError = null;

        if (Auth::check() && session()->has('coupon_code') && count($cart) > 0) {
            try {
                $subtotal = $this->couponService->cartSubtotal($cart, Auth::user());
                $couponQuote = $this->couponService->quote(session('coupon_code'), Auth::user(), $subtotal);
            } catch (ValidationException $exception) {
                session()->forget('coupon_code');
                $couponError = collect($exception->errors())->flatten()->first();
            }
        }

        return view('cart.checkout', compact('cart', 'couponQuote', 'couponError'));
    }

    public function applyCoupon(Request $request)
    {
        $data = $request->validate([
            'coupon_code' => ['required', 'string', 'max:50'],
        ]);

        $cart = session()->get('cart', []);

        if (count($cart) === 0) {
            return back()->with('error', 'Add products to your cart before applying a coupon.');
        }

        $cart = $this->refreshCartPrices($cart);
        session()->put('cart', $cart);

        $subtotal = $this->couponService->cartSubtotal($cart, $request->user());
        $quote = $this->couponService->quote($data['coupon_code'], $request->user(), $subtotal);

        session()->put('coupon_code', $quote['code']);

        return back()->with('success', 'Coupon applied successfully.');
    }

    public function removeCoupon()
    {
        session()->forget('coupon_code');

        return back()->with('success', 'Coupon removed.');
    }

    private function refreshCartPrices(array $cart): array
    {
        if (empty($cart)) {
            return [];
        }

        $productIds = collect($cart)->pluck('id')->filter()->unique()->values();
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');
        $user = Auth::user();

        foreach ($cart as $key => $item) {
            $product = $products->get($item['id'] ?? null);

            if (! $product) {
                continue;
            }

            $quantity = max(1, (int) ($item['quantity'] ?? 1));
            $installerPrice = installer_price_for_product($product, $quantity, $user);

            $cart[$key]['id'] = $product->id;
            $cart[$key]['name'] = $product->name;
            $cart[$key]['quantity'] = $quantity;
            $cart[$key]['price'] = $installerPrice ?: (float) $product->price;
            $cart[$key]['retail_price'] = (float) $product->price;
            $cart[$key]['installer_price_applied'] = $installerPrice !== null;
            $cart[$key]['photo'] = $product->photo;
            $cart[$key]['slug'] = $product->slug;
        }

        return $cart;
    }
}
