<?php

namespace App;

use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Exception\RuntimeException;

class ImageResize
{
    private $imagine;

    public function __construct()
    {
        $this->imagine = new Imagine();
    }

    public function resizeImage($size, $path, $savePath)
    {
        if (!file_exists($path)) {
            throw new \Exception("File not found: $path");
        }

        try {
            $image = $this->imagine->open($path)
                ->thumbnail(new Box($size, $size));

            $image->save($savePath);
        } catch (RuntimeException $e) {
            throw new \Exception("Error resizing image: " . $e->getMessage());
        }
    }
}
