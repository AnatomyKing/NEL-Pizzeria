<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Stonks Pizza')</title>
    @yield('refrence')
    <script src="{{ asset('js/javascript.js') }}" defer></script>
    <link rel="stylesheet" href="{{ asset('css/navi.css') }}">
</head>
<body>
    <div id="wrapper">
        <!-- Screen Info -->
        <div id="screen-info">
            <span class="block"></span>
            <p>@yield('stonks pizza', 'stonks pizza')</p>
        </div>

        <!-- Menu Title -->
        <div id="menu-title">
            <span class="indicator-symbol"></span>
            <h1>@yield('menu-title', 'MAIN MENU')</h1>
        </div>

        <!-- Navigation Menu -->
        <nav id="menu">
            <a href="{{ route('home') }}" id="one" class="item {{ request()->routeIs('home') ? 'selected' : '' }}">Home</a>
            <a href="{{ route('bestel') }}" id="two" class="item {{ request()->routeIs('bestel') ? 'selected' : '' }}">Bestel</a>
            <a href="{{ route('contact') }}" id="three" class="item {{ request()->routeIs('contact') ? 'selected' : '' }}">contact</a>
            
            @guest
                <a href="{{ route('login') }}" id="four" class="item {{ request()->routeIs('login') ? 'selected' : '' }}">Login</a>
                <a href="{{ route('register') }}" id="five" class="item {{ request()->routeIs('register') ? 'selected' : '' }}">Register</a>
            @else
                <a href="{{ route('dashboard') }}" id="five" class="item {{ request()->routeIs('dashboard') ? 'selected' : '' }}">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" id="seven" class="item" style="all: unset; cursor: pointer;">Logout</button>
                </form>
            @endguest
        </nav>

        <!-- Content View -->
        <div class="contentview">
            @yield('content')
        </div>
    </div>
</body>
</html>

