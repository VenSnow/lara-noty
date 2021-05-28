@extends('layouts.app')

@section('title')
    {{ $client->first_name . " " . $client->last_name }}
@endsection

@section('content')
    <div class="row">
        <div class="col-2">
            @include('components.categories')
        </div>
        <div class="col">
            <h1>Клиент: {{ $client->first_name . " " . $client->last_name }}</h1>
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
                                                    <div class="fw-bold">Имя</div>
                                                </div>
                                                <span class="badge bg-primary rounded-pill">{{ $client->first_name }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                    <div class="fw-bold">Фамилия</div>
                                                </div>
                                                <span class="badge bg-primary rounded-pill">{{ $client->last_name }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                    <div class="fw-bold">Email</div>
                                                </div>
                                                <span class="badge bg-primary rounded-pill">{{ $client->email }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                    <div class="fw-bold">Телефон</div>
                                                </div>
                                                <span class="badge bg-primary rounded-pill">{{ $client->phone }}</span>
                                            </li>
                                        </ol>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <h6 class="mt-3">Комментарий</h6>
                                        <textarea rows="10" style="width: 100%" disabled="disabled">{{ $client->comment }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                                Хосты
                            </button>
                        </h2>
                        <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                            <div class="accordion-body">
                                <div class="row">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th scope="col">Название</th>
                                            <th scope="col">Адресс</th>
                                            <th scope="col">Действия</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($hosts as $host)
                                            <tr>
                                                <th scope="row">{{ $host->name }}</th>
                                                <td><a href="{{ $host->address }}">{{ $host->address }}</a></td>
                                                <td class="row row-cols-lg-auto g-3 align-items-center">
                                                    <a class="btn btn-sm btn-primary me-2" href="{{ route('hosts.show', $host->id) }}"><i class="fas fa-eye"></i></a>
                                                    <form action="{{ route('hosts.destroy', $host) }}" method="post" onsubmit="return confirm('Вы действительно хотите удалить?');>
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    {!! $hosts->links() !!}
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
                                                <td><a href="{{ $project->domain }}">{{ $project->domain }}</a></td>
                                                <td>{{ \Carbon\Carbon::parse($project->domain_end)->format('d/m/Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($project->host_end)->format('d/m/Y') }}</td>
                                                <td class="row row-cols-lg-auto g-3 align-items-center">
                                                    <a class="btn btn-sm btn-primary me-2" href="{{ route('projects.show', $project->id) }}"><i class="fas fa-eye"></i></a>
                                                    <form action="{{ route('projects.destroy', $project->id) }}" method="post" onsubmit="return confirm('Вы действительно хотите удалить?')";>
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
                                <form class="row g-3" method="post" action="{{ route('clients.update', $client->id) }}">
                                    @csrf
                                    @method('patch')
                                    <div class="col-md-6">
                                        <label for="first_name" class="form-label">Имя</label>
                                        <input type="text" class="form-control @error('first_name') border border-danger @enderror" name="first_name" id="first_name" value="{{ old('first_name') ?? $client->first_name  }}">
                                        @error('first_name')
                                        <div class="alert alert-danger p-2 mt-1" role="alert">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="last_name" class="form-label">Фамилия</label>
                                        <input type="text" class="form-control @error('last_name') border border-danger @enderror" name="last_name" id="last_name" value="{{ old('last_name') ?? $client->last_name  }}">
                                        @error('last_name')
                                        <div class="alert alert-danger p-2 mt-1" role="alert">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control @error('email') border border-danger @enderror" name="email" id="email" value="{{ old('email') ?? $client->email  }}">
                                        @error('email')
                                        <div class="alert alert-danger p-2 mt-1" role="alert">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Телефон</label>
                                        <input type="text" class="form-control @error('phone') border border-danger @enderror" name="phone" id="phone" value="{{ old('phone') ?? $client->phone  }}">
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
                                            @foreach($allHosts as $host)
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
                                        <textarea class="form-control @error('') border border-danger @enderror" name="comment" id="comment" rows="10">{{ old('comment') ?? $client->comment  }}</textarea>
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

