@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
    </ul>
</div>
@endif

<form action="{{ $route }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($method === 'PUT') @method('PUT') @endif

    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Vendor</label>
            <select name="vendor_id" class="form-select">
                <option value="">-- Select Vendor --</option>
                @foreach($vendors as $vendor)
                <option value="{{ $vendor->id }}" {{ old('vendor_id', $vehicle->vendor_id ?? '') == $vendor->id ? 'selected' : '' }}>
                    {{ $vendor->name }} ({{ $vendor->company_name }})
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Vehicle Type</label>
            <input type="text" name="vehicle_type" value="{{ old('vehicle_type', $vehicle->vehicle_type ?? '') }}" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">Vehicle Number</label>
            <input type="text" name="vehicle_number" value="{{ old('vehicle_number', $vehicle->vehicle_number ?? '') }}" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">Vehicle Model</label>
            <input type="text" name="vehicle_model" value="{{ old('vehicle_model', $vehicle->vehicle_model ?? '') }}" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">Vehicle Year</label>
            <input type="number" name="vehicle_year" value="{{ old('vehicle_year', $vehicle->vehicle_year ?? '') }}" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">License Number</label>
            <input type="text" name="license_number" value="{{ old('license_number', $vehicle->license_number ?? '') }}" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">License Expiry</label>
            <input type="date" name="license_expiry" value="{{ old('license_expiry', $vehicle->license_expiry ?? '') }}" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">Insurance Number</label>
            <input type="text" name="insurance_number" value="{{ old('insurance_number', $vehicle->insurance_number ?? '') }}" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">Insurance Expiry</label>
            <input type="date" name="insurance_expiry" value="{{ old('insurance_expiry', $vehicle->insurance_expiry ?? '') }}" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">Upload Documents</label>
            <input type="file" name="vehicle_documents" class="form-control">
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">{{ $button }}</button>
        </div>
    </div>
</form>
