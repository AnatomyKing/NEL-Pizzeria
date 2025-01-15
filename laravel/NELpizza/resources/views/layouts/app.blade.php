<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Stonks Pizza')</title>
    <link rel="stylesheet" href="{{ asset('css/navi.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navi2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <script src="{{ asset('js/javascript.js') }}" defer></script>
</head>
<body>
    <div id="wrapper">
        <div id="screen-info">
            <span class="block"></span>
            <p>@yield('stonks pizza', 'stonks pizza')</p>
        </div>
        <div id="menu-title">
            <span class="indicator-symbol"></span>
            <h1>@yield('menu-title', 'MAIN MENU')</h1>
        </div>
        <nav id="menu">
            <a href="{{ route('home') }}" id="one" class="item selected">Home</a>
            <a href="{{ route('contact') }}" id="two" class="item" >Contact</a>
            <a href="{{ route('dashboard') }}" id="three" class="item">Login</a>
        </nav>
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>
