@extends('layouts.app')

@section('title', 'Manage Routes')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">
            <i class="bi bi-map text-primary me-2"></i> Manage City Routes
        </h4>
        <a href="{{ route('routes.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Add Route
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            @if($routes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>From City</th>
                                <th>To City</th>
                                <th>Distance (km)</th>
                                <th>Approx Time</th>
                                <th>Toll Tax (₹)</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($routes as $index => $route)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $route->fromCity->name ?? 'N/A' }}</td>
                                    <td>{{ $route->toCity->name ?? 'N/A' }}</td>
                                    <td>{{ number_format($route->distance_km, 2) }}</td>
                                    <td>{{ $route->approx_time ?? '-' }}</td>
                                    <td>₹{{ number_format($route->toll_tax, 2) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $route->status == 'active' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($route->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('routes.edit', $route) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('routes.destroy', $route) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this route?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted mb-0">No routes found. Click "Add Route" to create one.</p>
            @endif
        </div>
    </div>
</div>
@endsection
