@extends('layouts.app')
@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0"><i class="bi bi-airplane me-2 text-primary"></i> Airport Details</h4>
    <a href="{{ route('airports.index') }}" class="btn btn-outline-secondary btn-sm">
      <i class="bi bi-arrow-left"></i> Back
    </a>
  </div>

  <div class="card shadow-sm border-0">
    <div class="card-body p-4">
      <h5 class="fw-bold mb-3">{{ $airport->name }}</h5>
      <p><strong>City:</strong> {{ $airport->city->name ?? 'N/A' }}</p>
      <p><strong>Status:</strong> 
         <span class="badge bg-{{ $airport->status == 'active' ? 'success' : 'secondary' }}">
             {{ ucfirst($airport->status) }}
         </span>
      </p>
    </div>
  </div>

  <div class="mt-3 text-end">
    <a href="{{ route('airports.edit', $airport) }}" class="btn btn-warning me-2"><i class="bi bi-pencil"></i> Edit</a>
    <form action="{{ route('airports.destroy', $airport) }}" method="POST" class="d-inline">
      @csrf @method('DELETE')
      <button class="btn btn-danger" onclick="return confirm('Delete this airport?')">
        <i class="bi bi-trash"></i> Delete
      </button>
    </form>
  </div>
</div>
@endsection
