@extends('layouts.app')

@section('title')
    Клиенты
@endsection

@section('content')
    <div class="row">
        <div class="col-2">
            @include('components.categories')
        </div>
        <div class="col">
            <h1>Клиенты</h1>
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
@endsection

