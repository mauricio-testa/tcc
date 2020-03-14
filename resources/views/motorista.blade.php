@extends('layouts.app')

@section('content')

<motoristas api="{{ url('/api/motoristas') }}"></motoristas>

@endsection