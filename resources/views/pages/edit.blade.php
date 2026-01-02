@extends('layouts.app')
@section('title', 'Edit Page')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">Edit Page</h2>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form method="POST" action="{{ route('pages.update', $page->id) }}">
                @csrf
                @method('PUT')

                {{-- Title --}}
                <div class="mb-3">
                    <label for="title" class="form-label fw-semibold">Title</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="title" 
                        name="title" 
                        value="{{ old('title', $page->title) }}" 
                        required
                    >
                </div>

                {{-- Slug --}}
                <div class="mb-3">
                    <label for="slug" class="form-label fw-semibold">Slug</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="slug" 
                        name="slug" 
                        value="{{ old('slug', $page->slug) }}" 
                        required
                    >
                </div>

                {{-- Content --}}
                <div class="mb-3">
                    <label for="myeditorinstance" class="form-label fw-semibold">Content</label>
                    <textarea 
                        class="form-control" 
                        id="myeditorinstance" 
                        name="content" 
                        rows="10"
                    >{{ old('content', $page->content) }}</textarea>
                </div>

                {{-- Status --}}
                <div class="mb-3">
                    <label for="status" class="form-label fw-semibold">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="draft" {{ $page->status === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ $page->status === 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                </div>

                {{-- Buttons --}}
                <div class="text-end">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="fas fa-save me-2"></i>Update Page
                    </button>
                    <a href="{{ route('pages.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.tiny.cloud/1/vg6bhpvsuxcylacj1u2uqfvzqy91vuoicsg05tsh55g27i8a/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
<script>
  tinymce.init({
    selector: 'textarea#myeditorinstance', // Replace this CSS selector to match the placeholder element for TinyMCE
    plugins: 'code table lists',
    toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
  });
</script>
@endpush
