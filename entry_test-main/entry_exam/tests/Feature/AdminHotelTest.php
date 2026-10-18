<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Hotel;
use App\Models\Prefecture;
use App\Services\HotelService;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Mockery;
use Tests\TestCase;

class AdminHotelTest extends TestCase
{
    /**
     * Test hotel search with empty inputs shows error message
     */
    public function test_hotel_search_empty_shows_error(): void
    {
        $response = $this->post(route('adminHotelSearchResult'), [
            'hotel_name' => '',
            'prefecture_id' => '',
        ]);

        $response->assertStatus(200);
        $response->assertSee('何も入力されていません');
    }

    /**
     * Test hotel search with partial hotel name
     */
    public function test_hotel_search_partial_name(): void
    {
        $firstHotel = Hotel::first();
        $this->assertNotNull($firstHotel);

        $subName = mb_substr($firstHotel->hotel_name, 0, 4);

        $response = $this->post(route('adminHotelSearchResult'), [
            'hotel_name' => $subName,
            'prefecture_id' => '',
        ]);

        $response->assertStatus(200);
        $response->assertSee($firstHotel->hotel_name);
    }

    /**
     * Test hotel search with prefecture
     */
    public function test_hotel_search_by_prefecture(): void
    {
        $firstHotel = Hotel::first();
        $this->assertNotNull($firstHotel);

        $response = $this->post(route('adminHotelSearchResult'), [
            'hotel_name' => '',
            'prefecture_id' => $firstHotel->prefecture_id,
        ]);

        $response->assertStatus(200);
        $response->assertSee($firstHotel->hotel_name);
    }

    /**
     * Test hotel creation screen loads
     */
    public function test_hotel_create_screen_loads(): void
    {
        $response = $this->get(route('adminHotelCreatePage'));
        $response->assertStatus(200);
        $response->assertSee('ホテル追加');
        $response->assertSee('ホテル名');
        $response->assertSee('都道府県');
    }

    /**
     * Test hotel creation validation
     */
    public function test_hotel_create_validation(): void
    {
        $response = $this->post(route('adminHotelCreateProcess'), [
            'hotel_name' => '',
            'prefecture_id' => '',
        ]);

        $response->assertSessionHasErrors(['hotel_name', 'prefecture_id']);
    }

    /**
     * Test hotel creation successfully
     */
    public function test_hotel_create_success(): void
    {
        $prefecture = Prefecture::first();
        $uniqueName = 'テストホテル_' . uniqid();

        $response = $this->post(route('adminHotelCreateProcess'), [
            'hotel_name' => $uniqueName,
            'prefecture_id' => $prefecture->prefecture_id,
        ]);

        $response->assertRedirect(route('adminHotelCreatePage'));
        $response->assertSessionHas('success_message');

        $this->assertDatabaseHas('hotels', [
            'hotel_name' => $uniqueName,
            'prefecture_id' => $prefecture->prefecture_id,
        ]);

        // Verify it appears in user list
        $userListResponse = $this->get(route('hotelList', [
            'prefecture_name_alpha' => $prefecture->prefecture_name_alpha,
        ]));
        $userListResponse->assertStatus(200);
        $userListResponse->assertSee($uniqueName);
    }

    /**
     * Test hotel creation with image upload
     */
    public function test_hotel_create_with_image_upload(): void
    {
        $prefecture = Prefecture::first();
        $uniqueName = '画像付きホテル_' . uniqid();
        $file = UploadedFile::fake()->image('hotel_sample.jpg', 600, 400);

        $response = $this->post(route('adminHotelCreateProcess'), [
            'hotel_name' => $uniqueName,
            'prefecture_id' => $prefecture->prefecture_id,
            'file' => $file,
        ]);

        $response->assertRedirect(route('adminHotelCreatePage'));

        $createdHotel = Hotel::where('hotel_name', $uniqueName)->first();
        $this->assertNotNull($createdHotel);
        $this->assertNotNull($createdHotel->file_path);
        $this->assertStringStartsWith('hotel/', $createdHotel->file_path);

        // Verify file was saved in public/assets/img/hotel
        $fullPath = public_path('assets/img/' . $createdHotel->file_path);
        $this->assertFileExists($fullPath);

        // Clean up
        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    }

