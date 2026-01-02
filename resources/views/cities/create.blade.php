
@extends('layouts.app')
@section('title', 'Create City')

@section('content')
    <div class="container">
        <h2>Add City</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('cities.store') }}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">City Name</label>
                <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
            </div>
            <button type="submit" class="btn btn-primary">Add City</button>
        </form>
    </div>
@endsection