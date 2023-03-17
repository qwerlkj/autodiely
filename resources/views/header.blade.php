<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div id="app">
        <div class="container">
            <div class="row">
                <div class="col">
                    <a href="/cars">Cars</a>
                </div>
                <div class="col">
                    <a href="/parts">Parts</a>
                </div>
            </div>
            <header-comp title="@yield('title', 'List of Cars')"></header-comp>
            @yield('content')
        </div>
    </div>
</body>
</html>
