@extends('layouts.app')

@section('title', 'Company Details')

@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">Company Details</h4>
    <a href="{{ route('company-details.create') }}" class="btn btn-success">
      <i class="bi bi-plus-circle"></i> Add New
    </a>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card shadow-sm border-0">
    <div class="card-body table-responsive">
      <table class="table table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>Company</th>
            <th>Phone</th>
            <th>Email</th>
            <th>GST</th>
            <th>Bank</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($companies as $c)
          <tr>
            <td>{{ $c->company_name }}</td>
            <td>{{ $c->phone }}</td>
            <td>{{ $c->email }}</td>
            <td>{{ $c->gst_number }}</td>
            <td>{{ $c->bank_name }}</td>
            <td>
              <a href="{{ route('company-details.edit', $c->id) }}" class="btn btn-sm btn-primary">
                <i class="bi bi-pencil"></i>
              </a>
              <form action="{{ route('company-details.destroy', $c->id) }}" method="POST" class="d-inline">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this company?')">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            </td>
          </tr>
          @empty
          <tr><td colspan="6" class="text-center">No company details found.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
