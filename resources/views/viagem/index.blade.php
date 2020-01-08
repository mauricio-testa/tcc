@extends('layouts.app')

@section('content')

    <h1>Viagem </h1>
    <ol>
    @foreach($viagens as $v)
        <li>
            {{$v->id}} - 
            {{$v->data_viagem}}
            {{$v->hora_saida}}
            {{$v->motorista_nome}} - 
            {{$v->veiculo_nome}} - 
            {{$v->veiculo_placa}} - 
            {{$v->municipio_nome}}
        </li>
    @endforeach
    </ol>

    {{ $viagens->links() }}


@endsection