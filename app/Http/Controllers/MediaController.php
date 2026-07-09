<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medias = Media::orderBy('id', 'desc')->paginate(10);
        return view('medias.index', compact('medias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('medias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'file_path' => 'required|file',
        ]);

        // Save the file

                if($request->hasFile('file_path')) {



            $fileNameWithExt = $request->file_path->getClientOriginalName();
            $fileName =  pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $Extension = $request->file_path->getClientOriginalExtension();
            $filenameToStore = $fileName . '-' . time() . '.' . $Extension;
            $request->file_path->storeAs('uploads/medias/', $filenameToStore,'public');

         
            $filePath = url('/').'/storage/uploads/medias/'.$filenameToStore;
      
          




        Media::create([
            'name'       => $request->name,
            'media_type' => $request->media_type,
            'file_path'  => $filePath,
        ]);

        return redirect()->route('medias.index')
            ->with('success', 'Media uploaded successfully!');
    }


}


    /**
     * Display the specified resource.
     */
    public function show(Media $media)
    {
        return view('medias.show', compact('media'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Media $media)
    {
        return view('medias.edit', compact('media'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Media $media)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'file_path' => 'nullable|file',
        ]);

        // Update the file if provided
        if ($request->hasFile('file_path')) {
                  $fileNameWithExt = $request->file_path->getClientOriginalName();
            $fileName =  pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $Extension = $request->file_path->getClientOriginalExtension();
            $filenameToStore = $fileName . '-' . time() . '.' . $Extension;
            $request->file_path->storeAs('uploads/medias/', $filenameToStore,'public');

         
            $filePath = url('/').'/storage/uploads/medias/'.$filenameToStore;
            $media->update(['file_path' => $filePath]);
        }

        $media->update(['name' => $request->name, 'media_type' => $request->media_type]);

        return redirect()->route('medias.index')
            ->with('success', 'Media updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Media $media)
    {
        // Delete the file from storage
        \Storage::delete($media->file_path);
        $media->delete();

        return redirect()->route('medias.index')
            ->with('success', 'Media deleted successfully!');
    }
}
