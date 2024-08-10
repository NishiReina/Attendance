@extends('layouts.default')

@section('title' ,'出勤一覧（管理者用）')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/list.css')}}">
@endpush

@section('content')
<div class="list__flame flex_column_center">
    <h1 class="title">{{$ymd->format('Y年n月j日')}}の勤怠</h1>
   <div class="pagenation flex_row_space-between">
        <a href='/admin/attendance/list/?day={{$ymd->copy()->subDay()->format("Y-m-d")}}' class="pagenation__btn"><span class="pagenation__arrow"><</span>前日</a>
        <p class="show__month">{{$ymd->format('Y年n月j日')}}</p>
        <a href='/admin/attendance/list/?day={{$ymd->copy()->addDay()->format("Y-m-d")}}' class="pagenation__btn">後日<span class="pagenation__arrow">></span></a>
   </div>
   <div class="lists">
    <table class="list__table">
        <tr class="list__tr">
            <th class="list__th">名前</th>
            <th class="list__th">出勤</th>
            <th class="list__th">退勤</th>
            <th class="list__th">休憩</th>
            <th class="list__th">合計</th>
            <th class="list__th">詳細</th>
        </tr>
        @foreach($attendances as $attendance)
        <tr class="list__tr">
            <td class="list__td">{{ $attendance->user->name }}</td>
            <td class="list__td">{{ MyFunc::time_format($attendance->start_time)}}</td>
            <td class="list__td">{{ MyFunc::time_format($attendance->end_time)}}</td>
            <td class="list__td">{{ \App\Models\Attendance::formatTime($attendance->sumRestTime()) }}</td>
            <td class="list__td">{{ \App\Models\Attendance::formatTime($attendance->sumWorkingHours())}}</td>
            <td class="list__td"><a href="/attendance/{{$attendance->id}}">詳細</a></td>
        </tr>
        @endforeach

    </table>
   </div>
</div>

@endsection