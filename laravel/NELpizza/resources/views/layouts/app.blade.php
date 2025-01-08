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
            <p>@yield('screen-title', 'SCREEN TITLE')</p>
        </div>
        <div id="menu-title">
            <span class="indicator-symbol"></span>
            <h1>@yield('menu-title', 'MAIN MENU')</h1>
        </div>
        <nav id="menu">
            <span id="one" class="item selected" style="--item-text: 'Campaign'">Campaign</span>
            <span id="two" class="item" style="--item-text: 'Racebox'">Racebox</span>
            <span id="three" class="item" style="--item-text: 'Online'">Online</span>
            <span id="four" class="item" style="--item-text: 'Options'">Options</span>
            <a href="{{ route('openingstijden') }}" id="six" class="item" style="--item-text: 'Openingstijden'">Openingstijden</a>
        </nav>
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>
