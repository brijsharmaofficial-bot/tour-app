@extends('layouts.app')

@section('title', 'Add Route')

@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-3"><i class="bi bi-plus-circle text-primary me-2"></i>Add Route</h4>

    <form method="POST" action="{{ route('routes.store') }}" class="card p-4 shadow-sm border-0">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">From City</label>
                <select name="from_city_id" class="form-select" required>
                    <option value="">Select City</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">To City</label>
                <select name="to_city_id" class="form-select" required>
                    <option value="">Select City</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Distance (km)</label>
                <input type="number" step="0.01" name="distance_km" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Approx Time</label>
                <input type="text" name="approx_time" class="form-control" placeholder="e.g., 4h 30m">
            </div>
            <div class="col-md-4">
                <label class="form-label">Toll Tax (₹)</label>
                <input type="number" step="0.01" name="toll_tax" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>
        <div class="mt-4 text-end">
            <button class="btn btn-success me-2">Save</button>
            <a href="{{ route('routes.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
