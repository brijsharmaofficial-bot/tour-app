@extends('layouts.app')

@section('title', 'Vendors Management')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Vendors Management</h4>
            <p class="text-muted mb-0">Manage all your vendor partners and their information</p>
        </div>
        <a href="{{ route('vendors.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i>Add New Vendor
        </a>
    </div>

    <!-- Alert Messages -->
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
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card bg-primary bg-opacity-10 border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-primary text-white rounded-circle me-3">
                            <i class="fas fa-building fs-5"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="stat-label text-muted mb-1">Total Vendors</h6>
                            <h4 class="stat-value mb-0">{{ $vendors->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card bg-success bg-opacity-10 border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-success text-white rounded-circle me-3">
                            <i class="fas fa-check-circle fs-5"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="stat-label text-muted mb-1">Active Vendors</h6>
                            <h4 class="stat-value mb-0">{{ $vendors->where('status', 'active')->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card bg-warning bg-opacity-10 border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-warning text-white rounded-circle me-3">
                            <i class="fas fa-pause-circle fs-5"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="stat-label text-muted mb-1">Inactive Vendors</h6>
                            <h4 class="stat-value mb-0">{{ $vendors->where('status', 'inactive')->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card bg-info bg-opacity-10 border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-info text-white rounded-circle me-3">
                            <i class="fas fa-map-marker-alt fs-5"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="stat-label text-muted mb-1">Cities Covered</h6>
                            <h4 class="stat-value mb-0">{{ $vendors->pluck('city')->unique()->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vendors Table Card -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-list me-2 text-primary"></i>
                    All Vendors
                </h5>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm" id="refreshTable">
                        <i class="fas fa-sync-alt me-1"></i>Refresh
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="vendorsTable" class="table table-hover align-middle mb-0" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th width="50">#</th>
                            <th width="80">Logo</th>
                            <th>Vendor Details</th>
                            <th>Contact Info</th>
                            <th>Location</th>
                            <th width="100">Status</th>
                            <th width="120" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vendors as $vendor)
                        <tr>
                            <td class="fw-semibold">{{ $loop->iteration }}</td>
                            <td>
                                <div class="vendor-logo-container">
                                    @if($vendor->logo)
                                        <img src="{{ asset('storage/'.$vendor->logo) }}" 
                                             alt="{{ $vendor->name }}" 
                                             class="vendor-logo rounded">
                                    @else
                                        <div class="vendor-logo-placeholder rounded bg-light d-flex align-items-center justify-content-center">
                                            <i class="fas fa-building text-muted fs-6"></i>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="vendor-info">
                                    <h6 class="vendor-name mb-1">{{ $vendor->name }}</h6>
                                    <small class="text-muted">Vendor ID: #{{ $vendor->id }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="contact-info">
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="fas fa-envelope text-primary me-2 fs-6"></i>
                                        <small>{{ $vendor->email }}</small>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-phone text-success me-2 fs-6"></i>
                                        <small>{{ $vendor->phone ?? 'N/A' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="location-info">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-map-marker-alt text-danger me-2 fs-6"></i>
                                        <span>{{ $vendor->city ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge status-badge bg-{{ $vendor->status === 'active' ? 'success' : 'secondary' }}">
                                    <i class="fas fa-circle me-1 fs-6"></i>
                                    {{ ucfirst($vendor->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <!-- View Button -->
                                    <a href="{{ route('vendors.show', $vendor) }}" 
                                       class="btn btn-sm btn-info text-white" 
                                       data-bs-toggle="tooltip" 
                                       title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <!-- Edit Button -->
                                    <a href="{{ route('vendors.edit', $vendor) }}" 
                                       class="btn btn-sm btn-warning" 
                                       data-bs-toggle="tooltip" 
                                       title="Edit Vendor">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('vendors.destroy', $vendor) }}" method="POST" class="d-inline">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="button" 
                                                class="btn btn-sm btn-danger delete-vendor" 
                                                data-bs-toggle="tooltip" 
                                                title="Delete Vendor"
                                                data-vendor-name="{{ $vendor->name }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
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
    
    .stat-icon {
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
    }
    
    .vendor-logo-container {
        width: 50px;
        height: 50px;
    }
    
    .vendor-logo {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border: 2px solid #e9ecef;
    }
    
    .vendor-logo-placeholder {
        width: 100%;
        height: 100%;
        border: 2px dashed #dee2e6;
    }
    
    .vendor-name {
        font-weight: 600;
        color: var(--text-dark);
    }
    
    .contact-info small,
    .location-info span {
        font-size: 0.875rem;
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
        padding: 1rem 0.75rem;
    }
    
    .table td {
        vertical-align: middle;
        padding: 1rem 0.75rem;
    }
    
    .btn-sm {
        padding: 0.375rem 0.5rem;
        border-radius: 0.375rem;
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
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTable
    const vendorsTable = $('#vendorsTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        order: [[0, 'asc']],
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search vendors...",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ vendors",
            infoEmpty: "Showing 0 to 0 of 0 vendors",
            infoFiltered: "(filtered from _MAX_ total vendors)",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            },
            emptyTable: "No vendors available",
            zeroRecords: "No matching vendors found"
        },
        columnDefs: [
            {
                targets: [0, 1, 5, 6], // Index, Logo, Status, Actions columns
                orderable: false
            },
            {
                targets: 6, // Actions column
                searchable: false
            }
        ],
        initComplete: function() {
            // Add custom class to search input
            $('.dataTables_filter input').addClass('form-control form-control-sm');
            $('.dataTables_length select').addClass('form-select form-select-sm');
            
            console.log('Vendors DataTable initialized successfully');
        },
        drawCallback: function() {
            // Initialize tooltips on each table draw
            $('[data-bs-toggle="tooltip"]').tooltip({
                trigger: 'hover',
                placement: 'top'
            });
        }
    });

    // Refresh table button
    $('#refreshTable').on('click', function() {
        vendorsTable.ajax.reload();
        $(this).find('i').addClass('fa-spin');
        setTimeout(() => {
            $(this).find('i').removeClass('fa-spin');
        }, 1000);
    });

    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Enhanced delete confirmation
    $(document).on('click', '.delete-vendor', function(e) {
        e.preventDefault();
        const form = $(this).closest('form');
        const vendorName = $(this).data('vendor-name');
        
        Swal.fire({
            title: 'Delete Vendor?',
            html: `You are about to delete <strong>${vendorName}</strong>. This action cannot be undone.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            backdrop: true,
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return new Promise((resolve) => {
                    form.submit();
                    resolve();
                });
            }
        });
    });

    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
    }, 5000);

    // Add row highlighting on hover
    $('#vendorsTable tbody').on('mouseenter', 'tr', function() {
        $(this).addClass('table-active');
    });
    
    $('#vendorsTable tbody').on('mouseleave', 'tr', function() {
        $(this).removeClass('table-active');
    });
});
</script>

<!-- SweetAlert2 for better confirmations -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush