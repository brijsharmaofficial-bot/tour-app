
@extends('layouts.app')
@section('title', 'Create City')

@section('content')
    <div class="container">
        <h2>Edit City</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('cities.update', $city->id) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">City Name</label>
                <input type="text" name="name" id="name" class="form-control" required value="{{ old('name', $city->name) }}">
            </div>
            <button type="submit" class="btn btn-primary">Update City</button>
            <a href="{{ route('cities.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
    @endsection