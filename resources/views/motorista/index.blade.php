@extends('layout')

@section('content')

    <h1>Motoristas </h1>
    @foreach($motoristas as $m)
        <li>
            {{$m->id}} - {{$m->nome}} - {{$m->telefone}} - {{$m->created_at}}
        </li>
    @endforeach

    {{ $motoristas->links() }}


@endsection