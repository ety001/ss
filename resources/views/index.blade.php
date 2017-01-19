<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
    </head>
    <body>
        <div style="display:none;"><img src="icon.png"></div>
        <div class="container" id="app">
            <topnav></topnav>
            <router-view></router-view>
        </div>
        <script src="{{ elixir('js/app.js') }}"></script>
    </body>
</html>
