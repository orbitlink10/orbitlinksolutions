<?php

namespace App\Http\Controllers;

use App\Models\Design;
use Illuminate\Http\Request;

class DesignController extends Controller
{
    /**
     * Display a listing of the designs.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $designs = Design::all();
        return view('designs.index', compact('designs'));
    }


        public function designPublic()
    {
        $designs = Design::all();
        return view('designs.main', compact('designs'));
    }

    /**
     * Show the form for creating a new design.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('designs.create');
    }

    /**
     * Store a newly created design in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create a new design
        Design::create($request->only('name'));

        return redirect()->route('designs.index')
                         ->with('success', 'Design created successfully.');
    }

    /**
     * Display the specified design.
     *
     * @param  \App\Models\Design  $design
     * @return \Illuminate\View\View
     */
    public function show(Design $design)
    {
        return view('designs.show', compact('design'));
    }

    /**
     * Show the form for editing the specified design.
     *
     * @param  \App\Models\Design  $design
     * @return \Illuminate\View\View
     */
    public function edit(Design $design)
    {
        return view('designs.edit', compact('design'));
    }

    /**
     * Update the specified design in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Design  $design
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Design $design)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Update the design
        $design->update($request->only('name'));

        return redirect()->route('designs.index')
                         ->with('success', 'Design updated successfully.');
    }

    /**
     * Remove the specified design from storage.
     *
     * @param  \App\Models\Design  $design
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Design $design)
    {
        $design->delete();

        return redirect()->route('designs.index')
                         ->with('success', 'Design deleted successfully.');
    }

    public function design($id){

        $design = Design::find($id);
return view('designs.design', compact('design'));
    }
}
