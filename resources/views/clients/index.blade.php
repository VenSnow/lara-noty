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
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis dolore eum illum labore magni necessitatibus officia pariatur placeat possimus praesentium quaerat quia quisquam reiciendis ullam, velit veniam vero voluptatem voluptatibus.</p>
        </div>
    </div>
@endsection

