<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Booking;
use App\Models\Hotel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class BookingService
{
    /**
     * Search bookings based on provided filters with pagination
     *
     * @param array{customer_name?: ?string, customer_contact?: ?string, chekin_time?: ?string, checkout_time?: ?string} $filters
     * @return LengthAwarePaginator
     */
    public function searchBookings(array $filters = [], ?int $perPage = null): LengthAwarePaginator
    {
        $defaultPerPage = (int) config('pagination.default_per_page', 10);
        $perPage ??= $defaultPerPage;

        $params = array_filter($filters, static fn ($v) => $v !== null && $v !== '');
        if ($perPage !== $defaultPerPage) {
            $params['per_page'] = $perPage;
        }

        return Booking::query()
            ->search($filters)
            ->paginate($perPage)
            ->appends($params)
            ->withQueryString();
    }

    /**
     * Get all hotels for selection filter if needed
     *
     * @return Collection<int, Hotel>
     */
    public function getAllHotels(): Collection
    {
        return Hotel::with('prefecture')->orderBy('hotel_name')->get();
    }

    /**
     * Find a booking by its ID or fail
     */
    public function findBookingOrFail(int $bookingId): Booking
    {
        return Booking::with(['hotel.prefecture'])->findOrFail($bookingId);
    }
}
