<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    /**
     * @var string
     */
    protected $primaryKey = 'booking_id';

    /**
     * @var list<string>
     */
    protected $guarded = ['booking_id'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'chekin_time' => 'datetime',
        'checkout_time' => 'datetime',
    ];

    /**
     * Get the hotel associated with the booking
     */
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class, 'hotel_id', 'hotel_id');
    }

    /**
     * Scope a query to filter by customer name (partial match)
     */
    public function scopeFilterByCustomerName(Builder $query, ?string $name): Builder
    {
        if ($name === null || trim($name) === '') {
            return $query;
        }

        $escaped = addcslashes(trim($name), '%_\\');

        return $query->where('customer_name', 'LIKE', '%' . $escaped . '%');
    }

    /**
     * Scope a query to filter by customer contact (partial match)
     */
    public function scopeFilterByCustomerContact(Builder $query, ?string $contact): Builder
    {
        if ($contact === null || trim($contact) === '') {
            return $query;
        }

        $escaped = addcslashes(trim($contact), '%_\\');

        return $query->where('customer_contact', 'LIKE', '%' . $escaped . '%');
    }

    /**
     * Scope a query to filter by check-in time (matches date or from specified datetime)
     */
    public function scopeFilterByCheckinTime(Builder $query, ?string $checkinTime): Builder
    {
        if ($checkinTime === null || trim($checkinTime) === '') {
            return $query;
        }

        $trimmed = trim($checkinTime);
        $timezone = config('app.timezone', 'UTC');

        // If user input is date only (YYYY-MM-DD), filter within that day using application timezone
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $trimmed)) {
            try {
                $start = Carbon::createFromFormat('Y-m-d', $trimmed, $timezone)->startOfDay();
                $end = Carbon::createFromFormat('Y-m-d', $trimmed, $timezone)->endOfDay();
                return $query->whereBetween('chekin_time', [$start, $end]);
            } catch (\Throwable) {
                return $query->whereDate('chekin_time', '=', $trimmed);
            }
        }

        return $query->where('chekin_time', '>=', $trimmed);
    }

    /**
     * Scope a query to filter by check-out time (matches date or up to specified datetime)
     */
    public function scopeFilterByCheckoutTime(Builder $query, ?string $checkoutTime): Builder
    {
        if ($checkoutTime === null || trim($checkoutTime) === '') {
            return $query;
        }

        $trimmed = trim($checkoutTime);
        $timezone = config('app.timezone', 'UTC');

        // If user input is date only (YYYY-MM-DD), filter within that day using application timezone
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $trimmed)) {
            try {
                $start = Carbon::createFromFormat('Y-m-d', $trimmed, $timezone)->startOfDay();
                $end = Carbon::createFromFormat('Y-m-d', $trimmed, $timezone)->endOfDay();
                return $query->whereBetween('checkout_time', [$start, $end]);
            } catch (\Throwable) {
                return $query->whereDate('checkout_time', '=', $trimmed);
            }
        }

        return $query->where('checkout_time', '<=', $trimmed);
    }

    /**
     * Scope a query to search bookings by various filters
     *
     * @param array{customer_name?: ?string, customer_contact?: ?string, chekin_time?: ?string, checkout_time?: ?string} $filters
     */
    public function scopeSearch(Builder $query, array $filters = []): Builder
    {
        return $query
            ->with(['hotel.prefecture'])
            ->filterByCustomerName($filters['customer_name'] ?? null)
            ->filterByCustomerContact($filters['customer_contact'] ?? null)
            ->filterByCheckinTime($filters['chekin_time'] ?? null)
            ->filterByCheckoutTime($filters['checkout_time'] ?? null)
            ->orderBy('booking_id', 'desc');
    }

    /**
     * Override serializeDate method to customize date format
     */
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
