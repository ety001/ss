<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SS -- GFW</title>
        <link href="icon.png" rel="icon" type="image/png" />
        <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
    </head>
    <body>
        <div style="display:none;"><img src="icon.png"></div>
        <div class="container" id="app">
            <topnav :islogin="login_status"></topnav>
            <router-view></router-view>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <footer class="footer">
                        <p>
                            &copy; 2015
                            &nbsp;&nbsp;
                            <a href="#">建议</a>
                            &nbsp;&nbsp;
                            <a href="http://to0l.cn">工具</a>
                            &nbsp;&nbsp;
                            <a href="http://pix.domyself.me">像素风</a>
                        </p>
                      </footer>
                </div>
            </div>
        </div>
        <script>
            var Laravel = {
                csrfToken: '',
                baseURL: '/api'
            };
        </script>
        <script src="{{ elixir('js/app.js') }}"></script>
        <div class="hide"><script src="http://s11.cnzz.com/stat.php?id=1254728187&web_id=1254728187" language="JavaScript"></script></div>
    </body>
</html>
