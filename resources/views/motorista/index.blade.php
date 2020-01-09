@extends('layouts.app')

@section('content')

<div class="container">

    <h1>Motoristas </h1>

    <table class="table">
        <thead>
            <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Telefone</th>
            <th>Inserido em</th>
            <th>Action</th>
            </tr>
        </thead>
        <tbody>

        @foreach($motoristas as $m)
            <tr>
                <th>{{$m->id}}</th>
                <td>{{$m->nome}}</td>
                <td>{{$m->telefone}}</td>
                <td>{{$m->created_at}}</td>
                <td>
                    <a class="btn btn-danger btn-sm" href="{{route('motorista.delete', $m->id)}}">Delete</a>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
    
    {{ $motoristas->links() }}

</div>
@endsection