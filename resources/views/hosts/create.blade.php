@extends('layouts.app')

@section('title')
    Создать хост
@endsection

@section('content')
    <div class="row">
        <div class="col-2">
            @include('components.categories')
        </div>
        <div class="col">
            <h1>Создать хост</h1>
            @if ($message = Session::get('success'))
                <div class="alert alert-info mt-3" role="alert">
                    {{ $message }}
                </div>
            @endif
            <div class="row">
                <form class="row g-3" method="post" action="{{ route('hosts.store') }}">
                    @csrf
                    <div class="col-md-6">
                        <label for="name" class="form-label">Название</label>
                        <input type="text" class="form-control @error('name') border border-danger @enderror" name="name" id="name" value="{{ old('name') }}">
                        @error('name')
                        <div class="alert alert-danger p-2 mt-1" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="address" class="form-label">Адрес</label>
                        <input type="text" class="form-control @error('address') border border-danger @enderror" name="address" id="address" value="{{ old('address') }}">
                        @error('address')
                        <div class="alert alert-danger p-2 mt-1" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="host_login" class="form-label">Логин</label>
                        <input type="text" class="form-control @error('host_login') border border-danger @enderror" name="host_login" id="host_login" value="{{ old('host_login') }}">
                        @error('host_login')
                        <div class="alert alert-danger p-2 mt-1" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="host_password" class="form-label">Пароль</label>
                        <input type="text" class="form-control @error('host_password') border border-danger @enderror" name="host_password" id="host_password" value="{{ old('host_password') }}">
                        @error('host_password')
                        <div class="alert alert-danger p-2 mt-1" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label for="comment">Комментарий</label>
                        <textarea class="form-control @error('comment') border border-danger @enderror" name="comment" id="comment" rows="10">{{ old('comment') }}</textarea>
                        @error('comment')
                        <div class="alert alert-danger p-2 mt-1" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Создать</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
