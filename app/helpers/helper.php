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

function rich_content_image_url($src, $fallback = null)
{
    $fallback = $fallback ?: asset('assets/images/placeholder.svg');
    $src = trim((string) $src);

    if ($src === '' || str_starts_with(strtolower($src), 'blob:')) {
        return $fallback;
    }

    if (str_starts_with(strtolower($src), 'data:image/')) {
        return $src;
    }

    $urlPath = parse_url($src, PHP_URL_PATH) ?: '';
    $localPath = ltrim($urlPath !== '' ? $urlPath : $src, '/');

    if (
        str_starts_with($src, '/') ||
        str_contains($urlPath, '/storage/') ||
        str_contains($urlPath, '/uploads/') ||
        str_starts_with($localPath, 'uploads/') ||
        str_starts_with($localPath, 'products/') ||
        str_starts_with($localPath, 'storage/') ||
        str_starts_with($localPath, 'public/storage/') ||
        str_starts_with($localPath, 'app/public/') ||
        in_array(trim($urlPath, '/'), ['images', 'images.php'], true)
    ) {
        return uploaded_image_url($src, $fallback);
    }

    if (str_starts_with($localPath, 'assets/')) {
        return asset($localPath);
    }

    if (filter_var($src, FILTER_VALIDATE_URL)) {
        return $src;
    }

    return uploaded_image_url($src, $src);
}

function rich_content_html($html, $imageFallback = null)
{
    $html = (string) $html;

    if (trim($html) === '') {
        return '';
    }

    $imageFallback = $imageFallback ?: asset('assets/images/placeholder.svg');

    if (!class_exists(\DOMDocument::class)) {
        return preg_replace_callback('/<img\b[^>]*\bsrc=(["\'])(.*?)\1[^>]*>/i', function ($matches) use ($imageFallback) {
            $src = trim($matches[2]);
            $newSrc = rich_content_image_url($src, $imageFallback);

            if ($newSrc === $src) {
                return $matches[0];
            }

            return str_replace($matches[1] . $src . $matches[1], $matches[1] . e($newSrc) . $matches[1], $matches[0]);
        }, $html);
    }

    $previousErrors = libxml_use_internal_errors(true);
    $dom = new \DOMDocument('1.0', 'UTF-8');
    $dom->loadHTML(
        '<?xml encoding="UTF-8"><!DOCTYPE html><html><body><div id="rich-content-root">' . $html . '</div></body></html>',
        LIBXML_HTML_NODEFDTD | LIBXML_HTML_NOIMPLIED
    );

    foreach ($dom->getElementsByTagName('img') as $image) {
        $src = $image->getAttribute('src');
        $newSrc = rich_content_image_url($src, $imageFallback);

        if ($newSrc !== $src) {
            $image->setAttribute('src', $newSrc);
            $image->removeAttribute('srcset');
        }

        if (!$image->hasAttribute('loading')) {
            $image->setAttribute('loading', 'lazy');
        }

        if (!$image->hasAttribute('decoding')) {
            $image->setAttribute('decoding', 'async');
        }
    }

    $root = $dom->getElementById('rich-content-root');
    $output = '';

    if ($root) {
        foreach ($root->childNodes as $child) {
            $output .= $dom->saveHTML($child);
        }
    } else {
        $output = $html;
    }

    libxml_clear_errors();
    libxml_use_internal_errors($previousErrors);

    return $output;
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
