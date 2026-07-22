@extends('layouts.mengo')

@section('title', $classLevel->name . ' – Subjects')

@section('content')
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
        <li class="breadcrumb-item active">{{ $classLevel->name }}</li>
    </ol>
</nav>

<h1 class="h3 text-mengo fw-bold mb-1">{{ $classLevel->name }}</h1>
<p class="text-muted mb-4">{{ $classLevel->description }}</p>

<div class="row row-cols-1 row-cols-md-3 g-4">
    @forelse($subjects as $subject)
    <div class="col">
        <a href="{{ route('browse.subject', [$classLevel, $subject]) }}" class="text-decoration-none">
            <div class="card h-100 resource-card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-bold text-mengo">{{ $subject->name }}</h5>
                    <p class="text-muted small mb-0">{{ $subject->code }} &bull; {{ $subject->topics_count }} topic(s)</p>
                </div>
                <div class="card-footer bg-transparent">
                    <span class="btn btn-sm btn-mengo">View Topics →</span>
                </div>
            </div>
        </a>
    </div>
    @empty
    <div class="col-12"><div class="alert alert-info">No subjects available yet.</div></div>
    @endforelse
</div>
@endsection
