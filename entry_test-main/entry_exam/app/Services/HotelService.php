<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Hotel;
use App\Models\Prefecture;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Throwable;

class HotelService
{
    public function __construct(
        private readonly HotelImageService $imageService,
    ) {
    }

    /**
     * Get all prefectures
     *
     * @return Collection<int, Prefecture>
     */
    public function getAllPrefectures(): Collection
    {
        return Prefecture::all();
    }

    /**
     * Find a hotel with its prefecture or fail
     */
    public function findHotelOrFail(int $hotelId): Hotel
    {
        return Hotel::with('prefecture')->findOrFail($hotelId);
    }

    /**
     * Search hotels by name and/or prefecture with pagination
     *
     * @return LengthAwarePaginator
     */
    public function searchHotels(?string $name, ?int $prefectureId, ?int $perPage = null): LengthAwarePaginator
    {
        $defaultPerPage = (int) config('pagination.default_per_page', 10);
        $perPage ??= $defaultPerPage;

        $params = array_filter([
            'hotel_name' => $name,
            'prefecture_id' => $prefectureId,
            'per_page' => $perPage !== $defaultPerPage ? $perPage : null,
        ], static fn ($value) => $value !== null && $value !== '');

        return Hotel::query()
            ->search($name, $prefectureId)
            ->paginate($perPage)
            ->appends($params);
    }

    /**
     * Create a new hotel
     *
     * @throws Throwable
     */
    public function createHotel(string $hotelName, int $prefectureId, ?UploadedFile $imageFile = null): Hotel
    {
        $filePath = null;
        if ($imageFile !== null && $imageFile->isValid()) {
            $filePath = $this->imageService->storeUploadedImage($imageFile);
        }

        try {
            return DB::transaction(function () use ($hotelName, $prefectureId, $filePath): Hotel {
                return Hotel::create([
                    'hotel_name' => $hotelName,
                    'prefecture_id' => $prefectureId,
                    'file_path' => $filePath,
                ]);
            });
        } catch (Throwable $e) {
            if ($filePath !== null) {
                $this->imageService->deleteImage($filePath);
            }
            throw $e;
        }
    }

    /**
     * Prepare confirmation data for editing hotel (handles temporary image storage)
     *
     * @return array{hotel: Hotel, prefecture: Prefecture, hotel_name: string, prefecture_id: int, new_file_path: ?string, new_image_url: ?string}
     */
    public function prepareEditConfirmation(
        int $hotelId,
        string $hotelName,
        int $prefectureId,
        ?UploadedFile $imageFile,
        ?string $currentNewFilePath
    ): array {
        $hotel = $this->findHotelOrFail($hotelId);
        $prefecture = Prefecture::findOrFail($prefectureId);

        $newFilePath = $currentNewFilePath;
        if ($imageFile !== null && $imageFile->isValid()) {
            if (!empty($newFilePath)) {
                $this->imageService->deleteImage($newFilePath);
            }
            $newFilePath = $this->imageService->storeTempImage($imageFile);
        }

        return [
            'hotel' => $hotel,
            'prefecture' => $prefecture,
            'hotel_name' => $hotelName,
            'prefecture_id' => $prefectureId,
            'new_file_path' => $newFilePath,
            'new_image_url' => $this->imageService->getImageUrl($newFilePath),
        ];
    }

    /**
     * Update hotel information and finalize image promotion
     *
     * @throws Throwable
     */
    public function updateHotel(int $hotelId, string $hotelName, int $prefectureId, ?string $newFilePath): Hotel
    {
        $hotel = $this->findHotelOrFail($hotelId);
        $oldFilePath = $hotel->file_path;
        $promotedPath = null;

        if (!empty($newFilePath)) {
            $promotedPath = $this->imageService->promoteTempImage($newFilePath);
        }

        try {
            $updatedHotel = DB::transaction(function () use ($hotel, $hotelName, $prefectureId, $promotedPath): Hotel {
                $updateData = [
                    'hotel_name' => $hotelName,
                    'prefecture_id' => $prefectureId,
                ];

                if ($promotedPath !== null) {
                    $updateData['file_path'] = $promotedPath;
                }

                $hotel->update($updateData);

                return $hotel->fresh(['prefecture']);
            });

            // Delete old physical image only after successful transaction commit
            if ($promotedPath !== null && !empty($oldFilePath) && $oldFilePath !== $promotedPath) {
                $this->imageService->deleteImage($oldFilePath);
            }

            return $updatedHotel;
        } catch (Throwable $e) {
            if ($promotedPath !== null && $promotedPath !== $oldFilePath) {
                $this->imageService->deleteImage($promotedPath);
            }
            throw $e;
        }
    }

    /**
     * Delete a hotel and purge its image
     *
     * @throws Throwable
     */
    public function deleteHotel(int $hotelId): void
    {
        $hotel = $this->findHotelOrFail($hotelId);
        $filePath = $hotel->file_path;

        DB::transaction(function () use ($hotel): void {
            $hotel->delete();
        });

        if ($filePath !== null) {
            $this->imageService->deleteImage($filePath);
        }
    }
}
