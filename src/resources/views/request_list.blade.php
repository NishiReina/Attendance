@extends('layouts.default')

@section('title' ,'打刻修正申請画面')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/request_list.css')}}">
@endpush

@section('content')
<div class="request__list flex_column_center">
    @if(Auth::guard('admin')->check())
        <ul class="status">
            <li class="status__li"><a href="/stamp_correction_request/list?status=false&user=admin">承認待ち</a></li>    
            <li class="status__li"><a href="/stamp_correction_request/list?status=true&user=admin">承認済み</a></li>    
        </ul>
    @else
        <ul class="status">
            <li class="status__li"><a href="/stamp_correction_request/list?status=false&user=user">承認待ち</a></li>    
            <li class="status__li"><a href="/stamp_correction_request/list?status=true&user=user">承認済み</a></li>    
        </ul>
    @endisset
    <table class="list">
        <tr class="list__tr">
            <th class="list__th">状態</th>
            <th class="list__th">名前</th>
            <th class="list__th">対象日時</th>
            <th class="list__th">申請理由</th>
            <th class="list__th">申請日時</th>
            <th class="list__th"><a href="">詳細</a></th>
        </tr>
        @foreach($requests as $request)
           <tr class="list__tr">
                <td class="list__td">{{$request->status}}</td>
                <td class="list__td">{{$request->attendance->user->name}}</td>
                <td class="list__td">{{ MyFunc::date_format($request->attendance->date)}}</td>
                <td class="list__td">{{$request->reason}}</td>
                <td class="list__td">{{ MyFunc::date_format($request->created_at)}}</td>
                <td class="list__td"><a href="/stamp_correction_request/detail/{{$request->attendance->id}}">詳細</a></td>
           </tr> 
        @endforeach
    </table>
</div>

@endsection