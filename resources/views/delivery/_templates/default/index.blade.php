<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') • Cardápio e Delivery em Campinas</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.11.1/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/swup@3"></script>
    <link href="{{ asset('css/delivery/dist.css') }}" rel="stylesheet">
    <script src="{{ asset('js/delivery/app.js') }}"></script>
    @yield('header')
</head>

<body>
    @yield('body')

    @include('delivery._templates.navigator.index')
</body>

</html>
