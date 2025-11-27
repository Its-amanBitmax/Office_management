@extends('layouts.employee')

@section('title', 'Task Details')
@section('page-title', 'Task Details')
@section('page-description', 'View detailed information about your assigned task')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-white border-bottom py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-dark font-weight-bold">{{ $task->task_name }}</h5>
                        <a href="{{ route('employee.tasks') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left me-2"></i>Back to Tasks
                        </a>
                        @if($task->team_lead_id == auth('employee')->id())
                            <a href="{{ route('employee.tasks.edit', $task) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit me-2"></i>Edit Task
                            </a>
                        @endif
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-4">
                                <h6 class="text-muted mb-2">Description</h6>
                                <p class="mb-0">{{ $task->description }}</p>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-2">Assignment Type</h6>
                                    <span class="badge bg-info fs-6">{{ $task->assigned_team }}</span>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-2">Priority</h6>
                                    <span class="badge {{ $task->priority == 'High' ? 'bg-danger' : ($task->priority == 'Medium' ? 'bg-warning' : 'bg-info') }} fs-6">
                                        {{ $task->priority }}
                                    </span>
                                </div>
                            </div>

                            @if($task->assigned_team == 'Team')
                                <div class="mb-4">
                                    <h6 class="text-muted mb-2">Team Information</h6>
                                    @if($task->teamLead)
                                        <p class="mb-1"><strong>Team Lead:</strong> {{ $task->teamLead->name }}</p>
                                    @endif
                                    @if($task->team_members)
                                        <p class="mb-0"><strong>Team Members:</strong>
                                            @foreach($task->teamMembers() as $member)
                                                <span class="badge bg-light text-dark me-1">{{ $member->name }}</span>
                                            @endforeach
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="col-md-4">
                            <div class="card border-0 bg-light">
                                <div class="card-body">
                                    <h6 class="text-muted mb-3">Task Status</h6>

                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="fw-medium">Progress</span>
                                            <span class="badge bg-primary">{{ $task->progress }}%</span>
                                        </div>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar {{ $task->progress == 100 ? 'bg-success' : 'bg-primary' }}"
                                                 role="progressbar"
                                                 style="width: {{ $task->progress }}%;"
                                                 aria-valuenow="{{ $task->progress }}"
                                                 aria-valuemin="0"
                                                 aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <span class="fw-medium">Status:</span>
                                        <span class="badge {{ $task->status == 'Completed' ? 'bg-success' : ($task->status == 'In Progress' ? 'bg-primary' : ($task->status == 'On Hold' ? 'bg-warning' : 'bg-secondary')) }} ms-2">
                                            {{ $task->status }}
                                        </span>
                                    </div>

                                    @if(($task->assigned_team == 'Individual' && $task->assigned_to == auth('employee')->id()) || ($task->assigned_team == 'Team' && $task->team_lead_id == auth('employee')->id()))
                                        <button type="button" class="btn btn-primary btn-sm w-100"
                                                onclick="openProgressModal({{ $task->id }}, '{{ $task->task_name }}', {{ $task->progress }}, '{{ $task->status }}')">
                                            <i class="fas fa-edit me-2"></i>Update Progress
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <div class="card border-0 bg-light mt-3">
                                <div class="card-body">
                                    <h6 class="text-muted mb-3">Timeline</h6>

                                    <div class="mb-2">
                                        <small class="text-muted">Start Date</small>
                                        <p class="mb-1 fw-medium">
                                            @if($task->start_date)
                                                {{ \Carbon\Carbon::parse($task->start_date)->format('M d, Y') }}
                                            @else
                                                Not set
                                            @endif
                                        </p>
                                    </div>

                                    <div class="mb-0">
                                        <small class="text-muted">End Date</small>
                                        <p class="mb-0 fw-medium">
                                            @if($task->end_date)
                                                <span class="{{ \Carbon\Carbon::parse($task->end_date)->isPast() && $task->status != 'Completed' ? 'text-danger' : '' }}">
                                                    {{ \Carbon\Carbon::parse($task->end_date)->format('M d, Y') }}
                                                </span>
                                                @if(\Carbon\Carbon::parse($task->end_date)->isPast() && $task->status != 'Completed')
                                                    <br><small class="text-danger">Overdue</small>
                                                @endif
                                            @else
                                                Not set
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Progress Update Modal -->
<div class="modal fade" id="progressModal" tabindex="-1" aria-labelledby="progressModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="progressModalLabel">Update Task Progress</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="progressForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="progress" class="form-label">Progress (%)</label>
                        <input type="range" class="form-range" id="progress" name="progress" min="0" max="100" step="5">
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">0%</small>
                            <span id="progressValue" class="fw-bold">50%</span>
                            <small class="text-muted">100%</small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="Not Started">Not Started</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Completed">Completed</option>
                            <option value="On Hold">On Hold</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Progress</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openProgressModal(taskId, taskName, currentProgress, currentStatus) {
    document.getElementById('progressModalLabel').textContent = `Update Progress: ${taskName}`;
    document.getElementById('progressForm').action = `/employee/tasks/${taskId}/progress`;
    document.getElementById('progress').value = currentProgress;
    document.getElementById('progressValue').textContent = currentProgress + '%';
    document.getElementById('status').value = currentStatus;

    const progressModal = new bootstrap.Modal(document.getElementById('progressModal'));
    progressModal.show();
}

// Update progress value display
document.getElementById('progress').addEventListener('input', function() {
    document.getElementById('progressValue').textContent = this.value + '%';
});
</script>

<style>
.card {
    transition: all 0.3s ease;
}
.card:hover {
    box-shadow: 0 8px 24px rgba(0,0,0,0.1) !important;
}
.badge {
    font-size: 0.9rem;
    font-weight: 500;
}
.progress {
    background-color: #e9ecef;
    border-radius: 10px;
}
.progress-bar {
    transition: width 0.3s ease;
}
</style>
@endsection
