<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sub_categories =SubCategory::orderBy('id','desc')->paginate(10);
        $categories =Category::orderBy('id','desc')->get();
        return view('admin.sub_categories.index', compact('sub_categories','categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = Validator::make($request->all(), ['name']);

        if($validateData->fails()){
            return back()->with('error', 'Fill all fields please!!');
        }

        $data=[
            'name'=>$request->name,
            'category_id'=>$request->category_id,
        ];



        SubCategory::create($data);
        return back()->with('success','Sub category created successfully!!');
    }

    /**
     * Display the specified resource.
     */
    public function show(SubCategory $subCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubCategory $subCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $sub_categories =SubCategory::findOrFail($id);
        $sub_categories->name=$request->name;
        $sub_categories->category_id=$request->category_id;
        // dd($sub_categories);
        $sub_categories->save();

        return back()->with('success','Sub category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubCategory $subCategory)
    {
        //
    }
}
