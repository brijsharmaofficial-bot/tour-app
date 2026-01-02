@extends('layouts.app')
@section('content')
<div class="container py-4">
  <h4 class="fw-bold mb-3">Add Airport</h4>
  <form method="POST" action="{{ route('airports.store') }}" class="card p-4 shadow-sm border-0">
    @csrf
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Airport Name</label>
        <input type="text" name="name" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">City</label>
        <select name="city_id" class="form-select" required>
          <option value="">Select City</option>
          @foreach($cities as $city)
            <option value="{{ $city->id }}">{{ $city->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
          <option value="active" selected>Active</option>
          <option value="inactive">Inactive</option>
        </select>
      </div>
    </div>
    <div class="mt-4 text-end">
      <button class="btn btn-success me-2">Save</button>
      <a href="{{ route('airports.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
  </form>
</div>
@endsection
