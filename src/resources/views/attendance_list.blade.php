@extends('layouts.default')

@section('title' ,'出勤一覧')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/list.css')}}">
@endpush

@section('content')
<div class="list__flame flex_column_center">
    @if(Auth::guard('admin')->check())
    <h1 class="title">{{$staff_name}}さんの勤怠</h1>
    <div class="pagenation flex_row_space-between">
        <a href='/admin/attendance/staff/{{$id}}?month={{$ymd->copy()->subMonthNoOverflow()->format("Y-m")}}' class="pagenation__btn"><span class="pagenation__arrow"><</span>前月</a>
        <p class="show__month">{{$ymd->format('Y年n月')}}</p>
        <a href='/admin/attendance/staff/{{$id}}?month={{$ymd->copy()->addMonthNoOverflow()->format("Y-m")}}' class="pagenation__btn">後月<span class="pagenation__arrow">></span></a>
   </div>
    @else
    <h1 class="title">勤怠一覧</h1>
   <div class="pagenation flex_row_space-between">
        <a href='/attendance/list/?month={{$ymd->copy()->subMonthNoOverflow()->format("Y-m")}}' class="pagenation__btn"><span class="pagenation__arrow"><</span>前月</a>
        <p class="show__month">{{$ymd->format('Y年n月')}}</p>
        <a href='/attendance/list/?month={{$ymd->copy()->addMonthNoOverflow()->format("Y-m")}}' class="pagenation__btn">後月<span class="pagenation__arrow">></span></a>
   </div>
   @endif
   <div class="lists">
    <table class="list__table">
        <tr class="list__tr">
            <th class="list__th">日付</th>
            <th class="list__th">出勤</th>
            <th class="list__th">退勤</th>
            <th class="list__th">休憩</th>
            <th class="list__th">合計</th>
            <th class="list__th">詳細</th>
        </tr>
        @foreach($attendances as $key => $attendance)
        <tr class="list__tr">
            <td class="list__td">{{$ymd->format("n/$key")}}</td>
            @if($attendance == "")
            <td class="list__td"></td>
            <td class="list__td"></td>
            <td class="list__td"></td>
            <td class="list__td"></td>
            <td class="list__td"><a href=""></a></td>
            @else
            <td class="list__td">{{ MyFunc::time_format($attendance->start_time)}}</td>
            <td class="list__td">{{ MyFunc::time_format($attendance->end_time)}}</td>
            <td class="list__td">{{ \App\Models\Attendance::formatTime($attendance->sumRestTime()) }}</td>
            <td class="list__td">{{ \App\Models\Attendance::formatTime($attendance->sumWorkingHours())}}</td>
            <td class="list__td"><a href="/attendance/{{$attendance->id}}">詳細</a></td>
            @endif
        </tr>
        @endforeach

    </table>
   </div>
</div>

@endsection