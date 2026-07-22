@extends('layouts.mengo')
@section('title', 'Manage Subjects')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 text-mengo fw-bold mb-0">📖 Subjects</h1>
        <a href="{{ route('admin.dashboard') }}" class="text-muted small">← Back to Dashboard</a>
    </div>
    <button class="btn btn-mengo" data-bs-toggle="modal" data-bs-target="#createModal">
        + Add Subject
    </button>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Class Level</th>
                    <th>Topics</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subjects as $subject)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="fw-bold">{{ $subject->name }}</td>
                    <td><span class="badge bg-light text-dark border">{{ $subject->code ?? '—' }}</span></td>
                    <td>{{ $subject->classLevel->name }}</td>
                    <td><span class="badge bg-secondary">{{ $subject->topics_count }}</span></td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary me-1"
                            data-bs-toggle="modal"
                            data-bs-target="#editModal{{ $subject->id }}">Edit</button>
                        <form action="{{ route('admin.subjects.destroy', $subject) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Delete {{ $subject->name }}? All topics and resources under it will also be deleted.')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>

                {{-- Edit Modal --}}
                <div class="modal fade" id="editModal{{ $subject->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ route('admin.subjects.update', $subject) }}" method="POST" class="modal-content">
                            @csrf @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Subject</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Class Level <span class="text-danger">*</span></label>
                                    <select name="class_level_id" class="form-select" required>
                                        @foreach($classLevels as $level)
                                        <option value="{{ $level->id }}" {{ $subject->class_level_id == $level->id ? 'selected' : '' }}>
                                            {{ $level->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Subject Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="{{ $subject->name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Code</label>
                                    <input type="text" name="code" class="form-control" value="{{ $subject->code }}" placeholder="e.g. MTH-S1">
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
                <tr><td colspan="6" class="text-center text-muted py-4">No subjects yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Create Modal --}}
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.subjects.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Add Subject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Class Level <span class="text-danger">*</span></label>
                    <select name="class_level_id" class="form-select" required>
                        <option value="">— Select Class Level —</option>
                        @foreach($classLevels as $level)
                        <option value="{{ $level->id }}">{{ $level->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Subject Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Mathematics" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Code</label>
                    <input type="text" name="code" class="form-control" placeholder="e.g. MTH-S1">
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