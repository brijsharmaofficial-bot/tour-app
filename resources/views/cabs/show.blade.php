@extends('layouts.app')

@section('title', $cab->cab_name . ' - Cab Details')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('cabs.index') }}" class="text-decoration-none">Cabs</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $cab->cab_name }}</li>
                </ol>
            </nav>
            <h4 class="fw-bold mb-1">Cab Details</h4>
            <p class="text-muted mb-0">Complete information about {{ $cab->cab_name }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('cabs.edit', $cab) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Edit Cab
            </a>
            <a href="{{ route('cabs.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Cab Information Card -->
        <div class="col-xl-6 col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <h5 class="card-title mb-0 d-flex align-items-center">
                        <i class="fas fa-car me-2"></i>
                        Cab Information
                    </h5>
                </div>
                <div class="card-body p-4">
                    <!-- Cab Header -->
                    <div class="d-flex align-items-center mb-4">
                        <div class="cab-icon-container bg-primary bg-opacity-10 rounded-circle me-3">
                            <i class="fas fa-car text-primary fs-2"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h4 class="fw-bold mb-1">{{ $cab->cab_name }}</h4>
                            <span class="badge status-badge bg-{{ $cab->status === 'active' ? 'success' : 'secondary' }} fs-6">
                                <i class="fas fa-circle me-1 fs-6"></i>
                                {{ ucfirst($cab->status) }}
                            </span>
                        </div>
                    </div>

                    <!-- Cab Details Grid -->
                    <div class="row g-3">
                        <!-- Cab Number -->
                        <div class="col-md-6">
                            <div class="detail-card">
                                <div class="detail-icon bg-primary">
                                    <i class="fas fa-hashtag"></i>
                                </div>
                                <div class="detail-content">
                                    <label class="detail-label">Cab Number</label>
                                    <p class="detail-value">{{ $cab->cab_number ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Registration Number -->
                        <div class="col-md-6">
                            <div class="detail-card">
                                <div class="detail-icon bg-info">
                                    <i class="fas fa-id-card"></i>
                                </div>
                                <div class="detail-content">
                                    <label class="detail-label">Registration No</label>
                                    <p class="detail-value">{{ $cab->registration_no ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Vendor -->
                        <div class="col-md-6">
                            <div class="detail-card">
                                <div class="detail-icon bg-success">
                                    <i class="fas fa-building"></i>
                                </div>
                                <div class="detail-content">
                                    <label class="detail-label">Vendor</label>
                                    <p class="detail-value">
                                        @if($cab->vendor)
                                            <a href="{{ route('vendors.show', $cab->vendor) }}" class="text-decoration-none">
                                                {{ $cab->vendor->name }}
                                            </a>
                                        @else
                                            Not Assigned
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Cab Type -->
                        <div class="col-md-6">
                            <div class="detail-card">
                                <div class="detail-icon bg-warning">
                                    <i class="fas fa-car-side"></i>
                                </div>
                                <div class="detail-content">
                                    <label class="detail-label">Cab Type</label>
                                    <p class="detail-value text-capitalize">{{ $cab->cab_type ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Seating Capacity -->
                        <div class="col-md-6">
                            <div class="detail-card">
                                <div class="detail-icon bg-secondary">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="detail-content">
                                    <label class="detail-label">Seating Capacity</label>
                                    <p class="detail-value">
                                        <span class="badge bg-primary bg-opacity-10 text-primary fs-6">
                                            {{ $cab->capacity ?? 'N/A' }} seats
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Rate per KM -->
                        <div class="col-md-6">
                            <div class="detail-card">
                                <div class="detail-icon bg-danger">
                                    <i class="fas fa-indian-rupee-sign"></i>
                                </div>
                                <div class="detail-content">
                                    <label class="detail-label">Rate per KM</label>
                                    <p class="detail-value text-success fw-bold fs-5">
                                        ₹{{ number_format($cab->rate_per_km, 2) }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Fuel Type -->
                        @if($cab->fuel_type)
                        <div class="col-md-6">
                            <div class="detail-card">
                                <div class="detail-icon bg-dark">
                                    <i class="fas fa-gas-pump"></i>
                                </div>
                                <div class="detail-content">
                                    <label class="detail-label">Fuel Type</label>
                                    <p class="detail-value text-capitalize">{{ $cab->fuel_type }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Model Year -->
                        @if($cab->model_year)
                        <div class="col-md-6">
                            <div class="detail-card">
                                <div class="detail-icon bg-info">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="detail-content">
                                    <label class="detail-label">Model Year</label>
                                    <p class="detail-value">{{ $cab->model_year }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Information & Stats -->
        <div class="col-xl-6 col-lg-4">
            <!-- Quick Stats -->
            <div class="row mb-4">
                <div class="col-12 mb-3">
                    <div class="card stat-card bg-primary bg-opacity-10 border-0 h-100">
                        <div class="card-body text-center">
                            <div class="stat-icon-lg bg-primary text-white rounded-circle mx-auto mb-3">
                                <i class="fas fa-road"></i>
                            </div>
                            <h3 class="stat-value text-primary mb-1">0</h3>
                            <p class="stat-label text-muted mb-0">Total Trips</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <div class="card stat-card bg-success bg-opacity-10 border-0 h-100">
                        <div class="card-body text-center">
                            <div class="stat-icon-lg bg-success text-white rounded-circle mx-auto mb-3">
                                <i class="fas fa-clock"></i>
                            </div>
                            <h3 class="stat-value text-success mb-1">{{ $cab->status === 'active' ? 'Online' : 'Offline' }}</h3>
                            <p class="stat-label text-muted mb-0">Current Status</p>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card stat-card bg-info bg-opacity-10 border-0 h-100">
                        <div class="card-body text-center">
                            <div class="stat-icon-lg bg-info text-white rounded-circle mx-auto mb-3">
                                <i class="fas fa-star"></i>
                            </div>
                            <h3 class="stat-value text-info mb-1">4.5</h3>
                            <p class="stat-label text-muted mb-0">Average Rating</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-cogs me-2 text-primary"></i>
                        Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('cabs.edit', $cab) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit Cab Details
                        </a>
                        @if($cab->vendor)
                        <a href="{{ route('vendors.show', $cab->vendor) }}" class="btn btn-outline-primary">
                            <i class="fas fa-building me-2"></i>View Vendor
                        </a>
                        @endif
                        <button class="btn btn-outline-info">
                            <i class="fas fa-history me-2"></i>View Trip History
                        </button>
                        <form action="{{ route('cabs.destroy', $cab) }}" method="POST" class="d-grid">
                            @csrf 
                            @method('DELETE')
                            <button type="button" class="btn btn-outline-danger" onclick="confirmDelete()">
                                <i class="fas fa-trash me-2"></i>Delete Cab
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Packages Section -->
    @if($cab->packages && $cab->packages->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-box me-2 text-primary"></i>
                            Associated Packages
                            <span class="badge bg-primary ms-2">{{ $cab->packages->count() }}</span>
                        </h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="60">#</th>
                                    <th>Package Details</th>
                                    <th>Trip Type</th>
                                    <th>Route</th>
                                    <th>Base Price</th>
                                    <th width="100">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cab->packages as $index => $package)
                                <tr>
                                    <td>
                                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-circle p-2">
                                            {{ $index + 1 }}
                                        </span>
                                    </td>
                                    <td>
                                        <h6 class="mb-1">{{ $package->vendor->name ?? 'N/A' }}</h6>
                                        <small class="text-muted">Package #{{ $package->id }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-info bg-opacity-10 text-info text-capitalize">
                                            {{ $package->tripType->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $package->fromCity->name ?? 'N/A' }} 
                                            @if($package->toCity) → {{ $package->toCity->name }} @endif
                                        </small>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-success">₹{{ number_format($package->base_price, 2) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $package->status == 'active' ? 'success' : 'secondary' }}">
                                            <i class="fas fa-circle me-1 fs-6"></i>
                                            {{ ucfirst($package->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Timeline Footer -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            <small>
                                <i class="fas fa-calendar me-1"></i>
                                Added on {{ $cab->created_at->format('M d, Y') }}
                                @if($cab->updated_at->gt($cab->created_at))
                                • Last updated {{ $cab->updated_at->format('M d, Y') }}
                                @endif
                            </small>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('cabs.edit', $cab) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                            <form action="{{ route('cabs.destroy', $cab) }}" method="POST" class="d-inline">
                                @csrf 
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete()">
                                    <i class="fas fa-trash me-2"></i>Delete
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
    
    .cab-icon-container {
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .status-badge {
        font-size: 0.875rem;
        font-weight: 500;
        padding: 0.5rem 1rem;
    }
    
    .detail-card {
        display: flex;
        align-items: center;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 0.75rem;
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .detail-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .detail-icon {
        width: 50px;
        height: 50px;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        color: white;
        font-size: 1.25rem;
        flex-shrink: 0;
    }
    
    .detail-label {
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 0.25rem;
        font-weight: 500;
    }
    
    .detail-value {
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
        font-size: 1.5rem;
    }
    
    .stat-label {
        font-size: 0.875rem;
        font-weight: 500;
    }
    
    .table th {
        font-weight: 600;
        border-bottom: 2px solid var(--border-color);
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
        title: 'Delete Cab?',
        html: `You are about to delete <strong>{{ $cab->cab_name }}</strong>. This action cannot be undone.`,
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