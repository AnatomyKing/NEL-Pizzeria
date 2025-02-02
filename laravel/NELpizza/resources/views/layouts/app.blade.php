<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>
    <link rel="stylesheet" href="{{ asset('css/master.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
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
            <a href="/home" id="one" class="item selected" style="--item-text: 'HomeScreen'; text-decoration: none; background-color: #000000; color: white;">
                Homescreen
            </a>
            <a href="{{ route('bestel') }}" id="two" class="item" style="--item-text: 'Bestel'; text-decoration: none; background-color: #000000; color: white;">
                Bestel pagina
            </a>
            <span id="three" class="item" style="--item-text: 'Online'">Online</span>
            <a href="{{ route('options') }}" id="four" class="item" style="--item-text: 'Options'; text-decoration: none; background-color: #000000; color: white;">
                Options
            </a>
            <a href="{{ route('openingstijden') }}" id="six" class="item" style="--item-text: 'Openingstijden'; text-decoration: none; background-color: #000000; color: white;">
                Openingstijden
            </a>
        </nav>

        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>
