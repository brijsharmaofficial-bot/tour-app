@extends('layouts.app')
@section('title', 'Create Page')

@section('content')
    <h2 class="mb-4">Create New Page</h2>
    <div class="card">
        <div class="card-body">
            <p>Use the form below to create a new page.</p>

            <form method="POST" action="{{ route('pages.store') }}">
                @csrf
                <div class="form-group  mb-3">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="form-group mb-3">
                    <label for="slug">Slug</label>
                    <input type="text" class="form-control" id="slug" name="slug" required>
                </div>
                <div class="form-group mb-3">
                    <label for="editor">Content</label>
                    <textarea class="form-control" id="editor" name="content" ></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Create Page</button>
            </form>
        </div>
    </div>

@endsection
