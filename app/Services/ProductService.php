<?php

namespace App\Services;

use App\Models\Media;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductService{
    private $productService;
    public function __construct(ProductRepository $productRepository)
    {
        $this->productService = $productRepository;
    }

    public function all(){
        $data=$this->productService->query();
        return $data;
    }

    public function find($id){
        $product=$this->productService->find($id);
        if(!$product){
            return redirect()->route('products.index')->with("errors", "Product Not Found");
        }else{
            return $product;
        }
    }
    public function create(Request $request){
        $validationData = $request->all();
        $data = $validationData;
        unset($data['brochure_pdf'], $data['additional_information']);
        
        $product=Product::where('name',$data['name'])->first();

        if(!empty($product)){
            return redirect()->back()->withErrors(["Product Already Exists"]);
        }

       
        $validate=$this->validateProduct($validationData);
        if ($validate->fails()) {
            return back()->withErrors($validate);
        }
        // if($validate->fails()){
        //     return back()->with("errors", $validate->errors()->all());
        //     // return back()->withErrors($validate->errors());
        // }
        if ($request->hasFile('photo')) {
            $photoPath = upload_photo($request->photo);
            $data['photo'] = $photoPath;
        }

        // $data['sku'] = generate_sku();
        // $data['barcode'] = generateBarcode();
        
        DB::beginTransaction();
        try {
            //code...
            $product = $this->productService->create($data);
            save_product_additional_information($product->id, $request->input('additional_information'));

            if ($request->hasFile('brochure_pdf')) {
                $this->replaceProductBrochure($product, $request->file('brochure_pdf'));
            }

            DB::commit();
            return redirect()->route('products.index')->with('success',"Product created successfully");
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->withErrors([$th->getMessage()]);
        }
    }

    public function update(Request $request, $id){
        $validationData = $request->all();
        $data = $validationData;
        unset($data['brochure_pdf'], $data['additional_information']);
        $product =$this->productService->find($id);
        if(!$product){
            return redirect()->route('products.index')->with("errors", "Product Not Found");
        }

        $validate=$this->validateProduct($validationData);
        if($validate->fails()){
            return back()->withErrors($validate);
        }

        
        if ($request->hasFile('photo')) {
            $file_path = uploaded_image_file_path($product->photo);

            if($file_path && File::exists($file_path)) {
                File::delete($file_path); //delete from storage
                // Storage::delete($file_path); //Or you can do it as well
            }
            $photoPath = upload_photo($request->photo);
            $data['photo'] = $photoPath;
        }

        if ($request->hasFile('brochure_pdf')) {
            $this->replaceProductBrochure($product, $request->file('brochure_pdf'));
        }
        DB::beginTransaction();
        try {
            //code...
            $this->productService->update($product, $data);
            save_product_additional_information($product->id, $request->input('additional_information'));
            DB::commit();
            return redirect()->route('products.index')->with('success',"Product updated successfully");
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->withErrors([$th->getMessage()]);
        }

    }

    public function delete($id){
        $product =$this->productService->find($id);
        if(!$product){
            return redirect()->route('products.index')->with("errors", "Product Not Found");
        }
        $file_path = uploaded_image_file_path($product->photo);

        if($file_path && File::exists($file_path)) {
            File::delete($file_path); //delete from storage
            // Storage::delete($file_path); //Or you can do it as well
        }

        $brochure = Media::where('product_id', $product->id)
            ->where('media_type', 'product_brochure')
            ->first();
        $brochure_path = $brochure ? uploaded_image_file_path($brochure->file_path) : null;

        if($brochure_path && File::exists($brochure_path)) {
            File::delete($brochure_path);
        }

        if($brochure) {
            $brochure->delete();
        }

        save_product_additional_information($product->id, null);
        $this->productService->delete($product);
        return redirect()->back()->with('success',"Product deleted successfully");
    }

    protected function validateProduct(array $data)
    {
        return Validator::make($data, [
            "name" => "bail|required|string",
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'brochure_pdf' => 'nullable|file|mimes:pdf|max:10240',
            'additional_information' => 'nullable|string',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'files.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            "price" => "bail|required",
            "description" => "bail|required",
            "quantity" => "bail|required",
        ]);
    }

    private function storeProductBrochurePdf(UploadedFile $file): string
    {
        $filenameToStore = upload_file_name($file, 80);
        $file->storeAs('uploads/product-brochures/', $filenameToStore, 'public');

        return 'uploads/product-brochures/' . $filenameToStore;
    }

    private function replaceProductBrochure(Product $product, UploadedFile $file): void
    {
        $brochure = Media::where('product_id', $product->id)
            ->where('media_type', 'product_brochure')
            ->first();

        if ($brochure) {
            $file_path = uploaded_image_file_path($brochure->file_path);

            if($file_path && File::exists($file_path)) {
                File::delete($file_path);
            }
        }

        $filePath = $this->storeProductBrochurePdf($file);
        $data = [
            'product_id' => $product->id,
            'name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            'media_type' => 'product_brochure',
            'file_path' => $filePath,
        ];

        $brochure ? $brochure->update($data) : Media::create($data);
    }
}
