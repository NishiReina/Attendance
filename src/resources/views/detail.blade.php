@extends('layouts.default')

@section('title' ,'詳細画面')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/detail.css')}}">
@endpush

@section('content')
<div class="detail flex_column_center">
    <h1 class="title">勤怠詳細</h1>
    <form class="detail__form" action="/attendance/{{$attendance->id}}" method="post">
        @csrf
        @foreach ($errors->all() as $error)
            <p class="error">{{$error}}</p>
        @endforeach
        <table class="detail__table">
            <tr class="detail__tr">
                <th class="detail__th">名前</th>
                <td class="detail__td">{{$attendance->user->name}}</td>
            </tr>
            <tr class="detail__tr">
                <th class="detail__th">日付</th>
                <td class="detail__td"><input name="date" type="date" value="{{$attendance->date}}" readonly></td>
            </tr>
            <tr class="detail__tr">
                <th class="detail__th">勤務時間</th>
                <td class="detail__td"><input name="start_time" type="time" value="{{MyFunc::time_format($attendance->start_time)}}" step="1"></td>
                <td class="detail__td"><input name="end_time" type="time" value="{{MyFunc::time_format($attendance->end_time)}}" step="1"></td>
            </tr>
            @if(empty($attendance->rests[0]))
                <tr class="detail__tr">
                    <th class="detail__th">休憩</th>
                    <td class="detail__td"><input name="rest_start_time1" type="time"></td>
                    <td class="detail__td"><input name="rest_end_time1" type="time"></td>
                </tr>
            @else
                @for($i=1; $i <= count($attendance->rests); $i++)
                <tr class="detail__tr">
                    <th class="detail__th">休憩{{$i}}</th>
                    <td class="detail__td"><input name="rest_start_time{{$i}}" type="time" value="{{MyFunc::time_format($attendance->rests[$i-1]->start_time)}}" step="1"></td>
                    <td class="detail__td"><input name="rest_end_time{{$i}}" type="time" value="{{MyFunc::time_format($attendance->rests[$i-1]->end_time)}}" step="1"></td>
                </tr>
                @endfor
            @endif
            <tr class="detail__tr">
                <th class="detail__th">備考</th>
                <td class="detail__td"><input name="reason" type="text"></td>
            </tr>
        </table>
        <button class="btn">修正</button>
    </form>
</div>

@endsection