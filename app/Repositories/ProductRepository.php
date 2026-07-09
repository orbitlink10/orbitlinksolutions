<?php
namespace App\Repositories;

use App\Models\Product;

class ProductRepository {
    public function query(){
        return Product::query();
    }

    public function find($id){
        return Product::find($id);
    }

    public function create(array $data){
        return Product::create($data);
    }

    public function update(Product $product, array $data){
        $product->update($data);
    }

    public function delete(Product $product){
        $product->delete();
    }
}