@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-3">Add Cab</h4>

    <form method="POST" action="{{ route('cabs.store') }}" class="card p-4 shadow-sm border-0" enctype="multipart/form-data">
        @csrf

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Vendor</label>
                <select name="vendor_id" class="form-select" required>
                    <option value="">Select Vendor</option>
                    @foreach($vendors as $vendor)
                        <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Cab Image</label>
                <input type="file" name="image" accept="image/*" class="form-control">
                @if(isset($cab) && $cab->image)
                    <div class="mt-2">
                        <img src="{{ asset('storage/'.$cab->image) }}" width="100" class="rounded border">
                        <p class="small text-muted mt-1">Current Image</p>
                    </div>
                @endif
            </div>

            <div class="col-md-6">
                <label class="form-label">Cab Name</label>
                <input type="text" name="cab_name" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Registration Number</label>
                <input type="text" name="registration_no" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Cab Type</label>
                <select name="cab_type" class="form-select" required>
                    <option value="sedan">Sedan</option>
                    <option value="suv">SUV</option>
                    <option value="hatchback">Hatchback</option>
                    <option value="tempo">Tempo</option>
                    <option value="luxury">Luxury</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Seating Capacity</label>
                <input type="number" name="capacity" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active" selected>Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-end">
            <button class="btn btn-success me-2">Save</button>
            <a href="{{ route('cabs.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
