<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

function normalizeFilePath($path){
    return str_replace(['/', "\\"], DIRECTORY_SEPARATOR, $path);
}

function get_uploaded_image($path){
    if(!isset($path)){
        abort(404);
    }

    $path = normalizeFilePath(storage_path('/app/public/' . $path));

    if(!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
}



    function get_option($option_key = ''){
      $get = \App\Models\Option::where('option_key', $option_key)->first();
      if($get) {
        return $get->option_value;
      }
      return $option_key;
    }



function upload_photo($photo){
    $fileNameWithExt = $photo->getClientOriginalName();
    $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
    $extension = $photo->getClientOriginalExtension();
    $filenameToStore = $fileName . '-' . time() . '.' . $extension;
    $photo->storeAs('uploads/images/', $filenameToStore, 'public');
    $photoPath = 'uploads/images/' . $filenameToStore;
    return $photoPath;
}