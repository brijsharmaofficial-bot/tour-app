@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-3">Add Vendor</h4>
    <form method="POST" action="{{ route('vendors.store') }}" enctype="multipart/form-data" class="card p-4 shadow-sm">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control">
            </div>
            <div class="col-md-6 mb-3 position-relative">
             <div class="mb-3 position-relative">
                <label for="city" class="form-label">City</label>
                <input type="text" id="city" class="form-control" placeholder="Search city..." autocomplete="off">
                <input type="hidden" name="city_id" id="city_id">

                <ul id="cityList" class="list-group position-absolute w-100" style="z-index:1000; display:none;"></ul>
            </div>
            </div>

            <div class="col-12">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control" rows="2"></textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Logo</label>
                <input type="file" name="logo" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active" selected>Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>
        <div class="mt-4 d-flex justify-content-end">
            <button class="btn btn-success me-2">Save</button>
            <a href="{{ route('vendors.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection