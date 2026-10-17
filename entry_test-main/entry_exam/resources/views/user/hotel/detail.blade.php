<!-- base view -->
@extends('common.user.base')

<!-- CSS per page -->
@section('custom_css')
    @vite('resources/scss/user/hotedetail.scss')
@endsection

<!-- main contents -->
@section('main_contents')
    <header class="g-header">
        <a href="{{ route('top') }}">THK VN HANOI TRAVEL</a>
    </header>
    <div class="container">
        <div class="hotedetail_container">
            <img src="/assets/img/{{ $hotel->file_path }}" alt="{{ $hotel->hotel_name }}">
            <p class="hotel_title">{{ $hotel->hotel_name }}</p>
            <p class="hotel_information">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam esse beatae dolor, et facere animi distinctio facilis laboriosam obcaecati expedita minus voluptatibus aut amet, commodi quos aliquid vitae! Consequuntur, autem!
            </p>
        </div>
    </div>
@endsection