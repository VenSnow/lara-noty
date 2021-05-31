@extends('layouts.app')

@section('title')
    Создать проект
@endsection

@section('content')
    <div class="row">
        <div class="col-2">
            @include('components.categories')
        </div>
        <div class="col">
            <h1>Создать проект</h1>
                <div class="row">
                    <div class="col">
                        <form class="row g-3" method="post" action="{{ route('projects.store') }}">
                            @csrf
                            <div class="col-md-6">
                                <label for="name" class="form-label">Название</label>
                                <input type="text" class="form-control @error('name') border border-danger @enderror" name="name" id="name" value="{{ old('name') }}" required>
                                @error('name')
                                <div class="alert alert-danger p-2 mt-1" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="domain" class="form-label">Домен</label>
                                <input type="text" class="form-control @error('domain') border border-danger @enderror" name="domain" id="domain" value="{{ old('domain') }}" required>
                                @error('domain')
                                <div class="alert alert-danger p-2 mt-1" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="client_id" class="form-label">Клиент</label>
                                <select class="form-select" aria-label="Default select example" name="client_id" required>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->first_name . " " . $client->last_name }}</option>
                                    @endforeach
                                </select>
                                @error('client_id')
                                <div class="alert alert-danger p-2 mt-1" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="domain_end" class="form-label">Домен оплачен до</label>
                                <input type="date" class="form-control @error('domain_end') border border-danger @enderror" name="domain_end" id="domain_end" value="{{ old('domain_end') }}" required>
                                @error('domain_end')
                                <div class="alert alert-danger p-2 mt-1" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="host_id" class="form-label">Хост</label>
                                <select class="form-select" aria-label="Default select example" name="host_id" required>
                                    @foreach($hosts as $host)
                                        <option value="{{ $host->id }}">{{ $host->name }}</option>
                                    @endforeach
                                </select>
                                @error('host_id')
                                <div class="alert alert-danger p-2 mt-1" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="host_end" class="form-label">Хост оплачен до</label>
                                <input type="date" class="form-control @error('host_end') border border-danger @enderror" name="host_end" id="host_end" value="{{ old('host_end') }}" required>
                                @error('host_end')
                                <div class="alert alert-danger p-2 mt-1" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="ftp_login" class="form-label">FPT Логин</label>
                                <input type="text" class="form-control @error('ftp_login') border border-danger @enderror" name="ftp_login" id="ftp_login" value="{{ old('ftp_login') }}" required>
                                @error('ftp_login')
                                <div class="alert alert-danger p-2 mt-1" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="ftp_password" class="form-label">FTP Пароль</label>
                                <input type="text" class="form-control @error('ftp_password') border border-danger @enderror" name="ftp_password" id="ftp_password" value="{{ old('ftp_password') }}" required>
                                @error('ftp_password')
                                <div class="alert alert-danger p-2 mt-1" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="db_login" class="form-label">DB Логин</label>
                                <input type="text" class="form-control @error('db_login') border border-danger @enderror" name="db_login" id="db_login" value="{{ old('db_login') }}" required>
                                @error('db_login')
                                <div class="alert alert-danger p-2 mt-1" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="db_password" class="form-label">DB Пароль</label>
                                <input type="text" class="form-control @error('db_password') border border-danger @enderror" name="db_password" id="db_password" value="{{ old('db_password') }}" required>
                                @error('db_password')
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
    </div>
@endsection
