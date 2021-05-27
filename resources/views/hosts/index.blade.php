@extends('layouts.app')

@section('title')
    Хосты
@endsection

@section('content')
    <div class="row">
        <div class="col-2">
            @include('components.categories')
        </div>
        <div class="col">
            <h1>Хосты</h1>
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
                                <form action="{{ route('hosts.destroy', $host) }}" method="post">
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
@endsection

