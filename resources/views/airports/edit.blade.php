@extends('layouts.app')
@section('content')
<div class="container py-4">
  <h4 class="fw-bold mb-3">Edit Airport</h4>
  <form method="POST" action="{{ route('airports.update', $airport) }}" class="card p-4 shadow-sm border-0">
    @csrf
    @method('PUT')
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Airport Name</label>
        <input type="text" name="name" value="{{ $airport->name }}" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">City</label>
        <select name="city_id" class="form-select" required>
          @foreach($cities as $city)
            <option value="{{ $city->id }}" {{ $city->id == $airport->city_id ? 'selected' : '' }}>
              {{ $city->name }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
          <option value="active" {{ $airport->status == 'active' ? 'selected' : '' }}>Active</option>
          <option value="inactive" {{ $airport->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
      </div>
    </div>
    <div class="mt-4 text-end">
      <button class="btn btn-success me-2">Update</button>
      <a href="{{ route('airports.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
  </form>
</div>
@endsection
