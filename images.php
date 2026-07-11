<?php

use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$filePath = uploaded_image_file_path($_GET['path'] ?? null);

if (!$filePath) {
    http_response_code(404);
    echo 'Not Found';
    return;
}

$mimeType = mime_content_type($filePath) ?: 'application/octet-stream';

header('Content-Type: '.$mimeType);
header('Content-Length: '.filesize($filePath));
header('Cache-Control: public, max-age=31536000');

readfile($filePath);
