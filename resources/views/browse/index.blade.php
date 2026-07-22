@extends('layouts.mengo')

@section('title', 'Browse E-Resources – Mengo Senior School Library')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h1 class="h3 text-mengo fw-bold">📚 New Curriculum E-Resources</h1>
        <p class="text-muted">Browse digital learning resources organised by class level, subject and topic.</p>
    </div>
</div>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
    @forelse($classLevels as $level)
    <div class="col">
        <a href="{{ route('browse.class-level', $level) }}" class="text-decoration-none">
            <div class="card h-100 resource-card border-0 shadow-sm">
                <div class="card-body text-center py-4">
                    <div class="display-5 mb-2">🎓</div>
                    <h5 class="card-title fw-bold text-mengo">{{ $level->name }}</h5>
                    <p class="card-text text-muted small">{{ $level->subjects_count }} subject(s)</p>
                </div>
                <div class="card-footer bg-transparent text-center">
                    <span class="btn btn-sm btn-mengo">Browse Subjects →</span>
                </div>
            </div>
        </a>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info">No class levels found. Please check back soon.</div>
    </div>
    @endforelse
</div>
@endsection
