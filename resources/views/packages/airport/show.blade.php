@extends('layouts.app')
@section('title', $page->title)

@section('content')
    <h2 class="mb-3">{{ $page->title }}</h2>
    <p><strong>Slug:</strong> {{ $page->slug }}</p>
    <p><strong>Status:</strong> <span class="badge bg-{{ $page->status === 'published' ? 'success' : 'secondary' }}">{{ ucfirst($page->status) }}</span></p>
    <hr>

    <div class="mb-4">{!! $page->content !!}</div>

    <a href="{{ route('pages.edit', $page->id) }}" class="btn btn-warning">Edit Page</a>
    <a href="{{ route('pages.index') }}" class="btn btn-secondary">Back to List</a>
@endsection
