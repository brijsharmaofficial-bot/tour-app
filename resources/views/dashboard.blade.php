@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Dashboard Overview</h4>
            <p class="text-muted mb-0">Monitor your system performance and key metrics</p>
        </div>
        <div class="d-flex gap-2">
            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-calendar me-2"></i>Last 30 Days
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">Last 7 Days</a></li>
                    <li><a class="dropdown-item" href="#">Last 30 Days</a></li>
                    <li><a class="dropdown-item" href="#">Last 90 Days</a></li>
                </ul>
            </div>
            
        </div>
    </div>

    <!-- Welcome Banner -->
    <div class="card bg-gradient-primary text-white border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="fw-bold mb-2">Welcome back, {{ Auth::user()->name }}! 👋</h5>
                    <p class="text-white-50 mb-0">Here's what's happening in your tour & travel system today. You have <strong>{{ $bookingsCount ?? 0 }} bookings</strong> to manage.</p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="welcome-icon">
                        <i class="fas fa-rocket fs-1 opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- KPI Stats Cards -->
    <div class="row g-4 mb-4">
        @php
            $cards = [
                ['title' => 'Total Vendors', 'count' => $vendorsCount ?? 0, 'icon' => 'building', 'color' => 'primary', 'route' => 'vendors', 'trend' => '+12%'],
                ['title' => 'Active Cabs', 'count' => $cabsCount ?? 0, 'icon' => 'car', 'color' => 'success', 'route' => 'cabs', 'trend' => '+5%'],
                ['title' => 'Total Bookings', 'count' => $bookingsCount ?? 0, 'icon' => 'calendar-check', 'color' => 'warning', 'route' => 'bookings', 'trend' => '+18%'],
                ['title' => 'System Users', 'count' => $usersCount ?? 0, 'icon' => 'users', 'color' => 'info', 'route' => '#', 'trend' => '+8%']
            ];
        @endphp

        @foreach ($cards as $card)
            <div class="col-xl-3 col-md-6">
                <div class="card stat-card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="stat-icon bg-{{ $card['color'] }} bg-opacity-10 text-{{ $card['color'] }} rounded-circle">
                                <i class="fas fa-{{ $card['icon'] }} fs-5"></i>
                            </div>
                            <span class="badge bg-{{ $card['color'] }} bg-opacity-10 text-{{ $card['color'] }}">
                                <i class="fas fa-arrow-up me-1"></i>{{ $card['trend'] }}
                            </span>
                        </div>
                        <h3 class="stat-value text-{{ $card['color'] }} mb-2">{{ $card['count'] }}</h3>
                        <p class="stat-label text-muted mb-3">{{ $card['title'] }}</p>
                        <a href="{{ $card['route'] }}" class="stat-link text-decoration-none">
                            View Details <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Charts & Analytics Row -->
    <div class="row g-4 mb-4">
        <!-- Revenue Chart -->
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-chart-line me-2 text-primary"></i>
                        Revenue Overview
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <!-- Booking Status Chart -->
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-pie-chart me-2 text-primary"></i>
                        Booking Status
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="bookingChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Recent Bookings -->
    <div class="row g-4">
        <!-- Quick Actions -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-bolt me-2 text-warning"></i>
                        Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('vendors.create') }}" class="quick-action-card">
                            <div class="d-flex align-items-center">
                                <div class="action-icon bg-primary text-white rounded-circle me-3">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Add Vendor</h6>
                                    <small class="text-muted">Register new vendor partner</small>
                                </div>
                                <i class="fas fa-chevron-right text-muted"></i>
                            </div>
                        </a>

                        <a href="{{ route('cabs.create') }}" class="quick-action-card">
                            <div class="d-flex align-items-center">
                                <div class="action-icon bg-success text-white rounded-circle me-3">
                                    <i class="fas fa-taxi"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Add Cab</h6>
                                    <small class="text-muted">Register new vehicle</small>
                                </div>
                                <i class="fas fa-chevron-right text-muted"></i>
                            </div>
                        </a>

                        <a href="{{ route('packages.create') }}" class="quick-action-card">
                            <div class="d-flex align-items-center">
                                <div class="action-icon bg-warning text-white rounded-circle me-3">
                                    <i class="fas fa-box-open"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Create Package</h6>
                                    <small class="text-muted">Design new tour package</small>
                                </div>
                                <i class="fas fa-chevron-right text-muted"></i>
                            </div>
                        </a>

                        <a href="{{ route('bookings.create') }}" class="quick-action-card">
                            <div class="d-flex align-items-center">
                                <div class="action-icon bg-info text-white rounded-circle me-3">
                                    <i class="fas fa-calendar-plus"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">New Booking</h6>
                                    <small class="text-muted">Create booking manually</small>
                                </div>
                                <i class="fas fa-chevron-right text-muted"></i>
                            </div>
                        </a>

                        <a href="{{ route('airports.create') }}" class="quick-action-card">
                            <div class="d-flex align-items-center">
                                <div class="action-icon bg-secondary text-white rounded-circle me-3">
                                    <i class="fas fa-plane"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Add Airport</h6>
                                    <small class="text-muted">Register new airport</small>
                                </div>
                                <i class="fas fa-chevron-right text-muted"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Bookings -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-clock me-2 text-primary"></i>
                            Recent Bookings
                        </h6>
                        <a href="{{ route('bookings.index') }}" class="btn btn-sm btn-outline-primary">
                            View All <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if(isset($recentBookings) && $recentBookings->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Booking ID</th>
                                        <th>Customer</th>
                                        <th>Trip Route</th>
                                        <th>Date & Time</th>
                                        <th>Status</th>
                                        <th class="text-end pe-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentBookings as $booking)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="booking-id fw-semibold">#BK{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</div>
                                        </td>
                                        <td>
                                            <div class="customer-info">
                                                <h6 class="mb-1">{{ $booking->user->name ?? 'Guest' }}</h6>
                                                <small class="text-muted">{{ $booking->user->email ?? 'N/A' }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="route-info">
                                                <small class="text-muted">
                                                    <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                                    {{ $booking->fromCity->name ?? 'N/A' }}
                                                </small>
                                                <br>
                                                <small class="text-muted">
                                                    <i class="fas fa-flag-checkered text-success me-1"></i>
                                                    {{ $booking->toCity->name ?? 'N/A' }}
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="datetime-info">
                                                <div class="fw-semibold">{{ $booking->pickup_date }}</div>
                                                <small class="text-muted">{{ $booking->pickup_time }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge status-badge bg-{{ $booking->status == 'completed' ? 'success' : ($booking->status == 'assigned' ? 'primary' : ($booking->status == 'pending' ? 'warning' : 'secondary')) }}">
                                                <i class="fas fa-circle me-1 fs-6"></i>
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('bookings.show', $booking) }}" class="btn btn-outline-primary" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-outline-warning" title="Edit Booking">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="empty-state-icon mb-3">
                                <i class="fas fa-calendar-times text-muted fs-1"></i>
                            </div>
                            <h5 class="text-muted">No Recent Bookings</h5>
                            <p class="text-muted mb-4">Get started by creating your first booking</p>
                            <a href="{{ route('bookings.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle me-2"></i>Create Booking
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- System Status -->
    <div class="row g-4 mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-server me-2 text-primary"></i>
                        System Status
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-3 text-center">
                            <div class="system-stat">
                                <div class="stat-icon bg-success bg-opacity-10 text-success rounded-circle mx-auto mb-3">
                                    <i class="fas fa-database fs-4"></i>
                                </div>
                                <h4 class="text-success mb-1">100%</h4>
                                <p class="text-muted mb-0">Database</p>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="system-stat">
                                <div class="stat-icon bg-info bg-opacity-10 text-info rounded-circle mx-auto mb-3">
                                    <i class="fas fa-cloud fs-4"></i>
                                </div>
                                <h4 class="text-info mb-1">99.9%</h4>
                                <p class="text-muted mb-0">Uptime</p>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="system-stat">
                                <div class="stat-icon bg-warning bg-opacity-10 text-warning rounded-circle mx-auto mb-3">
                                    <i class="fas fa-shield-alt fs-4"></i>
                                </div>
                                <h4 class="text-warning mb-1">Secure</h4>
                                <p class="text-muted mb-0">Security</p>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="system-stat">
                                <div class="stat-icon bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-3">
                                    <i class="fas fa-bolt fs-4"></i>
                                </div>
                                <h4 class="text-primary mb-1">Fast</h4>
                                <p class="text-muted mb-0">Performance</p>
                            </div>
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
    
    .stat-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
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
    
    .stat-link {
        color: var(--text-muted);
        font-size: 0.875rem;
        font-weight: 500;
        transition: color 0.3s ease;
    }
    
    .stat-link:hover {
        color: var(--primary);
    }
    
    .quick-action-card {
        display: block;
        padding: 1rem;
        border: 1px solid #e9ecef;
        border-radius: 0.75rem;
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
    }
    
    .quick-action-card:hover {
        background-color: #f8f9fa;
        border-color: var(--primary);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .action-icon {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .booking-id {
        color: var(--primary);
        font-weight: 600;
    }
    
    .status-badge {
        font-size: 0.75rem;
        font-weight: 500;
        padding: 0.35rem 0.75rem;
    }
    
    .customer-info h6 {
        font-weight: 600;
        color: var(--text-dark);
    }
    
    .system-stat {
        padding: 1rem;
    }
    
    .empty-state-icon {
        opacity: 0.5;
    }
    
    .welcome-icon {
        opacity: 0.8;
    }
    
    .table th {
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid var(--border-color);
    }
    
    .table td {
        vertical-align: middle;
        padding: 1rem 0.75rem;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            datasets: [{
                label: 'Revenue (₹)',
                data: [12000, 19000, 15000, 25000, 22000, 30000, 28000],
                borderColor: '#3a57e8',
                backgroundColor: 'rgba(58, 87, 232, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Booking Status Chart
    const bookingCtx = document.getElementById('bookingChart').getContext('2d');
    new Chart(bookingCtx, {
        type: 'doughnut',
        data: {
            labels: ['Completed', 'Pending', 'Assigned', 'Cancelled'],
            datasets: [{
                data: @json($bookingStatusCounts),
                backgroundColor: ['#198754', '#ffc107', '#0dcaf0', '#dc3545'],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            cutout: '70%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        padding: 15,
                        color: '#333'
                    }
                }
            }
        }
    });

    // Add loading animation to stat cards
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        card.classList.add('animate__animated', 'animate__fadeInUp');
    });
});
</script>
@endpush