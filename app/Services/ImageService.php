<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    /**
     * Unggah gambar, kompres dan konversi ke WebP bila ekstensi GD mendukung.
     */
    public function uploadToWebp(UploadedFile $file, string $folder = 'uploads', int $maxWidth = 1280, int $quality = 80): string
    {
        $folder = trim($folder, '/');
        $filenameBase = Str::uuid()->toString();

        if (function_exists('imagecreatefromstring') && function_exists('imagewebp')) {
            $raw = @file_get_contents($file->getRealPath());
            $src = $raw ? @imagecreatefromstring($raw) : false;

            if ($src !== false) {
                $width = imagesx($src);
                $height = imagesy($src);

                if ($width > $maxWidth && $width > 0) {
                    $newWidth = $maxWidth;
                    $newHeight = (int) round($height * ($maxWidth / $width));
                    $dst = imagecreatetruecolor($newWidth, $newHeight);
                    imagealphablending($dst, false);
                    imagesavealpha($dst, true);
                    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                    imagedestroy($src);
                    $src = $dst;
                } else {
                    imagepalettetotruecolor($src);
                    imagealphablending($src, true);
                    imagesavealpha($src, true);
                }

                ob_start();
                imagewebp($src, null, $quality);
                $webpData = ob_get_clean();
                imagedestroy($src);

                if ($webpData !== false && strlen($webpData) > 0) {
                    $path = "{$folder}/{$filenameBase}.webp";
                    Storage::disk('public')->put($path, $webpData);

                    return $path;
                }
            }
        }

        $ext = strtolower($file->getClientOriginalExtension() ?: 'webp');
        $path = "{$folder}/{$filenameBase}.{$ext}";
        Storage::disk('public')->put($path, (string) file_get_contents($file->getRealPath()));

        return $path;
    }

    /**
     * Hapus gambar dari disk publik jika bukan asset contoh bawaan.
     */
    public function delete(?string $path): void
    {
        if (! $path || str_starts_with($path, 'images/') || str_starts_with($path, 'sample/')) {
            return;
        }

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
