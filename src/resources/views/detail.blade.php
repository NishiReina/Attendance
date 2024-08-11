@extends('layouts.default')

@section('title' ,'詳細画面')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/list.css')}}">
@endpush

@section('content')
<div class="list__flame flex_column_center">
    <h1 class="title">勤怠詳細</h1>
    <form class="detail__form" action="/attendance/{{$attendance->id}}" method="post">
        @csrf
        @foreach ($errors->all() as $error)
            <p class="error">{{$error}}</p>
        @endforeach
        <div class="lists">
        <table class="list__table">
            <tr class="list__tr">
                <th class="detail__th">名前</th>
                <td class="detail__td">{{$attendance->user->name}}</td>
            </tr>
            <tr class="list__tr">
                <th class="detail__th">日付</th>
                <td class="detail__td"><input class="detail__input" name="date" type="date" value="{{$attendance->date}}" readonly></td>
            </tr>
            <tr class="list__tr">
                <th class="detail__th">勤務時間</th>
                <td class="detail__td"><input class="detail__input" name="start_time" type="time" value="{{MyFunc::time_format($attendance->start_time)}}" step="1"></td>
                <td class="detail__td"><input class="detail__input" name="end_time" type="time" value="{{MyFunc::time_format($attendance->end_time)}}" step="1"></td>
            </tr>
            @if(empty($attendance->rests[0]))
                <tr class="list__tr">
                    <th class="detail__th">休憩</th>
                    <td class="detail__td"><input class="detail__input" name="rest_start_time1" type="time"></td>
                    <td class="detail__td"><input class="detail__input" name="rest_end_time1" type="time"></td>
                </tr>
            @else
                @for($i=1; $i <= count($attendance->rests); $i++)
                <tr class="list__tr">
                    <th class="detail__th">休憩{{$i}}</th>
                    <td class="detail__td"><input class="detail__input" name="rest_start_time{{$i}}" type="time" value="{{MyFunc::time_format($attendance->rests[$i-1]->start_time)}}" step="1"></td>
                    <td class="detail__td"><input class="detail__input" name="rest_end_time{{$i}}" type="time" value="{{MyFunc::time_format($attendance->rests[$i-1]->end_time)}}" step="1"></td>
                </tr>
                @endfor
            @endif
            <tr class="list__tr">
                <th class="detail__th">備考</th>
                <td class="detail__td"><input class="detail__input" name="reason" type="text"></td>
            </tr>
        </table>
        </div>
        @if($attendance->isPendingRequests())
            <p class="detail__caution">*承認待ちのため修正できません</p>
        @else
            <button class="detail__btn btn">修正</button>
        @endif
    </form>
</div>

@endsection