<?php 

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Repositories\SubCategoryRepository;

class SubCategoryService
{
    protected $subCategoryRepository;

    public function __construct(SubCategoryRepository $subCategoryRepository)
    {
        $this->subCategoryRepository = $subCategoryRepository;
    }
    public function all()
    {
        return $this->subCategoryRepository->query();
    }

    public function find($id)
    {
        $response= $this->subCategoryRepository->find($id);
        return $response;
    }

    public function create(array $data)
    {
        
        $validator = $this->validateCategory($data);

        if ($validator->fails()) {
            return back()->with("errors", $validator->errors()->all());
        }
        $this->subCategoryRepository->create($data);
        return redirect()->route('sub-categories.index')->with("success", "Sub Category Created Successfully");
        
    }

    public function update($id, array $data)
    {
        $sub_category = $this->subCategoryRepository->find($id);

        if (!$sub_category) {
            return back()->with("errors", "Sub Category not found");
        }

        $this->subCategoryRepository->update($sub_category, $data);

        return redirect()->route('sub-categories.index')->with("success", "Sub Category Updated Successfully");
    }

    public function delete($id)
    {
        $category = $this->subCategoryRepository->find($id);
        if (!$category) {
            return back()->with('error',"Sub Category not found");
        }
        $this->subCategoryRepository->delete($category);

        return back()->with('success',"Sub Category deleted successfully");
    }


    protected function validateCategory(array $data)
    {
        return Validator::make($data, [
            "name" => "required|string",
            "category_id" => "required",
        ]);
    }
}