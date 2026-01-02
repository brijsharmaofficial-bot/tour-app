@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-3">Add Package</h4>

    <form method="POST" action="{{ route('packages.store') }}" class="card p-4 shadow-sm border-0">
        @csrf
        <div class="row g-3">
            {{-- Vendor --}}
            <div class="col-md-6">
                <label class="form-label">Vendor</label>
                <select name="vendor_id" id="vendor_id" class="form-select" required>
                    <option value="">Select Vendor</option>
                    @foreach($vendors as $vendor)
                        <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Cab --}}
            <div class="col-md-6">
                <label class="form-label">Cab</label>
                <select name="cab_id" id="cab_id" class="form-select" required>
                    <option value="">Select Vendor First</option>
                    <!-- Cabs will be loaded dynamically via AJAX -->
                </select>
                <div class="form-text">Select a vendor to see their cabs</div>
            </div>

            {{-- Trip Type --}}
            <div class="col-md-6">
                <label class="form-label">Trip Type</label>
                <select name="trip_type_id" id="trip_type_id" class="form-select" required>
                    <option value="">Select Trip Type</option>
                    @foreach($tripTypes as $type)
                        <option value="{{ $type->id }}">{{ ucfirst($type->name) }}</option>
                    @endforeach
                </select>
            </div>

            {{-- From City --}}
            <div class="col-md-6">
                <label class="form-label">From City</label>
                <select name="from_city_id" class="form-select" required>
                    <option value="">Select From</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- To City (only for oneway/roundtrip) --}}
            <div class="col-md-6 trip-dependent" id="to_city_group">
                <label class="form-label">To City</label>
                <select name="to_city_id" class="form-select">
                    <option value="">Select To</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Airport Fields (only for airport trip type) --}}
            <div class="col-md-6 airport-fields" style="display:none;">
                <label class="form-label">Airport Type</label>
                <select name="airport_type" id="airport_type" class="form-select">
                    <option value="">Select Type</option>
                    <option value="pickup">Pickup from Airport</option>
                    <option value="drop">Drop to Airport</option>
                </select>
            </div>
            <div class="col-md-6 airport-fields" style="display:none;">
                <label class="form-label">Airport</label>
                <select name="airport_id" class="form-select">
                    <option value="">Select Airport</option>
                    @foreach($airports as $airport)
                        <option value="{{ $airport->id }}">{{ $airport->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- ✈️ Airport Minimum KM Field --}}
            <div class="col-md-4 airport-fields" id="airport_min_km_field" style="display:none;">
                <label class="form-label">Minimum KM (Airport)</label>
                <input type="number" step="1" name="airport_min_km" class="form-control" placeholder="e.g. 25">
            </div>

            {{-- Pricing --}}
            <div class="col-md-4">
                <label class="form-label">Offer % </label>
                <input type="number" step="0.01" name="offer_price" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Price per KM (₹)</label>
                <input type="number" step="0.01" name="price_per_km" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Extra Price per KM (₹)</label>
                <input type="number" step="0.01" name="extra_price_per_km" class="form-control">
            </div>

            {{-- Additional Costs --}}
            <div class="col-md-4">
                <label class="form-label">DA (₹)</label>
                <input type="number" step="0.01" name="da" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Toll Tax (₹)</label>
                <input type="number" step="0.01" name="toll_tax" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">GST (%)</label>
                <input type="number" step="0.01" name="gst" class="form-control">
            </div>

            {{-- Local Package Fields (only for Local trip type) --}}
            <div class="row local-fields" style="display:none;">
                <div class="col-md-4">
                    <label class="form-label">Hours</label>
                    <input type="number" step="1" name="hours" class="form-control" placeholder="e.g. 8">
                </div>
                <div class="col-md-4">
                    <label class="form-label">KMs</label>
                    <input type="number" step="1" name="kms" class="form-control" placeholder="e.g. 80">
                </div>
            </div>

            {{-- Status --}}
            <div class="col-md-4">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active" selected>Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-end">
            <button class="btn btn-success me-2">Save</button>
            <a href="{{ route('packages.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Vendor change event - fetch cabs
    $('#vendor_id').on('change', function() {
        const vendorId = $(this).val();
        const cabSelect = $('#cab_id');
        
        if (vendorId) {
            // Show loading
            cabSelect.html('<option value="">Loading cabs...</option>');
            
            // AJAX request to fetch vendor's cabs
            $.ajax({
                url: '{{ route("get.vendor.cabs") }}',
                type: 'GET',
                data: {
                    vendor_id: vendorId
                },
                success: function(response) {
                    if (response.success && response.cabs.length > 0) {
                        cabSelect.html('<option value="">Select Cab</option>');
                        $.each(response.cabs, function(index, cab) {
                            cabSelect.append(
                                $('<option>', {
                                    value: cab.id,
                                    text: cab.cab_name + ' (' + cab.cab_type + ')'
                                })
                            );
                        });
                    } else {
                        cabSelect.html('<option value="">No cabs available</option>');
                    }
                },
                error: function(xhr) {
                    console.error('Error fetching cabs:', xhr);
                    cabSelect.html('<option value="">Error loading cabs</option>');
                    alert('Error loading cabs. Please try again.');
                }
            });
        } else {
            cabSelect.html('<option value="">Select Vendor First</option>');
        }
    });

    function toggleFields() {
        const selectedType = $('#trip_type_id').find('option:selected').text().toLowerCase();

        if (selectedType.includes('airport')) {
            $('.airport-fields').show();
            $('.local-fields').hide();
            $('#to_city_group').hide();
        } 
        else if (selectedType.includes('local')) {
            $('.local-fields').show();
            $('.airport-fields').hide();
            $('#to_city_group').hide();
        } 
        else {
            $('.local-fields').hide();
            $('.airport-fields').hide();
            $('#to_city_group').show();
        }
    }

    // Initial trigger on page load
    toggleFields();

    // Trigger on trip type change
    $('#trip_type_id').on('change', toggleFields);
});
</script>
@endpush