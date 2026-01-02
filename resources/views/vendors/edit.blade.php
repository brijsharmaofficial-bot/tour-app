@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-3">{{ isset($vendor) ? 'Edit Vendor' : 'Add Vendor' }}</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ isset($vendor) ? route('vendors.update', $vendor->id) : route('vendors.store') }}"
          enctype="multipart/form-data"
          class="card p-4 shadow-sm">

        @csrf
        @if(isset($vendor))
            @method('PUT')
        @endif

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Name</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       required
                       value="{{ old('name', $vendor->name ?? '') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email"
                       name="email"
                       class="form-control"
                       value="{{ old('email', $vendor->email ?? '') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input type="text"
                       name="phone"
                       class="form-control"
                       value="{{ old('phone', $vendor->phone ?? '') }}">
            </div>

            <div class="col-md-6 mb-3 position-relative">
                <label for="city" class="form-label">City</label>
                <input type="text"
                       id="city"
                       class="form-control"
                       placeholder="Search city..."
                       autocomplete="off"
                       value="{{ old('city_name', optional($vendor->city)->name ?? '') }}">

                <!-- Hidden field to store selected city_id -->
                <input type="hidden" name="city_id" id="city_id" value="{{ old('city_id', $vendor->city_id ?? '') }}">

                <ul id="cityList" class="list-group position-absolute w-100" style="z-index:1000; display:none; max-height:220px; overflow:auto;"></ul>
            </div>

            <div class="col-12">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control" rows="2">{{ old('address', $vendor->address ?? '') }}</textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label">Logo</label>
                <input type="file" name="logo" class="form-control">
                @if(isset($vendor) && $vendor->logo)
                    <div class="mt-2">
                        <img src="{{ asset('storage/'.$vendor->logo) }}" width="100" class="rounded border">
                        <p class="small text-muted mt-1">Current Logo</p>
                    </div>
                @endif
            </div>

            <div class="col-md-6">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active" {{ old('status', $vendor->status ?? 'active') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $vendor->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-end">
            <button class="btn btn-success me-2">{{ isset($vendor) ? 'Update' : 'Save' }}</button>
            <a href="{{ route('vendors.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>

(function($){
    // debounce helper
    function debounce(fn, delay){
        let timer = null;
        return function(){
            const context = this, args = arguments;
            clearTimeout(timer);
            timer = setTimeout(() => fn.apply(context, args), delay);
        };
    }

    $(document).ready(function(){
        const $cityInput = $('#city');
        const $cityId = $('#city_id');
        const $list = $('#cityList');

        // handler to perform ajax search
        const searchCities = debounce(function(){
            const q = $cityInput.val().trim();
            if (q.length < 2) {
                $list.hide();
                return;
            }

            $.ajax({
                url: "{{ route('cities.search') }}",
                data: { q: q },
                method: 'GET',
                success: function(data){
                    let html = '';
                    if (Array.isArray(data) && data.length) {
                        data.forEach(function(city){
                            html += `<li class="list-group-item list-group-item-action" data-id="${city.id}" data-name="${city.name}">${city.name}</li>`;
                        });
                    } else {
                        html = '<li class="list-group-item disabled">No cities found</li>';
                    }
                    $list.html(html).show();
                },
                error: function(){
                    $list.html('<li class="list-group-item disabled">Search failed</li>').show();
                }
            });
        }, 300); // 300ms debounce

        // run search on keyup/input
        $cityInput.on('input', function(){
            // when user types, reset selected city_id (prevents mismatch when user edits)
            $cityId.val('');
            searchCities();
        });

        // click select
        $(document).on('click', '#cityList li[data-id]', function(){
            const id = $(this).data('id');
            const name = $(this).data('name');
            $cityInput.val(name);
            $cityId.val(id);
            $list.hide();
        });

        // hide when clicking outside
        $(document).on('click', function(e){
            if (!$(e.target).closest('#city, #cityList').length) {
                $list.hide();
            }
        });

        // if page loaded with city_id & city name (edit), keep them
        if ($cityId.val() && $cityInput.val()){
            // leave as is
        }
    });
})(jQuery);
</script>
@endpush
