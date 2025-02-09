<?php
session_start();

$isValid = true;
$errors = [
    'sizes' => '',
    'image' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['sizes'])) {
        $errors['sizes'] = 'Please select at least one size.';
        $isValid = false;
    }

    if (empty($_FILES['image']['name'])) {
        $errors['image'] = 'Please upload an image.';
        $isValid = false;
    }

    if (!$isValid) {
        $_SESSION['errors'] = $errors;
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;
    }
}
