@extends('layouts.app')

@section('title', 'Add Company')

@section('content')
<div class="container py-4">
  <h4 class="fw-bold mb-3">Add Company Details</h4>

  <form method="POST" action="{{ route('company-details.store') }}" class="card p-4 shadow-sm border-0">
    @csrf
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Company Name *</label>
        <input type="text" name="company_name" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control">
      </div>
      <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control">
      </div>
      <div class="col-md-6">
        <label class="form-label">Corporate Office</label>
        <input type="text" name="corporate_office" class="form-control">
      </div>
      <div class="col-md-6">
        <label class="form-label">GST Number</label>
        <input type="text" name="gst_number" class="form-control">
      </div>
      <div class="col-md-6">
        <label class="form-label">Bank Name</label>
        <input type="text" name="bank_name" class="form-control">
      </div>
      <div class="col-md-6">
        <label class="form-label">Bank Account</label>
        <input type="text" name="bank_account" class="form-control">
      </div>
      <div class="col-md-6">
        <label class="form-label">IFSC Code</label>
        <input type="text" name="ifsc_code" class="form-control">
      </div>
      <div class="col-md-12">
        <label class="form-label">Notes</label>
        <textarea name="notes" class="form-control" rows="2"></textarea>
      </div>
    </div>

    <div class="mt-4 text-end">
      <button class="btn btn-success me-2">Save</button>
      <a href="{{ route('company-details.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
  </form>
</div>
@endsection
