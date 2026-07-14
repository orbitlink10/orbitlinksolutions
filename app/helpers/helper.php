<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

function normalizeFilePath($path){
    return str_replace(['/', "\\"], DIRECTORY_SEPARATOR, $path);
}

function uploaded_image_relative_path($path)
{
    if (!isset($path)) {
        return null;
    }

    $path = trim((string) $path);

    if ($path === '') {
        return null;
    }

    $urlParts = parse_url($path);

    if (isset($urlParts['path'])) {
        if (in_array(trim($urlParts['path'], '/'), ['images', 'images.php'], true) && !empty($urlParts['query'])) {
            parse_str($urlParts['query'], $query);
            $path = $query['path'] ?? $path;
        } elseif (isset($urlParts['scheme']) || str_starts_with($path, '/')) {
            $path = $urlParts['path'];
        }
    }

    $path = rawurldecode($path);
    $path = str_replace('\\', '/', $path);
    $path = preg_replace('#/+#', '/', $path);
    $path = ltrim($path, '/');

    foreach (['public/storage/', 'storage/', 'app/public/'] as $prefix) {
        if (str_starts_with($path, $prefix)) {
            $path = substr($path, strlen($prefix));
            break;
        }
    }

    if ($path === '' || str_contains($path, '..')) {
        return null;
    }

    return $path;
}

function uploaded_image_file_path($path)
{
    $relativePath = uploaded_image_relative_path($path);

    if (!$relativePath) {
        return null;
    }

    $candidates = [
        storage_path($relativePath),
        storage_path('app/public/' . $relativePath),
        public_path('storage/' . $relativePath),
    ];

    $allowedRoots = array_filter([
        realpath(storage_path()),
        realpath(public_path('storage')),
    ]);

    foreach (array_unique($candidates) as $candidate) {
        $candidate = normalizeFilePath($candidate);

        if (!File::exists($candidate) || !is_file($candidate)) {
            continue;
        }

        $realPath = realpath($candidate);

        foreach ($allowedRoots as $root) {
            $root = rtrim(normalizeFilePath($root), DIRECTORY_SEPARATOR);

            if ($realPath === $root || str_starts_with($realPath, $root . DIRECTORY_SEPARATOR)) {
                return $realPath;
            }
        }
    }

    return null;
}

function uploaded_image_url($path, $fallback = null)
{
    $fallback = $fallback ?: asset('assets/images/placeholder.svg');

    if (isset($path) && filter_var($path, FILTER_VALIDATE_URL)) {
        $urlPath = parse_url($path, PHP_URL_PATH) ?: '';

        if (!str_contains($urlPath, '/storage/') && !str_contains($urlPath, '/uploads/')) {
            return $path;
        }
    }

    $relativePath = uploaded_image_relative_path($path);

    if ($relativePath && uploaded_image_file_path($relativePath)) {
        return url('images') . '?path=' . rawurlencode($relativePath);
    }

    return $fallback;
}

function product_image_url($product, $fallback = null)
{
    $fallback = $fallback ?: asset('assets/images/placeholder.svg');

    if (!$product) {
        return $fallback;
    }

    if (!empty($product->photo) && uploaded_image_file_path($product->photo)) {
        return uploaded_image_url($product->photo, $fallback);
    }

    $mediaFiles = method_exists($product, 'relationLoaded') && $product->relationLoaded('mediaFiles')
        ? $product->mediaFiles
        : \App\Models\Media::whereProductId($product->id)->whereNotNull('file_path')->orderBy('id')->take(10)->get();

    foreach ($mediaFiles as $media) {
        if (!empty($media->file_path) && uploaded_image_file_path($media->file_path)) {
            return uploaded_image_url($media->file_path, $fallback);
        }
    }

    $category = method_exists($product, 'relationLoaded') && $product->relationLoaded('category')
        ? $product->category
        : (!empty($product->category_id) ? \App\Models\Category::find($product->category_id) : null);

    if ($category && !empty($category->photo) && uploaded_image_file_path($category->photo)) {
        return uploaded_image_url($category->photo, $fallback);
    }

    return $fallback;
}

function get_uploaded_image($path){
    $path = uploaded_image_file_path($path);

    if (!$path) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
}



    function get_option($option_key = '', $default = null){
      $get = \App\Models\Option::where('option_key', $option_key)->first();
      if($get) {
        return $get->option_value;
      }
      if (func_num_args() > 1) {
        return $default;
      }
      return $option_key;
    }



function upload_file_name($photo, $maxBaseLength = 80, $suffix = null){
    $fileNameWithExt = $photo->getClientOriginalName();
    $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
    $extension = strtolower($photo->getClientOriginalExtension());
    $safeBaseName = Str::slug($fileName);

    if ($safeBaseName === '') {
        $safeBaseName = 'upload';
    }

    $safeBaseName = Str::limit($safeBaseName, $maxBaseLength, '');
    $filenameToStore = $safeBaseName . '-' . time();

    if ($suffix !== null && $suffix !== '') {
        $safeSuffix = Str::slug((string) $suffix);

        if ($safeSuffix !== '') {
            $filenameToStore .= '-' . $safeSuffix;
        }
    }

    if ($extension !== '') {
        $filenameToStore .= '.' . $extension;
    }

    return $filenameToStore;
}

function upload_photo($photo){
    $filenameToStore = upload_file_name($photo);
    $photo->storeAs('uploads/images/', $filenameToStore, 'public');
    $photoPath = 'uploads/images/' . $filenameToStore;
    return $photoPath;
}
