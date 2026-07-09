<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{

public function index(Request $request)
{
    $query = Order::query();

    // Apply search filter if provided
    if ($request->filled('search')) {
        $search = trim($request->search);
        $query->where(function ($q) use ($search) {
            $q->where('id', 'like', "%{$search}%")
                ->orWhere('order_reference', 'like', "%{$search}%")
                ->orWhere('customer_first_name', 'like', "%{$search}%")
                ->orWhere('customer_last_name', 'like', "%{$search}%")
                ->orWhere('customer_email', 'like', "%{$search}%")
                ->orWhere('customer_phone', 'like', "%{$search}%")
                ->orWhereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
        });
    }

    // Apply status filter if provided
    if ($request->has('status') && $request->status != '') {
        $query->where('status', $request->status);
    }

    // Fetch paginated orders, ordered by ID descending
    $orders = $query->orderBy('id', 'desc')->paginate(50);

    return view('orders.index', compact('orders'));
}



    public function users()
    {
        // Fetch paginated orders
        $users = User::whereUserType('buyer')
        ->orderBy('id', 'desc')
        ->paginate(10); // Adjust the number as needed
    
        return view('orders.users', compact('users'));
    }
    

    public function show($order)
    {

        $order = Order::find($order);
        return view('orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return redirect()->route('orders.index')->with('success', 'Order status updated successfully.');
    }
}