    /**
     * Test hotel edit 3-step transition
     */
    public function test_hotel_edit_three_step_flow(): void
    {
        $prefecture = Prefecture::first();
        $hotel = Hotel::create([
            'hotel_name' => '編集前ホテル_' . uniqid(),
            'prefecture_id' => $prefecture->prefecture_id,
        ]);

        // Step 1: Input screen
        $step1Response = $this->get(route('adminHotelEditPage', ['hotel_id' => $hotel->hotel_id]));
        $step1Response->assertStatus(200);
        $step1Response->assertSee($hotel->hotel_name);

        // Step 2: Confirmation screen
        $updatedName = '編集後ホテル_' . uniqid();
        $step2Response = $this->post(route('adminHotelEditConfirm'), [
            'hotel_id' => $hotel->hotel_id,
            'hotel_name' => $updatedName,
            'prefecture_id' => $prefecture->prefecture_id,
        ]);
        $step2Response->assertStatus(200);
        $step2Response->assertSee('ホテル編集（確認画面）');
        $step2Response->assertSee($updatedName);

        // Step 3: Completion screen with method PUT
        $step3Response = $this->put(route('adminHotelEditProcess'), [
            'hotel_id' => $hotel->hotel_id,
            'hotel_name' => $updatedName,
            'prefecture_id' => $prefecture->prefecture_id,
        ]);
        $step3Response->assertStatus(200);
        $step3Response->assertSee('ホテル編集（完了画面）');
        $step3Response->assertSee('ホテル情報の更新が完了しました。');

        // Check database
        $this->assertDatabaseHas('hotels', [
            'hotel_id' => $hotel->hotel_id,
            'hotel_name' => $updatedName,
        ]);
    }

    /**
     * Test hotel delete with method DELETE and image purge
     */
    public function test_hotel_delete_with_image_purge(): void
    {
        $prefecture = Prefecture::first();
        $dummyImageName = 'hotel/test_delete_' . uniqid() . '.jpg';
        $fullPath = public_path('assets/img/' . $dummyImageName);
        File::ensureDirectoryExists(dirname($fullPath));
        File::put($fullPath, 'fake image content');

        $hotel = Hotel::create([
            'hotel_name' => '削除対象ホテル_' . uniqid(),
            'prefecture_id' => $prefecture->prefecture_id,
            'file_path' => $dummyImageName,
        ]);

        $this->assertFileExists($fullPath);

        $response = $this->delete(route('adminHotelDeleteProcess'), [
            'hotel_id' => $hotel->hotel_id,
        ]);

        $response->assertRedirect(route('adminHotelSearchPage'));
        $this->assertDatabaseMissing('hotels', [
            'hotel_id' => $hotel->hotel_id,
        ]);

        // File should be purged from disk
        $this->assertFileDoesNotExist($fullPath);
    }

    /**
     * Test search result screen has JavaScript confirm for delete
     */
    public function test_search_result_has_delete_confirmation(): void
    {
        $hotel = Hotel::first();
        $response = $this->post(route('adminHotelSearchResult'), [
            'hotel_name' => $hotel->hotel_name,
            'prefecture_id' => '',
        ]);

        $response->assertStatus(200);
        $response->assertSee('本当に削除しますか？');
    }

    /**
     * Test imageUrl attribute accessor on Hotel model
     */
    public function test_hotel_image_url_accessor(): void
    {
        $hotelWithImage = new Hotel(['file_path' => 'hotel/test.jpg']);
        $this->assertNotNull($hotelWithImage->image_url);
        $this->assertStringContainsString('assets/img/hotel/test.jpg', $hotelWithImage->image_url);

        $hotelWithoutImage = new Hotel(['file_path' => null]);
        $this->assertNull($hotelWithoutImage->image_url);
    }

    /**
     * Test controller handles exception during creation gracefully and logs error
     */
    public function test_hotel_create_exception_logs_and_redirects_with_error(): void
    {
        Log::shouldReceive('error')
            ->once()
            ->withArgs(fn ($msg) => str_contains((string) $msg, 'Failed to create hotel'));

        $mockService = Mockery::mock(HotelService::class);
        $mockService->shouldReceive('createHotel')
            ->once()
            ->andThrow(new Exception('Simulated database error'));

        $this->app->instance(HotelService::class, $mockService);

        $prefecture = Prefecture::first();
        $response = $this->post(route('adminHotelCreateProcess'), [
            'hotel_name' => 'エラーテストホテル',
            'prefecture_id' => $prefecture->prefecture_id,
        ]);

        $response->assertRedirect(route('adminHotelCreatePage'));
        $response->assertSessionHas('error_message', 'ホテル情報の登録に失敗しました。');
    }

