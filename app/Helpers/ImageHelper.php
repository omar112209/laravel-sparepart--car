<?php

namespace App\Helpers;

class ImageHelper
{
    public static function uploadAndResize(
        $file,
        $directory,
        $fileName,
        $width = null,
        $height = null
    ) {
        $destinationPath = public_path($directory);
        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0775, true);
        }

        if (!extension_loaded('gd')) {
            $content = file_get_contents($file->getRealPath());
            file_put_contents($destinationPath . '/' . $fileName, $content);
            return $fileName;
        }

        $extension = strtolower($file->getClientOriginalExtension());
        $image = null;
        switch ($extension) {
            case 'jpeg':
            case 'jpg':
                $image = imagecreatefromjpeg($file->getRealPath());
                break;
            case 'png':
                $image = imagecreatefrompng($file->getRealPath());
                break;
            case 'gif':
                $image = imagecreatefromgif($file->getRealPath());
                break;
            default:
                throw new \Exception('Unsupported image type');
        }
        if ($width) {
            $oldWidth = imagesx($image);
            $oldHeight = imagesy($image);
            $aspectRatio = $oldWidth / $oldHeight;
            if (!$height) {
                $height = $width / $aspectRatio;
            }
            $newImage = imagecreatetruecolor($width, $height);
            imagecopyresampled(
                $newImage,
                $image,
                0,
                0,
                0,
                0,
                $width,
                $height,
                $oldWidth,

                $oldHeight
            );

            imagedestroy($image);
            $image = $newImage;
        }
        switch ($extension) {
            case 'jpeg':
            case 'jpg':
                imagejpeg($image, $destinationPath . '/' . $fileName);
                break;
            case 'png':
                imagepng($image, $destinationPath . '/' . $fileName);
                break;
            case 'gif':
                imagegif($image, $destinationPath . '/' . $fileName);
                break;
        }
        imagedestroy($image);
        return $fileName;
    }
}
