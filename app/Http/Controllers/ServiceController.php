<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::paginate(10);
        return view('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
    ]);

    // Generate the slug from the name
    $slug = \Str::slug($request->name);
    // Create the service, including the slug
    Service::create([
        'name' => $request->name,
        'meta_description' => $request->meta_description,
        'description' => $request->description,
        'price' => $request->price,
        'image_url' => $request->image_url,
        'slug' => $slug, // Adding the generated slug
    ]);

    return redirect()->route('service.index')
        ->with('success', 'Service created successfully!');
}


    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return view('services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, Service $service)
{


    // Update the service with only the specified fields
    $service->update([
        'name'        => $request->input('name'),
        'description' => $request->input('description'),
        'image_url'   => $request->input('image_url'),
        'price'       => $request->input('price'),
    ]);

    // Redirect with a success message
    return redirect()->route('service.index')
        ->with('success', 'Service updated successfully!');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('service.index')
            ->with('success', 'Service deleted successfully!');
    }
}
