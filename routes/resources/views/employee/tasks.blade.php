    @extends('layouts.employee')

@section('title', 'My Tasks')
@section('page-title', 'My Tasks')
@section('page-description', 'View and manage your assigned tasks')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 text-dark font-weight-bold">My Assigned Tasks</h4>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-lg">
        <div class="card-header bg-white border-bottom py-3">
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" placeholder="Search tasks..." id="searchInput">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="statusFilter">
                        <option value="">All Statuses</option>
                        <option value="Not Started">Not Started</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Completed">Completed</option>
                        <option value="On Hold">On Hold</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="priorityFilter">
                        <option value="">All Priorities</option>
                        <option value="High">High</option>
                        <option value="Medium">Medium</option>
                        <option value="Low">Low</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Task Name</th>
                            <th>Assignment Type</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Progress</th>
                            <th>Due Date</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="taskTable">
                        @forelse($tasks as $task)
                            <tr>
                                <td class="ps-4">
                                    <div>
                                        <strong>{{ $task->task_name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ Str::limit($task->description, 50) }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $task->assigned_team }}</span>
                                    @if($task->assigned_team == 'Team' && $task->teamLead)
                                        <br>
                                        <small class="text-muted">Lead: {{ $task->teamLead->name }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge rounded-pill px-3 py-2 {{ $task->status == 'Completed' ? 'bg-success' : ($task->status == 'In Progress' ? 'bg-primary' : ($task->status == 'On Hold' ? 'bg-warning' : 'bg-secondary')) }}">
                                        {{ $task->status }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge rounded-pill px-3 py-2 {{ $task->priority == 'High' ? 'bg-danger' : ($task->priority == 'Medium' ? 'bg-warning' : 'bg-info') }}">
                                        {{ $task->priority }}
                                    </span>
                                </td>
                                <td>
                                    <div class="progress" style="height: 20px; width: 100px;">
                                        <div class="progress-bar {{ $task->progress == 100 ? 'bg-success' : 'bg-primary' }}"
                                             role="progressbar"
                                             style="width: {{ $task->progress }}%;"
                                             aria-valuenow="{{ $task->progress }}"
                                             aria-valuemin="0"
                                             aria-valuemax="100">
                                            {{ $task->progress }}%
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($task->end_date)
                                        <span class="{{ \Carbon\Carbon::parse($task->end_date)->isPast() && $task->status != 'Completed' ? 'text-danger' : '' }}">
                                            {{ \Carbon\Carbon::parse($task->end_date)->format('M d, Y') }}
                                        </span>
                                        @if(\Carbon\Carbon::parse($task->end_date)->isPast() && $task->status != 'Completed')
                                            <br><small class="text-danger">Overdue</small>
                                        @endif
                                    @else
                                        <span class="text-muted">No due date</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('employee.tasks.show', $task) }}" class="btn btn-sm btn-outline-info rounded-circle mx-1" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($task->assigned_team == 'Team' && auth('employee')->check() && $task->team_lead_id && auth('employee')->user()->id === $task->team_lead_id)
                                            <a href="{{ route('employee.tasks.edit', $task) }}" class="btn btn-sm btn-outline-warning rounded-circle mx-1" title="Edit Task">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        @endif
                                        @if(($task->assigned_team == 'Individual' && auth('employee')->check() && $task->assigned_to == auth('employee')->user()->id) || ($task->assigned_team == 'Team' && auth('employee')->check() && $task->team_lead_id && auth('employee')->user()->id === $task->team_lead_id))
                                        <button type="button" class="btn btn-sm btn-outline-primary rounded-circle mx-1" title="Update Progress"
                                                onclick="openProgressModal({{ $task->id }}, '{{ $task->task_name }}', {{ $task->progress }}, '{{ $task->status }}')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        @endif


                                        
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-tasks fa-3x mb-3 opacity-25"></i>
                                        <p class="mb-3">No tasks assigned to you yet.</p>
                                        <p class="mb-0">Check back later for new assignments.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if($tasks->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $tasks->links('pagination::bootstrap-5') }}
        </div>
    @endif
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
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const priorityFilter = document.getElementById('priorityFilter');
    const tableRows = document.querySelectorAll('#taskTable tr');

    function filterTable() {
        const searchText = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value.toLowerCase();
        const priorityValue = priorityFilter.value.toLowerCase();

        tableRows.forEach(row => {
            const cells = row.querySelectorAll('td');
            if (cells.length === 0) return;

            const taskName = cells[0].textContent.toLowerCase();
            const assignmentType = cells[1].textContent.toLowerCase();
            const status = cells[2].textContent.toLowerCase();
            const priority = cells[3].textContent.toLowerCase();

            const matchesSearch = taskName.includes(searchText) || assignmentType.includes(searchText);
            const matchesStatus = !statusValue || status.includes(statusValue);
            const matchesPriority = !priorityValue || priority.includes(priorityValue);

            row.style.display = matchesSearch && matchesStatus && matchesPriority ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterTable);
    statusFilter.addEventListener('change', filterTable);
    priorityFilter.addEventListener('change', filterTable);
});

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
.table th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}
.table td {
    vertical-align: middle;
}
.btn-outline-info, .btn-outline-primary {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}
.btn-outline-info:hover {
    background-color: #0dcaf0;
    color: white;
}
.btn-outline-primary:hover {
    background-color: #0d6efd;
    color: white;
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
