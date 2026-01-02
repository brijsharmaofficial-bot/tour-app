@extends('layouts.app')

@section('title', 'Bookings Management')

@section('content')
<div class="container-fluid py-4">

    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Bookings Management</h4>
            <p class="text-muted mb-0">Manage all customer bookings and assignments</p>
        </div>
        <a href="{{ route('bookings.create') }}" class="btn btn-primary d-none">
            <i class="fas fa-plus-circle me-2"></i> Create New Booking
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
        <div class="col-xl-2 col-md-4 col-6 mb-3">
            <div class="card stat-card bg-primary bg-opacity-10 border-0">
                <div class="card-body text-center">
                    <div class="stat-icon-lg bg-primary text-white rounded-circle mx-auto mb-3">
                        <i class="fas fa-list-alt fs-5"></i>
                    </div>
                    <h3 class="stat-value text-primary mb-1">{{ $bookings->count() }}</h3>
                    <p class="stat-label text-muted mb-0">Total Bookings</p>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6 mb-3">
            <div class="card stat-card bg-warning bg-opacity-10 border-0">
                <div class="card-body text-center">
                    <div class="stat-icon-lg bg-warning text-white rounded-circle mx-auto mb-3">
                        <i class="fas fa-clock fs-5"></i>
                    </div>
                    <h3 class="stat-value text-warning mb-1">{{ $bookings->where('status', 'pending')->count() }}</h3>
                    <p class="stat-label text-muted mb-0">Pending</p>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6 mb-3">
            <div class="card stat-card bg-info bg-opacity-10 border-0">
                <div class="card-body text-center">
                    <div class="stat-icon-lg bg-info text-white rounded-circle mx-auto mb-3">
                        <i class="fas fa-car fs-5"></i>
                    </div>
                    <h3 class="stat-value text-info mb-1">{{ $bookings->where('status', 'assigned')->count() }}</h3>
                    <p class="stat-label text-muted mb-0">Assigned</p>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6 mb-3">
            <div class="card stat-card bg-success bg-opacity-10 border-0">
                <div class="card-body text-center">
                    <div class="stat-icon-lg bg-success text-white rounded-circle mx-auto mb-3">
                        <i class="fas fa-check-circle fs-5"></i>
                    </div>
                    <h3 class="stat-value text-success mb-1">{{ $bookings->where('status', 'completed')->count() }}</h3>
                    <p class="stat-label text-muted mb-0">Completed</p>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6 mb-3">
            <div class="card stat-card bg-danger bg-opacity-10 border-0">
                <div class="card-body text-center">
                    <div class="stat-icon-lg bg-danger text-white rounded-circle mx-auto mb-3">
                        <i class="fas fa-times-circle fs-5"></i>
                    </div>
                    <h3 class="stat-value text-danger mb-1">{{ $bookings->where('status', 'cancelled')->count() }}</h3>
                    <p class="stat-label text-muted mb-0">Cancelled</p>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6 mb-3">
            <div class="card stat-card bg-secondary bg-opacity-10 border-0">
                <div class="card-body text-center">
                    <div class="stat-icon-lg bg-secondary text-white rounded-circle mx-auto mb-3">
                        <i class="fas fa-money-bill-wave fs-5"></i>
                    </div>
                    <h3 class="stat-value text-secondary mb-1">{{ $bookings->where('payment_status', 'paid')->count() }}</h3>
                    <p class="stat-label text-muted mb-0">Paid</p>
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
                        <button class="btn btn-outline-warning filter-btn" data-status="pending">Pending</button>
                        <button class="btn btn-outline-info filter-btn" data-status="assigned">Assigned</button>
                        <button class="btn btn-outline-success filter-btn" data-status="completed">Completed</button>
                        <button class="btn btn-outline-danger filter-btn" data-status="cancelled">Cancelled</button>
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

    <!-- Bookings Table -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                <i class="fas fa-list me-2 text-primary"></i> All Bookings
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
                <table id="bookingsTable" class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Booking</th>
                            <th>Customer</th>
                            <th>Route</th>
                            <th>Date & Time</th>
                            <th>Vendor</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                        <tr data-status="{{ $booking->status }}" data-date="{{ $booking->pickup_date }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>#BK{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</strong><br>
                                <small class="text-muted">{{ $booking->created_at->format('d M, Y') }}</small>
                            </td>
                            <td>
                                <strong>{{ $booking->user->name ?? 'Guest' }}</strong><br>
                                <small class="text-muted">{{ $booking->user->email ?? 'N/A' }}</small>
                            </td>
                            <td>
                                <small><i class="fas fa-map-marker-alt text-danger"></i> {{ $booking->fromCity->name ?? 'N/A' }}</small><br>
                                <small><i class="fas fa-flag-checkered text-success"></i> {{ $booking->toCity->name ?? 'N/A' }}</small>
                            </td>
                            <td>
                                <strong>{{ $booking->pickup_date }}</strong><br>
                                <small>{{ $booking->pickup_time }}</small>
                            </td>
                            <td>
                                @if($booking->vendor)
                                    <div class="d-flex align-items-center">
                                        <div class="vendor-avatar bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 12px;">
                                            {{ substr($booking->vendor->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <strong class="d-block">{{ $booking->vendor->name }}</strong>
                                            <small class="text-muted">{{ $booking->vendor->phone ?? 'No Phone' }}</small>
                                        </div>
                                    </div>
                                @else
                                    <span class="badge bg-light text-muted">Not Assigned</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ [
                                    'pending' => 'warning',
                                    'assigned' => 'info',
                                    'completed' => 'success',
                                    'cancelled' => 'danger'
                                ][$booking->status] ?? 'secondary' }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $booking->payment_status == 'paid' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($booking->payment_status) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('bookings.show', $booking) }}" class="btn btn-sm btn-info text-white" data-bs-toggle="tooltip" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <!-- <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a> -->
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

