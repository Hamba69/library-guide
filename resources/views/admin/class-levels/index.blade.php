@extends('layouts.mengo')
@section('title', 'Manage Class Levels')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 text-mengo fw-bold mb-0">🎓 Class Levels</h1>
        <a href="{{ route('admin.dashboard') }}" class="text-muted small">← Back to Dashboard</a>
    </div>
    <button class="btn btn-mengo" data-bs-toggle="modal" data-bs-target="#createModal">
        + Add Class Level
    </button>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Subjects</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($classLevels as $level)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="fw-bold">{{ $level->name }}</td>
                    <td class="text-muted small">{{ Str::limit($level->description, 80) }}</td>
                    <td><span class="badge bg-secondary">{{ $level->subjects_count }}</span></td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary me-1"
                            data-bs-toggle="modal"
                            data-bs-target="#editModal{{ $level->id }}">Edit</button>
                        <form action="{{ route('admin.class-levels.destroy', $level) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Delete {{ $level->name }}? This will also delete all its subjects, topics and resources.')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>

                {{-- Edit Modal --}}
                <div class="modal fade" id="editModal{{ $level->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ route('admin.class-levels.update', $level) }}" method="POST" class="modal-content">
                            @csrf @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Class Level</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ $level->name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Description</label>
                                    <textarea name="description" class="form-control" rows="3">{{ $level->description }}</textarea>
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
                <tr><td colspan="5" class="text-center text-muted py-4">No class levels yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Create Modal --}}
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.class-levels.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Add Class Level</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Senior One" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Description</label>
                    <textarea name="description" class="form-control" rows="3"
                              placeholder="Brief description of this class level…"></textarea>
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