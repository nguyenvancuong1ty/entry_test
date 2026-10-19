<?php

declare(strict_types=1);

namespace App\Casts;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class DateTimeMinute implements CastsAttributes
{
    /**
     * Disable object caching so get() is always invoked to configure Carbon toStringFormat.
     */
    public bool $withoutObjectCaching = true;

    /**
     * Create a new cast instance.
     *
     * @param string|null $format Optional custom format override
     */
    public function __construct(
        protected ?string $format = null,
    ) {
    }

    /**
     * Cast the given value from database.
     *
     * @param array<string, mixed> $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ?Carbon
    {
        if ($value === null) {
            return null;
        }

        $format = $this->format ?? (string) config('booking.datetime_format', 'Y-m-d H:i');

        $date = Carbon::parse($value);
        $date->settings(['toStringFormat' => $format]);

        return $date;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param array<string, mixed> $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof Carbon) {
            return $value->toDateTimeString();
        }

        return Carbon::parse($value)->toDateTimeString();
    }
}
