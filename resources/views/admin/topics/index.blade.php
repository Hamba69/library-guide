@extends('layouts.mengo')
@section('title', 'Manage Topics')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 text-mengo fw-bold mb-0">📝 Topics</h1>
        <a href="{{ route('admin.dashboard') }}" class="text-muted small">← Back to Dashboard</a>
    </div>
    <button class="btn btn-mengo" data-bs-toggle="modal" data-bs-target="#createModal">
        + Add Topic
    </button>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Subject</th>
                    <th>Class Level</th>
                    <th>Resources</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topics as $topic)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="fw-bold">{{ $topic->title }}</td>
                    <td>{{ $topic->subject->name }}</td>
                    <td><span class="badge bg-light text-dark border">{{ $topic->subject->classLevel->name }}</span></td>
                    <td><span class="badge bg-secondary">{{ $topic->resources_count }}</span></td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary me-1"
                            data-bs-toggle="modal"
                            data-bs-target="#editModal{{ $topic->id }}">Edit</button>
                        <form action="{{ route('admin.topics.destroy', $topic) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Delete this topic and all its resources?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>

                {{-- Edit Modal --}}
                <div class="modal fade" id="editModal{{ $topic->id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <form action="{{ route('admin.topics.update', $topic) }}" method="POST" class="modal-content">
                            @csrf @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Topic</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Subject <span class="text-danger">*</span></label>
                                    <select name="subject_id" class="form-select" required>
                                        @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}" {{ $topic->subject_id == $subject->id ? 'selected' : '' }}>
                                            {{ $subject->classLevel->name }} — {{ $subject->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control" value="{{ $topic->title }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Competency Description</label>
                                    <textarea name="competency_description" class="form-control" rows="4">{{ $topic->competency_description }}</textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-mengo">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No topics yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Create Modal --}}
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('admin.topics.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Add Topic</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Subject <span class="text-danger">*</span></label>
                    <select name="subject_id" class="form-select" required>
                        <option value="">— Select Subject —</option>
                        @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}">
                            {{ $subject->classLevel->name }} — {{ $subject->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. Set Theory" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Competency Description</label>
                    <textarea name="competency_description" class="form-control" rows="4"
                              placeholder="Describe what learners should be able to do by the end of this topic…"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-mengo">Create</button>
            </div>
        </form>
    </div>
</div>
@endsection