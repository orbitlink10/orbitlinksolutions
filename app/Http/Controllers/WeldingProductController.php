<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\WeldingProduct;

class WeldingProductController extends Controller
{
    public function index()
    {
        $products = WeldingProduct::with('category')->paginate(12);
        $categories = Category::all();

        return view('welding-products.index', compact('products', 'categories'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = WeldingProduct::where('category_id', $category->id)->paginate(12);
        $categories = Category::all();

        return view('welding-products.category', compact('products', 'category', 'categories'));
    }


    public function show($id)
{
    $product = \App\Models\WeldingProduct::with('category')->findOrFail($id);
    return view('welding-products.show', compact('product'));
}
}
