@extends('layouts.app')

@section('content')

<viagens api="{{ url('/api/viagens') }}"></viagens>

@endsection