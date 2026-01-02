@extends('layouts.app')
@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold">Pricing Details – {{ $package->tripType->name }} ({{ $package->fromCity->name }})</h4>
    <a href="{{ route('package_pricing.create', $package) }}" class="btn btn-primary btn-sm">+ Add Pricing</a>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card shadow-sm border-0">
    <div class="table-responsive">
      <table class="table table-striped align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Hours</th>
            <th>KMs</th>
            <th>Price (₹)</th>
            <th width="130">Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($details as $d)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $d->hours }}</td>
              <td>{{ $d->kms }}</td>
              <td>₹{{ number_format($d->price,2) }}</td>
              <td>
                <a href="{{ route('package_pricing.edit', [$package, $d]) }}" class="btn btn-sm btn-warning me-1">
                  <i class="bi bi-pencil"></i>
                </a>
                <form action="{{ route('package_pricing.destroy', [$package, $d]) }}" method="POST" class="d-inline">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this price?')">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="5" class="text-center py-3">No pricing records found.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
