@extends('layouts.app')

@section('title', 'Edit Company')

@section('content')
<div class="container py-4">
  <h4 class="fw-bold mb-3">Edit Company Details</h4>

  <form method="POST" action="{{ route('company-details.update', $companyDetail->id) }}" class="card p-4 shadow-sm border-0">
    @csrf
    @method('PUT')
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Company Name *</label>
        <input type="text" name="company_name" class="form-control" value="{{ $companyDetail->company_name }}" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control" value="{{ $companyDetail->phone }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ $companyDetail->email }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Corporate Office</label>
        <input type="text" name="corporate_office" class="form-control" value="{{ $companyDetail->corporate_office }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">GST Number</label>
        <input type="text" name="gst_number" class="form-control" value="{{ $companyDetail->gst_number }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Bank Name</label>
        <input type="text" name="bank_name" class="form-control" value="{{ $companyDetail->bank_name }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Bank Account</label>
        <input type="text" name="bank_account" class="form-control" value="{{ $companyDetail->bank_account }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">IFSC Code</label>
        <input type="text" name="ifsc_code" class="form-control" value="{{ $companyDetail->ifsc_code }}">
      </div>
      <div class="col-md-12">
        <label class="form-label">Notes</label>
        <textarea name="notes" class="form-control" rows="2">{{ $companyDetail->notes }}</textarea>
      </div>
    </div>

    <div class="mt-4 text-end">
      <button class="btn btn-success me-2">Update</button>
      <a href="{{ route('company-details.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
  </form>
</div>
@endsection
