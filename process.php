<?php
require_once __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/helpers.php';

use App\ImageResize;
use App\ZipArchiver;
session_start();

$isValid = true;
$errors = [
    'sizes' => '',
    'image' => '',
];

$allowedFormats = ['image/jpeg', 'image/png'];
$maxFileSize = 5 * 1024 * 1024;

if (empty($_POST['sizes'])) {
    $errors['sizes'] = 'Please select at least one size.';
    $isValid = false;
}

if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    $errors['image'] = 'Please upload an image.';
    $isValid = false;
} else {
    $file = $_FILES['image'];

    if (!in_array($file['type'], $allowedFormats)) {
        $errors['image'] = 'Invalid image format. Only JPG, PNG, and WebP are allowed.';
        $isValid = false;
    }

    if ($file['size'] > $maxFileSize) {
        $errors['image'] = 'File size must be less than 5MB.';
        $isValid = false;
    }

    if (!getimagesize($file['tmp_name'])) {
        $errors['image'] = 'The uploaded file is not a valid image.';
        $isValid = false;
    }
}

if (!$isValid) {
    $_SESSION['errors'] = $errors;
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}

if (isset($_FILES['image']) && $_FILES['image']['name']) {
    if (!is_dir(__DIR__ . '/images/')) {
        mkdir(__DIR__ . '/images/');
    }
}

$uploadDir = __DIR__ . '/images/';
$sizes = $_POST['sizes'] ?? null;
$file = $_FILES['image'] ?? null;
$fileName = $file['name'];

$resizer = new ImageResize();

if ($sizes) {
    foreach ($sizes as $size) {
        $resizedImage = $uploadDir . "resize_{$size}x{$size}_" . $fileName;
        $resizer->resizeImage($size, $_FILES['image']['tmp_name'], $resizedImage);
    }
}

try {
    ZipArchiver::downloadZip($uploadDir, 'my_images.zip');
    exit;
} catch (Exception $e) {
    echo $e->getMessage();
}


header("Location: {$_SERVER['HTTP_REFERER']}");
exit;
