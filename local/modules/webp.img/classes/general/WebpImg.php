<?php

namespace WebCompany;

class WebpImg
{
    private static bool $isPng = true;
    private static array $curFile = [];

    private static function checkFormat(string $type):bool
    {
        if ($type === 'image/png') {
            self::$isPng = true;
            return true;
        } elseif ($type === 'image/jpeg') {
            self::$isPng = false;
            return true;
        } else
            return false;
    }

    private static function implodeSrc(array $path):string
    {
        $path[count($path) - 1] = '';
        return implode('/', $path);
    }

    private static function generateSrc(string $imgPath):string
    {
        $arPath = explode('/',$imgPath);
        $webpPath = self::implodeSrc($arPath);
        return str_replace('upload/', 'upload/webp.img/', $webpPath);
    }

    private static function generateWebp(int $quality = 100):void
    {
        if (self::checkFormat(self::$curFile['CONTENT_TYPE'])) {
            self::$curFile['WEBP_PATH'] = self::generateSrc(self::$curFile['SRC']);

            if (self::$isPng) {
                self::$curFile['WEBP_FILE_NAME'] = str_replace('.png', '.webp', strtolower(self::$curFile['FILE_NAME']));
            } else {
                self::$curFile['WEBP_FILE_NAME'] = str_replace('.jpg', '.webp', strtolower(self::$curFile['FILE_NAME']));
                self::$curFile['WEBP_FILE_NAME'] = str_replace('.jpeg', '.webp', strtolower(self::$curFile['WEBP_FILE_NAME']));
            }

            if (!file_exists($_SERVER['DOCUMENT_ROOT'] . self::$curFile['WEBP_PATH'])) {
                mkdir($_SERVER['DOCUMENT_ROOT'] . self::$curFile['WEBP_PATH'], 0777, true);
            }

            self::$curFile['WEBP_SRC'] = self::$curFile['WEBP_PATH'] . self::$curFile['WEBP_FILE_NAME'];

            if (!file_exists($_SERVER['DOCUMENT_ROOT'] . self::$curFile['WEBP_SRC'])) {
                if (self::$isPng) {
                    $im = imagecreatefrompng($_SERVER['DOCUMENT_ROOT'] . self::$curFile['SRC']);
                } else {
                    $im = imagecreatefromjpeg($_SERVER['DOCUMENT_ROOT'] . self::$curFile['SRC']);
                }

                imagewebp($im, $_SERVER['DOCUMENT_ROOT'] . self::$curFile['WEBP_SRC'], $quality);
                imagedestroy($im);
            }
        }
    }

    public static function getResizeSrc($file, int $width, int $height, bool $isProportional = true, int $quality = 100):string
    {
        self::$curFile = [];

        if (!is_array($file) && intval($file) > 0) {
            self::$curFile = \CFile::GetFileArray($file);
        } else {
            self::$curFile = $file;
        }

        if (!self::$curFile['FILE_NAME']) {
            self::$curFile['FILE_NAME'] = array_pop(explode('/', self::$curFile['SRC']));
        }

        $file = \CFile::ResizeImageGet(
            $file,
            array('width' => $width, 'height' => $height),
            $isProportional ? BX_RESIZE_IMAGE_PROPORTIONAL : BX_RESIZE_IMAGE_EXACT,
            true,
            false,
            false,
            $quality
        );

        self::$curFile['SRC'] = $file['src'];
        self::$curFile['WIDTH'] = $file['width'];
        self::$curFile['HEIGHT'] = $file['height'];

        return self::$curFile['SRC'];
    }

    public static function getResizeWebpSrc($file, int $width, int $height, bool $isProportional = true, int $quality = 100):string
    {
        self::getResizeSrc($file, $width, $height, $isProportional, $quality);
        self::generateWebp($quality);

        return self::$curFile['WEBP_SRC'];
    }
}