@extends('layouts.app')
@section('title', 'Create Page')

@section('content')
     <div class="container">
        <h2>City List</h2>

        <a href="{{ route('cities.create') }}" class="btn btn-success mb-3">Add New City</a>

        <table class="table table-bordered" id="citydatatable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>City Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cities as $city)
                    <tr>
                        <td>{{ $city->id }}</td>
                        <td>{{ $city->name }}</td>
                        
                        <td>
                            <a href="{{ route('cities.edit', $city->id) }}" class="btn btn-sm btn-primary">Edit</a>

                            <form action="{{ route('cities.destroy', $city->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this city?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
