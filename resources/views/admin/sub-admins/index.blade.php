@extends('layouts.admin')

@section('page-title', 'Manage Sub-Admins')
@section('page-description', 'List of all sub-administrators')

@section('content')
<div class="content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Sub-Admins</h2>
            <p class="text-muted">Manage sub-administrators and their permissions</p>
        </div>
        <a href="{{ route('admin.sub-admins.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create Sub-Admin
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Permissions</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subAdmins as $subAdmin)
                            <tr>
                                <td>{{ $subAdmins->firstItem() + $loop->index }}</td>
                                <td>{{ $subAdmin->name }}</td>
                                <td>{{ $subAdmin->email }}</td>
                                <td>{{ $subAdmin->phone ?? 'N/A' }}</td>
                                <td>
                                    @if($subAdmin->permissions)
                                        <span class="badge bg-info">{{ count($subAdmin->permissions) }} modules</span>
                                    @else
                                        <span class="badge bg-secondary">No permissions</span>
                                    @endif
                                </td>
                                <td>{{ $subAdmin->created_at ? $subAdmin->created_at->format('M d, Y') : 'N/A' }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.sub-admins.show', $subAdmin->id) }}" class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.sub-admins.edit', $subAdmin->id) }}" class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.sub-admins.destroy', $subAdmin->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this sub-admin?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-users fa-3x mb-3"></i>
                                        <p>No sub-admins found.</p>
                                        <a href="{{ route('admin.sub-admins.create') }}" class="btn btn-primary">Create First Sub-Admin</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($subAdmins->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $subAdmins->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
