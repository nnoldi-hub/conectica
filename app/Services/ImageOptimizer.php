<?php

namespace App\Services;

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Str;

class ImageOptimizer
{
    private const VARIANT_WIDTHS = [480, 960, 1440];

    public function optimize(FilesystemAdapter $disk, string $path): array
    {
        $absolutePath = $disk->path($path);
        $imageInfo = getimagesize($absolutePath);

        if ($imageInfo === false) {
            throw new \InvalidArgumentException('Fisierul incarcat nu este o imagine valida.');
        }

        $source = $this->createImage($absolutePath, $imageInfo['mime']);
        $directory = trim(dirname($path), '.\\/');
        $basename = Str::slug(pathinfo($path, PATHINFO_FILENAME));
        $optimizedDirectory = ($directory ? $directory.'/' : '').'optimized';
        $optimizedPath = $optimizedDirectory.'/'.$basename.'.webp';

        $this->writeVariant($disk, $source, $optimizedPath, 1440);
        $variants = [];

        foreach (self::VARIANT_WIDTHS as $width) {
            $variantPath = $optimizedDirectory.'/'.$basename.'-'.$width.'.webp';
            $this->writeVariant($disk, $source, $variantPath, $width);
            $variants[(string) $width] = $variantPath;
        }

        imagedestroy($source);

        return [
            'file_path' => $optimizedPath,
            'original_path' => $path,
            'variants' => $variants,
            'mime_type' => 'image/webp',
            'size' => $disk->size($optimizedPath),
            'width' => min($imageInfo[0], 1440),
            'height' => (int) round($imageInfo[1] * min($imageInfo[0], 1440) / $imageInfo[0]),
        ];
    }

    private function createImage(string $path, string $mime): \GdImage
    {
        $image = match ($mime) {
            'image/jpeg' => imagecreatefromjpeg($path),
            'image/png' => imagecreatefrompng($path),
            'image/webp' => imagecreatefromwebp($path),
            default => false,
        };

        if (! $image instanceof \GdImage) {
            throw new \InvalidArgumentException('Tipul imaginii nu este suportat.');
        }

        return $image;
    }

    private function writeVariant(FilesystemAdapter $disk, \GdImage $source, string $path, int $maxWidth): void
    {
        $sourceWidth = imagesx($source);
        $sourceHeight = imagesy($source);
        $width = min($sourceWidth, $maxWidth);
        $height = (int) round($sourceHeight * $width / $sourceWidth);
        $target = imagecreatetruecolor($width, $height);

        imagealphablending($target, false);
        imagesavealpha($target, true);
        imagecopyresampled($target, $source, 0, 0, 0, 0, $width, $height, $sourceWidth, $sourceHeight);

        $temporaryPath = tempnam(sys_get_temp_dir(), 'conectica-image-');
        if ($temporaryPath === false) {
            throw new \RuntimeException('Nu s-a putut crea fisierul temporar pentru imagine.');
        }

        try {
            imagewebp($target, $temporaryPath, 82);
            $contents = file_get_contents($temporaryPath);
            if ($contents === false || ! $disk->put($path, $contents)) {
                throw new \RuntimeException('Nu s-a putut salva varianta optimizata.');
            }
        } finally {
            imagedestroy($target);
            unlink($temporaryPath);
        }
    }
}
