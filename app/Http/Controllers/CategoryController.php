<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * GET /categories
     */
    public function index()
    {
        // Fetch all categories, or consider pagination: Category::paginate(10)
        $categories = Category::all();
        
        // Return a view 'categories.index' with data
        // (Create this view in resources/views/categories/index.blade.php)
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * GET /categories/create
     */
    public function create()
    {
        // Return a form view for creating a category
        // (Create this view in resources/views/categories/create.blade.php)
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * POST /categories
     */
public function store(Request $request)
{
    // 1. Validate input
    $validatedData = $request->validate([
        'name'             => 'required|string|max:255',
        'meta_description' => 'nullable|string',
        'description'      => 'nullable|string',
        'photo'            => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // 2. Generate a slug from the 'name'
    $slug = Str::slug($validatedData['name']);

    // 3. Create a new Category
    $category = new Category;
    $category->name             = $validatedData['name'];
    $category->slug             = $slug;
    $category->meta_description = $validatedData['meta_description'] ?? null;
    $category->description      = $validatedData['description'] ?? null;

    // 4. Optional: handle photo upload
    if ($request->hasFile('photo')) {
        $originalName     = $request->file('photo')->getClientOriginalName();
        $filename         = pathinfo($originalName, PATHINFO_FILENAME);
        $extension        = $request->file('photo')->getClientOriginalExtension();
        $filenameToStore  = $filename . '-' . time() . '.' . $extension;

        // Store the file in storage/app/public/uploads/images/
        $request->file('photo')->storeAs('uploads/images', $filenameToStore, 'public');

        // Option A: full URL
        $category->photo = url('storage/uploads/images/' . $filenameToStore);

        // Option B: relative path (uncomment if you prefer)
        // $category->photo = 'uploads/images/' . $filenameToStore;
    }

    // 5. Save the category
    $category->save();

    // 6. Redirect with success message
    return redirect()->route('categories.index')->with('success', 'Category created successfully!');
}

    /**
     * Display the specified resource.
     *
     * GET /categories/{category}
     */
    public function show(Category $category)
    {
        // Show a single category's detail
        // (Create a view at resources/views/categories/show.blade.php)
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * GET /categories/{category}/edit
     */
    public function edit(Category $category)
    {
        // Return a form for editing the category
        // (Create a view at resources/views/categories/edit.blade.php)
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * PUT or PATCH /categories/{category}
     */
public function update(Request $request, Category $category)
{
    // 1. Validate input
    //    - Include 'meta_description' and 'description' if needed
    //    - Photo is optional and must be a valid image if present
    $validatedData = $request->validate([
        'name'             => 'required|string|max:255',
        'meta_description' => 'nullable|string',
        'description'      => 'nullable|string',
        'photo'            => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // 2. Update basic fields
    $category->name = $validatedData['name'];
    $category->slug = Str::slug($validatedData['name']); // e.g., "my-updated-category"
    $category->meta_description = $validatedData['meta_description'] ?? null;
    $category->description = $validatedData['description'] ?? null;

    // 3. Handle new photo upload (if provided)
    if ($request->hasFile('photo')) {
        $originalName = $request->file('photo')->getClientOriginalName();
        $filename     = pathinfo($originalName, PATHINFO_FILENAME);
        $extension    = $request->file('photo')->getClientOriginalExtension();
        $filenameToStore = $filename . '-' . time() . '.' . $extension;

        // Store the file in "storage/app/public/uploads/images"
        $request->file('photo')->storeAs('uploads/images', $filenameToStore, 'public');

        // Option A: store the full URL
        $category->photo = url('storage/uploads/images/' . $filenameToStore);

        // Option B: store only the relative path (uncomment if you prefer)
        // $category->photo = 'uploads/images/' . $filenameToStore;
    }

    // 4. Save changes
    $category->save();

    // 5. Redirect with success message
    return redirect()->route('categories.index')
                     ->with('success', 'Category updated successfully!');
}
    /**
     * Remove the specified resource from storage.
     *
     * DELETE /categories/{category}
     */
    public function destroy(Category $category)
    {
        $category->delete();
        
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
    }
}
