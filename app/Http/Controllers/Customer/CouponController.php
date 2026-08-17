<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $entitlements = Auth::user()
            ->footballCouponEntitlements()
            ->with(['coupon', 'footballMatch', 'order'])
            ->latest()
            ->get();

        return view('account.coupons', compact('entitlements'));
    }
}
