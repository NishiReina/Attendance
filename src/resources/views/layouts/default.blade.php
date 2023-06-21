<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @stack('css')
</head>
<body>
    <header>
        <form action="/logout" method="post"><button>ログアウト</button></form>
    </header>
    @yield('content')
</body>
</html>