@extends('layouts.app')

@section('content')


<motoristas :data="{{ htmlspecialchars(json_encode($motoristas))}}"></motoristas>
@endsection