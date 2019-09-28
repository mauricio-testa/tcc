@extends('layout')

@section('content')

    <h1>Com blade </h1>
        @foreach($tarefas as $t)
            <li>
                {{$t->id}} - {{$t->descricao}} - {{$t->concluida}} - {{$t->created_at}}
            </li>
        @endforeach

    <h1> Com VUE </h1>
    
    <div id="app">
        <tarefas></tarefas>
    </div>

@endsection