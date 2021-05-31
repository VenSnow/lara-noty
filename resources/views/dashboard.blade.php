@extends('layouts.app')

@section('title')
    Дашборд
@endsection

@section('content')
    <div class="row">
        <div class="col-2">
            @include('components.categories')
        </div>
        <div class="col ms-2">
            <div class="row mb-3">
                <h1>Дашборд</h1>
            </div>
            <div class="row mb-3">
                <h3>Основная информация</h3>
                <ol class="list-group list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Всего клиентов</div>
                        </div>
                        <span class="badge bg-primary rounded-pill">{{ $clientsCount->count() }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Всего хостов</div>
                        </div>
                        <span class="badge bg-primary rounded-pill">{{ $hostsCount->count() }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Всего проектов</div>
                        </div>
                        <span class="badge bg-primary rounded-pill">{{ $projectsCount->count() }}</span>
                    </li>
                </ol>
            </div>
            <div class="row mb-3">
                <h3>Проекты у которых кончается срок оплаты ({{ $projects->total() }})</h3>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">Название</th>
                        <th scope="col">Домен</th>
                        <th scope="col">Домен оплачен до</th>
                        <th scope="col">Хост</th>
                        <th scope="col">Хост оплачен до</th>
                        <th scope="col">Владелец</th>
                        <th scope="col">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($projects as $project)
                        <tr class="@if(\Carbon\Carbon::parse($project->domain_end)->diffInDays(\Carbon\Carbon::now()) <= 45 || \Carbon\Carbon::parse($project->host_end)->diffInDays(\Carbon\Carbon::now()) <= 45) bg-warning text-dark @endif">
                            <th scope="row">{{ \Illuminate\Support\Str::words($project->name, 3) }}</th>
                            <td><a href="{{ $project->domain }}">{{ $project->domain }}</a></td>
                            <td>{{ \Carbon\Carbon::parse($project->domain_end)->format('d/m/Y') }}</td>
                            <td><a href="{{ route('hosts.show', $project->host->id) }}">{{ $project->host->name }}</a></td>
                            <td>{{ \Carbon\Carbon::parse($project->host_end)->format('d/m/Y') }}</td>
                            <td><a href="{{ route('clients.show', $project->client->id) }}">{{ $project->client->first_name . " " . $project->client->last_name }}</a></td>
                            <td class="row row-cols-lg-auto g-3 align-items-center">
                                <a class="btn btn-sm btn-primary me-2" href="{{ route('projects.show', $project->id) }}"><i class="fas fa-eye"></i></a>
                                <form action="{{ route('projects.destroy', $project->id) }}" method="post" onsubmit="return confirm('Вы действительно хотите удалить?');">
                                @csrf
                                @method('delete')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="col">
                    {!! $projects->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

