@extends('layouts.app')
@section('title', 'Edit Booking')

@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between mb-3">
    <h4 class="fw-bold mb-0">
      <i class="bi bi-pencil-square text-primary me-2"></i> Edit Booking
    </h4>
    <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary btn-sm">
      <i class="bi bi-arrow-left"></i> Back to List
    </a>
  </div>

  <form id="bookingForm" method="POST" action="{{ route('bookings.update', $booking->id) }}" class="card shadow-sm border-0 p-4">
    @csrf
    @method('PUT')

    <div class="row g-3">
      {{-- USER --}}
      <div class="col-md-4">
        <label class="form-label">Customer</label>
        <select name="user_id" class="form-select">
          <option value="">Select User</option>
          @foreach($users as $u)
            <option value="{{ $u->id }}" {{ $booking->user_id == $u->id ? 'selected' : '' }}>
              {{ $u->name }}
            </option>
          @endforeach
        </select>
      </div>

      {{-- PACKAGE SEARCH --}}
      <div class="col-md-4 position-relative">
        <label class="form-label">Package</label>
        <input type="text" id="packageSearch" class="form-control"
               value="{{ $booking->package ? ($booking->package->tripType->name ?? '') . ': ' . ($booking->package->fromCity->name ?? '') . ' → ' . ($booking->package->toCity->name ?? 'N/A') : '' }}"
               placeholder="Search Package (City or Trip Type)...">
        <input type="hidden" name="package_id" id="package_id" value="{{ $booking->package_id }}">
        <ul id="packageResults" class="list-group position-absolute w-100 shadow-sm" style="z-index:1000; display:none;"></ul>
      </div>

      {{-- VENDOR --}}
      <div class="col-md-4">
        <label class="form-label">Vendor</label>
        <select name="vendor_id" id="vendor_id" class="form-select">
          <option value="">Select Vendor</option>
          @foreach($vendors as $v)
            <option value="{{ $v->id }}" {{ $booking->vendor_id == $v->id ? 'selected' : '' }}>
              {{ $v->name }}
            </option>
          @endforeach
        </select>
      </div>

      {{-- CAB (Vendor Wise) --}}
      <div class="col-md-4">
        <label class="form-label">Cab</label>
        <select name="cab_id" id="cab_id" class="form-select">
          @foreach($cabs as $c)
            <option value="{{ $c->id }}" {{ $booking->cab_id == $c->id ? 'selected' : '' }}>
              {{ $c->cab_name }} ({{ ucfirst($c->cab_type) }})
            </option>
          @endforeach
        </select>
      </div>

      {{-- FROM CITY --}}
      <div class="col-md-4">
        <label class="form-label">From City</label>
        <select name="from_city_id" id="from_city_id" class="form-select">
          @foreach($cities as $city)
            <option value="{{ $city->id }}" {{ $booking->from_city_id == $city->id ? 'selected' : '' }}>
              {{ $city->name }}
            </option>
          @endforeach
        </select>
      </div>

      {{-- TO CITY --}}
      <div class="col-md-4">
        <label class="form-label">To City</label>
        <select name="to_city_id" id="to_city_id" class="form-select">
          @foreach($cities as $city)
            <option value="{{ $city->id }}" {{ $booking->to_city_id == $city->id ? 'selected' : '' }}>
              {{ $city->name }}
            </option>
          @endforeach
        </select>
      </div>

      {{-- PICKUP DATE/TIME --}}
      <div class="col-md-4">
        <label class="form-label">Pickup Date</label>
        <input type="date" name="pickup_date" value="{{ $booking->pickup_date }}" class="form-control" required>
      </div>
      <div class="col-md-4">
        <label class="form-label">Pickup Time</label>
        <input type="time" name="pickup_time" value="{{ $booking->pickup_time }}" class="form-control" required>
      </div>

      {{-- ADDRESSES --}}
      <div class="col-md-6">
        <label class="form-label">Pickup Address</label>
        <input type="text" name="pickup_address" value="{{ $booking->pickup_address }}" class="form-control">
      </div>
      <div class="col-md-6">
        <label class="form-label">Drop Address</label>
        <input type="text" name="drop_address" value="{{ $booking->drop_address }}" class="form-control">
      </div>

      {{-- DISTANCE / FARE --}}
      <div class="col-md-4">
        <label class="form-label">Distance (km)</label>
        <input type="number" step="0.01" name="distance_km" id="distance_km" value="{{ $booking->distance_km }}" class="form-control">
      </div>
      <div class="col-md-4">
        <label class="form-label">Fare Without GST</label>
        <input type="number" step="0.01" name="fare_without_gst" id="fare_without_gst" value="{{ $booking->fare_without_gst }}" class="form-control">
      </div>
      <div class="col-md-4">
        <label class="form-label">Total Estimated Fare (₹)</label>
        <input type="number" step="0.01" name="total_estimated_fare" id="total_estimated_fare" value="{{ $booking->total_estimated_fare }}" class="form-control">
      </div>

      {{-- STATUS --}}
      <div class="col-md-4">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
          @foreach(['pending','assigned','in_progress','completed','cancelled'] as $st)
            <option value="{{ $st }}" {{ $booking->status == $st ? 'selected' : '' }}>
              {{ ucfirst($st) }}
            </option>
          @endforeach
        </select>
      </div>

      {{-- PAYMENT --}}
      <div class="col-md-4">
        <label class="form-label">Payment Status</label>
        <select name="payment_status" class="form-select">
          <option value="unpaid" {{ $booking->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
          <option value="paid" {{ $booking->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
        </select>
      </div>
    </div>

    <div class="mt-4 text-end">
      <button class="btn btn-primary"><i class="bi bi-check-circle"></i> Update</button>
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
    if (q.length < 2) return;

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

  pkgResults.addEventListener('click', e => {
    if (e.target.matches('li')) {
      pkgSearch.value = e.target.textContent.trim();
      pkgHidden.value = e.target.dataset.id;
      pkgResults.style.display = 'none';
    }
  });

  // 💡 Load vendor-wise cabs dynamically
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
