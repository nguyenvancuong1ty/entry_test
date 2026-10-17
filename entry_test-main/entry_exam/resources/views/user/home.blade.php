<!-- base view -->
@extends('common.user.base')

<!-- CSS per page -->
@section('custom_css')
    @vite('resources/scss/user/home.scss')
@endsection

<!-- main contents -->
@section('main_contents')
    <header class="g-header">
        <a href="{{ route('top') }}">THK VN HANOI TRAVEL</a>
    </header>
    <div class="container">
        <div class="prefecture_container">
            <p class="text">お探しのエリアを選択ください</p>
            <div class="area_container">
                <div class="side-wrapper">
                    <div class="area_wrapper">
                        <p class="area">北海道</p>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'hokkaido']) }}" class="pref">北海道</a>
                    </div>
                    <div class="area_wrapper">
                        <p class="area">東北</p>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'aomori']) }}" class="pref">青森県</a>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'akita']) }}" class="pref">秋田県</a>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'iwate']) }}" class="pref">岩手県</a>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'yamagata']) }}" class="pref">山形県</a>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'miyagi']) }}" class="pref">宮城県</a>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'fukushima']) }}" class="pref">福島県</a>
                    </div>
                    <div class="area_wrapper">
                        <p class="area">北関東</p>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'gunma']) }}" class="pref">群馬県</a>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'tochigi']) }}" class="pref">栃木県</a>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'ibaraki']) }}" class="pref">茨城県</a>
                    </div>
                    <div class="area_wrapper">
                        <p class="area">関東</p>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'tokyo']) }}" class="pref">東京都</a>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'kanagawa']) }}" class="pref">神奈川県</a>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'saitama']) }}" class="pref">埼玉県</a>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'chiba']) }}" class="pref">千葉県</a>
                    </div>
                    <div class="area_wrapper">
                        <p class="area">東海</p>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'aichi']) }}" class="pref">愛知県</a>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'shizuoka']) }}" class="pref">静岡県</a>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'gifu']) }}" class="pref">岐阜県</a>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'mie']) }}" class="pref">三重県</a>
                    </div>
                </div>
                <div class="side-wrapper">
                    <div class="area_wrapper">
                        <p class="area">北陸・甲信越</p>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'niigata']) }}" class="pref">新潟県</a>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'toyama']) }}" class="pref">富山県</a>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'ishikawa']) }}" class="pref">石川県</a>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'fukushima']) }}" class="pref">福島県</a>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'nagano']) }}" class="pref">長野県</a>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'yamanashi']) }}" class="pref">山梨県</a>
                    </div>
                    <div class="area_wrapper">
                        <p class="area">関西</p>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'osaka']) }}" class="pref">大阪府</a>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'hyogo']) }}" class="pref">兵庫県</a>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'kyoto']) }}" class="pref">京都府</a>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'shiga']) }}" class="pref">滋賀県</a>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'nara']) }}" class="pref">奈良県</a>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'wakayama']) }}" class="pref">和歌山県</a>
                    </div>
                    <div class="area_wrapper">
                        <p class="area">中国</p>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'hiroshima']) }}" class="pref">広島県</a>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'okayama']) }}" class="pref">岡山県</a>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'yamaguchi']) }}" class="pref">山口県</a>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'tottori']) }}" class="pref">鳥取県</a>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'shimane']) }}" class="pref">島根県</a>
                    </div>
                    <div class="area_wrapper">
                        <p class="area">四国</p>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'kagawa']) }}" class="pref">香川県</a>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'tokushima']) }}" class="pref">徳島県</a>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'kouchi']) }}" class="pref">高知県</a>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'aichi']) }}" class="pref">愛知県</a>
                    </div>
                    <div class="area_wrapper">
                        <p class="area">九州・沖縄</p>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'gukushima']) }}" class="pref">福島県</a>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'saga']) }}" class="pref">佐賀県</a>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'nagasaki']) }}" class="pref">長崎県</a>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'ohita']) }}" class="pref">大分県</a>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'miyazaki']) }}" class="pref">宮崎県</a>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'kumamoto']) }}" class="pref">熊本県</a>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'kagoshima']) }}" class="pref">鹿児島県</a>
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => 'okinawa']) }}" class="pref">沖縄県</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection