<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Hotel;
use App\Models\Prefecture;
use Carbon\Carbon;
use Tests\TestCase;

class AdminBookingTest extends TestCase
{
    /**
     * Test booking search screen loads successfully
     */
    public function test_booking_search_screen_loads(): void
    {
        $response = $this->get(route('adminBookingSearchPage'));

        $response->assertStatus(200);
        $response->assertSee('予約情報検索');
        $response->assertSee('顧客名');
        $response->assertSee('顧客連絡先');
        $response->assertSee('チェックイン日時');
        $response->assertSee('チェックアウト日時');
    }

    /**
     * Test search by customer name (partial match)
     */
    public function test_booking_search_by_customer_name(): void
    {
        $hotel = Hotel::first();
        $uniqueName = '山田_特異太郎_' . uniqid();

        $booking = Booking::create([
            'hotel_id' => $hotel->hotel_id,
            'customer_name' => $uniqueName,
            'customer_contact' => '090-0000-1111',
            'chekin_time' => Carbon::now()->addDays(2),
            'checkout_time' => Carbon::now()->addDays(4),
        ]);

        $response = $this->post(route('adminBookingSearchResult'), [
            'customer_name' => '特異太郎',
        ]);

        $response->assertStatus(200);
        $response->assertSee($uniqueName);
        $response->assertSee('090-0000-1111');
        $response->assertSee($hotel->hotel_name);
    }

    /**
     * Test search by customer contact (partial match)
     */
    public function test_booking_search_by_customer_contact(): void
    {
        $hotel = Hotel::first();
        $uniqueContact = 'contact_' . uniqid() . '@domain.test';

        $booking = Booking::create([
            'hotel_id' => $hotel->hotel_id,
            'customer_name' => '連絡先テスト顧客',
            'customer_contact' => $uniqueContact,
            'chekin_time' => Carbon::now()->addDays(1),
            'checkout_time' => Carbon::now()->addDays(3),
        ]);

        $response = $this->post(route('adminBookingSearchResult'), [
            'customer_contact' => $uniqueContact,
        ]);

        $response->assertStatus(200);
        $response->assertSee($uniqueContact);
        $response->assertSee('連絡先テスト顧客');
    }

    /**
     * Test search by check-in date
     */
    public function test_booking_search_by_checkin_date(): void
    {
        $hotel = Hotel::first();
        $targetDate = Carbon::create(2027, 5, 20, 15, 0, 0);

        $booking = Booking::create([
            'hotel_id' => $hotel->hotel_id,
            'customer_name' => '日付テスト顧客',
            'customer_contact' => '080-1111-2222',
            'chekin_time' => $targetDate,
            'checkout_time' => (clone $targetDate)->addDays(2),
        ]);

        $response = $this->post(route('adminBookingSearchResult'), [
            'chekin_time' => '2027-05-20',
        ]);

        $response->assertStatus(200);
        $response->assertSee('日付テスト顧客');
    }

    /**
     * Test search with no matching records returns empty state
     */
    public function test_booking_search_empty_results(): void
    {
        $response = $this->post(route('adminBookingSearchResult'), [
            'customer_name' => '存在しないはずの顧客名_' . uniqid(),
        ]);

        $response->assertStatus(200);
        $response->assertSee('予約情報が見つかりません');
    }

    /**
     * Test validation error when customer_name is too long
     */
    public function test_booking_search_validation_error(): void
    {
        $response = $this->post(route('adminBookingSearchResult'), [
            'customer_name' => str_repeat('A', 256),
        ]);

        $response->assertSessionHasErrors(['customer_name']);
    }

    /**
     * Test validation error when date format is invalid
     */
    public function test_booking_search_invalid_date_validation_error(): void
    {
        $response = $this->post(route('adminBookingSearchResult'), [
            'chekin_time' => 'invalid-date-format',
        ]);

        $response->assertSessionHasErrors(['chekin_time']);
    }

    /**
     * Test Hotel and Booking relationships
     */
    public function test_hotel_and_booking_relationships(): void
    {
        $hotel = Hotel::first();
        $booking = Booking::create([
            'hotel_id' => $hotel->hotel_id,
            'customer_name' => 'リレーションテスト',
            'customer_contact' => '070-9999-8888',
            'chekin_time' => Carbon::now()->addDay(),
            'checkout_time' => Carbon::now()->addDays(2),
        ]);

        $this->assertInstanceOf(Hotel::class, $booking->hotel);
        $this->assertEquals($hotel->hotel_id, $booking->hotel->hotel_id);

        $this->assertTrue($hotel->bookings()->where('booking_id', $booking->booking_id)->exists());
    }

    /**
     * Test booking search pagination, per_page options, and count text
     */
    public function test_booking_search_pagination_and_per_page(): void
    {
        $response = $this->get(route('adminBookingSearchResult', [
            'per_page' => 10,
        ]));

        $response->assertStatus(200);
        $response->assertSee('表示件数:');
        $response->assertSee('10 件');
        $response->assertSee('20 件');
        $response->assertSee('30 件');
        $response->assertSee('50 件');
        $response->assertSee('100 件');
    }

    /**
     * Test booking search preserves search criteria in pagination URLs
     */
    public function test_booking_search_pagination_preserves_query_parameters_across_pages(): void
    {
        $hotel = Hotel::first();
        for ($i = 0; $i < 15; $i++) {
            Booking::create([
                'hotel_id' => $hotel->hotel_id,
                'customer_name' => 'ページネーション顧客 ' . $i,
                'customer_contact' => '090-1111-' . sprintf('%04d', $i),
                'chekin_time' => Carbon::now()->addDays($i),
                'checkout_time' => Carbon::now()->addDays($i + 1),
            ]);
        }

        $response = $this->post(route('adminBookingSearchResult'), [
            'customer_name' => 'ページネーション顧客',
            'per_page' => 10,
        ]);

        $response->assertStatus(200);
        $response->assertSee('customer_name=' . urlencode('ページネーション顧客'));
    }
}

