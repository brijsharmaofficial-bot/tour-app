@extends('layouts.app')
@section('title', 'Create Booking')

@section('content')
<div class="container py-4">
  <h4 class="fw-bold mb-3">
    <i class="bi bi-plus-circle text-success me-2"></i> New Booking
  </h4>

  <form id="bookingForm" method="POST" action="{{ route('bookings.store') }}" class="card shadow-sm border-0 p-4">
    @csrf
    <div class="row g-3">

      {{-- USER --}}
      <div class="col-md-4">
        <label class="form-label">Customer</label>
        <select name="user_id" class="form-select">
          <option value="">Select User</option>
          @foreach($users as $u)
            <option value="{{ $u->id }}">{{ $u->name }}</option>
          @endforeach
        </select>
      </div>

      {{-- PACKAGE SEARCH --}}
      <div class="col-md-4 position-relative">
        <label class="form-label">Package</label>
        <input type="text" id="packageSearch" class="form-control" placeholder="Search Package (City or Trip Type)...">
        <input type="hidden" name="package_id" id="package_id">
        <ul id="packageResults" class="list-group position-absolute w-100 shadow-sm" style="z-index:1000; display:none;"></ul>
      </div>

      {{-- VENDOR --}}
      <div class="col-md-4">
        <label class="form-label">Vendor</label>
        <select name="vendor_id" id="vendor_id" class="form-select">
          <option value="">Select Vendor</option>
          @foreach($vendors as $v)
            <option value="{{ $v->id }}">{{ $v->name }}</option>
          @endforeach
        </select>
      </div>

      {{-- CAB (Vendor Wise) --}}
      <div class="col-md-4">
        <label class="form-label">Cab</label>
        <select name="cab_id" id="cab_id" class="form-select">
          <option value="">Select Vendor First</option>
        </select>
      </div>

      {{-- FROM CITY --}}
      <div class="col-md-4">
        <label class="form-label">From City</label>
        <select name="from_city_id" id="from_city_id" class="form-select">
          @foreach($cities as $city)
            <option value="{{ $city->id }}">{{ $city->name }}</option>
          @endforeach
        </select>
      </div>

      {{-- TO CITY --}}
      <div class="col-md-4">
        <label class="form-label">To City</label>
        <select name="to_city_id" id="to_city_id" class="form-select">
          @foreach($cities as $city)
            <option value="{{ $city->id }}">{{ $city->name }}</option>
          @endforeach
        </select>
      </div>

      {{-- PICKUP DATE/TIME --}}
      <div class="col-md-4">
        <label class="form-label">Pickup Date</label>
        <input type="date" name="pickup_date" class="form-control" required>
      </div>
      <div class="col-md-4">
        <label class="form-label">Pickup Time</label>
        <input type="time" name="pickup_time" class="form-control" required>
      </div>

      {{-- ADDRESSES --}}
      <div class="col-md-6">
        <label class="form-label">Pickup Address</label>
        <input type="text" name="pickup_address" class="form-control">
      </div>
      <div class="col-md-6">
        <label class="form-label">Drop Address</label>
        <input type="text" name="drop_address" class="form-control">
      </div>

      {{-- DISTANCE / FARE --}}
      <div class="col-md-4">
        <label class="form-label">Distance (km)</label>
        <input type="number" step="0.01" name="distance_km" id="distance_km" class="form-control">
      </div>
      <div class="col-md-4">
        <label class="form-label">Fare Without GST</label>
        <input type="number" step="0.01" name="fare_without_gst" id="fare_without_gst" class="form-control">
      </div>
      <div class="col-md-4">
        <label class="form-label">Total Estimated Fare (₹)</label>
        <input type="number" step="0.01" name="total_estimated_fare" id="total_estimated_fare" class="form-control">
      </div>

      {{-- STATUS --}}
      <div class="col-md-4">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
          <option value="pending">Pending</option>
          <option value="assigned">Assigned</option>
          <option value="completed">Completed</option>
          <option value="cancelled">Cancelled</option>
        </select>
      </div>

      {{-- PAYMENT --}}
      <div class="col-md-4">
        <label class="form-label">Payment Status</label>
        <select name="payment_status" class="form-select">
          <option value="unpaid">Unpaid</option>
          <option value="paid">Paid</option>
        </select>
      </div>
    </div>

    <div class="mt-4 text-end">
      <button class="btn btn-success"><i class="bi bi-check-circle"></i> Save</button>
      <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const vendorSelect = document.getElementById('vendor_id');
  const cabSelect = document.getElementById('cab_id');
  const pkgSearch = document.getElementById('packageSearch');
  const pkgResults = document.getElementById('packageResults');
  const pkgHidden = document.getElementById('package_id');

  // 🔍 Autocomplete search for packages
  pkgSearch.addEventListener('input', async () => {
    const q = pkgSearch.value.trim();
    pkgResults.innerHTML = '';
    pkgResults.style.display = 'none';

    if (q.length < 2) return; // Minimum 2 chars

    const res = await fetch(`/admin/packages/search?q=${q}`);
    const data = await res.json();

    if (data.length) {
      pkgResults.innerHTML = data.map(p => `
        <li class="list-group-item list-group-item-action"
            data-id="${p.id}">
          ${p.trip_type_name} — ${p.from_city_name} → ${p.to_city_name || 'N/A'}
        </li>`).join('');
      pkgResults.style.display = 'block';
    }
  });

  // Select package from dropdown
  pkgResults.addEventListener('click', e => {
    if (e.target.matches('li')) {
      pkgSearch.value = e.target.textContent.trim();
      pkgHidden.value = e.target.dataset.id;
      pkgResults.style.display = 'none';
    }
  });

  // 💡 Vendor wise cabs
  vendorSelect.addEventListener('change', async () => {
    const id = vendorSelect.value;
    cabSelect.innerHTML = '<option>Loading...</option>';
    if (!id) return;
    const res = await fetch(`/admin/get-cabs?vendor_id=${id}`);
    const data = await res.json();
    cabSelect.innerHTML = data.length
      ? data.map(c => `<option value="${c.id}">${c.cab_name} (${c.cab_type})</option>`).join('')
      : '<option>No cabs available</option>';
  });
});
</script>
@endpush

@push('styles')
<style>
#packageResults li:hover { background:#f8f9fa; cursor:pointer; }
</style>
@endpush
