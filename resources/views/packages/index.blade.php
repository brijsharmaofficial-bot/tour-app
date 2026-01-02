@extends('layouts.app')

@section('title', 'Packages Management')

@section('content')
<div class="container-fluid py-4">

    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Packages Management</h4>
            <p class="text-muted mb-0">Manage all your cab, route, and trip packages efficiently</p>
        </div>
        <a href="{{ route('packages.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i> Add New Package
        </a>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="fas fa-check-circle me-2 fs-5"></i>
            <div class="flex-grow-1">{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="fas fa-exclamation-circle me-2 fs-5"></i>
            <div class="flex-grow-1">{{ session('error') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

        <!-- Stats Cards -->
        <div class="row mb-4">
        <div class="col-xl-2 col-md-4 col-6 mb-3">
            <div class="card stat-card bg-primary bg-opacity-10 border-0">
                <div class="card-body text-center">
                    <div class="stat-icon-lg bg-primary text-white rounded-circle mx-auto mb-3">
                        <i class="fas fa-box fs-5"></i>
                    </div>
                    <h3 class="stat-value text-primary mb-1">{{ $packages->count() }}</h3>
                    <p class="stat-label text-muted mb-0">Total Packages</p>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6 mb-3">
            <div class="card stat-card bg-success bg-opacity-10 border-0">
                <div class="card-body text-center">
                    <div class="stat-icon-lg bg-success text-white rounded-circle mx-auto mb-3">
                        <i class="fas fa-check-circle fs-5"></i>
                    </div>
                    <h3 class="stat-value text-success mb-1">{{ $packages->where('status', 'active')->count() }}</h3>
                    <p class="stat-label text-muted mb-0">Active</p>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6 mb-3">
            <div class="card stat-card bg-warning bg-opacity-10 border-0">
                <div class="card-body text-center">
                    <div class="stat-icon-lg bg-warning text-white rounded-circle mx-auto mb-3">
                        <i class="fas fa-pause-circle fs-5"></i>
                    </div>
                    <h3 class="stat-value text-warning mb-1">{{ $packages->where('status', 'inactive')->count() }}</h3>
                    <p class="stat-label text-muted mb-0">Inactive</p>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6 mb-3">
            <div class="card stat-card bg-info bg-opacity-10 border-0">
                <div class="card-body text-center">
                    <div class="stat-icon-lg bg-info text-white rounded-circle mx-auto mb-3">
                        <i class="fas fa-car fs-5"></i>
                    </div>
                    <h3 class="stat-value text-info mb-1">{{ $packages->pluck('cab_id')->unique()->count() }}</h3>
                    <p class="stat-label text-muted mb-0">Cab Types</p>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6 mb-3">
            <div class="card stat-card bg-secondary bg-opacity-10 border-0">
                <div class="card-body text-center">
                    <div class="stat-icon-lg bg-secondary text-white rounded-circle mx-auto mb-3">
                        <i class="fas fa-route fs-5"></i>
                    </div>
                    <h3 class="stat-value text-secondary mb-1">{{ $packages->pluck('trip_type_id')->unique()->count() }}</h3>
                    <p class="stat-label text-muted mb-0">Trip Types</p>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6 mb-3">
            <div class="card stat-card bg-dark bg-opacity-10 border-0">
                <div class="card-body text-center">
                    <div class="stat-icon-lg bg-dark text-white rounded-circle mx-auto mb-3">
                        <i class="fas fa-building fs-5"></i>
                    </div>
                    <h3 class="stat-value text-dark mb-1">{{ $packages->pluck('vendor_id')->unique()->count() }}</h3>
                    <p class="stat-label text-muted mb-0">Vendors</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Controls -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body py-3">
            <div class="row g-3 align-items-center">
                <div class="col-md-8">
                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-outline-primary filter-btn active" data-status="">All</button>
                        <button class="btn btn-outline-success filter-btn" data-status="active">Active</button>
                        <button class="btn btn-outline-secondary filter-btn" data-status="inactive">Inactive</button>
                        <button class="btn btn-outline-info filter-btn" data-trip="local">Local</button>
                        <button class="btn btn-outline-warning filter-btn" data-trip="airport">Airport</button>
                        <button class="btn btn-outline-primary filter-btn" data-trip="oneway">Oneway</button>
                        <button class="btn btn-outline-primary filter-btn" data-trip="roundtrip">Round Trip</button>

                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-calendar text-muted"></i>
                        </span>
                        <input type="date" class="form-control" id="dateFilter">
                        <button class="btn btn-outline-secondary" type="button" id="clearDateFilter">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Packages Table -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                <i class="fas fa-box me-2 text-primary"></i> All Packages
            </h5>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-secondary btn-sm" id="refreshTable">
                    <i class="fas fa-sync-alt me-1"></i> Refresh
                </button>
                <button class="btn btn-outline-primary btn-sm" id="exportBtn">
                    <i class="fas fa-download me-1"></i> Export
                </button>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="packagesTable" class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Vendor</th>
                            <th>Cab</th>
                            <th>Trip Type</th>
                            <th>Route</th>
                            <th>Status</th>
                            <th class="text-center">Created At</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($packages as $pkg)
                        @php
                            $tripType = strtolower($pkg->tripType->name ?? '');
                            $statusColor = $pkg->status === 'active' ? 'success' : 'secondary';
                        @endphp
                        <tr data-status="{{ strtolower($pkg->status) }}" data-trip="{{ $tripType }}" data-date="{{ $pkg->created_at->format('Y-m-d') }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pkg->vendor->name ?? 'N/A' }}</td>
                            <td>{{ $pkg->cab->cab_name ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-{{ $tripType === 'local' ? 'info' : ($tripType === 'airport' ? 'warning' : 'primary') }}">
                                    {{ ucfirst($pkg->tripType->name ?? 'N/A') }}
                                </span>
                            </td>
                            <td>
                                {{ $pkg->fromCity->name ?? 'N/A' }} →
                                {{ $pkg->toCity->name ?? 'N/A' }}
                            </td>
                           
                            <td>
                                <span class="badge bg-{{ $statusColor }}">{{ ucfirst($pkg->status) }}</span>
                            </td>
                            <td class="text-center">{{ $pkg->created_at->format('d M, Y') }}</td>
                            <td class="text-center">
                                <a href="{{ route('packages.show', $pkg) }}" class="btn btn-sm btn-info text-white" title="View"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('packages.edit', $pkg) }}" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('packages.destroy', $pkg) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger delete-btn" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
    .stat-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    
    .stat-icon-lg {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .stat-label {
        font-size: 0.875rem;
        font-weight: 500;
    }
    
    .stat-value {
        font-weight: 700;
        color: var(--text-dark);
        font-size: 1.5rem;
    }
    
    .vendor-avatar {
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .vendor-name {
        font-weight: 600;
        color: var(--text-dark);
    }
    
    .cab-name {
        font-weight: 600;
        color: var(--text-dark);
    }
    
    .trip-type-badge {
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .status-badge {
        font-size: 0.75rem;
        font-weight: 500;
        padding: 0.35rem 0.75rem;
    }
    
    .table th {
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid var(--border-color);
        padding: 0.6rem 0.75rem;
    }
    
    .table td {
        vertical-align: middle;
        padding: 0.5rem 0.5rem;
    }
    
    .btn-sm {
        padding: 0.375rem 0.5rem;
        border-radius: 0.375rem;
    }
    
    .filter-btn.active {
        background-color: var(--primary);
        color: white;
        border-color: var(--primary);
    }
    
    .base-price {
        font-size: 1.1rem;
    }
    
    .per-km {
        font-size: 0.875rem;
    }
    
    .status-container {
        text-align: center;
    }
    
    .form-check-input:checked {
        background-color: var(--success);
        border-color: var(--success);
    }
    
    .form-check-input {
        width: 2.5em;
        height: 1.25em;
    }
    
    /* DataTables custom styling */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        padding: 1rem 1.25rem 0.5rem;
    }
    
    .dataTables_wrapper .dataTables_info {
        padding: 0.5rem 1.25rem;
    }
    
    .dataTables_wrapper .dataTables_paginate {
        padding: 0.5rem 1.25rem 1rem;
    }
    
    /* Card header styling */
    .card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    
    /* Hover effects */
    #packagesTable tbody tr {
        transition: all 0.3s ease;
    }
    
    #packagesTable tbody tr:hover {
        background-color: rgba(var(--primary-rgb), 0.05);
        transform: translateY(-1px);
    }
    .filter-btn.active {
    background-color: var(--bs-primary);
    color: white;
}
/* .table th { font-size: 0.875rem; text-transform: uppercase; } */
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {
    // ✅ Initialize DataTable
    const table = $('#packagesTable').DataTable({
        destroy: true,
        order: [[0, 'asc']],
        responsive: true
    });

    // ✅ STATUS/TRIP FILTER
    $('.filter-btn').on('click', function() {
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');

        const status = $(this).data('status');
        const trip = $(this).data('trip');

        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            const row = table.row(dataIndex).node();
            const rowStatus = $(row).data('status');
            const rowTrip = $(row).data('trip');

            const statusMatch = !status || rowStatus === status;
            const tripMatch = !trip || rowTrip === trip;
            return statusMatch && tripMatch;
        });

        table.draw();
        $.fn.dataTable.ext.search.pop();
    });

    // ✅ DATE FILTER
    $('#dateFilter').on('change', function() {
        const date = $(this).val();
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            const rowDate = $(table.row(dataIndex).node()).data('date');
            return !date || rowDate === date;
        });
        table.draw();
        $.fn.dataTable.ext.search.pop();
    });

    $('#clearDateFilter').on('click', function() {
        $('#dateFilter').val('');
        table.search('').draw();
    });

    // ✅ REFRESH BUTTON
    $('#refreshTable').on('click', function() {
        const icon = $(this).find('i');
        icon.addClass('fa-spin');
        setTimeout(() => {
            location.reload();
        }, 800);
    });

    // ✅ EXPORT PLACEHOLDER
    $('#exportBtn').on('click', function() {
        Swal.fire({
            title: 'Export Coming Soon!',
            text: 'Export to Excel, CSV, and PDF will be available soon.',
            icon: 'info',
            confirmButtonText: 'OK'
        });
    });

    // ✅ DELETE CONFIRMATION
    $(document).on('click', '.delete-btn', function() {
        const form = $(this).closest('form');
        Swal.fire({
            title: 'Delete Package?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    // ✅ Bootstrap tooltips
    $('[title]').tooltip();
});
</script>
@endpush
