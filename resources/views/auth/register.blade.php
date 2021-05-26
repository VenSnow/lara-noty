@extends('layouts.app')
@section('title')
    Регистрация
@endsection

@section('content')
    <div class="row position-absolute top-50 start-50 translate-middle">
        <form method="post" action="{{ route('register') }}" class="border border-1 rounded py-4 px-5 shadow bg-light">
            @csrf
            <h4 class="text-center mb-5">Регистрация</h4>
            <div class="mb-3">
                <label for="name" class="form-label">Логин</label>
                <input type="text" class="form-control @error('name') border border-danger @enderror" id="name" name="name" required>
                @error('name')
                <div class="alert alert-danger mt-2 p-2" role="alert">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') border border-danger @enderror" id="email" name="email" required>
                @error('email')
                <div class="alert alert-danger mt-2 p-2" role="alert">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Пароль</label>
                <input type="password" class="form-control @error('password') border border-danger @enderror" id="password" name="password" required>
                @error('password')
                <div class="alert alert-danger mt-2 p-2" role="alert">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Подтвердите пароль</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>

            <div class="mb-3 text-center">
                <button type="submit" class="btn btn-primary mb-3">Зарегестрироваться</button>
                <br>
                <span>Уже есть аккаунт? <a href="{{ route('login') }}">Войдите на сайт</a></span>
            </div>
        </form>
    </div>
@endsection
