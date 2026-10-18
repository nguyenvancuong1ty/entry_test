<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class HotelImageService
{
    /**
     * Get relative base directory for permanent hotel images
     */
    public function getBaseRelativeDir(): string
    {
        return config('hotel.image.base_dir', 'hotel');
    }

    /**
     * Get relative directory for temporary hotel images
     */
    public function getTempRelativeDir(): string
    {
        return config('hotel.image.temp_dir', 'hotel/tmp');
    }

    /**
     * Store directly an uploaded hotel image
     *
     * @param UploadedFile $file
     * @return string Relative path from assets/img
     */
    public function storeUploadedImage(UploadedFile $file): string
    {
        $baseDir = $this->getBaseRelativeDir();
        $targetDirectory = public_path('assets/img/' . $baseDir);
        $this->ensureDirectoryExists($targetDirectory);

        $extension = $file->guessExtension() ?? $file->getClientOriginalExtension() ?? 'jpg';
        $filename = sprintf('hotel_%s.%s', uniqid('', true), $extension);
        $file->move($targetDirectory, $filename);

        return $baseDir . '/' . $filename;
    }

    /**
     * Store an uploaded image temporarily for multi-step confirmation
     *
     * @param UploadedFile $file
     * @return string Relative path from assets/img
     */
    public function storeTempImage(UploadedFile $file): string
    {
        $tempDir = $this->getTempRelativeDir();
        $targetDirectory = public_path('assets/img/' . $tempDir);
        $this->ensureDirectoryExists($targetDirectory);

        $extension = $file->guessExtension() ?? $file->getClientOriginalExtension() ?? 'jpg';
        $filename = sprintf('tmp_%s.%s', uniqid('', true), $extension);
        $file->move($targetDirectory, $filename);

        return $tempDir . '/' . $filename;
    }

    /**
     * Promote a temporary image to permanent hotel image directory
     *
     * @param string $tempFilePath
     * @return string Promoted permanent path, or original path if not temp
     */
    public function promoteTempImage(string $tempFilePath): string
    {
        $tempDir = $this->getTempRelativeDir();
        $baseDir = $this->getBaseRelativeDir();

        if (str_contains($tempFilePath, '..') || !str_starts_with($tempFilePath, $tempDir . '/')) {
            return $tempFilePath;
        }

        $tempFullPath = public_path('assets/img/' . $tempFilePath);
        if (!File::exists($tempFullPath)) {
            return $tempFilePath;
        }

        $filename = basename($tempFullPath);
        $cleanFilename = preg_replace('/^tmp_/', 'hotel_', $filename);

        $permanentDirectory = public_path('assets/img/' . $baseDir);
        $this->ensureDirectoryExists($permanentDirectory);

        $permanentFullPath = $permanentDirectory . DIRECTORY_SEPARATOR . $cleanFilename;
        File::move($tempFullPath, $permanentFullPath);

        return $baseDir . '/' . $cleanFilename;
    }

    /**
     * Delete an image from disk safely (only custom uploaded hotel images)
     *
     * @param string|null $filePath
     * @return void
     */
    public function deleteImage(?string $filePath): void
    {
        $baseDir = $this->getBaseRelativeDir();

        if ($filePath === null || str_contains($filePath, '..') || !str_starts_with($filePath, $baseDir . '/')) {
            return;
        }

        $fullPath = public_path('assets/img/' . $filePath);
        if (File::exists($fullPath) && !File::isDirectory($fullPath)) {
            File::delete($fullPath);
        }
    }

    /**
     * Resolve public URL for an asset image path
     */
    public function getImageUrl(?string $filePath): ?string
    {
        if ($filePath === null || trim($filePath) === '') {
            return null;
        }

        return asset('assets/img/' . $filePath);
    }

    /**
     * Ensure a target directory exists on disk
     *
     * @param string $directoryPath
     * @return void
     */
    private function ensureDirectoryExists(string $directoryPath): void
    {
        if (!File::isDirectory($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true, true);
        }
    }
}
