@extends('layouts.app')

@section('title')
    Проекты
@endsection

@section('content')
    <div class="row">
        <div class="col-2">
            @include('components.categories')
        </div>
        <div class="col">
            <h1>Проекты</h1>
            <div class="row">
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
                        <tr class="@if(\Carbon\Carbon::parse($project->domain_end)->diffInDays(\Carbon\Carbon::now()) < 45) bg-warning text-dark @endif">
                            <th scope="row">{{ \Illuminate\Support\Str::words($project->name, 3) }}</th>
                            <td><a href="{{ $project->domain }}">{{ $project->domain }}</a></td>
                            <td>{{ \Carbon\Carbon::parse($project->domain_end)->format('d/m/Y') }}</td>
                            <td><a href="{{ route('hosts.show', $project->host->id) }}">{{ $project->host->name }}</a></td>
                            <td>{{ \Carbon\Carbon::parse($project->host_end)->format('d/m/Y') }}</td>
                            <td><a href="{{ route('clients.show', $project->client->id) }}">{{ $project->client->first_name . " " . $project->client->last_name }}</a></td>
                            <td class="row row-cols-lg-auto g-3 align-items-center">
                                <a class="btn btn-sm btn-primary me-2" href="{{ route('projects.show', $project->id) }}"><i class="fas fa-eye"></i></a>
                                <form action="{{ route('projects.destroy', $project->id) }}" method="post" onsubmit="return confirm('Вы действительно хотите удалить?');>
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-4">
                        <a href="{{ route('projects.create') }}" class="btn btn-primary">Добавить проект</a>
                    </div>
                    <div class="col-md-4">
                        {!! $projects->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

