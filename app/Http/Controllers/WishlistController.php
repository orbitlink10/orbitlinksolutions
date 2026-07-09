<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product; // Assuming products are stored in this model
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display the user's wishlist.
     */
    public function index()
    {
        $user = Auth::user();
        $wishlistItems = Wishlist::where('user_id', $user->id)->with('product')->get();

        return view('wishlist.index', compact('wishlistItems'));
    }

    /**
     * Add an item to the user's wishlist.
     */
    public function store($id)
    {

        $user = Auth::user();

        // Check if the item is already in the wishlist
        $existingItem = Wishlist::where('user_id', $user->id)
            ->where('product_id', $id)
            ->first();

        if ($existingItem) {
            return redirect()->back()->with('error', 'This item is already in your wishlist.');
        }

        // Add the item to the wishlist
        Wishlist::create([
            'user_id'    => $user->id,
            'product_id' => $id,
        ]);

        return redirect()->back()->with('success', 'Item added to wishlist.');
    }

    /**
     * Remove an item from the wishlist.
     */
    public function destroy($id)
    {
        $user = Auth::user();

        $wishlistItem = Wishlist::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$wishlistItem) {
            return redirect()->back()->with('error', 'Item not found in your wishlist.');
        }

        $wishlistItem->delete();

        return redirect()->back()->with('success', 'Item removed from wishlist.');
    }
}
