<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>THK Holdings Vietman Hanoi</title>

        @vite('resources/css/reset.css')
        @vite('resources/css/user/base.css')
        @vite('resources/scss/user/common.scss')
        @yield('custom_css')
    </head>
    <body>
        @yield('main_contents')
        @yield('page_js')
    </body>
</html>
