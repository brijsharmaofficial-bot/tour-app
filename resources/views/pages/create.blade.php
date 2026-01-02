@extends('layouts.app')

@section('title', 'Create Page')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">Create New Page</h2>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form method="POST" action="{{ route('pages.store') }}">
                @csrf

                {{-- Title --}}
                <div class="mb-3">
                    <label for="title" class="form-label fw-semibold">Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter page title..." required>
                </div>

                {{-- Slug --}}
                <div class="mb-3">
                    <label for="slug" class="form-label fw-semibold">Slug (auto-generated)</label>
                    <input type="text" class="form-control" id="slug" name="slug" placeholder="auto-generated-slug" required>
                </div>

                {{-- Content --}}
                <div class="mb-3">
                    <label for="myeditorinstance" class="form-label fw-semibold">Content</label>
                    <textarea class="form-control" id="myeditorinstance" name="content" rows="10" placeholder="Write your content here..."></textarea>
                </div>

                {{-- Status --}}
                <div class="mb-3">
                    <label for="status" class="form-label fw-semibold">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                    </select>
                </div>

                {{-- Submit --}}
                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-2"></i>Create Page
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')

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


@endpush

@push('styles')
<style>
.ck-editor__editable {
    min-height: 300px;
}
.ck-content {
    font-family: "Inter", sans-serif;
    line-height: 1.6;
}
</style>
@endpush
