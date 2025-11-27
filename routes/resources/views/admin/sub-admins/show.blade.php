@extends('layouts.admin')

@section('page-title', 'Sub-Admin Details')
@section('page-description', 'View sub-administrator information and permissions')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Profile Information</h5>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        @if($subAdmin->profile_image)
                            <img src="{{ asset('storage/profile_images/' . $subAdmin->profile_image) }}" alt="Profile Image" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                        @else
                            <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                                <span class="text-white h3">{{ strtoupper(substr($subAdmin->name, 0, 1)) }}</span>
                            </div>
                        @endif
                    </div>
                    <h4>{{ $subAdmin->name }}</h4>
                    <p class="text-muted">{{ $subAdmin->email }}</p>
                    @if($subAdmin->phone)
                        <p class="text-muted"><i class="fas fa-phone"></i> {{ $subAdmin->phone }}</p>
                    @endif
                    @if($subAdmin->bio)
                        <p class="mt-3">{{ $subAdmin->bio }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Account Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Role:</strong> <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $subAdmin->role)) }}</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Created:</strong> {{ $subAdmin->created_at ? $subAdmin->created_at->format('M d, Y H:i') : 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Module Permissions</h5>
                </div>
                <div class="card-body">
                    @if($subAdmin->permissions && count($subAdmin->permissions) > 0)
                        <div class="row">
                            @foreach($subAdmin->permissions as $permission)
                                <div class="col-md-4 mb-2">
                                    <span class="badge bg-success">
                                        <i class="fas fa-check"></i> {{ ucfirst(str_replace('_', ' ', $permission)) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">No module permissions assigned.</p>
                    @endif
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.sub-admins.edit', $subAdmin->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Sub-Admin
                    </a>
                    <a href="{{ route('admin.sub-admins.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                    <form action="{{ route('admin.sub-admins.destroy', $subAdmin->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this sub-admin?')">
                            <i class="fas fa-trash"></i> Delete Sub-Admin
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
