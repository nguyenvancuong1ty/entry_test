<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Hotel;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('bookings')->truncate();
        Schema::enableForeignKeyConstraints();

        $hotels = Hotel::all();
        if ($hotels->isEmpty()) {
            return;
        }

        $sampleBookings = [
            [
                'customer_name' => '佐藤 太郎',
                'customer_contact' => '090-1234-5678',
                'checkin_offset' => 1,
                'stay_days' => 2,
            ],
            [
                'customer_name' => '鈴木 一郎',
                'customer_contact' => 'suzuki.ichiro@example.com',
                'checkin_offset' => 3,
                'stay_days' => 1,
            ],
            [
                'customer_name' => '田中 美咲',
                'customer_contact' => '080-9876-5432',
                'checkin_offset' => 5,
                'stay_days' => 3,
            ],
            [
                'customer_name' => '高橋 健太',
                'customer_contact' => 'takahashi.kenta@example.jp',
                'checkin_offset' => 7,
                'stay_days' => 2,
            ],
            [
                'customer_name' => '渡辺 花子',
                'customer_contact' => '070-5555-1111',
                'checkin_offset' => -2,
                'stay_days' => 2,
            ],
            [
                'customer_name' => '伊藤 誠',
                'customer_contact' => 'ito.makoto@example.com',
                'checkin_offset' => 10,
                'stay_days' => 4,
            ],
            [
                'customer_name' => '山本 裕子',
                'customer_contact' => '090-4444-2222',
                'checkin_offset' => 14,
                'stay_days' => 1,
            ],
            [
                'customer_name' => '中村 翔太',
                'customer_contact' => 'nakamura.shota@example.com',
                'checkin_offset' => -5,
                'stay_days' => 3,
            ],
            [
                'customer_name' => '小林 さくら',
                'customer_contact' => '080-3333-7777',
                'checkin_offset' => 20,
                'stay_days' => 2,
            ],
            [
                'customer_name' => '加藤 勇気',
                'customer_contact' => 'kato.yuki@example.jp',
                'checkin_offset' => 0,
                'stay_days' => 1,
            ],
            [
                'customer_name' => '吉田 拓也',
                'customer_contact' => '090-8888-9999',
                'checkin_offset' => 4,
                'stay_days' => 2,
            ],
            [
                'customer_name' => '山田 陽菜',
                'customer_contact' => 'yamada.hina@example.com',
                'checkin_offset' => 8,
                'stay_days' => 1,
            ],
            [
                'customer_name' => '佐々木 健司',
                'customer_contact' => '080-1212-3434',
                'checkin_offset' => 12,
                'stay_days' => 3,
            ],
            [
                'customer_name' => '山口 葵',
                'customer_contact' => 'yamaguchi.aoi@example.jp',
                'checkin_offset' => -3,
                'stay_days' => 2,
            ],
            [
                'customer_name' => '松本 大輔',
                'customer_contact' => '070-7777-8888',
                'checkin_offset' => 6,
                'stay_days' => 1,
            ],
            [
                'customer_name' => '井上 真央',
                'customer_contact' => 'inoue.mao@example.com',
                'checkin_offset' => 15,
                'stay_days' => 2,
            ],
            [
                'customer_name' => '木村 拓哉',
                'customer_contact' => '090-5656-7878',
                'checkin_offset' => 2,
                'stay_days' => 4,
            ],
            [
                'customer_name' => '林 優子',
                'customer_contact' => 'hayashi.yuko@example.jp',
                'checkin_offset' => 18,
                'stay_days' => 2,
            ],
            [
                'customer_name' => '斎藤 蓮',
                'customer_contact' => '080-6767-8989',
                'checkin_offset' => 9,
                'stay_days' => 3,
            ],
            [
                'customer_name' => '清水 結衣',
                'customer_contact' => 'shimizu.yui@example.com',
                'checkin_offset' => 25,
                'stay_days' => 1,
            ],
        ];

        $hotelCount = $hotels->count();
        $now = Carbon::now();

        foreach ($sampleBookings as $idx => $sample) {
            $hotel = $hotels[$idx % $hotelCount];
            $checkin = (clone $now)->addDays($sample['checkin_offset'])->setHour(15)->setMinute(0)->setSecond(0);
            $checkout = (clone $checkin)->addDays($sample['stay_days'])->setHour(10)->setMinute(0)->setSecond(0);
            $createdAt = (clone $now)->subDays(rand(1, 15));

            Booking::create([
                'hotel_id' => $hotel->hotel_id,
                'customer_name' => $sample['customer_name'],
                'customer_contact' => $sample['customer_contact'],
                'chekin_time' => $checkin,
                'checkout_time' => $checkout,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }
    }
}