    /**
     * Test controller handles exception during delete gracefully and logs error
     */
    public function test_hotel_delete_exception_logs_and_redirects_with_error(): void
    {
        Log::shouldReceive('error')
            ->once()
            ->withArgs(fn ($msg) => str_contains((string) $msg, 'Failed to delete hotel'));

        $mockService = Mockery::mock(HotelService::class);
        $mockService->shouldReceive('deleteHotel')
            ->once()
            ->andThrow(new Exception('Simulated delete error'));

        $this->app->instance(HotelService::class, $mockService);

        $hotel = Hotel::first();
        $response = $this->delete(route('adminHotelDeleteProcess'), [
            'hotel_id' => $hotel->hotel_id,
        ]);

        $response->assertRedirect(route('adminHotelSearchPage'));
        $response->assertSessionHas('error_message', 'ホテル情報の削除に失敗しました。');
    }

    /**
     * Test backward compatibility of Prefecture->hotel() alias
     */
    public function test_prefecture_hotel_backward_compatibility(): void
    {
        $prefecture = Prefecture::first();
        $this->assertNotNull($prefecture);
        $this->assertTrue(method_exists($prefecture, 'hotel'));
        $this->assertTrue(method_exists($prefecture, 'hotels'));
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $prefecture->hotel());
    }

    /**
     * Test backward compatibility of Hotel::getHotelListByName() static method
     */
    public function test_hotel_get_hotel_list_by_name_backward_compatibility(): void
    {
        $hotel = Hotel::first();
        $this->assertNotNull($hotel);

        $results = Hotel::getHotelListByName($hotel->hotel_name);
        $this->assertIsArray($results);
        $this->assertNotEmpty($results);
        $this->assertEquals($hotel->hotel_id, $results[0]['hotel_id']);
    }

    /**
     * Test hotel search pagination, per_page options, and count text
     */
    public function test_hotel_search_pagination_and_per_page(): void
    {
        $response = $this->get(route('adminHotelSearchResult', [
            'hotel_name' => 'ホテル',
            'per_page' => 20,
        ]));

        $response->assertStatus(200);
        $response->assertSee('表示件数:');
        $response->assertSee('20 件');
        $response->assertSee('全');
        $response->assertSee('件を表示');
    }

    /**
     * Test hotel search preserves search criteria in pagination URLs and page 2 does not show empty error
     */
    public function test_hotel_search_pagination_preserves_query_parameters_across_pages(): void
    {
        // 1. Initial search via POST
        $postResponse = $this->post(route('adminHotelSearchResult'), [
            'hotel_name' => 'ホテル',
        ]);

        $postResponse->assertStatus(200);
        $postResponse->assertDontSee('何も入力されていません');
        // Pagination link should include hotel_name
        $postResponse->assertSee('hotel_name=' . urlencode('ホテル'));

        // 2. Navigating to page 2 via GET with preserved query params
        $page2Response = $this->get(route('adminHotelSearchResult', [
            'hotel_name' => 'ホテル',
            'page' => 2,
        ]));

        $page2Response->assertStatus(200);
        $page2Response->assertDontSee('何も入力されていません');
        $page2Response->assertSee('value="ホテル"', false);
    }

    /**
     * Test pagination and hotel configurations are loaded and applied correctly
     */
    public function test_pagination_and_hotel_configurations(): void
    {
        $this->assertEquals(10, config('pagination.default_per_page'));
        $this->assertEquals([10, 20, 30, 50, 100], config('pagination.options'));
        $this->assertEquals(2, config('pagination.on_each_side'));

        $this->assertEquals('hotel', config('hotel.image.base_dir'));
        $this->assertEquals('hotel/tmp', config('hotel.image.temp_dir'));
        $this->assertEquals(2048, config('hotel.image.max_size_kb'));
        $this->assertContains('jpeg', config('hotel.image.allowed_mimes'));
    }
}

