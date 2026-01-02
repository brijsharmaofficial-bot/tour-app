@extends('layouts.app')

@section('title', 'Booking #' . $booking->id . ' - Details')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('bookings.index') }}" class="text-decoration-none">Bookings</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Booking #{{ $booking->id }}</li>
                </ol>
            </nav>
            <h4 class="fw-bold mb-1">Booking Details</h4>
            <p class="text-muted mb-0">Complete information about booking #{{ $booking->id }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-warning d-none">
                <i class="fas fa-edit me-2"></i>Edit Booking
            </a>
            <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Booking Information -->
        <div class="col-xl-8 col-lg-7">
            <!-- Trip Information Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <h5 class="card-title mb-0 d-flex align-items-center">
                        <i class="fas fa-route me-2"></i>
                        Trip Information
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <!-- Route Information -->
                        <div class="col-12">
                            <div class="route-display d-flex align-items-center justify-content-between p-3 bg-light rounded">
                                <div class="text-center">
                                    <div class="location-icon bg-primary text-white rounded-circle mx-auto mb-2">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <h6 class="fw-semibold mb-1">From</h6>
                                    <p class="mb-0">{{ $booking->fromCity->name ?? 'N/A' }}</p>
                                    <small class="text-muted">{{ $booking->pickup_address }}</small>
                                </div>
                                <div class="route-arrow mx-4">
                                    <i class="fas fa-arrow-right text-primary fs-2"></i>
                                </div>
                                <div class="text-center">
                                    <div class="location-icon bg-success text-white rounded-circle mx-auto mb-2">
                                        <i class="fas fa-flag-checkered"></i>
                                    </div>
                                    <h6 class="fw-semibold mb-1">To</h6>
                                    <p class="mb-0">{{ $booking->toCity->name ?? 'N/A' }}</p>
                                    <small class="text-muted">{{ $booking->drop_address ?? 'Not specified' }}</small>
                                </div>
                            </div>
                        </div>

                        <!-- Trip Details -->
                        <div class="col-md-6">
                            <div class="detail-card">
                                <div class="detail-icon bg-info">
                                    <i class="fas fa-calendar-day"></i>
                                </div>
                                <div class="detail-content">
                                    <label class="detail-label">Pickup Date & Time</label>
                                    <p class="detail-value">
                                        {{ \Carbon\Carbon::parse($booking->pickup_date)->format('M d, Y') }}
                                        at {{ \Carbon\Carbon::parse($booking->pickup_time)->format('h:i A') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="detail-card">
                                <div class="detail-icon bg-warning">
                                    <i class="fas fa-box"></i>
                                </div>
                                <div class="detail-content">
                                    <label class="detail-label">Package Type</label>
                                    <p class="detail-value text-capitalize">
                                        {{ $booking->package->tripType->name ?? 'N/A' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Trip Information -->
                        <div class="col-md-6">
                            <div class="detail-card">
                                <div class="detail-icon bg-secondary">
                                    <i class="fas fa-road"></i>
                                </div>
                                <div class="detail-content">
                                    <label class="detail-label">Estimated Distance</label>
                                    <p class="detail-value">
                                        {{ $booking->estimated_distance ?? 'N/A' }} km
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="detail-card">
                                <div class="detail-icon bg-dark">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="detail-content">
                                    <label class="detail-label">Estimated Duration</label>
                                    <p class="detail-value">
                                        {{ $booking->estimated_duration ?? 'N/A' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Package Details Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-box-open me-2 text-primary"></i>
                        Package Details
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Package Type</label>
                            <p class="fw-semibold">{{ $booking->package->tripType->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Vehicle Type</label>
                            <p class="fw-semibold">{{ $booking->package->cab->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Base Fare</label>
                            <p class="fw-semibold">₹{{ number_format($booking->package->base_fare ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Price Per KM</label>
                            <p class="fw-semibold">₹{{ number_format($booking->package->price_per_km ?? 0, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fare Breakdown Card -->
            <div class="card shadow-sm border-0 mb-4 d-none">
                <div class="card-header bg-white py-3">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-receipt me-2 text-primary"></i>
                        Fare Breakdown
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Base Fare:</span>
                                <span class="fw-semibold">₹{{ number_format($booking->base_fare ?? 0, 2) }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Distance Charges:</span>
                                <span class="fw-semibold">₹{{ number_format($booking->distance_fare ?? 0, 2) }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Waiting Charges:</span>
                                <span class="fw-semibold">₹{{ number_format($booking->waiting_charges ?? 0, 2) }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Night Charges:</span>
                                <span class="fw-semibold">₹{{ number_format($booking->night_charges ?? 0, 2) }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Toll/Parking Charges:</span>
                                <span class="fw-semibold">₹{{ number_format($booking->toll_charges ?? 0, 2) }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Other Charges:</span>
                                <span class="fw-semibold">₹{{ number_format($booking->other_charges ?? 0, 2) }}</span>
                            </div>
                        </div>
                        <div class="col-12 mt-3 pt-3 border-top">
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold">Subtotal:</span>
                                <span class="fw-bold">₹{{ number_format($booking->subtotal_fare ?? 0, 2) }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Tax ({{ $booking->tax_percentage ?? 0 }}%):</span>
                                <span class="fw-semibold">₹{{ number_format($booking->tax_amount ?? 0, 2) }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Discount:</span>
                                <span class="fw-semibold text-success">-₹{{ number_format($booking->discount_amount ?? 0, 2) }}</span>
                            </div>
                        </div>
                        <div class="col-12 mt-3 pt-3 border-top">
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold fs-5">Total Fare:</span>
                                <span class="fw-bold fs-5 text-primary">₹{{ number_format($booking->total_estimated_fare, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer & Assignment Information -->
            <div class="row">
                <!-- Customer Information -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-white py-3">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-user me-2 text-primary"></i>
                                Customer Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="customer-info text-center">
                                <div class="customer-avatar bg-primary text-white rounded-circle mx-auto mb-3">
                                    <i class="fas fa-user fs-4"></i>
                                </div>
                                <h5 class="customer-name mb-2">{{ $booking->user->name ?? 'Guest User' }}</h5>
                                <p class="text-muted mb-3">{{ $booking->user->email ?? 'N/A' }}</p>
                                
                                <div class="contact-info">
                                    @if($booking->user->phone ?? false)
                                    <div class="d-flex align-items-center justify-content-center mb-2">
                                        <i class="fas fa-phone text-success me-2"></i>
                                        <span>{{ $booking->user->phone }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Assignment Information -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-white py-3">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-users me-2 text-primary"></i>
                                Assignment Details
                            </h6>
                        </div>
                        <div class="card-body">
                            @if($booking->vendor && $booking->cab)
                            <div class="assignment-info">
                                <!-- Vendor Info -->
                                <div class="d-flex align-items-center mb-3 p-2 bg-light rounded">
                                    <div class="vendor-icon bg-success text-white rounded-circle me-3">
                                        <i class="fas fa-building"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">{{ $booking->vendor->name }}</h6>
                                        <small class="text-muted">Vendor</small>
                                        <div class="mt-1">
                                            <small>
                                                <i class="fas fa-phone text-muted me-1"></i>
                                                {{ $booking->vendor->phone ?? 'N/A' }}
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Cab Info -->
                                <div class="d-flex align-items-center p-2 bg-light rounded">
                                    <div class="cab-icon bg-info text-white rounded-circle me-3">
                                        <i class="fas fa-car"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">{{ $booking->cab->cab_name }}</h6>
                                        <small class="text-muted">
                                            {{ ucfirst($booking->cab->cab_type) }} • 
                                            {{ $booking->cab->registration_no }}
                                        </small>
                                        <div class="mt-1">
                                            <small>
                                                <i class="fas fa-user text-muted me-1"></i>
                                                {{ $booking->cab->driver_name ?? 'N/A' }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="text-center py-4">
                                <div class="empty-state-icon mb-3">
                                    <i class="fas fa-users text-muted fs-1"></i>
                                </div>
                                <h6 class="text-muted">Not Assigned</h6>
                                <p class="text-muted mb-0">No vendor or cab assigned yet</p>
                                <button class="btn btn-primary btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#assignVendorModal">
                                    <i class="fas fa-user-check me-1"></i>Assign Vendor
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar - Status & Actions -->
        <div class="col-xl-4 col-lg-5">
            <!-- Status & Payment Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2 text-primary"></i>
                        Booking Status & Actions
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Booking Status -->
                    <div class="status-display text-center mb-4">
                        @php
                            $statusConfig = [
                                'pending' => ['color' => 'warning', 'icon' => 'clock'],
                                'assigned' => ['color' => 'info', 'icon' => 'user-check'],
                                'in_progress' => ['color' => 'primary', 'icon' => 'play-circle'],
                                'completed' => ['color' => 'success', 'icon' => 'check-circle'],
                                'cancelled' => ['color' => 'danger', 'icon' => 'times-circle']
                            ];
                            $status = $statusConfig[$booking->status] ?? ['color' => 'secondary', 'icon' => 'question-circle'];
                        @endphp
                        
                        <div class="status-icon bg-{{ $status['color'] }} text-white rounded-circle mx-auto mb-3">
                            <i class="fas fa-{{ $status['icon'] }} fs-4"></i>
                        </div>
                        <h4 class="text-{{ $status['color'] }} mb-2">{{ ucfirst($booking->status) }}</h4>
                        
                        <!-- Status Update Form -->
                        <form action="{{ route('bookings.update-status', $booking) }}" method="POST" class="mb-3">
                            @csrf
                            @method('PATCH')
                            <div class="input-group input-group-sm">
                                <select name="status" class="form-select" onchange="this.form.submit()">
                                    <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="assigned" {{ $booking->status == 'assigned' ? 'selected' : '' }}>Assigned</option>
                                    <option value="in_progress" {{ $booking->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                        </form>
                    </div>

                    <!-- Payment Status -->
                    <div class="payment-status text-center mb-4 p-3 bg-light rounded">
                        <div class="d-flex align-items-center justify-content-center mb-2">
                            <div class="payment-icon bg-{{ $booking->payment_status == 'paid' ? 'success' : ($booking->payment_status == 'pending' ? 'warning' : 'secondary') }} text-white rounded-circle me-2">
                                <i class="fas fa-{{ $booking->payment_status == 'paid' ? 'check' : ($booking->payment_status == 'pending' ? 'clock' : 'exclamation-triangle') }}"></i>
                            </div>
                            <h5 class="mb-0">Payment {{ ucfirst($booking->payment_status) }}</h5>
                        </div>
                        
                        <!-- Payment Status Update Form -->
                        <form action="{{ route('bookings.update-payment-status', $booking) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="input-group input-group-sm">
                                <select name="payment_status" class="form-select" onchange="this.form.submit()">
                                    <option value="pending" {{ $booking->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid" {{ $booking->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="failed" {{ $booking->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                                    <option value="refunded" {{ $booking->payment_status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                </select>
                            </div>
                        </form>
                    </div>

                    <!-- Fare Information -->
                    <div class="fare-info text-center p-3 bg-primary bg-opacity-10 rounded">
                        <h6 class="text-muted mb-2">Total Fare</h6>
                        <h3 class="text-primary fw-bold">₹{{ number_format($booking->total_estimated_fare, 2) }}</h3>
                        <small class="text-muted">Inclusive of all charges</small>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-bolt me-2 text-primary"></i>
                        Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($booking->status == 'pending' && !$booking->vendor)
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#assignVendorModal">
                            <i class="fas fa-user-check me-2"></i>Assign Vendor
                        </button>
                        @endif

                        @if($booking->status == 'assigned')
                        <form action="{{ route('bookings.update-status', $booking) }}" method="POST" class="d-grid">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="in_progress">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-play-circle me-2"></i>Start Trip
                            </button>
                        </form>
                        @endif

                        @if($booking->status == 'in_progress')
                        <form action="{{ route('bookings.update-status', $booking) }}" method="POST" class="d-grid">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="completed">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check-circle me-2"></i>Complete Trip
                            </button>
                        </form>
                        @endif

                        @if($booking->status == 'pending')
                        <form action="{{ route('bookings.update-status', $booking) }}" method="POST" class="d-grid">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this booking?')">
                                <i class="fas fa-times-circle me-2"></i>Cancel Booking
                            </button>
                        </form>
                        @endif

                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v me-2"></i>More Actions
                            </button>
                            <ul class="dropdown-menu w-100">
                                <li>
                                    <a class="dropdown-item" href="{{ route('bookings.invoice', $booking) }}" target="_blank">
                                        <i class="fas fa-receipt me-2"></i>Generate Invoice
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#sendNotificationModal">
                                        <i class="fas fa-envelope me-2"></i>Send Notification
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('bookings.destroy', $booking) }}" method="POST" class="d-inline">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="button" class="dropdown-item text-danger" onclick="confirmDelete()">
                                            <i class="fas fa-trash me-2"></i>Delete Booking
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-white py-3">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-history me-2 text-primary"></i>
                        Booking Timeline
                    </h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item completed">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Booking Created</h6>
                                <small class="text-muted">{{ $booking->created_at->format('M d, Y h:i A') }}</small>
                            </div>
                        </div>

                        @if($booking->vendor)
                        <div class="timeline-item completed">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Vendor Assigned</h6>
                                <small class="text-muted">{{ $booking->updated_at->format('M d, Y h:i A') }}</small>
                            </div>
                        </div>
                        @endif

                        <div class="timeline-item {{ in_array($booking->status, ['assigned', 'in_progress', 'completed']) ? 'completed' : 'pending' }}">
                            <div class="timeline-marker {{ in_array($booking->status, ['assigned', 'in_progress', 'completed']) ? 'bg-info' : 'bg-light' }}"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Trip Started</h6>
                                <small class="text-muted">
                                    {{ in_array($booking->status, ['assigned', 'in_progress', 'completed']) ? 'In progress' : 'Pending' }}
                                </small>
                            </div>
                        </div>

                        <div class="timeline-item {{ $booking->status == 'completed' ? 'completed' : 'pending' }}">
                            <div class="timeline-marker {{ $booking->status == 'completed' ? 'bg-success' : 'bg-light' }}"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Trip Completed</h6>
                                <small class="text-muted">
                                    {{ $booking->status == 'completed' ? 'Successfully completed' : 'Awaiting completion' }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Assign Vendor Modal -->
<div class="modal fade" id="assignVendorModal" tabindex="-1" aria-labelledby="assignVendorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignVendorModalLabel">Assign Vendor & Cab</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('bookings.assign-vendor', $booking) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="vendor_id" class="form-label">Select Vendor</label>
                            <select class="form-select" id="vendor_id" name="vendor_id" required>
                                <option value="">Choose Vendor...</option>
                                @foreach($vendors as $vendor)
                                <option value="{{ $vendor->id }}" {{ $booking->vendor_id == $vendor->id ? 'selected' : '' }}>
                                    {{ $vendor->name }} - {{ $vendor->phone }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="cab_id" class="form-label">Select Cab</label>
                            <select class="form-select" id="cab_id" name="cab_id" required>
                                <option value="">Choose Cab...</option>
                                @foreach($cabs as $cab)
                                <option value="{{ $cab->id }}" {{ $booking->cab_id == $cab->id ? 'selected' : '' }}>
                                    {{ $cab->cab_name }} ({{ $cab->registration_no }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="driver_notes" class="form-label">Driver Notes (Optional)</label>
                        <textarea class="form-control" id="driver_notes" name="driver_notes" rows="3" placeholder="Any special instructions for the driver...">{{ $booking->driver_notes }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Assign Vendor</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Send Notification Modal -->
<div class="modal fade" id="sendNotificationModal" tabindex="-1" aria-labelledby="sendNotificationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sendNotificationModalLabel">Send Notification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('bookings.send-notification', $booking) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="notification_type" class="form-label">Notification Type</label>
                        <select class="form-select" id="notification_type" name="notification_type" required>
                            <option value="status_update">Status Update</option>
                            <option value="payment_reminder">Payment Reminder</option>
                            <option value="trip_reminder">Trip Reminder</option>
                            <option value="custom">Custom Message</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="4" required placeholder="Enter your notification message..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Send Notification</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%) !important;
    }
    
    .location-icon, .status-icon, .payment-icon, .vendor-icon, .cab-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .customer-avatar {
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .route-display {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }
    
    .detail-card {
        display: flex;
        align-items: center;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 0.75rem;
        border: 1px solid #e9ecef;
    }
    
    .detail-icon {
        width: 45px;
        height: 45px;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        color: white;
        font-size: 1.1rem;
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
    
    /* Timeline Styles */
    .timeline {
        position: relative;
        padding-left: 2rem;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 1.5rem;
    }
    
    .timeline-marker {
        position: absolute;
        left: -2rem;
        top: 0;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 2px solid white;
    }
    
    .timeline-item.completed .timeline-marker {
        background: var(--success);
    }
    
    .timeline-item.pending .timeline-marker {
        background: #e9ecef;
    }
    
    .timeline-content h6 {
        font-size: 0.9rem;
        margin-bottom: 0.25rem;
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
    
    .empty-state-icon {
        opacity: 0.5;
    }
    
    .form-label {
        font-size: 0.875rem;
        font-weight: 500;
    }
</style>
@endpush

@push('scripts')
<script>
function confirmDelete() {
    Swal.fire({
        title: 'Delete Booking?',
        html: `You are about to delete booking <strong>#{{ $booking->id }}</strong>. This action cannot be undone.`,
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

// Auto-submit forms when dropdown changes
document.querySelectorAll('select[onchange]').forEach(select => {
    select.addEventListener('change', function() {
        this.form.submit();
    });
});
</script>

<!-- SweetAlert2 for better confirmations -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush