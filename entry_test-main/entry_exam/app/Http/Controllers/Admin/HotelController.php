<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Hotel;

class HotelController extends Controller
{
    /** get methods */

    public function showSearch(): View
    {
        return view('admin.hotel.search');
    }

    public function showResult(): View
    {
        return view('admin.hotel.result');
    }

    public function showEdit(): View
    {
        return view('admin.hotel.edit');
    }

    public function showCreate(): View
    {
        return view('admin.hotel.create');
    }

    /** post methods */

    public function searchResult(Request $request): View
    {
        $var = [];

        $hotelNameToSearch = $request->input('hotel_name');
        $hotelList = Hotel::getHotelListByName($hotelNameToSearch);

        $var['hotelList'] = $hotelList;

        return view('admin.hotel.result', $var);
    }

    public function edit(Request $request): void
    {
        //
    }

    public function create(Request $request): void
    {
        //
    }

    public function delete(Request $request): void
    {
        //
    }
}
