@extends('layouts.default')

@section('title', 'ユーザー登録')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/auth.css')}}">
@endpush

@section('content')
<div class="auth flex_column_center">

<h1 class="auth__headline">会員登録</h1>

<form action="/register" method="post" class="auth__form form">
    @csrf
    <label for="name" class="auth__label">名前</label>
    <input id="name" type="text" name="name" class="auth__input auth__input--register" />
    @error('name')
        <p class="auth__error">
            {{$message}}
        </p>
    @enderror
    <label for="email" class="auth__label">メールアドレス</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" class="auth__input auth__input--register"/>
    @error('email')
        <p class="auth__error">
            {{$message}}
        </p>
    @enderror
    <label for="password" class="auth__label">パスワード</label>
    <input id="password" type="password" name="password" class="auth__input auth__input--register"/>
    @error('password')
        <p class="auth__error">
            {{$message}}
        </p>
    @enderror
    <label for="password_confirmation" class="auth__label">確認用パスワード</label>
    <input id="password_confirmation" type="password" name="password_confirmation" class="auth__input auth__input--register"/>
    <button class="btn" >登録する</button>
</form>
<a href="/login" class="auth__link">ログインはこちら</a>

</div>
@endsection