@extends('layouts.mengo')

@section('title', $subject->name . ' Topics')

@section('content')
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('browse.class-level', $subject->classLevel) }}">{{ $subject->classLevel->name }}</a></li>
        <li class="breadcrumb-item active">{{ $subject->name }}</li>
    </ol>
</nav>

<h1 class="h3 text-mengo fw-bold mb-4">{{ $subject->name }} <small class="text-muted fs-6">({{ $subject->code }})</small></h1>

<div class="list-group shadow-sm">
    @forelse($topics as $topic)
    <a href="{{ route('browse.topic', [$subject->classLevel, $subject, $topic]) }}"
       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
        <div>
            <strong>{{ $topic->title }}</strong>
            @if($topic->competency_description)
            <p class="mb-0 text-muted small">{{ Str::limit($topic->competency_description, 120) }}</p>
            @endif
        </div>
        <span class="badge bg-secondary rounded-pill">{{ $topic->verified_resources_count }} resource(s)</span>
    </a>
    @empty
    <div class="list-group-item text-muted">No topics available for this subject yet.</div>
    @endforelse
</div>
@endsection
