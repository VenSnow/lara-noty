@extends('layouts.app')

@section('title')
    Добавить клиента
@endsection

@section('content')
    <div class="row">
        <div class="col-2">
            @include('components.categories')
        </div>
        <div class="col">
            <h1>Добавить клиента</h1>
                <div class="row">
                    <form class="row g-3" method="post" action="{{ route('clients.store') }}">
                        @csrf
                        <div class="col-md-6">
                            <label for="first_name" class="form-label">Имя</label>
                            <input type="text" class="form-control @error('first_name') border border-danger @enderror" name="first_name" id="first_name" value="{{ old('first_name') }}">
                            @error('first_name')
                            <div class="alert alert-danger p-2 mt-1" role="alert">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="last_name" class="form-label">Фамилия</label>
                            <input type="text" class="form-control @error('last_name') border border-danger @enderror" name="last_name" id="last_name" value="{{ old('last_name') }}">
                            @error('last_name')
                            <div class="alert alert-danger p-2 mt-1" role="alert">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') border border-danger @enderror" name="email" id="email" value="{{ old('email') }}">
                            @error('email')
                            <div class="alert alert-danger p-2 mt-1" role="alert">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Телефон</label>
                            <input type="text" class="form-control @error('phone') border border-danger @enderror" name="phone" id="phone" value="{{ old('phone') }}">
                            @error('phone')
                            <div class="alert alert-danger p-2 mt-1" role="alert">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="hosts" class="form-label">Хосты</label>
                            <select class="form-select" multiple aria-label="multiple select example" name="hosts[]" required>
                                <option>Выберите хост</option>
                                @foreach($hosts as $host)
                                    <option value="{{ $host->id }}">{{ $host->name }}</option>
                                @endforeach
                            </select>
                            @error('hosts')
                            <div class="alert alert-danger p-2 mt-1" role="alert">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="comment">Комментарий</label>
                            <textarea class="form-control @error('') border border-danger @enderror" name="comment" id="comment" rows="10">{{ old('comment') }}</textarea>
                            @error('')
                            <div class="alert alert-danger p-2 mt-1" role="alert">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Добавить</button>
                        </div>
                    </form>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection

