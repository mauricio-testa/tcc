@extends('layouts.app')

@section('content')

<dashboard :data="{{ htmlspecialchars(json_encode($data))}}"></dashboard>

@endsection
