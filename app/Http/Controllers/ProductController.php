<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Media;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Settings;
use App\Models\SubCategory;
use App\Services\ProductService;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $service){
        $this->productService =$service;
    }
   
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $products = $this->productService->all()->paginate(20);
        $query = $request->input('query');

        $products = Product::whereProductType('product')->latest();
        
        // If there's a search query, filter products by name
        if ($query) {
            $products = $products->where('name', 'like', '%'.$query.'%');
        }
        
        $products = $products->paginate(50);
        $user =Auth::user();
        $sub_categories =SubCategory::orderBy('id','desc')->get();
        $categories =Category::orderBy('id','desc')->get();
        return view('admin.products.index', compact('products','sub_categories','user','categories'));
    }



public function preview(Request $request)
{
    // Validate the incoming data
    $data = $request->validate([
        'image'     => 'required|string',  // Base64 image data
        'text'      => 'required|string',  // Text on the T-shirt
        'textColor' => 'required|string',  // Text color
        'fontSize'  => 'required|integer', // Font size
    ]);

    // Decode the base64 image (remove the prefix if exists)
    $imageData = $data['image'];
    if (strpos($imageData, 'base64,') !== false) {
        $imageData = explode('base64,', $imageData)[1];
    }
    $decodedImage = base64_decode($imageData);
    if ($decodedImage === false) {
        \Log::error('Failed to decode image data.');
        return response()->json(['success' => false, 'error' => 'Failed to decode image data.'], 422);
    }

    // Ensure the directory exists
    $directory = storage_path('app/public/tshirt_designs');
    if (!is_dir($directory)) {
        mkdir($directory, 0755, true);
    }

    // Save the image to storage
    $imageName = 'design_' . uniqid() . '.png';
    $path = $directory . '/' . $imageName;
    $result = file_put_contents($path, $decodedImage);
    if ($result === false) {
        \Log::error('Failed to save image file.');
        return response()->json(['success' => false, 'error' => 'Failed to save image file.'], 500);
    }

    // Generate a unique slug with timestamp and uniqid
    $slugBase = \Illuminate\Support\Str::slug($data['text']);
    $slug2 = 'in-' . time() . '-' . Str::random(6);
    $slug1 = $slugBase . '-' . $slug2;

    // Create a new product record (ensure that category_id and sub_category_id exist)
    $product = Product::create([
        'name'            => 'Custom T-Shirt with Design',
        'sku'             => strtoupper(uniqid('T-Shirt-')),
        'price'           => 1000.00,
        'marked_price'    => 25.00,
        'has_price'       => true,
        'quantity'        => 100,
        'discount'        => 0,
        'product_type'    => 'design',
        'photo'           => 'storage/app/public/tshirt_designs/' . $imageName,
        'slug'            => $slug1,
        'description'     => 'A custom-designed T-shirt with your personal touch!',
        'meta_description'=> 'Custom T-shirt with personalized design',
        'category_id'     => 1,
        'sub_category_id' => 1,
        'stock'           => 100,
        'is_active'       => true,
    ]);

    // Return JSON with the redirect URL to the product details page
    return response()->json([
        'success'      => true,
        'redirect_url' => route('product_details_preview', ['slug' => $product->slug])
    ]);
}











    public function mediaSave(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'files' => 'required|array',
            'files.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $this->storeProductMedia($request, (int) $request->product_id, 'files');

        return back()->with('success', 'Media uploaded successfully!');
    }

    private function storeProductMedia(Request $request, int $productId, string $field = 'media_files'): void
    {
        if (!$request->hasFile($field)) {
            return;
        }

        foreach ($request->file($field) as $index => $file) {
            $fileNameWithExt = $file->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $filenameToStore = upload_file_name($file, 80, $index);

            $file->storeAs('uploads/medias/', $filenameToStore, 'public');

            Media::create([
                'product_id' => $productId,
                'name' => $fileName,
                'media_type' => 'product',
                'file_path' => url('/') . '/storage/uploads/medias/' . $filenameToStore,
            ]);
        }
    }

    private function storeProductBrochurePdf($file): string
    {
        $filenameToStore = upload_file_name($file, 80);
        $file->storeAs('uploads/product-brochures/', $filenameToStore, 'public');

        return 'uploads/product-brochures/' . $filenameToStore;
    }

    private function storeProductBrochureMedia(int $productId, $file, string $filePath): void
    {
        Media::create([
            'product_id' => $productId,
            'name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            'media_type' => 'product_brochure',
            'file_path' => $filePath,
        ]);
    }



    /**
     * Show the form for creating a new resource.
     */
    
    public function create()
    {


        $categories =Category::orderBy("id","desc")->get();
        $sub_categories =SubCategory::orderBy("id","desc")->get();
        $user =Auth::user();
        return view("admin.products.create",compact('categories','sub_categories','user'));
    }





