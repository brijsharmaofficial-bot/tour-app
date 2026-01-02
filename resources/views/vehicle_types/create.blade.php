@extends('layouts.app')
@section('title', 'Create Page')

@section('content')
   <div class="container">
        <h2>Add Vehicle Type</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('vehicle-types.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Name*</label>
                <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
            </div>

            <div class="mb-3">
                <label for="icon" class="form-label">Icon (URL or Class)*</label>
                <input type="file" name="icon" id="icon" class="form-control" accept="image/*">
            </div>


            <div class="mb-3">
                <label for="rate_per_km" class="form-label">Rate Per KM</label>
                <input type="number" step="0.01" name="rate_per_km" id="rate_per_km" class="form-control" value="{{ old('rate_per_km', 0) }}">
            </div>

            <div class="mb-3">
                <label for="rate_per_max_km" class="form-label">Rate Per Max KM</label>
                <input type="number" step="0.01" name="rate_per_max_km" id="rate_per_max_km" class="form-control" value="{{ old('rate_per_max_km', 0) }}">
            </div>

            <button type="submit" class="btn btn-primary">Add Vehicle Type</button>
            <a href="{{ route('vehicle-types.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
    @endsection