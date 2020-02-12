@extends('layouts.app')

@section('content')


<veiculos api="{{ url('/api/veiculos') }}"></veiculos>

@endsection