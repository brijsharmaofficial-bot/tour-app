@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-3">Edit Package</h4>

    <form method="POST" action="{{ route('packages.update', $package) }}" class="card p-4 shadow-sm border-0">
        @csrf
        @method('PUT')

        <div class="row g-3">
            {{-- Vendor --}}
            <div class="col-md-6">
                <label class="form-label">Vendor</label>
                <select name="vendor_id" id="vendor_id" class="form-select" required>
                    <option value="">Select Vendor</option>
                    @foreach($vendors as $vendor)
                        <option value="{{ $vendor->id }}" {{ $vendor->id == $package->vendor_id ? 'selected' : '' }}>
                            {{ $vendor->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Cab --}}
            <div class="col-md-6">
                <label class="form-label">Cab</label>
                <select name="cab_id" id="cab_id" class="form-select" required>
                    <option value="">Loading cabs...</option>
                    <!-- Cabs will be loaded dynamically via AJAX -->
                </select>
                <div class="form-text">Cabs will update based on selected vendor</div>
            </div>

            {{-- Trip Type --}}
            <div class="col-md-6">
                <label class="form-label">Trip Type</label>
                <select name="trip_type_id" id="trip_type_id" class="form-select" required>
                    @foreach($tripTypes as $type)
                        <option value="{{ $type->id }}" {{ $type->id == $package->trip_type_id ? 'selected' : '' }}>
                            {{ ucfirst($type->name) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- From City --}}
            <div class="col-md-6">
                <label class="form-label">From City</label>
                <select name="from_city_id" class="form-select" required>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}" {{ $city->id == $package->from_city_id ? 'selected' : '' }}>
                            {{ $city->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- To City --}}
            <div class="col-md-6 trip-dependent" id="to_city_group">
                <label class="form-label">To City</label>
                <select name="to_city_id" class="form-select">
                    <option value="">Select To</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}" {{ $city->id == $package->to_city_id ? 'selected' : '' }}>
                            {{ $city->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Airport Fields --}}
            <div class="col-md-6 airport-fields" style="{{ strtolower($package->tripType->name) == 'airport' ? '' : 'display:none;' }}">
                <label class="form-label">Airport Type</label>
                <select name="airport_type" class="form-select">
                    <option value="">Select Type</option>
                    <option value="pickup" {{ $package->airport_type == 'pickup' ? 'selected' : '' }}>Pickup</option>
                    <option value="drop" {{ $package->airport_type == 'drop' ? 'selected' : '' }}>Drop</option>
                </select>
            </div>

            <div class="col-md-6 airport-fields" style="{{ strtolower($package->tripType->name) == 'airport' ? '' : 'display:none;' }}">
                <label class="form-label">Airport</label>
                <select name="airport_id" class="form-select">
                    <option value="">Select Airport</option>
                    @foreach($airports as $airport)
                        <option value="{{ $airport->id }}" {{ $airport->id == $package->airport_id ? 'selected' : '' }}>
                            {{ $airport->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- ✈️ Airport Minimum KM Field --}}
            <div class="col-md-4 airport-fields" id="airport_min_km_field" style="{{ strtolower($package->tripType->name) == 'airport' ? '' : 'display:none;' }}">
                <label class="form-label">Minimum KM (Airport)</label>
                <input type="number" step="1" name="airport_min_km" class="form-control" value="{{ $package->airport_min_km }}" placeholder="e.g. 25">
            </div>

            {{-- Pricing Fields --}}
            <div class="col-md-4">
                <label class="form-label">Offer %</label>
                <input type="number" step="0.01" name="offer_price" class="form-control" value="{{ $package->offer_price }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Price per KM (₹)</label>
                <input type="number" step="0.01" name="price_per_km" class="form-control" value="{{ $package->price_per_km }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Extra Price per KM (₹)</label>
                <input type="number" step="0.01" name="extra_price_per_km" class="form-control" value="{{ $package->extra_price_per_km }}">
            </div>

            {{-- Local Package Fields --}}
            <div class="row local-fields" style="{{ strtolower($package->tripType->name) == 'local' ? '' : 'display:none;' }}">
                <div class="col-md-4">
                    <label class="form-label">Hours</label>
                    <input type="number" step="1" name="hours" class="form-control" value="{{ $package->hours }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">KMs</label>
                    <input type="number" step="1" name="kms" class="form-control" value="{{ $package->kms }}">
                </div>
            </div>

            {{-- Extra Costs --}}
            <div class="col-md-4">
                <label class="form-label">DA (₹)</label>
                <input type="number" step="0.01" name="da" class="form-control" value="{{ $package->da }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Toll Tax (₹)</label>
                <input type="number" step="0.01" name="toll_tax" class="form-control" value="{{ $package->toll_tax }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">GST (%)</label>
                <input type="number" step="0.01" name="gst" class="form-control" value="{{ $package->gst }}">
            </div>

            {{-- Status --}}
            <div class="col-md-4">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active" {{ $package->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $package->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-end">
            <button class="btn btn-success me-2">Update</button>
            <a href="{{ route('packages.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Function to load cabs for selected vendor
    function loadVendorCabs(vendorId, selectedCabId = null) {
        const cabSelect = $('#cab_id');
        
        if (vendorId) {
            cabSelect.html('<option value="">Loading cabs...</option>');
            
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
                            const isSelected = (selectedCabId && cab.id == selectedCabId) ? 'selected' : '';
                            cabSelect.append(
                                $('<option>', {
                                    value: cab.id,
                                    text: cab.cab_name + (cab.cab_type ? ' (' + cab.cab_type + ')' : ''),
                                    selected: isSelected
                                })
                            );
                        });
                        
                        // If no cab selected but we have a selectedCabId, select it
                        if (selectedCabId && !cabSelect.val()) {
                            cabSelect.val(selectedCabId);
                        }
                    } else {
                        cabSelect.html('<option value="">No cabs available</option>');
                    }
                },
                error: function(xhr) {
                    console.error('Error fetching cabs:', xhr);
                    cabSelect.html('<option value="">Error loading cabs</option>');
                }
            });
        } else {
            cabSelect.html('<option value="">Select Vendor First</option>');
        }
    }

    // Initial load - load cabs for current vendor
    const currentVendorId = $('#vendor_id').val();
    const currentCabId = {{ $package->cab_id ?? 'null' }};
    
    if (currentVendorId) {
        loadVendorCabs(currentVendorId, currentCabId);
    } else {
        $('#cab_id').html('<option value="">Select Vendor First</option>');
    }

    // Vendor change event
    $('#vendor_id').on('change', function() {
        const vendorId = $(this).val();
        loadVendorCabs(vendorId);
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

    // Run once when page loads
    toggleFields();

    // Trigger on type change
    $('#trip_type_id').on('change', toggleFields);
});
</script>
@endpush