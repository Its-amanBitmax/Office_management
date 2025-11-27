@extends('layouts.employee')

@section('title', 'Edit Task')
@section('page-title', 'Edit Task')
@section('page-description', 'Update task details and assignments')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            @if($task->assigned_team == 'Team' && auth()->check() && $task->team_lead_id && $task->team_lead_id != auth()->user()->id)
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-header bg-white border-bottom py-3">
                        <h4 class="card-title mb-0 text-dark font-weight-bold">Access Denied</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="alert alert-warning" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            You do not have permission to edit this team task. Only the team leader can edit team tasks.
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('employee.tasks') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-arrow-left me-2"></i>Back to Tasks
                            </a>
                        </div>
                    </div>
                </div>
            @elseif($task->assigned_team == 'Individual' && auth()->check() && $task->assigned_to && $task->assigned_to != auth()->user()->id)
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-header bg-white border-bottom py-3">
                        <h4 class="card-title mb-0 text-dark font-weight-bold">Access Denied</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="alert alert-warning" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            You do not have permission to edit this individual task. Only the assigned employee can edit individual tasks.
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('employee.tasks') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-arrow-left me-2"></i>Back to Tasks
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-header bg-white border-bottom py-3">
                        <h4 class="card-title mb-0 text-dark font-weight-bold">Edit Task</h4>
                    </div>
                    <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('employee.tasks.update', $task) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Hidden fields for required data -->
                        <input type="hidden" name="task_name" value="{{ $task->task_name }}">
                        <input type="hidden" name="description" value="{{ $task->description }}">
                        <input type="hidden" name="assigned_to" value="{{ $task->assigned_to }}">
                        <input type="hidden" name="start_date" value="{{ \Carbon\Carbon::parse($task->start_date)->format('Y-m-d') }}">
                        <input type="hidden" name="end_date" value="{{ \Carbon\Carbon::parse($task->end_date)->format('Y-m-d') }}">
                        <input type="hidden" name="priority" value="{{ $task->priority }}">

                        <!-- Assignment Type (visible for team lead) -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="assigned_team" class="form-label fw-bold">Assignment Type <span class="text-danger">*</span></label>
                                <select class="form-select @error('assigned_team') is-invalid @enderror" id="assigned_team" name="assigned_team" required {{ (auth()->check() && $task->team_lead_id && $task->team_lead_id != auth()->user()->id) ? 'disabled' : '' }}>
                                    <option value="Individual" {{ old('assigned_team', $task->assigned_team) == 'Individual' ? 'selected' : '' }}>Individual</option>
                                    <option value="Team" {{ old('assigned_team', $task->assigned_team) == 'Team' ? 'selected' : '' }}>Team</option>
                                </select>
                                @error('assigned_team')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if(auth()->check() && $task->team_lead_id && $task->team_lead_id != auth()->user()->id)
                                    <small class="form-text text-muted">Only team lead can change assignment type.</small>
                                @endif
                            </div>
                        </div>

                        <div class="team-fields" style="display: {{ old('assigned_team', $task->assigned_team) == 'Team' ? 'block' : 'none' }};">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="team_lead_id" class="form-label fw-bold">Team Lead</label>
                                <select class="form-select @error('team_lead_id') is-invalid @enderror" id="team_lead_id" name="team_lead_id">
                                    <option value="">Select Team Lead</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}" {{ old('team_lead_id', $task->team_lead_id) == $employee->id ? 'selected' : '' }}>{{ $employee->name }} ({{ $employee->employee_code }})</option>
                                    @endforeach
                                </select>
                                @error('team_lead_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="team_members" class="form-label fw-bold">Team Members</label>
                                <select class="form-select @error('team_members') is-invalid @enderror" id="team_members" name="team_members[]" multiple>
                                    @foreach($employees as $employee)
                                        @if($employee->id != $task->team_lead_id)
                                            <option value="{{ $employee->id }}" {{ in_array($employee->id, old('team_members', $task->team_members ?? [])) ? 'selected' : '' }}>{{ $employee->name }} ({{ $employee->employee_code }})</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('team_members')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="Not Started" {{ old('status', $task->status) == 'Not Started' ? 'selected' : '' }}>Not Started</option>
                                        <option value="In Progress" {{ old('status', $task->status) == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="Completed" {{ old('status', $task->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="On Hold" {{ old('status', $task->status) == 'On Hold' ? 'selected' : '' }}>On Hold</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="progress" class="form-label fw-bold">Progress (%)</label>
                                    <input type="number" class="form-control @error('progress') is-invalid @enderror" id="progress" name="progress" value="{{ old('progress', $task->progress) }}" min="0" max="100">
                                    @error('progress')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>



                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('employee.tasks') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-arrow-left me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-save me-2"></i>Update Task
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Select2 for team members
    $('#team_members').select2({
        placeholder: "Select team members",
        allowClear: true,
        width: '100%'
    });

    // Handle team fields display
    const assignedTeam = document.getElementById('assigned_team');
    const teamFields = document.querySelectorAll('.team-fields');

    assignedTeam.addEventListener('change', function() {
        if (this.value === 'Team') {
            teamFields.forEach(field => field.style.display = 'block');
        } else {
            teamFields.forEach(field => field.style.display = 'none');
        }
    });

    // Trigger change on page load
    assignedTeam.dispatchEvent(new Event('change'));
});
</script>

<style>
.card {
    transition: all 0.3s ease;
}
.card:hover {
    box-shadow: 0 8px 24px rgba(0,0,0,0.1) !important;
}
.form-label {
    font-size: 0.9rem;
    color: #333;
}
.form-control, .form-select {
    border-radius: 8px;
    transition: all 0.2s ease;
}
.form-control:focus, .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}
.btn {
    border-radius: 8px;
    padding: 0.5rem 1rem;
}
.select2-container--default .select2-selection--multiple {
    border-radius: 8px;
    border: 1px solid #ced4da;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #0d6efd;
    color: white;
    border-radius: 4px;
}
</style>
            @endif
@endsection
