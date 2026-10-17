<!-- base view -->
@extends('common.admin.base')

<!-- CSS per page -->
@section('custom_css')
    @vite('resources/scss/admin/home.scss')
@endsection

<!-- main contents -->
@section('main_contents')
    <div class="top">
        <h2 class="title">THK Holdings Vietnam Hanoi's entrance examination</h2>
        <p class="description">
            This is a management screen for THK Holdings Vietnam Hanoi's entry examination.<br>
            Although it will be a management screen, a login feature has not been implemented this time to simplify testing. note that.
        </p>
    </div>
@endsection