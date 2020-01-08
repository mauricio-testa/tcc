@extends('layouts.app')

@section('content')

    <h1>Veículos </h1>
    <ol>
    @foreach($veiculos as $v)
        <li>
            {{$v->id}} - {{$v->descricao}} - {{$v->placa}} - {{$v->lotacao}} - {{$v->tipo}} - {{$v->ano_modelo}} - {{$v->marca_modelo}}
        </li>
    @endforeach
    </ol>

    {{ $veiculos->links() }}


@endsection