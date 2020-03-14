@extends('layouts.app')

@section('content')

<pacientes api="{{ url('/api/pacientes') }}"></pacientes>

@endsection