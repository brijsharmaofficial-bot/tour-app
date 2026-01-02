@extends('layouts.app')

@section('content')
<h2>Vehicle Details</h2>
<a href="{{ route('vehicles.index') }}" class="btn btn-secondary mb-3">Back</a>

<div class="card">
    <div class="card-body">
        <p><strong>Vendor:</strong> {{ $vehicle->vendor->name ?? 'N/A' }}</p>
        <p><strong>Type:</strong> {{ $vehicle->vehicle_type }}</p>
        <p><strong>Number:</strong> {{ $vehicle->vehicle_number }}</p>
        <p><strong>Model:</strong> {{ $vehicle->vehicle_model }}</p>
        <p><strong>Year:</strong> {{ $vehicle->vehicle_year }}</p>
        <p><strong>License:</strong> {{ $vehicle->license_number }} (Expiry: {{ $vehicle->license_expiry }})</p>
        <p><strong>Insurance:</strong> {{ $vehicle->insurance_number }} (Expiry: {{ $vehicle->insurance_expiry }})</p>
    </div>
</div>
@endsection
