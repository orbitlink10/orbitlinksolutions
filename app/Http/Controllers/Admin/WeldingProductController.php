<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\WeldingProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WeldingProductController extends Controller
{
    public function index()
    {
        $products = WeldingProduct::with('category')->paginate(15);
        return view('admin.welding-products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.welding-products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'material_cost' => 'nullable|numeric|min:0',
            'labour_cost' => 'nullable|numeric|min:0',
            'total_cost' => 'nullable|numeric|min:0',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('welding-products', 'public');
        }

        // Auto-calculate total_cost if not provided
        if (!isset($data['total_cost'])) {
            $data['total_cost'] = ($data['material_cost'] ?? 0) + ($data['labour_cost'] ?? 0);
        }

        WeldingProduct::create($data);

        return redirect()->route('admin.welding-products.index')->with('success', 'Product created successfully.');
    }

    public function edit(WeldingProduct $welding_product)
    {
        $categories = Category::all();
        return view('admin.welding-products.edit', compact('welding_product', 'categories'));
    }

    public function update(Request $request, WeldingProduct $weldingProduct)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'material_cost' => 'nullable|numeric|min:0',
            'labour_cost' => 'nullable|numeric|min:0',
            'total_cost' => 'nullable|numeric|min:0',
        ]);

        if ($request->hasFile('image')) {
            if ($weldingProduct->image) {
                Storage::disk('public')->delete($weldingProduct->image);
            }
            $data['image'] = $request->file('image')->store('welding-products', 'public');
        }

        // Auto-calculate total_cost if not provided
        if (!isset($data['total_cost'])) {
            $data['total_cost'] = ($data['material_cost'] ?? 0) + ($data['labour_cost'] ?? 0);
        }

        $weldingProduct->update($data);

        return redirect()->route('admin.welding-products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(WeldingProduct $weldingProduct)
    {
        if ($weldingProduct->image) {
            Storage::disk('public')->delete($weldingProduct->image);
        }

        $weldingProduct->delete();

        return redirect()->route('admin.welding-products.index')->with('success', 'Product deleted successfully.');
    }
}
