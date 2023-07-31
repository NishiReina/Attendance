@extends('layouts.default')

@section('title' ,'スタッフ一覧')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/list.css')}}">
@endpush

@section('content')
<div class="list__flame flex_column_center">
    <h1 class="list__title">スタッフ一覧</h1>
   <div class="lists">
    <table class="list__table">
        <tr class="list__tr">
            <th class="list__th">名前</th>
            <th class="list__th">出勤一覧</th>
        </tr>
        @foreach($users as $user)
        <tr class="list__tr">
            <td class="list__td">{{ $user->name }}</td>
            <td class="list__td"><a href="/admin/attendance/staff/{{$user->id}}">詳細</a></td>
        </tr>
        @endforeach

    </table>
   </div>
</div>

@endsection