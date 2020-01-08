@extends('layouts.app')

@section('content')

<div class="container">

    <h1>Veículos </h1>

    <table class="table">
        <thead>
            <tr>
            <th>#</th>
            <th>Descricao</th>
            <th>Placa</th>
            <th>Lotação</th>
            <th>Tipo</th>
            <th>Ano/Modelo</th>
            <th>Marca/Modelo</th>
            </tr>
        </thead>
        <tbody>

        @foreach($veiculos as $v)
            <tr>
                <th>{{$v->id}}</th>
                <td>{{$v->descricao}}</td>
                <td>{{$v->placa}}</td>
                <td>{{$v->lotacao}}</td>
                <td>{{$v->tipo}}</td>
                <td>{{$v->ano_modelo}}</td>
                <td>{{$v->marca_modelo}}</td>
            </tr>
        @endforeach

        </tbody>
    </table>
    
    {{ $veiculos->links() }}

</div>
@endsection