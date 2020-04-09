<?php

namespace Framework\Modules;

class Image
{
    public static function addTemplate(string $image, string $template, string $output)
    {
        global $USER;
        $img = Image::crop(imagecreatefromjpeg($image));
        $mask = imagecreatefrompng($template);
        $maskData = getimagesize($template);
        imagealphablending($img, true);
        imagesavealpha($img, true);
        imagealphablending($mask, true);
        imagesavealpha($mask, true);
        imagecopy(
            $img,
            $mask,
            200, 200,
            0, 0,
            $maskData[0], $maskData[1]
        );
        imagejpeg($img, FW_UPLOAD_PATH . '/' . $USER->getId() . '/' . $output);
    }

    private static function crop($image)
    {
        $imageWidth = imagesx($image);
        $imageHeight = imagesy($image);
        $size = min($imageWidth, $imageHeight);

        $x = 0;
        $y = 0;
        if ($imageWidth > $imageHeight) {
            $x = ($imageWidth - $imageHeight) / 2;
        } else {
            $y = ($imageHeight - $imageWidth) / 2;
        }

        return (
            imagecrop(
                $image,
                [
                    'x' => $x,
                    'y' => $y,
                    'width' => $size,
                    'height' => $size,
                ]
            )
        );
    }
}