.table th { 
    font-size: 0.875rem; 
    text-transform: uppercase; 
}

.filter-btn.active { 
    background-color: var(--bs-primary); 
    color: white; 
}

.dataTables_filter input { 
    width: 200px !important; 
}

.vendor-avatar {
    font-weight: bold;
}

/* Vendor column specific styling */
td:nth-child(6) {
    min-width: 180px;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {

    // ✅ Initialize DataTable first
    const table = $('#bookingsTable').DataTable({
        destroy: true, // ✅ allows reinitialization
        order: [[0, 'desc']],
        responsive: true,
        columnDefs: [
            { responsivePriority: 1, targets: 1 }, // Booking ID
            { responsivePriority: 2, targets: 2 }, // Customer
            { responsivePriority: 3, targets: 8 }, // Actions
            { responsivePriority: 4, targets: 3 }, // Route
            { responsivePriority: 5, targets: 6 }, // Status
            { responsivePriority: 6, targets: 7 }, // Payment
            { responsivePriority: 7, targets: 5 }, // Vendor
            { responsivePriority: 8, targets: 4 }, // Date & Time
            { responsivePriority: 9, targets: 0 }  // #
        ]
    });

    // ✅ STATUS FILTER — working for all + case-insensitive
    $('.filter-btn').on('click', function() {
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');

        const status = $(this).data('status').toLowerCase();

        // Clear any previous filters before applying a new one
        $.fn.dataTable.ext.search = [];

        if (status === '') {
            // “All” clicked → clear all filters & redraw
            table.search('').columns().search('').draw();
        } else {
            // Apply new status filter (case-insensitive)
            $.fn.dataTable.ext.search.push(function(settings, data) {
                const cellStatus = (data[6] || '').toLowerCase().trim(); // Status column index changed to 6
                return cellStatus.includes(status);
            });
            table.draw();
        }
    });

    // ✅ DATE FILTER
    $('#dateFilter').on('change', function() {
        const date = $(this).val();
        table.column(4).search(date || '', true, false).draw(); // Date column index changed to 4
    });

    $('#clearDateFilter').on('click', function() {
        $('#dateFilter').val('');
        table.column(4).search('').draw(); // Date column index changed to 4
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

    // ✅ Bootstrap tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();

});
</script>
@endpush