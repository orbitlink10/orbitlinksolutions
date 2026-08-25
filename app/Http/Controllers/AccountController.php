<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Address;
use App\Models\Payment;
use App\Models\Wishlist;
use App\Models\WalletTransaction;
use App\Models\Product;
use App\Models\InstallerApplication;
use App\Models\BoqSubmission;

class AccountController extends Controller
{
public function dashboard()
{
    $ordersCount = Order::where('user_id', Auth::id())->count();
    $wishlistCount = Wishlist::where('user_id', Auth::id())->count();
    $accountBalance = WalletTransaction::where('user_id', Auth::id())->sum('balance');
    $recentOrders = Order::where('user_id', Auth::id())->latest()->take(5)->get();
    $recommendedProducts = Product::where('product_type', 'product')
        ->when(\Illuminate\Support\Facades\Schema::hasColumn('products', 'popular_with_installers'), fn ($query) => $query->orderByDesc('popular_with_installers'))
        ->latest()
        ->take(8)
        ->get();
    $installerApplication = InstallerApplication::where('user_id', Auth::id())
        ->orWhere('email', Auth::user()->email)
        ->latest()
        ->first();
    $boqSubmissions = BoqSubmission::where('user_id', Auth::id())
        ->orWhere('email', Auth::user()->email)
        ->latest()
        ->take(5)
        ->get();
    $totalPurchases = Order::where('user_id', Auth::id())->sum('total_amount');

    return view('account.dashboard', compact(
        'ordersCount',
        'wishlistCount',
        'accountBalance',
        'recentOrders',
        'recommendedProducts',
        'installerApplication',
        'boqSubmissions',
        'totalPurchases'
    ));
}


    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->get();
        return view('account.orders', compact('orders'));
    }

    public function showOrder(Order $order)
    {
        abort_unless((int) $order->user_id === (int) Auth::id(), 403);

        $order->load(['user', 'orderItems.product', 'orderItems.size', 'coupon']);

        return view('orders.show', compact('order'));
    }
    public function payments()
    {
        $payments = Payment::where('user_id', Auth::id())->get();
        return view('account.payments', compact('payments'));
    }

    public function details()
    {
        return view('account.details');
    }

    public function updateDetails(Request $request)
    {
        $user = Auth::user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();
        
        return redirect()->route('account.details')->with('success', 'Account details updated.');
    }

    public function addresses()
    {
        $addresses = Address::where('user_id', Auth::id())->get();
        return view('account.addresses', compact('addresses'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
