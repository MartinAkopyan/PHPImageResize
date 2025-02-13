<?php

function deleteAllFilesInFolder($folderPath)
{
    $files = glob($folderPath . '/*'); // Получаем все файлы

    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file); // Удаляем файл
        } elseif (is_dir($file)) {
            deleteAllFilesInFolder($file); // Рекурсивно удаляем папки
            rmdir($file);
        }
    }
}

