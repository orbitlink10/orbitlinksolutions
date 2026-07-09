<?php

namespace App\Http\Controllers;
use App\Models\Media;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id){
    $post=Page::findOrFail($id);
      $mediaFiles = Media::wherePageId($id)->get();
        return view('admin.pages.edit',compact('post', 'mediaFiles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $page = Page::find($id);
        if (!$page) {
            return back()->with('error', 'Page does not exist');
        }

        try {
            \DB::beginTransaction();
            $mediaPaths = Media::where('page_id', $page->id)->pluck('file_path')->toArray();
            $pagePhoto  = $page->photo;

            Media::where('page_id', $page->id)->delete();
            $page->delete();
            \DB::commit();

            foreach ($mediaPaths as $fp) {
                $rel = $this->toPublicDiskPath($fp);
                if ($rel) {
                    @Storage::disk('public')->delete($rel);
                }
            }
            if ($pagePhoto) {
                @Storage::disk('public')->delete($pagePhoto);
            }
        } catch (\Throwable $e) {
            \DB::rollBack();
            return back()->with('error', 'Failed to delete page: '.$e->getMessage());
        }

        return back()->with('success', 'Page deleted successfully');
    }

    private function toPublicDiskPath(?string $filePath): ?string
    {
        if (!$filePath) return null;
        $path = $filePath;
        if (preg_match('#^https?://#i', $path)) {
            $u = parse_url($path, PHP_URL_PATH) ?: '';
            $path = ltrim($u, '/');
        }
        $path = ltrim($path, '/');
        if (Str::startsWith($path, 'storage/')) {
            $path = substr($path, strlen('storage/'));
        }
        $pos = strpos($path, 'uploads/');
        if ($pos !== false) {
            $path = substr($path, $pos);
        }
        return $path ?: null;
    }


        public function mediaSave(Request $request)
{
   

   

    $uploadedMedia = [];
    if ($request->hasFile('files')) {
        foreach ($request->file('files') as $index => $file) {
            // Generate file name
            $fileNameWithExt = $file->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $filenameToStore = $fileName . '-' . time() . '-' . $index . '.' . $extension;

            // Store the file
            $file->storeAs('uploads/medias/', $filenameToStore, 'public');

            // Generate file path
            $filePath = url('/') . '/storage/uploads/medias/' . $filenameToStore;

            // Get the caption for the file if available
            $caption = $captions[$index] ?? null;

            // Create media entry in the database
            $uploadedMedia[] = Media::create([
                'page_id'    => $request->page_id,
                'name'       => $fileName,
                'media_type' => "page",
                'file_path'  => $filePath,
            ]);
        }
    }

        return back()->with('success', 'Media uploaded successfully!');
}
}
