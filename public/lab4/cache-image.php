<?php
$file = __DIR__ . '/image.jpg';

if (!file_exists($file)) {
    http_response_code(404);
    exit('Image not found');
}
header('Cache-Control: public, max-age=86400');
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 86400) . ' GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($file)) . ' GMT');
header('Content-Type: image/jpeg');
header('Content-Length: ' . filesize($file));
readfile($file);