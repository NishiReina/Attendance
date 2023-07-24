@extends('layouts.default')

@section('title' ,'打刻修正申請画面')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/stamp_correction_request.css')}}">
@endpush

@section('content')
<div class="request flex_column_center">
    <table class="request__table">
        <tr class="request__tr">
            <th class="request__th">名前</th>
            <td class="request__td">{{$attendance_correct_request->attendance->user->name}}</td>
        </tr>
        <tr class="request__tr">
            <th class="request__th">日付</th>
            <td class="request__td">{{ MyFunc::date_format($attendance_correct_request->attendance->date) }}</td>
        </tr>
        <tr class="request__tr">
            <th class="request__th">出勤・退勤</th>
            <td class="request__td">{{ MyFunc::time_format($attendance_correct_request->start_time) }}</td>
            <td class="request__td">{{ MyFunc::time_format($attendance_correct_request->end_time) }}</td>
        </tr>
        @foreach($attendance_correct_request->restRequests as $rest)
                <tr class="request__tr">
                    <th class="request__th">休憩</th>
                    <td class="request__td">{{MyFunc::time_format($rest->start_time)}}</td>
                    <td class="request__td">{{MyFunc::time_format($rest->end_time)}}</td>
                </tr>
        @endforeach
        <tr class="request__tr">
            <th class="request__th">備考</th>
            <td class="request__td">{{ $attendance_correct_request->reason }}</td>
        </tr>
    </table>
</div>

@endsection