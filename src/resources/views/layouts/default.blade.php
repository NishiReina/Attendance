<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/reset.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common.css')}}">
    @stack('css')
</head>

<body>
    <header class="header flex_row_space-between">
        <div class="header__left img">
            <img src="{{ asset('img/CoachTech_logo_White.png')}}" alt="コーチテックロゴ">
        </div>
        @if(Auth::guard('admin')->check())
        <div class="header__right flex_row_center">
            <a class="header__item" href="/admin/attendance/list">勤怠一覧</a>
            <a class="header__item" href="/admin/staff/list">スタッフ一覧</a>
            <a class="header__item" href="/stamp_correction_request/list?status=false">申請一覧</a>
            <form action="/logout" method="post">
                @csrf
                <button class="btn">ログアウト</button>
            </form>
        </div>
        @else
        <div class="header__right flex_row_center">
            <a class="header__item" href="/attendance">勤怠</a>
            <a class="header__item" href="/attendance/list">勤怠一覧</a>
            <a class="header__item" href="/stamp_correction_request/list?status=false">申請一覧</a>
            <form class="header__item" action="/logout" method="post">
                @csrf
                <button class="btn">ログアウト</button>
            </form>
        </div>
        @endif
    </header>
    @yield('content')
</body>

</html>