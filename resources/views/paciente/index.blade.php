@extends('layout')

@section('content')

    <h1>Pacientes </h1>
    <ol>
    @foreach($pacientes as $p)
        <li>
            {{$p->id}} - {{$p->nome}} - {{$p->telefone}} - {{$p->created_at}}
        </li>
    @endforeach
    </ol>

    {{ $pacientes->links() }}


@endsection