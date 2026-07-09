<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Response;

class GoogleFeedController extends Controller
{
    public function index()
    {
        $products = Product::where('google_merchant', 1)
    ->whereProductType('product')
    ->get();


        return response()
            ->view('google_feed', ['products' => $products])
            ->header('Content-Type', 'application/xml');
    }
}
