@extends('layouts.mengo')
@section('title', 'Admin Dashboard – Mengo Library')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 text-mengo fw-bold mb-0">📋 Librarian Dashboard</h1>
    <span class="text-muted small">Logged in as {{ auth()->user()->name }}</span>
</div>

{{-- Stats Row --}}
<div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 g-3 mb-5">
    @foreach([
        ['label' => 'Class Levels', 'value' => $stats['class_levels'], 'icon' => '🎓', 'route' => 'admin.class-levels'],
        ['label' => 'Subjects',     'value' => $stats['subjects'],     'icon' => '📖', 'route' => 'admin.subjects'],
        ['label' => 'Topics',       'value' => $stats['topics'],       'icon' => '📝', 'route' => 'admin.topics'],
        ['label' => 'Resources',    'value' => $stats['resources'],    'icon' => '🔗', 'route' => 'admin.resources'],
        ['label' => 'Verified',     'value' => $stats['verified'],     'icon' => '✅', 'route' => 'admin.resources'],
        ['label' => 'Students',     'value' => $stats['students'],     'icon' => '👤', 'route' => 'admin.students'],
    ] as $stat)
    <div class="col">
        <a href="{{ route($stat['route']) }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm text-center py-3 h-100">
                <div class="fs-3">{{ $stat['icon'] }}</div>
                <div class="fw-bold fs-4 text-mengo">{{ $stat['value'] }}</div>
                <div class="text-muted small">{{ $stat['label'] }}</div>
            </div>
        </a>
    </div>
    @endforeach
</div>

{{-- Quick Nav --}}
<div class="row g-3 mb-5">
    @foreach([
        ['label' => 'Class Levels', 'route' => 'admin.class-levels', 'icon' => '🎓'],
        ['label' => 'Subjects',     'route' => 'admin.subjects',     'icon' => '📖'],
        ['label' => 'Topics',       'route' => 'admin.topics',       'icon' => '📝'],
        ['label' => 'Resources',    'route' => 'admin.resources',    'icon' => '🔗'],
        ['label' => 'Students',     'route' => 'admin.students',     'icon' => '👤'],
    ] as $link)
    <div class="col-6 col-md-3">
        <a href="{{ route($link['route']) }}" class="btn btn-mengo w-100">
            {{ $link['icon'] }} {{ $link['label'] }}
        </a>
    </div>
    @endforeach
</div>

{{-- Pending Verification Alert --}}
@if($stats['pending'] > 0)
<div class="alert alert-warning d-flex justify-content-between align-items-center mb-4">
    <span>⚠️ <strong>{{ $stats['pending'] }}</strong> resource(s) are awaiting verification and not visible to students.</span>
    <a href="{{ route('admin.resources') }}" class="btn btn-sm btn-warning">Review Now</a>
</div>
@endif

{{-- Recent Resources --}}
<h2 class="h5 text-mengo mb-3">Recently Added Resources</h2>
<div class="table-responsive shadow-sm rounded">
    <table class="table table-hover align-middle mb-0 bg-white">
        <thead class="table-light">
            <tr>
                <th>Title</th>
                <th>Type</th>
                <th>Topic</th>
                <th>Class Level</th>
                <th>Verified</th>
                <th>Added</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentResources as $r)
            <tr>
                <td>
                    <a href="{{ $r->url }}" target="_blank" class="text-decoration-none">
                        {{ Str::limit($r->title, 50) }}
                    </a>
                </td>
                <td><span class="badge bg-{{ $r->typeBadgeClass() }}">{{ $r->resource_type }}</span></td>
                <td>{{ $r->topic->title }}</td>
                <td>{{ $r->topic->subject->classLevel->name }}</td>
                <td>
                    @if($r->is_verified)
                        <span class="badge bg-success">✅ Yes</span>
                    @else
                        <span class="badge bg-secondary">⏳ Pending</span>
                    @endif
                </td>
                <td class="text-muted small">{{ $r->created_at->diffForHumans() }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection