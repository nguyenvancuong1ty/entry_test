<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use DateTime;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // TRUNCATE DATABASE
        Schema::disableForeignKeyConstraints(); // invalid foreign key constraints
        DB::table('hotels')->truncate();
        Schema::enableForeignKeyConstraints(); // valid foreign key constraints

        $hotel_data = [];

        // ホテル種類
        $hotel_type = [
            'ビジネスホテル',
            'シティホテル',
            'リゾートホテル',
            'カプセルホテル',
            '旅館',
            'グランピング',
            'ゲストハウス'
        ];

        // ホテル種類 Enlish
        $hotel_type_alpha = [
            'business',
            'city',
            'resort',
            'capsule',
            'inn',
            'glamping',
            'guesthouse'
        ];

        // 都道府県
        $prefs = [
            '北海道',
            '青森',
            '秋田',
            '岩手',
            '山形',
            '福島',
            '宮城',
            '群馬',
            '栃木',
            '茨城',
            '東京',
            '神奈川',
            '千葉',
            '埼玉',
            '愛知',
            '静岡',
            '三重',
            '岐阜',
            '石川',
            '福井',
            '富山',
            '新潟',
            '長野',
            '山梨',
            '大阪',
            '兵庫',
            '京都',
            '滋賀',
            '奈良',
            '和歌山',
            '広島',
            '岡山',
            '山口',
            '鳥取',
            '島根',
            '香川',
            '徳島',
            '高知',
            '愛媛',
            '福岡',
            '長崎',
            '大分',
            '佐賀',
            '熊本',
            '宮崎',
            '鹿児島',
            '沖縄',
        ];

        // ホテル名 組み合わせ
        foreach ($prefs as $pref_key => $pref_val) {
            $pref_key++;    // Match primary key of prefectures table.
            foreach ($hotel_type as $hotel_type_key => $hotel_type_val) {
                $hotel_name = $hotel_type_val . ' ' . $pref_val;
                $file_path = 'hoteltype/' . $hotel_type_alpha[$hotel_type_key] . '.png';

                if (preg_match('/ビジネスホテル|シティホテル|リゾートホテル/', $hotel_type_val) === 1) {
                    $hotel_name = $hotel_type_val . ' ' . $pref_val . ' A';

                    $hotel_data[] = [
                        'hotel_name' => $hotel_type_val . ' ' . $pref_val . ' B',
                        'prefecture_id' => $pref_key,
                        'file_path' => $file_path,
                        'created_at' => new DateTime(),
                        'updated_at' => new DateTime(),
                    ];
                    $hotel_data[] = [
                        'hotel_name' => $hotel_type_val . ' ' . $pref_val . ' C',
                        'prefecture_id' => $pref_key,
                        'file_path' => $file_path,
                        'created_at' => new DateTime(),
                        'updated_at' => new DateTime(),
                    ];
                    $hotel_data[] = [
                        'hotel_name' => $hotel_type_val . ' ' . $pref_val . ' D',
                        'prefecture_id' => $pref_key,
                        'file_path' => $file_path,
                        'created_at' => new DateTime(),
                        'updated_at' => new DateTime(),
                    ];
                    $hotel_data[] = [
                        'hotel_name' => $hotel_type_val . ' ' . $pref_val . ' E',
                        'prefecture_id' => $pref_key,
                        'file_path' => $file_path,
                        'created_at' => new DateTime(),
                        'updated_at' => new DateTime(),
                    ];
                }

                $hotel_data[] = [
                    'hotel_name' => $hotel_name,
                    'prefecture_id' => $pref_key,
                    'file_path' => $file_path,
                    'created_at' => new DateTime(),
                    'updated_at' => new DateTime(),
                ];
            }
        }

        // INSERT INTO DATABASE
        foreach ($hotel_data as $value) {
            DB::table('hotels')->insert($value);
        }
    }
}
