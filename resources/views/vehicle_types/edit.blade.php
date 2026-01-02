@extends('layouts.app')
@section('title', 'Create Page')

@section('content')

   <div class="container">
        <h2>Edit Vehicle Type</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('vehicle-types.update', $vehicleType->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Name*</label>
                <input type="text" name="name" id="name" class="form-control" required value="{{ old('name', $vehicleType->name) }}">
            </div>

            <div class="mb-3">
                <label for="icon" class="form-label">Icon (Image Upload)</label>
                @if($vehicleType->icon)
                    <div class="mb-2">
                        <img src="{{ asset($vehicleType->icon) }}" alt="Current Icon" style="max-width: 120px; display: block;">
                    </div>
                @endif
                <input type="file" name="icon" id="icon" class="form-control" accept="image/*">
                <small class="text-muted">Leave empty to keep the current icon. Upload a new image to replace it.</small>
            </div>
     

            <div class="mb-3">
                <label for="rate_per_km" class="form-label">Rate Per KM</label>
                <input type="number" step="0.01" name="rate_per_km" id="rate_per_km" class="form-control" value="{{ old('rate_per_km', $vehicleType->rate_per_km) }}">
            </div>

            <div class="mb-3">
                <label for="rate_per_max_km" class="form-label">Rate Per Max KM</label>
                <input type="number" step="0.01" name="rate_per_max_km" id="rate_per_max_km" class="form-control" value="{{ old('rate_per_max_km', $vehicleType->rate_per_max_km) }}">
            </div>

            <button type="submit" class="btn btn-primary">Update Vehicle Type</button>
            <a href="{{ route('vehicle-types.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
@endsection