@extends('layouts.app')
@section('content')
<div class="container py-4">
  <h4 class="fw-bold mb-3">Edit Pricing ({{ $package->tripType->name }})</h4>
  <form method="POST" action="{{ route('package_pricing.update', [$package, $detail]) }}" class="card p-4 shadow-sm border-0">
    @csrf
    @method('PUT')
    <div class="row g-3">
      <div class="col-md-4">
        <label class="form-label">Hours</label>
        <input type="number" name="hours" class="form-control" value="{{ $detail->hours }}" required>
      </div>
      <div class="col-md-4">
        <label class="form-label">KMs</label>
        <input type="number" name="kms" class="form-control" value="{{ $detail->kms }}" required>
      </div>
      <div class="col-md-4">
        <label class="form-label">Price (₹)</label>
        <input type="number" step="0.01" name="price" class="form-control" value="{{ $detail->price }}" required>
      </div>
    </div>
    <div class="mt-4 text-end">
      <button class="btn btn-success me-2">Update</button>
      <a href="{{ route('package_pricing.index', $package) }}" class="btn btn-secondary">Cancel</a>
    </div>
  </form>
</div>
@endsection
