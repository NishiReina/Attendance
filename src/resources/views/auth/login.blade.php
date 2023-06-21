@extends('layouts.auth')

@section('title', 'ログイン')

@section('content')

<form action="/login" method="post" class="form">
    @csrf
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
    <button>ログイン</button>
</form>
@endsection
