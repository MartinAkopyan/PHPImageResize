<?php

namespace App;

use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use Exception;

class ZipArchiver
{
    public static function downloadZip($folderPath, $zipFileName = 'archive.zip')
    {
        if (!is_dir($folderPath)) {
            throw new Exception("Directory does not exist: $folderPath");
        }

        $zip = new ZipArchive();
        $zipTempPath = tempnam(sys_get_temp_dir(), 'zip');

        if ($zip->open($zipTempPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new Exception("Cannot create ZIP archive");
        }

        $folderPath = realpath($folderPath);
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($folderPath, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($folderPath) + 1);
                $zip->addFile($filePath, $relativePath);
            }
        }

        $zip->close();

        // Отправляем ZIP пользователю
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . basename($zipFileName) . '"');
        header('Content-Length: ' . filesize($zipTempPath));
        readfile($zipTempPath);
        unlink($zipTempPath);

        self::deleteAllFilesInFolder($folderPath);
        exit;
    }

    public static function deleteAllFilesInFolder($folderPath)
    {
        $files = glob($folderPath . '/*');

        foreach ($files as $file) {
            if (is_file($file)) {
                chmod($file, 0777);
                unlink($file);
            } elseif (is_dir($file)) {
                self::deleteAllFilesInFolder($file);
                rmdir($file);
            }
        }
    }
}
