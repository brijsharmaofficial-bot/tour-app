@extends('layouts.app')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Cabs</h4>
        <a href="{{ route('cabs.create') }}" class="btn btn-primary btn-sm">+ Add Cab</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive shadow-sm rounded bg-white">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Cab Name</th>
                    <th>Cab Number</th>
                    <th>Type</th>
                    <th>Seating</th>
                    <th>Vendor</th>
                    <th>Status</th>
                    <th width="150">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cabs as $cab)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>@if($cab->image)
                        <div class="text-center mb-3">
                           <img src="{{ asset('storage/' . $cab->image) }}" width="120" class="rounded shadow-sm">
                        </div>
                    @endif
                    </td>
                    <td>{{ $cab->cab_name }}</td>
                    <td>{{ $cab->registration_no }}</td>
                    <td>{{ ucfirst($cab->cab_type) }}</td>
                    <td>{{ $cab->capacity }}</td>

                    <td>{{ $cab->vendor->name ?? '—' }}</td>
                    <td>
                        <span class="badge bg-{{ $cab->status === 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($cab->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('cabs.show', $cab) }}" class="btn btn-sm btn-info text-white me-1">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('cabs.edit', $cab) }}" class="btn btn-sm btn-warning me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('cabs.destroy', $cab) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this cab?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center py-3">No cabs found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
