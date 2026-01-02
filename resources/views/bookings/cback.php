@extends('layouts.app')
@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0"><i class="bi bi-plus-circle me-2 text-success"></i> Add Booking</h4>
    <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary btn-sm">
      <i class="bi bi-arrow-left"></i> Back to List
    </a>
  </div>

  <form method="POST" action="{{ route('bookings.store') }}" class="card p-4 shadow-sm border-0">
    @csrf
    <div class="row g-3">

      {{-- USER --}}
      <div class="col-md-4">
        <label class="form-label fw-semibold">Customer</label>
        <select name="user_id" class="form-select" required>
          <option value="">Select User</option>
          @foreach($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
          @endforeach
        </select>
      </div>

      {{-- PACKAGE --}}
      <div class="col-md-4">
        <label class="form-label fw-semibold">Package</label>
        <select name="package_id" class="form-select">
          <option value="">Select Package</option>
          @foreach($packages as $pkg)
            <option value="{{ $pkg->id }}">
              {{ ucfirst($pkg->tripType->name) }} – {{ $pkg->fromCity->name }}
              @if($pkg->toCity) → {{ $pkg->toCity->name }} @endif
            </option>
          @endforeach
        </select>
      </div>

      {{-- VENDOR (optional assign) --}}
      <div class="col-md-4">
        <label class="form-label fw-semibold">Assign Vendor (Optional)</label>
        <select name="vendor_id" class="form-select">
          <option value="">Select Vendor</option>
          @foreach($vendors as $vendor)
            <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
          @endforeach
        </select>
      </div>

      {{-- CAB (optional assign) --}}
      <div class="col-md-4">
        <label class="form-label fw-semibold">Assign Cab (Optional)</label>
        <select name="cab_id" class="form-select">
          <option value="">Select Cab</option>
          @foreach($cabs as $cab)
            <option value="{{ $cab->id }}">{{ $cab->cab_name }} ({{ ucfirst($cab->cab_type) }})</option>
          @endforeach
        </select>
      </div>

      {{-- FROM CITY --}}
      <div class="col-md-4">
        <label class="form-label fw-semibold">From City</label>
        <select name="from_city_id" class="form-select" required>
          <option value="">Select City</option>
          @foreach($cities as $city)
            <option value="{{ $city->id }}">{{ $city->name }}</option>
          @endforeach
        </select>
      </div>

      {{-- TO CITY --}}
      <div class="col-md-4">
        <label class="form-label fw-semibold">To City</label>
        <select name="to_city_id" class="form-select">
          <option value="">Select City</option>
          @foreach($cities as $city)
            <option value="{{ $city->id }}">{{ $city->name }}</option>
          @endforeach
        </select>
      </div>

      {{-- PICKUP DATE & TIME --}}
      <div class="col-md-4">
        <label class="form-label fw-semibold">Pickup Date</label>
        <input type="date" name="pickup_date" class="form-control" required>
      </div>

      <div class="col-md-4">
        <label class="form-label fw-semibold">Pickup Time</label>
        <input type="time" name="pickup_time" class="form-control" required>
      </div>

      {{-- ADDRESSES --}}
      <div class="col-md-12">
        <label class="form-label fw-semibold">Pickup Address</label>
        <input type="text" name="pickup_address" class="form-control" required>
      </div>

      <div class="col-md-12">
        <label class="form-label fw-semibold">Drop Address</label>
        <input type="text" name="drop_address" class="form-control">
      </div>

      {{-- TOTAL FARE --}}
      <div class="col-md-4">
        <label class="form-label fw-semibold">Total Fare (₹)</label>
        <input type="number" step="0.01" name="total_estimated_fare" class="form-control" required>
      </div>

      {{-- STATUS --}}
      <div class="col-md-4">
        <label class="form-label fw-semibold">Booking Status</label>
        <select name="status" class="form-select">
          <option value="pending">Pending</option>
          <option value="assigned">Assigned</option>
          <option value="in_progress">In Progress</option>
          <option value="completed">Completed</option>
          <option value="cancelled">Cancelled</option>
        </select>
      </div>

      {{-- PAYMENT --}}
      <div class="col-md-4">
        <label class="form-label fw-semibold">Payment Status</label>
        <select name="payment_status" class="form-select">
          <option value="unpaid">Unpaid</option>
          <option value="paid">Paid</option>
        </select>
      </div>
    </div>

    <div class="mt-4 d-flex justify-content-end">
      <button type="submit" class="btn btn-success me-2">
        <i class="bi bi-check2-circle"></i> Save Booking
      </button>
      <a href="{{ route('bookings.index') }}" class="btn btn-secondary">
        <i class="bi bi-x-circle"></i> Cancel
      </a>
    </div>
  </form>
</div>
@endsection
