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

class AccountController extends Controller
{
public function dashboard()
{
    $ordersCount = Order::where('user_id', Auth::id())->count();
    $wishlistCount = Wishlist::where('user_id', Auth::id())->count();
    $accountBalance = WalletTransaction::where('user_id', Auth::id())->sum('balance');
    $recentOrders = Order::where('user_id', Auth::id())->latest()->take(5)->get();
    $recommendedProducts = Product::take(8)->get(); // Replace with recommendation logic

    return view('account.dashboard', compact(
        'ordersCount',
        'wishlistCount',
        'accountBalance',
        'recentOrders',
        'recommendedProducts'
    ));
}


    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())->get();
        return view('account.orders', compact('orders'));
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
