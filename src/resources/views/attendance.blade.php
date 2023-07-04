@extends('layouts.default')

@section('title' ,'管理画面ホーム')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/attendance.css')}}">
@endpush

@section('content')
<div class="attendance flex_column_center">
    <div class="attendance__status flex_row_space-between"></div>
    <h2 class="date">{{$date}}</h2>
    <h1 class="time">{{$time}}</h1>
    <div class="flex__attendance flex_row_space-around">
        @if($status["status"] == "non_work")
            <form action="/attendance/start" method="post">
                @csrf
                <button class="btn">出勤</button>
            </form>
        @elseif($status["status"] == "at_work")
            <form action="/attendance/end/{{$status['key']}}" method="post">
                @csrf
                <button class="btn">退勤</button>
            </form>
            <form action="/attendance/rest_start/{{$status['key']}}" method="post">
                @csrf
                <button class="btn btn--white">休憩入</button>
            </form>
        @elseif($status["status"] == "rest")
            <form action="/attendance/rest_end/{{$status['key']}}" method="post">
                @csrf
                <button class="btn btn--white">休憩戻</button>
            </form>
        @else
            <p>お疲れ様でした</p>
        @endif
    </div>
</div>

@endsection