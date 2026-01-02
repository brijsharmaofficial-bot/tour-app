@extends('layouts.app')
@section('title', 'Create Page')

@section('content')
<div class="container">
        <h2>Vehicle Types</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('vehicle-types.create') }}" class="btn btn-success mb-3">Add Vehicle Type</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Icon</th>            
                    <th>Rate per Km</th>
                    <th>Rate per Max Km</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vehicleTypes as $vehicle)
                    <tr>
                        <td>{{ $vehicle->id }}</td>
                        <td>{{ $vehicle->name }}</td>
                        <td><img src="{{ asset($vehicle->icon) }}" alt="Icon" style="max-width: 60px;"></td>                  
                        <td>{{ $vehicle->rate_per_km }}</td>
                        <td>{{ $vehicle->rate_per_max_km }}</td>
                        <td>
                            <a href="{{ route('vehicle-types.edit', $vehicle->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('vehicle-types.destroy', $vehicle->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