public function getSubcategories($categoryId)
{
    $subcategories = SubCategory::where('category_id', $categoryId)->pluck('name', 'id');
    
    return response()->json([
        'subcategories' => $subcategories
    ]);
}



    /**
     * Store a newly created resource in storage.
     */











public function store(Request $request)
{
    // Validate the incoming request data, including the photo if provided
    $validator = Validator::make($request->all(), [
        'name'            => 'required|string|max:255',
        'price'           => 'required|numeric',
        'marked_price'    => 'nullable|numeric',
        'quantity'        => 'required|integer',
        'category_id'     => 'required|exists:categories,id',
        'sub_category_id' => 'nullable|exists:sub_categories,id',
        'meta_title'      => 'nullable|string|max:255',
        'meta_description'=> 'nullable|string',
        'description'     => 'required|string',
        'additional_information' => 'nullable|string',
        'photo'           => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        'brochure_pdf'    => 'nullable|file|mimes:pdf|max:10240',
        'media_files'     => 'nullable|array',
        'media_files.*'   => 'image|mimes:jpg,jpeg,png,gif,webp|max:2048',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
                         ->withErrors($validator)
                         ->withInput();
    }

    // Extract fields from the request (excluding photo)
    $data = $request->only([
        'name',
        'price',
        'marked_price',
        'quantity',
        'category_id',
        'sub_category_id',
        'meta_title',
        'meta_description',
        'description'
    ]);

    // Generate a URL-friendly slug from the product name
    $data['slug'] = Str::slug($data['name']);

    // If a photo file is uploaded, store it and add the file path to the data
    if ($request->hasFile('photo')) {
        // Stores the file in storage/app/public/products and returns the path
        $path = $request->file('photo')->store('products', 'public');
        $data['photo'] = $path;
    }

    // Create the product record in the database
    $product = Product::create($data);
    $this->storeProductMedia($request, $product->id);
    save_product_additional_information($product->id, $request->input('additional_information'));

    if ($request->hasFile('brochure_pdf')) {
        $brochureFile = $request->file('brochure_pdf');
        $brochurePath = $this->storeProductBrochurePdf($brochureFile);
        $this->storeProductBrochureMedia($product->id, $brochureFile, $brochurePath);
    }

    // Redirect to the products index with a success message
    return redirect()->route('products.index')
                     ->with('success', 'Product created successfully.');
}




    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return $this->productService->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit($id)
    {
        $product = $this->productService->find($id);
        $categories =Category::orderBy("id","desc")->get();
        $sub_categories =SubCategory::orderBy("id","desc")->get();
        $user =Auth::user();
       $mediaFiles = Media::whereProductId($id)->get();
       $additionalInformationText = product_additional_information_text($id);
        return view('admin.products.update', compact('product','categories','sub_categories','user', 'mediaFiles', 'additionalInformationText'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
$product->has_price = $request->has('has_price') ? 1 : 0;
$product->save();

       return $this->productService->update($request,$id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return $this->productService->delete($id);
    }

   
    
}
