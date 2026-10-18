<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class HotelImageService
{
    private const BASE_RELATIVE_DIR = 'hotel';
    private const TEMP_RELATIVE_DIR = 'hotel/tmp';

    /**
     * Store directly an uploaded hotel image
     *
     * @param UploadedFile $file
     * @return string Relative path from assets/img
     */
    public function storeUploadedImage(UploadedFile $file): string
    {
        $targetDirectory = public_path('assets/img/' . self::BASE_RELATIVE_DIR);
        $this->ensureDirectoryExists($targetDirectory);

        $extension = $file->guessExtension() ?? $file->getClientOriginalExtension() ?? 'jpg';
        $filename = sprintf('hotel_%s.%s', uniqid('', true), $extension);
        $file->move($targetDirectory, $filename);

        return self::BASE_RELATIVE_DIR . '/' . $filename;
    }

    /**
     * Store an uploaded image temporarily for multi-step confirmation
     *
     * @param UploadedFile $file
     * @return string Relative path from assets/img
     */
    public function storeTempImage(UploadedFile $file): string
    {
        $targetDirectory = public_path('assets/img/' . self::TEMP_RELATIVE_DIR);
        $this->ensureDirectoryExists($targetDirectory);

        $extension = $file->guessExtension() ?? $file->getClientOriginalExtension() ?? 'jpg';
        $filename = sprintf('tmp_%s.%s', uniqid('', true), $extension);
        $file->move($targetDirectory, $filename);

        return self::TEMP_RELATIVE_DIR . '/' . $filename;
    }

    /**
     * Promote a temporary image to permanent hotel image directory
     *
     * @param string $tempFilePath
     * @return string Promoted permanent path, or original path if not temp
     */
    public function promoteTempImage(string $tempFilePath): string
    {
        if (str_contains($tempFilePath, '..') || !str_starts_with($tempFilePath, self::TEMP_RELATIVE_DIR . '/')) {
            return $tempFilePath;
        }

        $tempFullPath = public_path('assets/img/' . $tempFilePath);
        if (!File::exists($tempFullPath)) {
            return $tempFilePath;
        }

        $filename = basename($tempFullPath);
        $cleanFilename = preg_replace('/^tmp_/', 'hotel_', $filename);

        $permanentDirectory = public_path('assets/img/' . self::BASE_RELATIVE_DIR);
        $this->ensureDirectoryExists($permanentDirectory);

        $permanentFullPath = $permanentDirectory . DIRECTORY_SEPARATOR . $cleanFilename;
        File::move($tempFullPath, $permanentFullPath);

        return self::BASE_RELATIVE_DIR . '/' . $cleanFilename;
    }

    /**
     * Delete an image from disk safely (only custom uploaded hotel images)
     *
     * @param string|null $filePath
     * @return void
     */
    public function deleteImage(?string $filePath): void
    {
        if ($filePath === null || str_contains($filePath, '..') || !str_starts_with($filePath, self::BASE_RELATIVE_DIR . '/')) {
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
