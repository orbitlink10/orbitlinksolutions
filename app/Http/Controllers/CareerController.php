<?php

namespace App\Http\Controllers;

use App\Models\CareerApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CareerController extends Controller
{
    /**
     * Handle a career application.
     */

    public function apply(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255',
            'position' => 'required|in:Satellite Installation Technician,Customer Support Specialist,Digital Marketer',
            'resume'   => 'required|file|mimes:pdf|max:2048',
        ]);

        // Store the uploaded resume under storage/app/resumes
        $path = $request->file('resume')->store('resumes');

        // Persist to database
        CareerApplication::create([
            'name'        => $data['name'],
            'email'       => $data['email'],
            'position'    => $data['position'],
            'resume_path' => $path,
        ]);

        return back()->with('success', 'Thanks for applying! We will review your application and be in touch.');
    }
    
}
