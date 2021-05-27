@extends('layouts.app')

@section('title')
    {{ $project->name }}
@endsection

@section('content')
    <div class="row">
        <div class="col-2">
            @include('components.categories')
        </div>
        <div class="col">
            <h1>Проект: {{ $project->name }}</h1>
            @if ($message = Session::get('success'))
                <div class="alert alert-info mt-3" role="alert">
                    {{ $message }}
                </div>
            @endif
            <div class="row">
                <div class="col">
                    <div class="accordion" id="accordionPanelsStayOpenExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                    Информация
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                                <div class="accordion-body">
                                    <ol class="list-group list-group my-3">
                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                            <div class="ms-2 me-auto">
                                                <div class="fw-bold">Название</div>
                                            </div>
                                            {{ $project->name }}
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                            <div class="ms-2 me-auto">
                                                <div class="fw-bold">Домен</div>
                                            </div>
                                            <a href="{{ $project->domain }}">{{ $project->domain }}</a>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                            <div class="ms-2 me-auto">
                                                <div class="fw-bold">Домен оплачен до</div>
                                            </div>
                                            {{ \Carbon\Carbon::parse($project->domain_end)->format('d/m/Y') }}
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                            <div class="ms-2 me-auto">
                                                <div class="fw-bold">Клиент</div>
                                            </div>
                                            {{ $project->client->first_name . " " . $project->client->last_name }}
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                            <div class="ms-2 me-auto">
                                                <div class="fw-bold">Хост</div>
                                            </div>
                                            <a href="{{ $project->host->address }}">{{ $project->host->name }}</a>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                            <div class="ms-2 me-auto">
                                                <div class="fw-bold">Хост оплачен до</div>
                                            </div>
                                            {{ \Carbon\Carbon::parse($project->host_end)->format('d/m/Y') }}
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                            <div class="ms-2 me-auto">
                                                <div class="fw-bold">FTP Логин</div>
                                            </div>
                                            {{ $project->ftp_login }}
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                            <div class="ms-2 me-auto">
                                                <div class="fw-bold">FTP Пароль</div>
                                            </div>
                                            {{ $project->ftp_password }}
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                            <div class="ms-2 me-auto">
                                                <div class="fw-bold">DB Логин</div>
                                            </div>
                                            {{ $project->db_login }}
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                            <div class="ms-2 me-auto">
                                                <div class="fw-bold">DB Пароль</div>
                                            </div>
                                            {{ $project->db_password }}
                                        </li>
                                    </ol>
                                    <div class="row">
                                        <div class="col">
                                            <h6 class="mt-3">Комментарий</h6>
                                            <textarea rows="10" style="width: 100%" disabled="disabled">{{ $project->comment }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                    Редактировать
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                                <div class="accordion-body">
                                    <form class="row g-3" method="post" action="{{ route('projects.update', $project->id) }}">
                                        @csrf
                                        @method('patch')
                                        <div class="col-md-6">
                                            <label for="name" class="form-label">Название</label>
                                            <input type="text" class="form-control @error('name') border border-danger @enderror" name="name" id="name" value="{{ old('name') ?? $project->name  }}">
                                            @error('name')
                                            <div class="alert alert-danger p-2 mt-1" role="alert">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="domain" class="form-label">Домен</label>
                                            <input type="text" class="form-control @error('domain') border border-danger @enderror" name="domain" id="domain" value="{{ old('domain') ?? $project->domain  }}">
                                            @error('domain')
                                            <div class="alert alert-danger p-2 mt-1" role="alert">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="client_id" class="form-label">Клиент</label>
                                            <select class="form-select" aria-label="Default select example" name="client_id">
                                                <option selected>{{ $project->client->first_name . " " . $project->client->last_name }}</option>
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
                                            <input type="date" class="form-control @error('domain_end') border border-danger @enderror" name="domain_end" id="domain_end" value="{{ old('domain_end') ?? $project->domain_end  }}">
                                            @error('domain_end')
                                            <div class="alert alert-danger p-2 mt-1" role="alert">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="host_id" class="form-label">Хост</label>
                                            <input type="text" class="form-control @error('host_id') border border-danger @enderror" name="host_id" id="host_id" value="{{ old('host_id') ?? $project->host->name  }}">
                                            @error('host_id')
                                            <div class="alert alert-danger p-2 mt-1" role="alert">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="host_end" class="form-label">Хост оплачен до</label>
                                            <input type="date" class="form-control @error('host_end') border border-danger @enderror" name="host_end" id="host_end" value="{{ old('host_end') ?? $project->host_end  }}">
                                            @error('host_end')
                                            <div class="alert alert-danger p-2 mt-1" role="alert">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="ftp_login" class="form-label">FPT Логин</label>
                                            <input type="text" class="form-control @error('ftp_login') border border-danger @enderror" name="ftp_login" id="ftp_login" value="{{ old('ftp_login') ?? $project->ftp_login  }}">
                                            @error('ftp_login')
                                            <div class="alert alert-danger p-2 mt-1" role="alert">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="ftp_password" class="form-label">FTP Пароль</label>
                                            <input type="text" class="form-control @error('ftp_password') border border-danger @enderror" name="ftp_password" id="ftp_password" value="{{ old('ftp_password') ?? $project->ftp_password  }}">
                                            @error('ftp_password')
                                            <div class="alert alert-danger p-2 mt-1" role="alert">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="db_login" class="form-label">DB Логин</label>
                                            <input type="text" class="form-control @error('db_login') border border-danger @enderror" name="db_login" id="db_login" value="{{ old('db_login') ?? $project->db_login  }}">
                                            @error('db_login')
                                            <div class="alert alert-danger p-2 mt-1" role="alert">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="db_password" class="form-label">DB Пароль</label>
                                            <input type="text" class="form-control @error('db_password') border border-danger @enderror" name="db_password" id="db_password" value="{{ old('db_password') ?? $project->db_password  }}">
                                            @error('db_password')
                                            <div class="alert alert-danger p-2 mt-1" role="alert">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-12">
                                            <label for="comment">Комментарий</label>
                                            <textarea class="form-control @error('') border border-danger @enderror" name="comment" id="comment" rows="10">{{ old('comment') ?? $project->comment  }}</textarea>
                                            @error('')
                                            <div class="alert alert-danger p-2 mt-1" role="alert">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary">Редактировать</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
