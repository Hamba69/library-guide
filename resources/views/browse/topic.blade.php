@extends('layouts.mengo')

@section('title', $topic->title . ' – Resources')

@section('content')
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('browse.class-level', $topic->subject->classLevel) }}">{{ $topic->subject->classLevel->name }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('browse.subject', [$topic->subject->classLevel, $topic->subject]) }}">{{ $topic->subject->name }}</a></li>
        <li class="breadcrumb-item active">{{ $topic->title }}</li>
    </ol>
</nav>

<h1 class="h3 text-mengo fw-bold mb-1">{{ $topic->title }}</h1>
@if($topic->competency_description)
<div class="alert alert-light border-start border-4 border-success mb-4">
    <strong class="small text-muted text-uppercase">Learning Competency</strong>
    <p class="mb-0">{{ $topic->competency_description }}</p>
</div>
@endif

<div class="row row-cols-1 row-cols-md-2 g-4">
    @forelse($resources as $resource)
    <div class="col">
        <div class="card h-100 resource-card border-0 shadow-sm">
            <div class="card-header bg-white d-flex align-items-center gap-2">
                <span class="badge bg-{{ $resource->typeBadgeClass() }}">
                    <i class="fa-solid {{ $resource->typeIcon() }}"></i>
                    {{ $resource->resource_type }}
                </span>
                @if($resource->is_verified)
                <span class="badge bg-success ms-auto"><i class="fa-solid fa-check-circle"></i> Verified</span>
                @endif
            </div>
            <div class="card-body">
                <h6 class="card-title fw-bold">{{ $resource->title }}</h6>
                @if($resource->annotation)
                <p class="card-text text-muted small">{{ $resource->annotation }}</p>
                @endif
            </div>
            <div class="card-footer bg-transparent">
                <a href="{{ $resource->url }}" target="_blank" rel="noopener noreferrer"
                   class="btn btn-sm btn-mengo">
                    <i class="fa-solid fa-external-link-alt"></i> Open Resource
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-warning">No verified resources have been added for this topic yet. Check back later.</div>
    </div>
    @endforelse
</div>
@endsection
