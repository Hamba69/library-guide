@extends('layouts.mengo')
@section('title', 'Manage Students')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 text-mengo fw-bold mb-0">👤 Student Accounts</h1>
        <a href="{{ route('admin.dashboard') }}" class="text-muted small">← Back to Dashboard</a>
    </div>
    <button class="btn btn-mengo" data-bs-toggle="modal" data-bs-target="#createModal">
        + Add Student
    </button>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="fw-bold">{{ $student->name }}</td>
                    <td class="text-muted">{{ $student->email }}</td>
                    <td class="text-muted small">{{ $student->created_at->format('d M Y') }}</td>
                    <td>
                        {{-- Reset Password --}}
                        <button class="btn btn-sm btn-outline-secondary me-1"
                            data-bs-toggle="modal"
                            data-bs-target="#resetModal{{ $student->id }}">
                            Reset Password
                        </button>
                        {{-- Delete --}}
                        <form action="{{ route('admin.students.destroy', $student) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Delete account for {{ $student->name }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>

                {{-- Reset Password Modal --}}
                <div class="modal fade" id="resetModal{{ $student->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ route('admin.students.reset-password', $student) }}" method="POST" class="modal-content">
                            @csrf @method('PATCH')
                            <div class="modal-header">
                                <h5 class="modal-title">Reset Password – {{ $student->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">New Password</label>
                                    <input type="password" name="password" class="form-control"
                                           placeholder="Minimum 6 characters" required minlength="6">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-mengo">Reset Password</button>
                            </div>
                        </form>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        No student accounts yet. Add one to get started.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Create Student Modal --}}
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.students.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Add Student Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. John Ssemwogerere" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Email Address <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" placeholder="e.g. john.s@mengo.sc.ug" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control"
                           placeholder="Minimum 6 characters" required minlength="6">
                    <div class="form-text">Share this password with the student directly.</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-mengo">Create Account</button>
            </div>
        </form>
    </div>
</div>
@endsection