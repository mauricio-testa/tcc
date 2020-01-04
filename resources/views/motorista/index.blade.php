@extends('layout')

@section('content')

    <h1>Motoristas </h1>
    <ol>
    @foreach($motoristas as $m)
        <li>
            {{$m->id}} - {{$m->nome}} - {{$m->telefone}} - {{$m->created_at}}
        </li>
    @endforeach
    </ol>

    {{ $motoristas->links() }}


@endsection