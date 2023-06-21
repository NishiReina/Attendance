@extends('layouts.auth')

@section('title', 'ユーザー登録')

@section('content')
<form action="/register" method="post" class="form">
    @csrf
    <label for="name" class="auth__label">名前</label>
    <input id="name" type="text" name="name" class="auth__input" />
    @error('name')
        <p class="auth__error">
            {{$message}}
        </p>
    @enderror
    <label for="email" class="auth__label">メールアドレス</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" class="auth__input"/>
    @error('email')
        <p class="auth__error">
            {{$message}}
        </p>
    @enderror
    <label for="password" class="auth__label">パスワード</label>
    <input id="password" type="password" name="password" class="auth__input"/>
    @error('password')
        <p class="auth__error">
            {{$message}}
        </p>
    @enderror
    <label for="password_confirmation" class="auth__label">確認用パスワード</label>
    <input id="password_confirmation" type="password" name="password_confirmation" class="auth__input"/>
    <button>登録する</button>
</form>
@endsection