<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Services\CouponService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CouponController extends Controller
{
    public function __construct(private CouponService $couponService)
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(Request $request)
    {
        $query = Coupon::with(['creator', 'footballMatch', 'redeemedBy', 'redeemedOrder'])
            ->withCount('redemptions');

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $coupons = $query->latest()->paginate(25);

        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['code'] = $this->couponService->normalizeCode($data['code']);

        if (Coupon::where('code', $data['code'])->exists()) {
            throw ValidationException::withMessages([
                'code' => 'This coupon code already exists.',
            ]);
        }

        $data['source'] = Coupon::SOURCE_MANUAL;
        $data['created_by'] = Auth::id();
        $data['is_active'] = $request->boolean('is_active', true);
        $data['usage_limit'] = $data['usage_limit'] ?? 1;

        $coupon = Coupon::create($data);

        return redirect()->route('admin.coupons.show', $coupon)->with('success', 'Coupon created successfully.');
    }

    public function show(Coupon $coupon)
    {
        $coupon->load(['creator', 'footballMatch', 'redemptions.user', 'redemptions.order', 'entitlements.user', 'entitlements.order']);

        return view('admin.coupons.show', compact('coupon'));
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $data = $this->validatedData($request, $coupon);
        $data['code'] = $this->couponService->normalizeCode($data['code']);

        $duplicate = Coupon::where('code', $data['code'])
            ->whereKeyNot($coupon->id)
            ->exists();

        if ($duplicate) {
            throw ValidationException::withMessages([
                'code' => 'This coupon code already exists.',
            ]);
        }

        $data['is_active'] = $request->boolean('is_active');
        $coupon->update($data);

        return redirect()->route('admin.coupons.show', $coupon)->with('success', 'Coupon updated successfully.');
    }

    public function toggle(Coupon $coupon)
    {
        $coupon->update(['is_active' => ! $coupon->is_active]);

        return back()->with('success', 'Coupon status updated.');
    }

    public function destroy(Coupon $coupon)
    {
        if ($coupon->redemptions()->exists()) {
            return back()->with('error', 'Used coupons cannot be deleted.');
        }

        $coupon->delete();

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon deleted successfully.');
    }

    private function validatedData(Request $request, ?Coupon $coupon = null): array
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:255'],
            'discount_type' => ['required', Rule::in([Coupon::TYPE_PERCENTAGE, Coupon::TYPE_FIXED])],
            'discount_value' => ['required', 'numeric', 'min:0.01'],
            'usage_limit' => ['nullable', 'integer', 'min:1'],
            'expires_at' => ['nullable', 'date'],
        ]);

        if ($data['discount_type'] === Coupon::TYPE_PERCENTAGE && (float) $data['discount_value'] > 100) {
            throw ValidationException::withMessages([
                'discount_value' => 'Percentage discounts cannot be greater than 100.',
            ]);
        }

        if ($coupon && $coupon->isFootballCoupon()) {
            unset($data['code']);
        }

        return $data;
    }
}
