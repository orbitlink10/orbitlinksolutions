<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;

class ProductSizeController extends Controller
{
    /**
     * Show the form for adding sizes to the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\View\View
     */
 public function create(Product $product)
{
    // Eager load the sizes relationship on the existing product instance.
    $product->load('sizes');
    
    return view('admin.products.sizes.create', compact('product'));
}



  /**
     * Store the sizes for the specified product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product       $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Product $product)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string',
        ]);

  Size::create([
                'product_id' => $product->id,
                'name'       => $request->name,
            ]);

        return redirect()->route('products.edit', $product->id)
                         ->with('success', 'Sizes added successfully.');
    }


}
