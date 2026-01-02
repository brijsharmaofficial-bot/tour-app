@extends('layouts.app')
@section('title', 'All Pages')

@section('content')
    <h2 class="mb-4">All Pages</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3 text-end">
        <a href="{{ route('pages.create') }}" class="btn btn-primary">+ Create New Page</a>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pages as $page)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $page->title }}</td>
                            <td>{{ $page->slug }}</td>
                            <td><span class="badge bg-{{ $page->status === 'published' ? 'success' : 'secondary' }}">{{ ucfirst($page->status) }}</span></td>
                            <td>{{ $page->created_at->format('d M Y') }}</td>
                            <td>
                                <!-- <a href="{{ route('pages.show', $page->id) }}" class="btn btn-sm btn-info">View</a> -->
                                <a href="{{ route('pages.edit', $page->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('pages.destroy', $page->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure to delete this page?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center">No pages found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
