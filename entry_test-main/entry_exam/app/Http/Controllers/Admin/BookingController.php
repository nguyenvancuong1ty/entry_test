<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SearchBookingRequest;
use App\Services\BookingService;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function __construct(
        private readonly BookingService $bookingService,
    ) {
    }

    /**
     * Show booking search page (loads all booking data by default with pagination)
     */
    public function showSearch(SearchBookingRequest $request): View
    {
        return $this->searchResult($request);
    }

    /**
     * Process booking search and display results
     */
    public function searchResult(SearchBookingRequest $request): View
    {
        $filters = $request->toFilters();

        $bookingList = $this->bookingService->searchBookings($filters, $request->getPerPage());

        return view('admin.booking.result', [
            'bookingList' => $bookingList,
            'filters' => $filters,
            'per_page' => $request->getPerPage(),
        ]);
    }
}
