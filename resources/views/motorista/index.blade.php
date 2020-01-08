@extends('layouts.app')

@section('content')

<div class="container">

    <h1>Motoristas </h1>

    <table class="table">
        <thead>
            <tr>
            <th>#</th>
            <th>Descricao</th>
            <th>Placa</th>
            <th>Lotação</th>
            </tr>
        </thead>
        <tbody>

        @foreach($motoristas as $m)
            <tr>
                <th>{{$m->id}}</th>
                <td>{{$m->nome}}</td>
                <td>{{$m->telefone}}</td>
                <td>{{$m->created_at}}</td>
            </tr>
        @endforeach

        </tbody>
    </table>
    
    {{ $motoristas->links() }}

</div>
@endsection