@extends('layouts.default')

@section('title' ,'出勤一覧')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/attendance_list.css')}}">
@endpush

@section('content')
<div class="attendance__list flex_column_center">
   <div class="pagenation">
        <a href="/attendance/list/?month={{$ymd->copy()->subMonthNoOverflow()}}" class="pagination__before"><span class="page--btn"><</span>前月</a>
        <p class="show__month">{{$ymd}}</p>
        <a href="/attendance/list/?month={{$ymd->copy()->addMonthNoOverflow()}}" class="pagination__before"><span class="page--btn">></span>後月</a>
   </div>
   <div class="list">
    <table class="attendances">
        <tr class="attendances__tr">
            <th class="attendances__th">日付</th>
            <th class="attendances__th">出勤</th>
            <th class="attendances__th">退勤</th>
            <th class="attendances__th">休憩</th>
            <th class="attendances__th">合計</th>
            <th class="attendances__th">詳細</th>
        </tr>
        @foreach($attendances as $key => $attendance)
        <tr class="attendances__tr">
            <td class="attendances_td">{{$ymd->format("n/$key")}}</td>
            @if($attendance == "")
            <td class="attendances_td"></td>
            <td class="attendances_td"></td>
            <td class="attendances_td"></td>
            <td class="attendances_td"></td>
            <td class="attendances_td"><a href=""></a></td>
            @else
            <td class="attendances_td">{{ MyFunc::time_format($attendance->start_time)}}</td>
            <td class="attendances_td">{{ MyFunc::time_format($attendance->end_time)}}</td>
            <td class="attendances_td">{{ \App\Models\Attendance::formatTime($attendance->sumRestTime()) }}</td>
            <td class="attendances_td">{{ \App\Models\Attendance::formatTime($attendance->sumWorkingHours())}}</td>
            <td class="attendances_td"><a href="/attendance/{{$attendance->id}}">詳細</a></td>
            @endif
        </tr>
        @endforeach

    </table>
   </div>
</div>

@endsection