<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Shop4Earn - @yield('title')</title>
    @include('layout.head')
    @stack('below_style')
</head>
<body>

    @include('layout.header')
    @yield('page_content')
    @include('layout.footer')
    @include('layout.footer_script')
    @stack('below_script')
</body>
</html>
