@extends('layouts.mengo')
@section('title', 'Manage Resources')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 text-mengo fw-bold mb-0">🔗 Resources</h1>
        <a href="{{ route('admin.dashboard') }}" class="text-muted small">← Back to Dashboard</a>
    </div>
    <button class="btn btn-mengo" data-bs-toggle="modal" data-bs-target="#createModal">
        + Add Resource
    </button>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Topic</th>
                    <th>Class</th>
                    <th>Verified</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($resources as $resource)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <a href="{{ $resource->url }}" target="_blank" class="text-decoration-none fw-bold text-mengo">
                            {{ Str::limit($resource->title, 45) }}
                        </a>
                        @if($resource->annotation)
                        <p class="mb-0 text-muted" style="font-size:0.75rem">{{ Str::limit($resource->annotation, 60) }}</p>
                        @endif
                    </td>
                    <td><span class="badge bg-{{ $resource->typeBadgeClass() }}">{{ $resource->resource_type }}</span></td>
                    <td class="small">{{ $resource->topic->title }}</td>
                    <td><span class="badge bg-light text-dark border small">{{ $resource->topic->subject->classLevel->name }}</span></td>
                    <td>
                        <form action="{{ route('admin.resources.toggle-verify', $resource) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-sm {{ $resource->is_verified ? 'btn-success' : 'btn-outline-secondary' }}">
                                {{ $resource->is_verified ? '✅ Yes' : '⏳ No' }}
                            </button>
                        </form>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary me-1"
                            data-bs-toggle="modal"
                            data-bs-target="#editModal{{ $resource->id }}">Edit</button>
                        <form action="{{ route('admin.resources.destroy', $resource) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Delete this resource?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>

                {{-- Edit Modal --}}
                <div class="modal fade" id="editModal{{ $resource->id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <form action="{{ route('admin.resources.update', $resource) }}" method="POST" class="modal-content">
                            @csrf @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Resource</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Topic <span class="text-danger">*</span></label>
                                    <select name="topic_id" class="form-select" required>
                                        @foreach($topics as $topic)
                                        <option value="{{ $topic->id }}" {{ $resource->topic_id == $topic->id ? 'selected' : '' }}>
                                            {{ $topic->subject->name }} — {{ $topic->title }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 mb-3">
                                        <label class="form-label fw-bold">Title <span class="text-danger">*</span></label>
                                        <input type="text" name="title" class="form-control" value="{{ $resource->title }}" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">Type <span class="text-danger">*</span></label>
                                        <select name="resource_type" class="form-select" required>
                                            @foreach(['Link','PDF','Video','Simulation'] as $type)
                                            <option value="{{ $type }}" {{ $resource->resource_type === $type ? 'selected' : '' }}>{{ $type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">URL <span class="text-danger">*</span></label>
                                    <input type="url" name="url" class="form-control" value="{{ $resource->url }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Annotation (Librarian Notes)</label>
                                    <textarea name="annotation" class="form-control" rows="3">{{ $resource->annotation }}</textarea>
                                </div>
                                <div class="form-check">
                                    <input type="hidden" name="is_verified" value="0">
                                    <input class="form-check-input" type="checkbox" name="is_verified" value="1" id="verified{{ $resource->id }}"
                                           {{ $resource->is_verified ? 'checked' : '' }}>
                                    <label class="form-check-label" for="verified{{ $resource->id }}">
                                        Mark as Verified (visible to students)
                                    </label>
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
                <tr><td colspan="7" class="text-center text-muted py-4">No resources yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Pagination --}}
<div class="mt-3">{{ $resources->links() }}</div>

{{-- Create Modal --}}
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('admin.resources.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Add Resource</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Topic <span class="text-danger">*</span></label>
                    <select name="topic_id" class="form-select" required>
                        <option value="">— Select Topic —</option>
                        @foreach($topics as $topic)
                        <option value="{{ $topic->id }}">
                            {{ $topic->subject->name }} — {{ $topic->title }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label fw-bold">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. Introduction to Sets – Khan Academy" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Type <span class="text-danger">*</span></label>
                        <select name="resource_type" class="form-select" required>
                            <option value="">— Type —</option>
                            @foreach(['Link','PDF','Video','Simulation'] as $type)
                            <option value="{{ $type }}">{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">URL <span class="text-danger">*</span></label>
                    <input type="url" name="url" class="form-control" placeholder="https://…" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Annotation (Librarian Notes)</label>
                    <textarea name="annotation" class="form-control" rows="3"
                              placeholder="Briefly describe this resource and why it is useful for students…"></textarea>
                </div>
                <div class="form-check">
                    <input type="hidden" name="is_verified" value="0">
                    <input class="form-check-input" type="checkbox" name="is_verified" value="1" id="createVerified">
                    <label class="form-check-label" for="createVerified">
                        Mark as Verified (visible to students immediately)
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-mengo">Add Resource</button>
            </div>
        </form>
    </div>
</div>
@endsection