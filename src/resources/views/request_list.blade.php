@extends('layouts.default')

@section('title' ,'打刻修正申請画面')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/list.css')}}">
@endpush

@section('content')
<div class="list__flame flex_column_center">
    <h1 class="title">申請一覧</h1>
    @if(Auth::guard('admin')->check())
        <ul class="status flex_row_start">
            <li class="status__li {{ ($status == 'false') ? 'status--bold' : ''}}"><a href="/stamp_correction_request/list?status=false">承認待ち</a></li>    
            <li class="status__li {{ ($status == 'true') ? 'status--bold' : ''}}"><a href="/stamp_correction_request/list?status=true">承認済み</a></li>    
        </ul>
    @else
        <ul class="status flex_row_start">
            <li class="status__li {{ ($status == 'false') ? 'status--bold' : ''}}"><a href="/stamp_correction_request/list?status=false">承認待ち</a></li>    
            <li class="status__li {{ ($status == 'true') ? 'status--bold' : ''}}"><a href="/stamp_correction_request/list?status=true">承認済み</a></li>    
        </ul>
    @endisset
    <div class="lists">
        <table class="list__table">
            <tr class="list__tr">
                <th class="list__th">状態</th>
                <th class="list__th">名前</th>
                <th class="list__th">対象日時</th>
                <th class="list__th">申請理由</th>
                <th class="list__th">申請日時</th>
                <th class="list__th">詳細</th>
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
</div>

@endsection