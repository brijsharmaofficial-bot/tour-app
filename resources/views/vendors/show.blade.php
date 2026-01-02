@extends('layouts.app')

@section('title', $vendor->name . ' - Vendor Details')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('vendors.index') }}" class="text-decoration-none">Vendors</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $vendor->name }}</li>
                </ol>
            </nav>
            <h4 class="fw-bold mb-1">Vendor Details</h4>
            <p class="text-muted mb-0">Complete information about {{ $vendor->name }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('vendors.edit', $vendor) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Edit Vendor
            </a>
            <a href="{{ route('vendors.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
        </div>
    </div>

    <!-- Main Vendor Profile Card -->
    <div class="row">
        <!-- Vendor Information Card -->
        <div class="col-xl-4 col-lg-5 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <h5 class="card-title mb-0 d-flex align-items-center">
                        <i class="fas fa-building me-2"></i>
                        Vendor Profile
                    </h5>
                </div>
                <div class="card-body p-4">
                    <!-- Vendor Logo & Status -->
                    <div class="text-center mb-4">
                        <div class="vendor-logo-container mx-auto mb-3">
                            @if($vendor->logo)
                                <img src="{{ asset('storage/'.$vendor->logo) }}" 
                                     alt="{{ $vendor->name }}" 
                                     class="vendor-logo-img rounded-circle">
                            @else
                                <div class="vendor-logo-placeholder rounded-circle bg-light d-flex align-items-center justify-content-center">
                                    <i class="fas fa-building text-muted fs-1"></i>
                                </div>
                            @endif
                        </div>
                        <h4 class="fw-bold mb-2">{{ $vendor->name }}</h4>
                        <span class="badge status-badge bg-{{ $vendor->status === 'active' ? 'success' : 'secondary' }} fs-6">
                            <i class="fas fa-circle me-1 fs-6"></i>
                            {{ ucfirst($vendor->status) }}
                        </span>
                    </div>

                    <!-- Contact Information -->
                    <div class="vendor-contact-info">
                        <h6 class="section-title text-primary mb-3">
                            <i class="fas fa-address-card me-2"></i>Contact Information
                        </h6>
                        
                        <div class="contact-item mb-3">
                            <div class="contact-icon bg-primary">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-details">
                                <label class="contact-label">Email Address</label>
                                <p class="contact-value">{{ $vendor->email ?? 'Not provided' }}</p>
                            </div>
                        </div>

                        <div class="contact-item mb-3">
                            <div class="contact-icon bg-success">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="contact-details">
                                <label class="contact-label">Phone Number</label>
                                <p class="contact-value">{{ $vendor->phone ?? 'Not provided' }}</p>
                            </div>
                        </div>

                        <div class="contact-item mb-3">
                            <div class="contact-icon bg-info">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-details">
                                <label class="contact-label">City</label>
                                <p class="contact-value">{{ $vendor->city?->name ?? 'Not specified' }}</p>
                            </div>
                        </div>

                        @if($vendor->address)
                        <div class="contact-item">
                            <div class="contact-icon bg-warning">
                                <i class="fas fa-map"></i>
                            </div>
                            <div class="contact-details">
                                <label class="contact-label">Address</label>
                                <p class="contact-value">{{ $vendor->address }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics & Details Cards -->
        <div class="col-xl-8 col-lg-7">
            <!-- Quick Stats -->
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <div class="stat-card bg-primary bg-opacity-10 border-0 h-100">
                        <div class="card-body text-center">
                            <div class="stat-icon-lg bg-primary text-white rounded-circle mx-auto mb-3">
                                <i class="fas fa-car"></i>
                            </div>
                            <h3 class="stat-value text-primary mb-1">{{ $vendor->cabs->count() }}</h3>
                            <p class="stat-label text-muted mb-0">Total Cabs</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="stat-card bg-success bg-opacity-10 border-0 h-100">
                        <div class="card-body text-center">
                            <div class="stat-icon-lg bg-success text-white rounded-circle mx-auto mb-3">
                                <i class="fas fa-box"></i>
                            </div>
                            <h3 class="stat-value text-success mb-1">{{ $vendor->packages->count() }}</h3>
                            <p class="stat-label text-muted mb-0">Total Packages</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="stat-card bg-info bg-opacity-10 border-0 h-100">
                        <div class="card-body text-center">
                            <div class="stat-icon-lg bg-info text-white rounded-circle mx-auto mb-3">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h3 class="stat-value text-info mb-1">{{ $vendor->cabs->where('status', 'active')->count() }}</h3>
                            <p class="stat-label text-muted mb-0">Active Cabs</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cabs Section -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-car me-2 text-primary"></i>
                            Vendor's Cabs
                            <span class="badge bg-primary ms-2">{{ $vendor->cabs->count() }}</span>
                        </h5>
                        @if($vendor->cabs->count() > 0)
                        <a href="#" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-plus me-1"></i>Add Cab
                        </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if($vendor->cabs && $vendor->cabs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th width="60">#</th>
                                        <th>Cab Details</th>
                                        <th>Registration</th>
                                        <th>Capacity</th>
                                        <th width="100">Status</th>
                                        <th width="80" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($vendor->cabs as $index => $cab)
                                    <tr>
                                        <td>
                                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-circle p-2">
                                                {{ $index + 1 }}
                                            </span>
                                        </td>
                                        <td>
                                            <h6 class="mb-1">{{ $cab->cab_name }}</h6>
                                            <small class="text-muted text-capitalize">{{ $cab->cab_type }}</small>
                                        </td>
                                        <td>
                                            <code class="text-dark">{{ $cab->registration_no }}</code>
                                        </td>
                                        <td>
                                            <span class="badge bg-info bg-opacity-10 text-info">
                                                {{ $cab->capacity }} seats
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $cab->status == 'active' ? 'success' : 'secondary' }}">
                                                <i class="fas fa-circle me-1 fs-6"></i>
                                                {{ ucfirst($cab->status) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" title="View Cab">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="empty-state-icon mb-3">
                                <i class="fas fa-car text-muted fs-1"></i>
                            </div>
                            <h5 class="text-muted">No Cabs</h5>
                            <p class="text-muted mb-4">This vendor doesn't have any cabs yet.</p>
                            <a href="#" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Add First Cab
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Packages Section -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-box me-2 text-primary"></i>
                            Related Packages
                            <span class="badge bg-primary ms-2">{{ $vendor->packages->count() }}</span>
                        </h5>
                        @if($vendor->packages->count() > 0)
                        <a href="{{ route('packages.create') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-plus me-1"></i>Create Package
                        </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if($vendor->packages && $vendor->packages->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th width="60">#</th>
                                        <th>Trip Details</th>
                                        <th>Pricing</th>
                                        <th width="100">Status</th>
                                        <th width="80" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($vendor->packages as $index => $pkg)
                                    <tr>
                                        <td>
                                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-circle p-2">
                                                {{ $index + 1 }}
                                            </span>
                                        </td>
                                        <td>
                                            <h6 class="mb-1 text-capitalize">{{ $pkg->tripType->name }} Trip</h6>
                                            <small class="text-muted">
                                                {{ $pkg->fromCity->name ?? 'N/A' }} 
                                                @if($pkg->toCity) → {{ $pkg->toCity->name }} @endif
                                            </small>
                                        </td>
                                        <td>
                                            <div class="pricing-info">
                                                <div class="base-price fw-bold text-success">₹{{ number_format($pkg->base_price, 2) }}</div>
                                                <small class="text-muted">₹{{ number_format($pkg->price_per_km, 2) }}/km</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $pkg->status == 'active' ? 'success' : 'secondary' }}">
                                                <i class="fas fa-circle me-1 fs-6"></i>
                                                {{ ucfirst($pkg->status) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('packages.show', $pkg) }}" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" title="View Package">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="empty-state-icon mb-3">
                                <i class="fas fa-box text-muted fs-1"></i>
                            </div>
                            <h5 class="text-muted">No Packages Created</h5>
                            <p class="text-muted mb-4">This vendor doesn't have any packages created yet.</p>
                            <a href="{{ route('packages.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Create First Package
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            <small>
                                <i class="fas fa-calendar me-1"></i>
                                Vendor since {{ $vendor->created_at->format('M d, Y') }}
                                @if($vendor->updated_at->gt($vendor->created_at))
                                • Last updated {{ $vendor->updated_at->format('M d, Y') }}
                                @endif
                            </small>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('vendors.edit', $vendor) }}" class="btn btn-warning">
                                <i class="fas fa-edit me-2"></i>Edit Vendor
                            </a>
                            <form action="{{ route('vendors.destroy', $vendor) }}" method="POST" class="d-inline">
                                @csrf 
                                @method('DELETE')
                                <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                                    <i class="fas fa-trash me-2"></i>Delete Vendor
                                </button>
                            </form>
                        </div>
                    </div>
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
    
    .vendor-logo-container {
        width: 120px;
        height: 120px;
        margin: 0 auto;
    }
    
    .vendor-logo-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border: 4px solid #fff;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .vendor-logo-placeholder {
        width: 100%;
        height: 100%;
        border: 4px solid #e9ecef;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .status-badge {
        font-size: 0.875rem;
        font-weight: 500;
        padding: 0.5rem 1rem;
    }
    
    .section-title {
        font-weight: 600;
        font-size: 1rem;
        border-bottom: 2px solid var(--primary);
        padding-bottom: 0.5rem;
        margin-bottom: 1rem;
    }
    
    .contact-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 1rem;
    }
    
    .contact-icon {
        width: 40px;
        height: 40px;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        color: white;
        font-size: 1rem;
        flex-shrink: 0;
    }
    
    .contact-label {
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 0.25rem;
        font-weight: 500;
    }
    
    .contact-value {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0;
    }
    
    .stat-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    }
    
    .stat-icon-lg {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .stat-value {
        font-weight: 700;
        font-size: 2rem;
    }
    
    .stat-label {
        font-size: 0.875rem;
        font-weight: 500;
    }
    
    .table th {
        font-weight: 600;
        border-bottom: 2px solid var(--border-color);
    }
    
    .empty-state-icon {
        opacity: 0.5;
    }
    
    .pricing-info .base-price {
        font-size: 1.1rem;
    }
    
    .card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    
    .breadcrumb {
        background: transparent;
        padding: 0;
        margin-bottom: 0.5rem;
    }
</style>
@endpush

@push('scripts')
<script>
function confirmDelete() {
    Swal.fire({
        title: 'Delete Vendor?',
        html: `You are about to delete <strong>{{ $vendor->name }}</strong>. This will also remove all associated cabs and packages. This action cannot be undone.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        backdrop: true
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

<!-- SweetAlert2 for better confirmations -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush