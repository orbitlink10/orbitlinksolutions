<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();
        return view('sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('sliders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'h1_title' => 'nullable|string|max:255',
            'h2_title' => 'nullable|string|max:255',
            'h4_title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'button_url' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:255',
            'img_url' => 'nullable|string|max:255',
        ]);

        Slider::create($validated);

        return redirect()->route('sliders.index')->with('success', 'Slider created successfully.');
    }

    public function edit(Slider $slider)
    {
        return view('sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $validated = $request->validate([
            'h1_title' => 'nullable|string|max:255',
            'h2_title' => 'nullable|string|max:255',
            'h4_title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'button_url' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:255',
            'img_url' => 'nullable|string|max:255',
        ]);

        $slider->update($validated);

        return redirect()->route('sliders.index')->with('success', 'Slider updated successfully.');
    }

    public function destroy(Slider $slider)
    {
        $slider->delete();

        return redirect()->route('sliders.index')->with('success', 'Slider deleted successfully.');
    }
}
