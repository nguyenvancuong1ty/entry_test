<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use DateTime;

class PrefectureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // TRUNCATE DATABASE
        Schema::disableForeignKeyConstraints(); // invalid foreign key constraints
        DB::table('prefectures')->truncate();
        Schema::enableForeignKeyConstraints(); // valid foreign key constraints

        // 都道府県用の連想配列
        $prefs = [
            [
                'prefecture_name' => '北海道',
                'prefecture_name_alpha' => 'hokkaido',
                'file_path' => 'prefecture/hokkaido.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '青森県',
                'prefecture_name_alpha' => 'aomori',
                'file_path' => 'prefecture/aomori.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '秋田県',
                'prefecture_name_alpha' => 'akita',
                'file_path' => 'prefecture/akita.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '岩手県',
                'prefecture_name_alpha' => 'iwate',
                'file_path' => 'prefecture/iwate.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '山形県',
                'prefecture_name_alpha' => 'yamagata',
                'file_path' => 'prefecture/yamagata.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '福島県',
                'prefecture_name_alpha' => 'fukushima',
                'file_path' => 'prefecture/fukushima.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '宮城県',
                'prefecture_name_alpha' => 'miyagi',
                'file_path' => 'prefecture/miyagi.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '群馬県',
                'prefecture_name_alpha' => 'gunma',
                'file_path' => 'prefecture/gunma.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '栃木県',
                'prefecture_name_alpha' => 'tochigi',
                'file_path' => 'prefecture/tochigi.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '茨城県',
                'prefecture_name_alpha' => 'ibaraki',
                'file_path' => 'prefecture/ibaraki.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '東京都',
                'prefecture_name_alpha' => 'tokyo',
                'file_path' => 'prefecture/tokyo.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '神奈川県',
                'prefecture_name_alpha' => 'kanagawa',
                'file_path' => 'prefecture/kanagawa.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '千葉県',
                'prefecture_name_alpha' => 'chiba',
                'file_path' => 'prefecture/chiba.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '埼玉県',
                'prefecture_name_alpha' => 'saitama',
                'file_path' => 'prefecture/saitama.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '愛知県',
                'prefecture_name_alpha' => 'aichi',
                'file_path' => 'prefecture/aichi.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '静岡県',
                'prefecture_name_alpha' => 'shizuoka',
                'file_path' => 'prefecture/shizuoka.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '三重県',
                'prefecture_name_alpha' => 'mie',
                'file_path' => 'prefecture/mie.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '岐阜県',
                'prefecture_name_alpha' => 'gifu',
                'file_path' => 'prefecture/gifu.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '石川県',
                'prefecture_name_alpha' => 'ishikawa',
                'file_path' => 'prefecture/ishikawa.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '福井県',
                'prefecture_name_alpha' => 'fukui',
                'file_path' => 'prefecture/fukui.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '富山県',
                'prefecture_name_alpha' => 'toyama',
                'file_path' => 'prefecture/toyama.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '新潟県',
                'prefecture_name_alpha' => 'niigata',
                'file_path' => 'prefecture/niigata.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '長野県',
                'prefecture_name_alpha' => 'nagano',
                'file_path' => 'prefecture/nagano.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '山梨県',
                'prefecture_name_alpha' => 'yamanashi',
                'file_path' => 'prefecture/yamanashi.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '大阪府',
                'prefecture_name_alpha' => 'osaka',
                'file_path' => 'prefecture/osaka.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '兵庫県',
                'prefecture_name_alpha' => 'hyogo',
                'file_path' => 'prefecture/hyogo.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '京都府',
                'prefecture_name_alpha' => 'kyoto',
                'file_path' => 'prefecture/kyoto.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '滋賀県',
                'prefecture_name_alpha' => 'shiga',
                'file_path' => 'prefecture/shiga.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '奈良県',
                'prefecture_name_alpha' => 'nara',
                'file_path' => 'prefecture/nara.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '和歌山県',
                'prefecture_name_alpha' => 'wakayama',
                'file_path' => 'prefecture/wakayama.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '広島県',
                'prefecture_name_alpha' => 'hiroshima',
                'file_path' => 'prefecture/hiroshima.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '岡山県',
                'prefecture_name_alpha' => 'okayama',
                'file_path' => 'prefecture/okayama.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '山口県',
                'prefecture_name_alpha' => 'yamaguchi',
                'file_path' => 'prefecture/yamaguchi.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '鳥取県',
                'prefecture_name_alpha' => 'tottori',
                'file_path' => 'prefecture/tottori.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '島根県',
                'prefecture_name_alpha' => 'shimane',
                'file_path' => 'prefecture/shimane.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '香川県',
                'prefecture_name_alpha' => 'kagawa',
                'file_path' => 'prefecture/kagawa.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '徳島県',
                'prefecture_name_alpha' => 'tokushima',
                'file_path' => 'prefecture/tokushima.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '高知県',
                'prefecture_name_alpha' => 'kouchi',
                'file_path' => 'prefecture/kouchi.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '愛媛県',
                'prefecture_name_alpha' => 'ehime',
                'file_path' => 'prefecture/ehime.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '福岡県',
                'prefecture_name_alpha' => 'fukuoka',
                'file_path' => 'prefecture/fukuoka.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '長崎県',
                'prefecture_name_alpha' => 'nagasaki',
                'file_path' => 'prefecture/nagasaki.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '大分県',
                'prefecture_name_alpha' => 'ohita',
                'file_path' => 'prefecture/ohita.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '佐賀県',
                'prefecture_name_alpha' => 'saga',
                'file_path' => 'prefecture/saga.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '熊本県',
                'prefecture_name_alpha' => 'kumamoto',
                'file_path' => 'prefecture/kumamoto.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '宮崎県',
                'prefecture_name_alpha' => 'miyazaki',
                'file_path' => 'prefecture/miyazaki.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '鹿児島県',
                'prefecture_name_alpha' => 'kagoshima',
                'file_path' => 'prefecture/kagoshima.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'prefecture_name' => '沖縄県',
                'prefecture_name_alpha' => 'okinawa',
                'file_path' => 'prefecture/okinawa.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]
        ];

        // INSERT INTO DATABASE
        foreach ($prefs as $value) {
            DB::table('prefectures')->insert($value);
        }
    }
}
