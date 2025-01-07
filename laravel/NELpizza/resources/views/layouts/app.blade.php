<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/master.css') }}">
</head>
<body>
<div id="wrapper">
  <div id="screen-info">
    <span class="block"></span>
    <p> SCREEN TITLE </p>
  </div>
  <div id="menu-title">
    <span class="indicator-symbol"></span>
    <h1> MAIN MENU </h1>
  </div>
  <nav id="menu">
    <span id="one" class="item selected                                                 " style="--item-text: 'Campaign'">Campaign</span>
    <span id="two" class="item" style="--item-text: 'Racebox'">Racebox</span>
    <span id="three" class="item" style="--item-text: 'Online'">Online</span>
    <span id="four" class="item" style="--item-text: 'Options'">Options</span>
    <span id="five" class="item" style="--item-text: 'Records'">Records</span>
  </nav>
</div>
</body>
</html>