@extends('layouts.admin')

@section('title', 'Activities')
@section('page-title', 'Activities')
@section('page-description', 'Manage and participate in various activities')

@section('content')
<div class="container-fluid">
    {{-- <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('activities.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Create New Activity
            </a>
        </div>
    </div> --}}

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Static Activity Cards -->
    <div class="row mb-5">
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-question-circle fa-3x text-primary"></i>
                    </div>
                    <h5 class="card-title">QnA with Points</h5>
                    <p class="card-text">Participate in Q&A sessions and earn points for correct answers.</p>
                    <form action="{{ route('activities.create') }}" method="GET" id="qnaCreateForm">
                        <input type="hidden" name="title" value="QnA with Points" />
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Create Activity
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Add more activity cards here as needed -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-plus-circle fa-3x text-secondary"></i>
                    </div>
                    <h5 class="card-title">Coming Soon</h5>
                    <p class="card-text">More activities will be available soon.</p>
                    <button class="btn btn-secondary" disabled>
                        <i class="fas fa-clock"></i> Coming Soon
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Dynamic Activities Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">All Activities</h5>
                </div>
                <div class="card-body">
                    @if($activities->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Scheduled At</th>
                                        <th>Created At</th>
                                        <th>Members</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($activities as $activity)
                                        <tr>
                                            <td>{{ $activity->id }}</td>
                                            <td>{{ $activity->title }}</td>
                                            <td>{{ Str::limit($activity->description, 50) }}</td>
                                            <td>
                                                <span class="badge bg-{{ $activity->status == 'active' ? 'success' : ($activity->status == 'completed' ? 'secondary' : 'warning') }}">
                                                    {{ ucfirst($activity->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $activity->schedule_at ? $activity->schedule_at->format('M d, Y H:i') : 'N/A' }}</td>
                                            <td>{{ $activity->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="tooltip" data-bs-html="true" title="@php
                                                    $names = $activity->employees->pluck('name')->toArray();
                                                    echo implode('<br>', $names);
                                                @endphp">
                                                    View
                                                </button>
                                            </td>
                                            <td>
                                                <a href="{{ route('activities.show', $activity) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('activities.edit', $activity) }}" class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('activities.destroy', $activity) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this activity?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5>No Activities Found</h5>
                            <p class="text-muted">Start by creating your first activity.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
</script>
@endsection
