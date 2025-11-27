@extends('layouts.employee')

@section('title', 'My Activities')
@section('page-title', 'My Activities')
@section('page-description', 'View your assigned activities')

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($activities->count() > 0)
        <div class="row">
            @foreach($activities as $activity)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="card-title">{{ $activity->title }}</h6>
                            <p class="card-text">{{ Str::limit($activity->description, 100) }}</p>
                            <div class="mb-2">
                                <small class="text-muted">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    @if($activity->schedule_at)
                                        {{ $activity->schedule_at->format('M d, Y H:i') }}
                                    @else
                                        Not scheduled
                                    @endif
                                </small>
                            </div>
                            <div class="mb-2">
                                <span class="badge bg-{{ $activity->status == 'active' ? 'success' : ($activity->status == 'completed' ? 'secondary' : 'warning') }}">
                                    {{ ucfirst($activity->status) }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-users me-1"></i>
                                    {{ $activity->employees->count() }} member{{ $activity->employees->count() != 1 ? 's' : '' }}
                                </small>
                                @if($activity->status != 'completed')
                                    @if(in_array($activity->id, $submittedActivities))
                                        <form action="{{ route('employee.activities.start', $activity) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye me-1"></i>View
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('employee.activities.start', $activity) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fas fa-play me-1"></i>Start
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <span class="text-success">
                                        <i class="fas fa-check me-1"></i>Completed
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($activities->hasPages())
            <div class="d-flex justify-content-center">
                {{ $activities->links() }}
            </div>
        @endif
    @else
        <div class="text-center py-4">
            <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
            <h5>No Activities Found</h5>
            <p class="text-muted">You have no assigned activities at the moment.</p>
        </div>
    @endif
</div>

<script>
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
</script>
@endsection
