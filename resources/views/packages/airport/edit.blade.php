@extends('layouts.app')
@section('title', 'Edit Page')

@section('content')
    <h2 class="mb-4">Edit Page</h2>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('pages.update', $page->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $page->title) }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="slug">Slug</label>
                    <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug', $page->slug) }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="editor">Content</label>
                    <textarea class="form-control" id="editor" name="content">{{ old('content', $page->content) }}</textarea>
                </div>

                <div class="form-group mb-3">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="draft" {{ $page->status === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ $page->status === 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update Page</button>
                <a href="{{ route('pages.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection

