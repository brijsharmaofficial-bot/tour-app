@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Vehicles</h2>
    <a href="{{ route('vehicles.create') }}" class="btn btn-primary">Add Vehicle</a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Vendor</th>
            <th>Type</th>
            <th>Number</th>
            <th>Model</th>
            <th>Year</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($vehicles as $vehicle)
        <tr>
            <td>{{ $vehicle->id }}</td>
            <td>{{ $vehicle->vendor->name ?? 'N/A' }}</td>
            <td>{{ $vehicle->vehicle_type }}</td>
            <td>{{ $vehicle->vehicle_number }}</td>
            <td>{{ $vehicle->vehicle_model }}</td>
            <td>{{ $vehicle->vehicle_year }}</td>
            <td>
                <a href="{{ route('vehicles.show', $vehicle) }}" class="btn btn-info btn-sm">View</a>
                <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this vehicle?')">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center">No vehicles found.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
