<?php

require_once __DIR__ . '/vendor/autoload.php';

session_start();

$errors = $_SESSION['errors'] ?? ['sizes' => '', 'image' => ''];

echo '<pre>';
print_r($errors);
echo '</pre>';

unset($_SESSION['errors']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Resize</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-primary bg-gradient">
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card w-100 p-2 mx-auto bg-light shadow" style="max-width: 600px">
        <form action="process.php" method="POST" enctype="multipart/form-data">
            <div class="card-header">
                <h1 class="fs-2 text-center">Upload image</h1>
            </div>
            <div class="card-body">
                <div class="file-drop-area">
                    <span class="btn btn-outline-primary me-2">Choose image</span>
                    <span class="file-message text-muted">or drag and drop here</span>
                    <input class="file-input" type="file" name="image" accept="image/*">
                </div>

                <div class="file-preview mt-3 d-none">
                    <img id="preview-img" src="" alt="Selected Image">
                    <span class="remove-file">✖</span>
                </div>
                <?php if ($errors['image']): ?>
                    <div class="invalid-feedback d-block text-center mt-2" style="font-size: 12px;">
                        <?= $errors['image'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="resize-values mt-4">
                <div class="has-validation d-flex justify-content-center gap-2">
                    <div class="resize-value">
                        <input type="checkbox" class="btn-check" id="size-200" name="sizes[]" value="200">
                        <label class="btn btn-outline-primary" for="size-200" style="font-size: 10px;">200x200</label>
                    </div>
                    <div class="resize-value">
                        <input type="checkbox" class="btn-check" id="size-400" name="sizes[]" value="400">
                        <label class="btn btn-outline-primary" for="size-400" style="font-size: 10px;">400x400</label>
                    </div>
                    <div class="resize-value">
                        <input type="checkbox" class="btn-check" id="size-600" name="sizes[]" value="600">
                        <label class="btn btn-outline-primary" for="size-600" style="font-size: 10px;">600x600</label>
                    </div>
                </div>
                <?php if ($errors['sizes']): ?>
                    <div class="invalid-feedback d-block text-center mt-2" style="font-size: 12px;">
                        <?= $errors['sizes'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary px-5 mt-4 mx-auto d-block">Resize</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.querySelector('.file-input');
        const filePreview = document.querySelector('.file-preview');
        const previewImg = document.getElementById('preview-img');
        const removeBtn = document.querySelector('.remove-file');
        const fileMessage = document.querySelector('.file-message');

        fileInput.addEventListener('change', function (event) {
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImg.src = e.target.result;
                    filePreview.classList.remove('d-none');
                    fileMessage.textContent = "Image selected";
                };
                reader.readAsDataURL(file);
            }
        });

        removeBtn.addEventListener('click', function () {
            fileInput.value = "";
            filePreview.classList.add('d-none');
            fileMessage.textContent = "or drag and drop here";
        });
    });
</script>

<style>
    .file-drop-area {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 20px;
        border: 2px dashed #6c757d;
        border-radius: 10px;
        background-color: #f8f9fa;
        text-align: center;
        cursor: pointer;
        transition: border-color 0.3s;
    }

    .file-drop-area:hover {
        border-color: #007bff;
    }

    .file-input {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    .file-preview {
        margin-top: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .file-preview img {
        max-width: 100px;
        border-radius: 5px;
        border: 1px solid #ddd;
    }

    .remove-file {
        cursor: pointer;
        color: red;
        font-weight: bold;
    }
</style>

</body>
</html>
