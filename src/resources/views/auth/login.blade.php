@extends('layouts.default')

@section('title', 'ログイン')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/auth.css')}}">
@endpush

@section('content')
<div class="auth flex_column_center">

@isset($guard)
<h1 class="auth__headline">管理者ログイン</h1>
@else
<h1 class="auth__headline">スタッフログイン</h1>
@endisset

<form action="{{ isset($guard) ? route('admin.login') : route('login') }}" method="post" class="auth__form form">
    @csrf
    <label for="email" class="auth__label">メールアドレス</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" class="auth__input" placeholder="メールアドレスを入力してください"/>
    @error('email')
        <p class="auth__error">
            {{$message}}
        </p>
    @enderror
    <label for="password" class="auth__label">パスワード</label>
    <input id="password" type="password" name="password" class="auth__input" placeholder="パスワードを入力してください"/>
    @error('password')
        <p class="auth__error">
            {{$message}}
        </p>
    @enderror
    <button class="btn" >ログイン</button>
</form>
<a href="/register" class="auth__link">新規登録はこちら</a>

</div>
@endsection
