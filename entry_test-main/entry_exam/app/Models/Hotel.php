<?php

declare(strict_types=1);

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hotel extends Model
{
    /**
     * @var string
     */
    protected $primaryKey = 'hotel_id';

    /**
     * @var list<string>
     */
    protected $guarded = ['hotel_id'];

    /**
     * Get the prefecture that owns the hotel
     */
    public function prefecture(): BelongsTo
    {
        return $this->belongsTo(Prefecture::class, 'prefecture_id', 'prefecture_id');
    }

    /**
     * Get bookings for the hotel
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'hotel_id', 'hotel_id');
    }

    /**
     * Get the resolved public URL of the hotel image
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: function (): ?string {
                if (empty($this->file_path)) {
                    return null;
                }

                return asset('assets/img/' . $this->file_path);
            },
        );
    }

    /**
     * Scope a query to filter by partial hotel name with escaped wildcards
     */
    public function scopeFilterByName(Builder $query, ?string $name): Builder
    {
        if ($name === null || trim($name) === '') {
            return $query;
        }

        $escaped = addcslashes(trim($name), '%_\\');

        return $query->where('hotel_name', 'LIKE', '%' . $escaped . '%');
    }

    /**
     * Scope a query to filter by prefecture ID
     */
    public function scopeFilterByPrefecture(Builder $query, ?int $prefectureId): Builder
    {
        if (empty($prefectureId)) {
            return $query;
        }

        return $query->where('prefecture_id', $prefectureId);
    }

    /**
     * Scope a query to search hotels by name and/or prefecture
     */
    public function scopeSearch(Builder $query, ?string $name = null, ?int $prefectureId = null): Builder
    {
        return $query
            ->with('prefecture')
            ->filterByName($name)
            ->filterByPrefecture($prefectureId);
    }

    /**
     * Search hotel by hotel name (kept for backward compatibility with initial test specification)
     *
     * @param string $hotelName
     * @return array<int, mixed>
     */
    public static function getHotelListByName(string $hotelName): array
    {
        return self::query()
            ->filterByName($hotelName)
            ->with('prefecture')
            ->get()
            ->toArray();
    }

    /**
     * Override serializeDate method to customize date format
     */
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
