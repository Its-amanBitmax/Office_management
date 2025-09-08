@extends('layouts.admin')

@section('title', 'Edit Task')
@section('page-title', 'Edit Task')
@section('page-description', 'Update task details and assignments')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
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

                    <form action="{{ route('tasks.update', $task) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="task_name" class="form-label fw-bold">Task Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('task_name') is-invalid @enderror" id="task_name" name="task_name" value="{{ old('task_name', $task->task_name) }}" required>
                                @error('task_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="assigned_team" class="form-label fw-bold">Assignment Type <span class="text-danger">*</span></label>
                                <select class="form-select @error('assigned_team') is-invalid @enderror" id="assigned_team" name="assigned_team" required>
                                    <option value="">Select Type</option>
                                    <option value="Individual" {{ old('assigned_team', $task->assigned_team) == 'Individual' ? 'selected' : '' }}>Individual</option>
                                    <option value="Team" {{ old('assigned_team', $task->assigned_team) == 'Team' ? 'selected' : '' }}>Team</option>
                                </select>
                                @error('assigned_team')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" required>{{ old('description', $task->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="individual-fields" style="display: {{ old('assigned_team', $task->assigned_team) == 'Individual' ? 'block' : 'none' }};">
                            <div class="mb-3">
                                <label for="assigned_to" class="form-label fw-bold">Assigned To</label>
                                <select class="form-select @error('assigned_to') is-invalid @enderror" id="assigned_to" name="assigned_to">
                                    <option value="">Select Employee</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}" {{ old('assigned_to', $task->assigned_to) == $employee->id ? 'selected' : '' }}>{{ $employee->name }} ({{ $employee->employee_code }})</option>
                                    @endforeach
                                </select>
                                @error('assigned_to')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="team-fields" style="display: {{ old('assigned_team', $task->assigned_team) == 'Team' ? 'block' : 'none' }};">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="team_lead_id" class="form-label fw-bold">Team Lead <span class="text-danger team-lead-required">*</span></label>
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

                                <div class="col-md-6 mb-3">
                                    <label for="team_members" class="form-label fw-bold">Team Members</label>
                                    <select class="form-select @error('team_members') is-invalid @enderror" id="team_members" name="team_members[]" multiple>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}" {{ in_array($employee->id, old('team_members', $task->team_members ?? [])) ? 'selected' : '' }}>{{ $employee->name }} ({{ $employee->employee_code }})</option>
                                        @endforeach
                                    </select>
                                    @error('team_members')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="team_created_by" class="form-label fw-bold">Team Created By</label>
                                <select class="form-select @error('team_created_by') is-invalid @enderror" id="team_created_by" name="team_created_by" required>
                                    <option value="">Select Option</option>
                                    <option value="admin" {{ old('team_created_by', $task->team_created_by ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="team_lead" {{ old('team_created_by', $task->team_created_by ?? '') == 'team_lead' ? 'selected' : '' }}>Team Lead</option>
                                </select>
                                @error('team_created_by')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label fw-bold">Start Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date', \Carbon\Carbon::parse($task->start_date)->format('Y-m-d')) }}" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="end_date" class="form-label fw-bold">End Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date', \Carbon\Carbon::parse($task->end_date)->format('Y-m-d')) }}" required>
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
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
                                <label for="priority" class="form-label fw-bold">Priority <span class="text-danger">*</span></label>
                                <select class="form-select @error('priority') is-invalid @enderror" id="priority" name="priority" required>
                                    <option value="Low" {{ old('priority', $task->priority) == 'Low' ? 'selected' : '' }}>Low</option>
                                    <option value="Medium" {{ old('priority', $task->priority) == 'Medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="High" {{ old('priority', $task->priority) == 'High' ? 'selected' : '' }}>High</option>
                                </select>
                                @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="progress" class="form-label fw-bold">Progress (%)</label>
                            <input type="number" class="form-control @error('progress') is-invalid @enderror" id="progress" name="progress" value="{{ old('progress', $task->progress) }}" min="0" max="100">
                            @error('progress')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-arrow-left me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-save me-2"></i>Update Task
                            </button>
                        </div>

                        @if(old('team_created_by', $task->team_created_by ?? '') == 'admin')
                        <div class="mb-3 team-select-section" style="display: {{ old('assigned_team', $task->assigned_team) == 'Team' ? 'block' : 'none' }};">
                            <label for="selected_team" class="form-label fw-bold">Select Team</label>
                            <select class="form-select @error('selected_team') is-invalid @enderror" id="selected_team" name="selected_team">
                                <option value="">Select Team</option>
                                <option value="Development Team" {{ old('selected_team', $task->selected_team) == 'Development Team' ? 'selected' : '' }}>Development Team</option>
                                <option value="Design Team" {{ old('selected_team', $task->selected_team) == 'Design Team' ? 'selected' : '' }}>Design Team</option>
                                <option value="QA Team" {{ old('selected_team', $task->selected_team) == 'QA Team' ? 'selected' : '' }}>QA Team</option>
                                <option value="Marketing Team" {{ old('selected_team', $task->selected_team) == 'Marketing Team' ? 'selected' : '' }}>Marketing Team</option>
                            </select>
                            @error('selected_team')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @endif
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
    // Initialize Select2 for team members and selected_team
    $('#team_members, #selected_team').select2({
        placeholder: "Select an option",
        allowClear: true,
        width: '100%'
    });

    // Handle assignment type toggle
    const assignedTeam = document.getElementById('assigned_team');
    const individualFields = document.querySelector('.individual-fields');
    const teamFields = document.querySelectorAll('.team-fields');
    const teamSelectSection = document.querySelector('.team-select-section');
    const teamCreatedBy = document.getElementById('team_created_by');

    function toggleTeamSelect() {
        if (teamSelectSection && assignedTeam.value === 'Team' && teamCreatedBy.value === 'admin') {
            teamSelectSection.style.display = 'block';
        } else {
            if (teamSelectSection) teamSelectSection.style.display = 'none';
        }
    }

    function toggleTeamMembers() {
        const teamMembersSelect = document.getElementById('team_members');
        if (teamMembersSelect) {
            if (assignedTeam.value === 'Team' && teamCreatedBy.value === 'team_lead') {
                teamMembersSelect.disabled = true;
                teamMembersSelect.style.opacity = '0.5';
            } else {
                teamMembersSelect.disabled = false;
                teamMembersSelect.style.opacity = '1';
            }
        }
    }

    assignedTeam.addEventListener('change', function() {
        if (this.value === 'Individual') {
            individualFields.style.display = 'block';
            teamFields.forEach(field => field.style.display = 'none');
            if (teamSelectSection) teamSelectSection.style.display = 'none';
            document.getElementById('assigned_to').setAttribute('required', 'required');
            document.getElementById('team_created_by').removeAttribute('required');
            document.getElementById('team_lead_id').removeAttribute('required');
            document.querySelector('.team-lead-required').style.display = 'none';
        } else if (this.value === 'Team') {
            individualFields.style.display = 'none';
            teamFields.forEach(field => field.style.display = 'block');
            toggleTeamSelect();
            document.getElementById('assigned_to').removeAttribute('required');
            document.getElementById('team_created_by').setAttribute('required', 'required');
            document.getElementById('team_lead_id').setAttribute('required', 'required');
            document.querySelector('.team-lead-required').style.display = 'inline';
        } else {
            individualFields.style.display = 'none';
            teamFields.forEach(field => field.style.display = 'none');
            if (teamSelectSection) teamSelectSection.style.display = 'none';
            document.getElementById('assigned_to').removeAttribute('required');
            document.getElementById('team_created_by').removeAttribute('required');
            document.getElementById('team_lead_id').removeAttribute('required');
            document.querySelector('.team-lead-required').style.display = 'none';
        }
    });

    teamCreatedBy.addEventListener('change', function() {
        toggleTeamSelect();
        toggleTeamMembers();
    });

    // Additional handler to show/hide team select section based on team_created_by value
    function handleTeamCreatedByChange() {
        const value = teamCreatedBy.value;
        if (value === 'team_lead') {
            // Enable team members selection
            teamMembers.disabled = false;
            // Hide team select section because team created by is team lead
            if (teamSelectSection) teamSelectSection.style.display = 'none';
        } else if (value === 'admin') {
            // Enable team members selection
            teamMembers.disabled = false;
            // Show team select section if assigned team is Team and created by is admin
            if (assignedTeam.value === 'Team' && teamSelectSection) {
                teamSelectSection.style.display = 'block';
            }
        } else {
            // Default case: enable team members and hide team select section
            teamMembers.disabled = false;
            if (teamSelectSection) teamSelectSection.style.display = 'none';
        }
    }

    teamCreatedBy.addEventListener('change', handleTeamCreatedByChange);
    // Trigger on page load
    handleTeamCreatedByChange();

    // Trigger change on page load
    assignedTeam.dispatchEvent(new Event('change'));
    teamCreatedBy.dispatchEvent(new Event('change'));
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
@endsection