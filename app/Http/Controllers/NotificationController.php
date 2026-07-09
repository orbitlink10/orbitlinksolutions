<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Product;

class NotificationController extends Controller
{
    /**
     * Display a listing of notifications.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $notifications = Notification::with('product')->paginate(10);
        return view('notifications.index', compact('notifications'));
    }

    /**
     * Show the form for creating a new notification.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $products = Product::all(); // Get all products to allow selection
        return view('notifications.create', compact('products'));
    }

    /**
     * Store a newly created notification in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the form inputs
        $validated = $request->validate([
            'email' => 'required|email',
            'phone' => 'required|regex:/^\d{10,15}$/',
            'product_id' => 'nullable|exists:products,id',
        ]);

        try {
            // Store the notification in the database
            Notification::create([
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'product_id' => $validated['product_id'] ?? null,
            ]);

            // Return success message and redirect
            return redirect()->route('notifications.thank-you')->with('success', 'You have successfully subscribed!');
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Notification Store Error: ', ['error' => $e->getMessage()]);

            // Redirect with an error message
            return back()->withErrors(['error' => 'An error occurred while saving your request. Please try again.']);
        }
    }

    /**
     * Show the form for editing an existing notification.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\View\View
     */
    public function edit(Notification $notification)
    {
        $products = Product::all(); // Get all products for selection
        return view('notifications.edit', compact('notification', 'products'));
    }

    /**
     * Update the specified notification in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Notification $notification)
    {
        // Validate the form inputs
        $validated = $request->validate([
            'email' => 'required|email',
            'phone' => 'required|regex:/^\d{10,15}$/',
            'product_id' => 'nullable|exists:products,id',
        ]);

        try {
            // Update the notification
            $notification->update([
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'product_id' => $validated['product_id'] ?? null,
            ]);

            // Return success message and redirect
            return redirect()->route('notifications.index')->with('success', 'Notification updated successfully!');
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Notification Update Error: ', ['error' => $e->getMessage()]);

            // Redirect with an error message
            return back()->withErrors(['error' => 'An error occurred while updating the notification. Please try again.']);
        }
    }

    /**
     * Remove the specified notification from the database.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Notification $notification)
    {
        try {
            // Delete the notification
            $notification->delete();

            // Return success message and redirect
            return redirect()->route('notifications.index')->with('success', 'Notification deleted successfully!');
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Notification Delete Error: ', ['error' => $e->getMessage()]);

            // Redirect with an error message
            return back()->withErrors(['error' => 'An error occurred while deleting the notification. Please try again.']);
        }
    }

    /**
     * Show the thank you page after successful notification subscription.
     *
     * @return \Illuminate\View\View
     */
    public function thankYou()
    {
        return view('notifications.thank-you');
    }
}
