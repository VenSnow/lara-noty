@extends('layouts.app')

@section('title')
    {{ $host->name }}
@endsection

@section('content')
    <div class="row">
        <div class="col-2">
            @include('components.categories')
        </div>
        <div class="col">
            <h1>Хост: {{ $host->name }}</h1>
            @if ($message = Session::get('success'))
                <div class="alert alert-info mt-3" role="alert">
                    {{ $message }}
                </div>
            @endif
            <div class="row">
                <div class="accordion" id="accordionPanelsStayOpenExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                Информация
                            </button>
                        </h2>
                        <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col">
                                        <ol class="list-group list-group">
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                    <div class="fw-bold">Название</div>
                                                </div>
                                                {{ $host->name }}
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                    <div class="fw-bold">Адресс</div>
                                                </div>
                                                <a href="{{ $host->address }}">{{ $host->address }}</a>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                    <div class="fw-bold">Логин</div>
                                                </div>
                                                {{ $host->host_login }}
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                    <div class="fw-bold">Пароль</div>
                                                </div>
                                                {{ $host->host_password }}
                                            </li>
                                        </ol>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <h6 class="mt-3">Комментарий</h6>
                                        <textarea rows="10" style="width: 100%" disabled="disabled">{{ $host->comment }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                                Клиенты
                            </button>
                        </h2>
                        <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                            <div class="accordion-body">
                                <div class="row">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th scope="col">Имя</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Телефон</th>
                                            <th scope="col">Действия</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($clients as $client)
                                            <tr>
                                                <th scope="row">{{ $client->first_name . " " . $client->last_name }}</th>
                                                <td>{{ $client->email }}</td>
                                                <td>{{ $client->phone }}</td>
                                                <td class="row row-cols-lg-auto g-3 align-items-center">
                                                    <a class="btn btn-sm btn-primary me-2" href="{{ route('clients.show', $client->id) }}"><i class="fas fa-user"></i></a>
                                                    <form action="{{ route('clients.destroy', $client) }}" method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-user-slash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    {!! $clients->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="panelsStayOpen-headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false" aria-controls="panelsStayOpen-collapseFour">
                                Проекты
                            </button>
                        </h2>
                        <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingFour">
                            <div class="accordion-body">
                                <div class="row">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th scope="col">Название</th>
                                            <th scope="col">Владелец</th>
                                            <th scope="col">Домен</th>
                                            <th scope="col">Домен оплачен до</th>
                                            <th scope="col">Хост оплачен до</th>
                                            <th scope="col">Действия</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($projects as $project)
                                            <tr class="@if(\Carbon\Carbon::parse($project->domain_end)->diffInDays(\Carbon\Carbon::now()) < 45) bg-warning text-dark @endif">
                                                <th scope="row">{{ \Illuminate\Support\Str::words($project->name, 3) }}</th>
                                                <td><a href="{{ route('clients.show', $project->client->id) }}">{{ $project->client->first_name }}</a></td>
                                                <td><a href="{{ $project->domain }}">{{ $project->domain }}</a></td>
                                                <td>{{ \Carbon\Carbon::parse($project->domain_end)->format('d/m/Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($project->host_end)->format('d/m/Y') }}</td>
                                                <td class="row row-cols-lg-auto g-3 align-items-center">
                                                    <a class="btn btn-sm btn-primary me-2" href="{{ route('projects.show', $project->id) }}"><i class="fas fa-eye"></i></a>
                                                    <form action="{{ route('projects.destroy', $project->id) }}" method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    {!! $projects->links() !!}
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
                                <form class="row g-3" method="post" action="{{ route('hosts.update', $host->id) }}">
                                    @csrf
                                    @method('patch')
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Название</label>
                                        <input type="text" class="form-control @error('name') border border-danger @enderror" name="name" id="name" value="{{ old('name') ?? $host->name  }}">
                                        @error('name')
                                        <div class="alert alert-danger p-2 mt-1" role="alert">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="address" class="form-label">Адрес</label>
                                        <input type="text" class="form-control @error('address') border border-danger @enderror" name="address" id="address" value="{{ old('address') ?? $host->address  }}">
                                        @error('address')
                                        <div class="alert alert-danger p-2 mt-1" role="alert">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="host_login" class="form-label">Логин</label>
                                        <input type="text" class="form-control @error('host_login') border border-danger @enderror" name="host_login" id="host_login" value="{{ old('host_login') ?? $host->host_login  }}">
                                        @error('host_login')
                                        <div class="alert alert-danger p-2 mt-1" role="alert">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="host_password" class="form-label">Пароль</label>
                                        <input type="text" class="form-control @error('host_password') border border-danger @enderror" name="host_password" id="host_password" value="{{ old('host_password') ?? $host->host_password  }}">
                                        @error('host_password')
                                        <div class="alert alert-danger p-2 mt-1" role="alert">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label for="comment">Комментарий</label>
                                        <textarea class="form-control @error('') border border-danger @enderror" name="comment" id="comment" rows="10">{{ old('comment') ?? $host->comment  }}</textarea>
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
@endsection

