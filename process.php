<?php
use App\ImageResize;
session_start();

$isValid = true;
$errors = [
    'sizes' => '',
    'image' => '',
];

$sizes = $_POST['sizes'] ?? null;

$allowedFormats = ['image/jpeg', 'image/png', 'image/webp'];
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

echo '<pre>';
print_r($_FILES);
print_r($sizes);
echo '</pre>';
