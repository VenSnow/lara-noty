@extends('layouts.app')
@section('title')
    Вход
@endsection

@section('content')
    <div class="row position-absolute top-50 start-50 translate-middle">
        <form method="post" action="{{ route('login') }}" class="border border-1 rounded py-4 px-5 shadow bg-light">
            @csrf
            <h4 class="text-center mb-5">Вход</h4>
            @if ($message = Session::get('status'))
                <div class="mb-3">
                    <div class="alert alert-danger mb-2" role="alert">
                        {{ $message }}
                    </div>
                </div>
            @endif
            <div class="mb-3">
                <label for="name" class="form-label">Логин</label>
                <input type="text" class="form-control @error('name') border border-danger @enderror" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Пароль</label>
                <input type="password" class="form-control @error('password') border border-danger @enderror" id="password" name="password" required>
            </div>
            <div class="mb-3 text-center">
                <button type="submit" class="btn btn-primary mb-3">Войти</button>
                <br>
                <span>Нет аккаунта? <a href="{{ route('register') }}">Зарегестрируйтесь</a></span>
            </div>
        </form>
    </div>
@endsection
