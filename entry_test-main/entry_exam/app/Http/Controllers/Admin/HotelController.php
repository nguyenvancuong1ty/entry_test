<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ConfirmEditHotelRequest;
use App\Http\Requests\Admin\DeleteHotelRequest;
use App\Http\Requests\Admin\SearchHotelRequest;
use App\Http\Requests\Admin\StoreHotelRequest;
use App\Http\Requests\Admin\UpdateHotelRequest;
use App\Services\HotelService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Throwable;

class HotelController extends Controller
{
    public function __construct(
        private readonly HotelService $hotelService,
    ) {
    }

    /**
     * Show hotel search page
     */
    public function showSearch(): View
    {
        $prefectures = $this->hotelService->getAllPrefectures();

        return view('admin.hotel.search', compact('prefectures'));
    }

    /**
     * Process hotel search and display results
     */
    public function searchResult(SearchHotelRequest $request): View
    {
        $prefectures = $this->hotelService->getAllPrefectures();

        if ($request->isEmptySearch()) {
            return view('admin.hotel.search', [
                'prefectures' => $prefectures,
                'errorMessage' => '何も入力されていません',
                'hotel_name' => '',
                'prefecture_id' => '',
            ]);
        }

        $hotelList = $this->hotelService->searchHotels(
            $request->getHotelName(),
            $request->getPrefectureId()
        );

        return view('admin.hotel.result', [
            'hotelList' => $hotelList,
            'prefectures' => $prefectures,
            'hotel_name' => $request->getHotelName(),
            'prefecture_id' => $request->getPrefectureId(),
        ]);
    }

    /**
     * Show hotel creation page
     */
    public function showCreate(): View
    {
        $prefectures = $this->hotelService->getAllPrefectures();

        return view('admin.hotel.create', compact('prefectures'));
    }

    /**
     * Store a newly created hotel
     */
    public function create(StoreHotelRequest $request): RedirectResponse
    {
        try {
            $this->hotelService->createHotel(
                $request->string('hotel_name')->value(),
                $request->integer('prefecture_id'),
                $request->file('file')
            );

            return redirect()->route('adminHotelCreatePage')
                ->with('success_message', 'ホテル情報を登録しました。');
        } catch (Throwable $e) {
            Log::error('Failed to create hotel: ' . $e->getMessage(), [
                'exception' => $e,
                'input' => $request->validated(),
            ]);

            return redirect()->route('adminHotelCreatePage')
                ->withInput()
                ->with('error_message', 'ホテル情報の登録に失敗しました。');
        }
    }

    /**
     * Show hotel edit input page (Step 1)
     */
    public function showEdit(Request $request): View
    {
        $hotel = $this->hotelService->findHotelOrFail($request->integer('hotel_id'));
        $prefectures = $this->hotelService->getAllPrefectures();

        return view('admin.hotel.edit', compact('hotel', 'prefectures'));
    }

    /**
     * Confirm hotel edit contents (Step 2)
     */
    public function confirmEdit(ConfirmEditHotelRequest $request): View|RedirectResponse
    {
        try {
            $confirmationData = $this->hotelService->prepareEditConfirmation(
                $request->integer('hotel_id'),
                $request->string('hotel_name')->value(),
                $request->integer('prefecture_id'),
                $request->file('file'),
                $request->validated('current_new_file_path')
            );

            return view('admin.hotel.edit_confirm', $confirmationData);
        } catch (Throwable $e) {
            Log::error('Failed to prepare hotel edit confirmation: ' . $e->getMessage(), [
                'exception' => $e,
                'input' => $request->validated(),
            ]);

            return redirect()->route('adminHotelEditPage', ['hotel_id' => $request->integer('hotel_id')])
                ->withInput()
                ->with('error_message', '確認画面の表示に失敗しました。');
        }
    }

    /**
     * Process hotel update and show completion page (Step 3)
     */
    public function edit(UpdateHotelRequest $request): View|RedirectResponse
    {
        try {
            $hotel = $this->hotelService->updateHotel(
                $request->integer('hotel_id'),
                $request->string('hotel_name')->value(),
                $request->integer('prefecture_id'),
                $request->validated('new_file_path')
            );

            return view('admin.hotel.edit_complete', compact('hotel'));
        } catch (Throwable $e) {
            Log::error('Failed to update hotel: ' . $e->getMessage(), [
                'exception' => $e,
                'input' => $request->validated(),
            ]);

            return redirect()->route('adminHotelEditPage', ['hotel_id' => $request->integer('hotel_id')])
                ->withInput()
                ->with('error_message', 'ホテル情報の更新に失敗しました。');
        }
    }

    /**
     * Delete a hotel
     */
    public function delete(DeleteHotelRequest $request): RedirectResponse
    {
        try {
            $this->hotelService->deleteHotel($request->integer('hotel_id'));

            return redirect()->route('adminHotelSearchPage')
                ->with('success_message', 'ホテル情報を削除しました。');
        } catch (Throwable $e) {
            Log::error('Failed to delete hotel: ' . $e->getMessage(), [
                'exception' => $e,
                'hotel_id' => $request->integer('hotel_id'),
            ]);

            return redirect()->route('adminHotelSearchPage')
                ->with('error_message', 'ホテル情報の削除に失敗しました。');
        }
    }
}
