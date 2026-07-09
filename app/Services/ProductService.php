<?php

namespace App\Services;

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
        $data = $request->all();
        
        $product=Product::where('name',$data['name'])->first();

        if(!empty($product)){
            return redirect()->back()->with('errors',"Product Already Exists");
        }

       
        $validate=$this->validateProduct($data);
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
            $this->productService->create($data);
            DB::commit();
            return redirect()->route('products.index')->with('success',"Product created successfully");
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->with('errors',[$th->getMessage()]);
        }
    }

    public function update(Request $request, $id){
        $data = $request->all();
        $product =$this->productService->find($id);
        if(!$product){
            return redirect()->route('products.index')->with("errors", "Product Not Found");
        }

        $validate=$this->validateProduct($data);
        if($validate->fails()){
            return back()->with("errors", $validate->errors()->all());
        }

        
        if ($request->hasFile('photo')) {
            $file_path = normalizeFilePath(storage_path().'/app/public/'.$product->photo);

            if(File::exists($file_path)) {
                File::delete($file_path); //delete from storage
                // Storage::delete($file_path); //Or you can do it as well
            }
            $photoPath = upload_photo($request->photo);
            $data['photo'] = $photoPath;
        }
        DB::beginTransaction();
        try {
            //code...
            $this->productService->update($product, $data);
            DB::commit();
            return redirect()->route('products.index')->with('success',"Product updated successfully");
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->with('errors',[$th->getMessage()]);
        }

    }

    public function delete($id){
        $product =$this->productService->find($id);
        if(!$product){
            return redirect()->route('products.index')->with("errors", "Product Not Found");
        }
        $file_path = normalizeFilePath(storage_path().'/app/public/'.$product->photo);

        if(File::exists($file_path)) {
            File::delete($file_path); //delete from storage
            // Storage::delete($file_path); //Or you can do it as well
        }

        $this->productService->delete($product);
        return redirect()->back()->with('success',"Product deleted successfully");
    }

    protected function validateProduct(array $data)
    {
        return Validator::make($data, [
            "name" => "bail|required|string",
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            "price" => "bail|required",
            "description" => "bail|required",
            "quantity" => "bail|required",
        ]);
    }
}