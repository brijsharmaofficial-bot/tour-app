@extends('layouts.app')

@section('content')
<h2>Edit Vehicle</h2>
<a href="{{ route('vehicles.index') }}" class="btn btn-secondary mb-3">Back</a>

@include('vehicles.partials.form', ['route' => route('vehicles.update', $vehicle), 'method' => 'PUT', 'button' => 'Update Vehicle'])
@endsection
