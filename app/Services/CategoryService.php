<?php 

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    public function all()
    {
        $response= $this->categoryRepository->all();
        return response()->json(["data"=> $response]);
    }

    public function find($id)
    {
        $response= $this->categoryRepository->find($id);

        return $response;
        // if($response){
        //     return response()->json(["data"=> $response]);
        // }
        // else{
        //     // throw new ModelNotFoundException("Category not found");
        //     return response()->json(["error" => "Category not found"], 404);
        // }
    }

    public function create(array $data)
    {
        
        $validator = $this->validateCategory($data);

        if ($validator->fails()) {
            return back()->with('error',$validator->errors()->all());
        }

        // if (!isset($data['status'])) {
        //     $data['status'] = 0; 
        // } else {
            
        //     $data['status'] = 1;
        // }

        return $this->categoryRepository->create($data);
    }

    public function update($id, array $data)
    {
        $category = $this->categoryRepository->find($id);

        if (!$category) {
            return back()->with('error',"Category not found");
        }
        // dd($data);
        

        return $this->categoryRepository->update($category, $data);

        
    }

    public function delete($id)
    {
        $category = $this->categoryRepository->find($id);

        if (!$category) {
            return back()->with('error',"Category not Found");
        }
        $this->categoryRepository->delete($category);

        return back()->with('success',"Category deleted successfully");
    }


    protected function validateCategory(array $data)
    {
        return Validator::make($data, [
            "name" => "required|string",
            "status" => "",
        ]);
    }

   
}

