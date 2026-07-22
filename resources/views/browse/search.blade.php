@extends('layouts.mengo')

@section('title', 'Search – Mengo Library')

@section('content')
<h1 class="h4 text-mengo fw-bold mb-3">Search E-Resources</h1>

<form action="{{ route('search') }}" method="GET" class="mb-4">
    <div class="input-group shadow-sm">
        <input type="text" name="q" class="form-control form-control-lg"
               placeholder="Search by title or description…" value="{{ $query }}">
        <button class="btn btn-mengo btn-lg" type="submit">Search</button>
    </div>
</form>

@if($query)
    @if($results->count())
    <p class="text-muted mb-3">Found <strong>{{ $results->total() }}</strong> result(s) for "<em>{{ $query }}</em>".</p>
    <div class="list-group shadow-sm mb-4">
        @foreach($results as $resource)
        <div class="list-group-item">
            <div class="d-flex justify-content-between align-items-start mb-1">
                <a href="{{ $resource->url }}" target="_blank" class="fw-bold text-decoration-none text-mengo">
                    <i class="fa-solid {{ $resource->typeIcon() }}"></i>
                    {{ $resource->title }}
                </a>
                <span class="badge bg-{{ $resource->typeBadgeClass() }}">{{ $resource->resource_type }}</span>
            </div>
            <small class="text-muted">
                {{ $resource->topic->subject->classLevel->name }} →
                {{ $resource->topic->subject->name }} →
                {{ $resource->topic->title }}
            </small>
            @if($resource->annotation)
            <p class="mb-0 mt-1 small text-secondary">{{ Str::limit($resource->annotation, 160) }}</p>
            @endif
        </div>
        @endforeach
    </div>
    {{ $results->links() }}
    @else
    <div class="alert alert-info">No resources found for "<em>{{ $query }}</em>". Try a different keyword.</div>
    @endif
@endif
@endsection
