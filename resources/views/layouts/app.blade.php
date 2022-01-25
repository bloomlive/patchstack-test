<!doctype html>
<html lang="en">
<head>
    <title>Patchstack Test - @yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ mix('/js/app.js') }}" async defer/>
</head>
<body>
<x-header></x-header>
<main class="container mx-auto">
    @yield('content')
</main>
</body>
</html>
