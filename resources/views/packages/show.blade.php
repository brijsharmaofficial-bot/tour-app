@extends('layouts.app')

@section('title', 'Package Details - ' . $package->cab->cab_name)

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('packages.index') }}" class="text-decoration-none">Packages</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Details</li>
                </ol>
            </nav>
            <h4 class="fw-bold mb-1">{{ $package->cab->cab_name }} - {{ ucfirst($package->tripType->name) }} Trip</h4>
            <p class="text-muted mb-0">Complete package information and pricing details</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('packages.edit', $package) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Edit Package
            </a>
            <a href="{{ route('packages.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
        </div>
    </div>

    <!-- Main Card -->
    <div class="card shadow-sm border-0 overflow-hidden">
        <!-- Card Header -->
        <div class="card-header bg-gradient-primary text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="avatar-lg bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center me-3">
                        <i class="fas fa-box-open fs-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">{{ $package->cab->cab_name }} Package</h5>
                        <p class="mb-0 opacity-75">{{ $package->tripType->name }} • {{ $package->fromCity->name }} @if($package->toCity) → {{ $package->toCity->name }} @endif</p>
                    </div>
                </div>
                <div class="text-end">
                    <span class="badge bg-white text-primary fs-6 px-3 py-2">
                        <i class="fas fa-circle me-1 fs-6 {{ $package->status == 'active' ? 'text-success' : 'text-secondary' }}"></i>
                        {{ ucfirst($package->status) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="card-body p-4">
            <!-- Basic Information Section -->
            <div class="row g-4 mb-5">
                <div class="col-12">
                    <h6 class="section-title text-primary mb-3">
                        <i class="fas fa-info-circle me-2"></i>Basic Information
                    </h6>
                </div>
                
                <!-- Vendor Information -->
                <div class="col-md-6 col-lg-4">
                    <div class="info-card">
                        <div class="info-icon bg-primary">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="info-content">
                            <label class="info-label">Vendor</label>
                            <p class="info-value">{{ $package->vendor->name }}</p>
                        </div>
                    </div>
                </div>

                <!-- Cab Information -->
                <div class="col-md-6 col-lg-4">
                    <div class="info-card">
                        <div class="info-icon bg-info">
                            <i class="fas fa-car"></i>
                        </div>
                        <div class="info-content">
                            <label class="info-label">Cab Type</label>
                            <p class="info-value">{{ $package->cab->cab_name }} <span class="text-muted">({{ ucfirst($package->cab->cab_type) }})</span></p>
                        </div>
                    </div>
                </div>

                <!-- Trip Type -->
                <div class="col-md-6 col-lg-4">
                    <div class="info-card">
                        <div class="info-icon bg-warning">
                            <i class="fas fa-route"></i>
                        </div>
                        <div class="info-content">
                            <label class="info-label">Trip Type</label>
                            <p class="info-value text-capitalize">{{ $package->tripType->name }}</p>
                        </div>
                    </div>
                </div>

                <!-- From City -->
                <div class="col-md-6 col-lg-4">
                    <div class="info-card">
                        <div class="info-icon bg-success">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="info-content">
                            <label class="info-label">From City</label>
                            <p class="info-value">{{ $package->fromCity->name }}</p>
                        </div>
                    </div>
                </div>

                <!-- To City -->
                <div class="col-md-6 col-lg-4">
                    <div class="info-card">
                        <div class="info-icon bg-danger">
                            <i class="fas fa-flag-checkered"></i>
                        </div>
                        <div class="info-content">
                            <label class="info-label">To City</label>
                            <p class="info-value">{{ $package->toCity->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Airport Information (if applicable) -->
                @if($package->tripType->name === 'airport')
                <div class="col-md-6 col-lg-4">
                    <div class="info-card">
                        <div class="info-icon bg-secondary">
                            <i class="fas fa-plane"></i>
                        </div>
                        <div class="info-content">
                            <label class="info-label">Airport Type</label>
                            <p class="info-value text-capitalize">{{ $package->airport_type ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="info-card">
                        <div class="info-icon bg-dark">
                            <i class="fas fa-plane-departure"></i>
                        </div>
                        <div class="info-content">
                            <label class="info-label">Airport</label>
                            <p class="info-value">{{ $package->airport ? $package->airport->name : 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Pricing Information Section -->
            <div class="row g-4 mb-5">
                <div class="col-12">
                    <h6 class="section-title text-primary mb-3">
                        <i class="fas fa-money-bill-wave me-2"></i>Pricing Information
                    </h6>
                </div>

                

                <!-- Price per KM -->
                <div class="col-md-6 col-lg-3">
                    <div class="pricing-card">
                        <div class="pricing-icon bg-success bg-opacity-10 text-success">
                            <i class="fas fa-road"></i>
                        </div>
                        <div class="pricing-content">
                            <label class="pricing-label">Price per KM</label>
                            <p class="pricing-value">₹{{ number_format($package->price_per_km, 2) }}</p>
                            <small class="text-muted">Per kilometer rate</small>
                        </div>
                    </div>
                </div>

                <!-- Extra Price per KM -->
                <div class="col-md-6 col-lg-3">
                    <div class="pricing-card">
                        <div class="pricing-icon bg-warning bg-opacity-10 text-warning">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                        <div class="pricing-content">
                            <label class="pricing-label">Extra Price per KM</label>
                            <p class="pricing-value">₹{{ number_format($package->extra_price_per_km, 2) }}</p>
                            <small class="text-muted">Additional KM rate</small>
                        </div>
                    </div>
                </div>

                <!-- GST -->
                <div class="col-md-6 col-lg-3">
                    <div class="pricing-card">
                        <div class="pricing-icon bg-info bg-opacity-10 text-info">
                            <i class="fas fa-percentage"></i>
                        </div>
                        <div class="pricing-content">
                            <label class="pricing-label">GST</label>
                            <p class="pricing-value">{{ $package->gst }}%</p>
                            <small class="text-muted">Tax percentage</small>
                        </div>
                    </div>
                </div>

                <!-- DA & Toll Tax -->
                <div class="col-md-6 col-lg-3">
                    <div class="pricing-card">
                        <div class="pricing-icon bg-secondary bg-opacity-10 text-secondary">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div class="pricing-content">
                            <label class="pricing-label">Driver Allowance</label>
                            <p class="pricing-value">₹{{ number_format($package->da ?? 0, 2) }}</p>
                            <small class="text-muted">Daily allowance</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="pricing-card">
                        <div class="pricing-icon bg-dark bg-opacity-10 text-dark">
                            <i class="fas fa-toll"></i>
                        </div>
                        <div class="pricing-content">
                            <label class="pricing-label">Toll Tax</label>
                            <p class="pricing-value">₹{{ number_format($package->toll_tax ?? 0, 2) }}</p>
                            <small class="text-muted">Toll charges</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Local Package Pricing Slabs -->
            <!-- Local Package Details -->
@if(strtolower($package->tripType->name) == 'local')
<div class="row">
    <div class="col-12">
        <div class="section-header">
            <h6 class="section-title text-primary mb-3">
                <i class="fas fa-clock me-2"></i>Local Package Details
            </h6>
            <p class="text-muted">Includes total hours, kilometers, and fixed price for this local trip package</p>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="120"><i class="fas fa-clock me-1 text-warning"></i> Hours</th>
                        <th width="140"><i class="fas fa-tachometer-alt me-1 text-info"></i> Kilometers</th>
                    
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><span class="fw-semibold">{{ $package->hours ?? 'N/A' }}</span></td>
                        <td><span class="text-info">{{ $package->kms ?? 'N/A' }}</span></td>
                        <!-- <td><span class="fw-bold text-success">₹{{ number_format($package->base_price ?? 0, 2) }}</span></td> -->
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

        </div>

        <!-- Card Footer -->
        <div class="card-footer bg-light py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    <small>
                        <i class="fas fa-calendar me-1"></i>
                        Created: {{ $package->created_at->format('M d, Y') }}
                        @if($package->updated_at->gt($package->created_at))
                        • Updated: {{ $package->updated_at->format('M d, Y') }}
                        @endif
                    </small>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('packages.edit', $package) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Edit Package
                    </a>
                    <form action="{{ route('packages.destroy', $package) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                            <i class="fas fa-trash me-2"></i>Delete Package
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%) !important;
    }
    
    .avatar-lg {
        width: 60px;
        height: 60px;
    }
    
    .section-title {
        font-weight: 600;
        font-size: 1.1rem;
        border-bottom: 2px solid var(--primary);
        padding-bottom: 0.5rem;
    }
    
    .info-card {
        display: flex;
        align-items: center;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 0.75rem;
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }
    
    .info-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .info-icon {
        width: 50px;
        height: 50px;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        color: white;
        font-size: 1.25rem;
    }
    
    .info-label {
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 0.25rem;
        font-weight: 500;
    }
    
    .info-value {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0;
    }
    
    .pricing-card {
        text-align: center;
        padding: 1.5rem 1rem;
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 0.75rem;
        transition: all 0.3s ease;
    }
    
    .pricing-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    }
    
    .pricing-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.5rem;
    }
    
    .pricing-label {
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }
    
    .pricing-value {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .section-header {
        border-bottom: 1px solid #e9ecef;
        padding-bottom: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .table th {
        font-weight: 600;
        border-bottom: 2px solid var(--border-color);
    }
</style>
@endpush

@push('scripts')
<script>
function confirmDelete() {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this! This will delete the package and all associated pricing details.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            event.target.closest('form').submit();
        }
    });
}

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endpush