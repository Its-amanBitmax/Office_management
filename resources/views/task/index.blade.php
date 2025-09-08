@extends('layouts.admin')

@section('title', 'Tasks')
@section('page-title', 'Tasks Management')
@section('page-description', 'Manage tasks, assignments, and progress')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 text-dark font-weight-bold">Tasks List</h4>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm shadow-sm">
            <i class="fas fa-plus me-2"></i>Create New Task
        </a>
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
                        <option value="completed">Completed</option>
                        <option value="in progress">In Progress</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="priorityFilter">
                        <option value="">All Priorities</option>
                        <option value="high">High</option>
                        <option value="medium">Medium</option>
                        <option value="low">Low</option>
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
                            <th>Assigned To</th>
                            <th>Team</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Progress</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="taskTable">
                        @forelse($tasks as $task)
                            <tr>
                                <td class="ps-4">{{ $task->task_name }}</td>
                                <td>
                                    @if($task->assigned_team == 'Individual')
                                        {{ $task->assignedEmployee ? $task->assignedEmployee->name : 'N/A' }}
                                    @else
                                        Team Task
                                    @endif
                                </td>
                                <td>{{ $task->assigned_team }}</td>
                                <td>
                                    <span class="badge rounded-pill px-3 py-2 {{ $task->status == 'Completed' ? 'bg-success' : ($task->status == 'In Progress' ? 'bg-primary' : 'bg-secondary') }}">
                                        {{ $task->status }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge rounded-pill px-3 py-2 {{ $task->priority == 'High' ? 'bg-danger' : ($task->priority == 'Medium' ? 'bg-warning' : 'bg-info') }}">
                                        {{ $task->priority }}
                                    </span>
                                </td>
                                <td>
                                    <div class="progress" style="height: 20px;">
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
                                <td class="text-end pe-4">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('tasks.show', $task) }}" class="btn btn-sm btn-outline-info rounded-circle mx-1" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-warning rounded-circle mx-1" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this task?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle mx-1" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-tasks fa-3x mb-3 opacity-25"></i>
                                        <p class="mb-3">No tasks found.</p>
                                        <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm shadow-sm">
                                            <i class="fas fa-plus me-2"></i>Create First Task
                                        </a>
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
            const assignedTo = cells[1].textContent.toLowerCase();
            const team = cells[2].textContent.toLowerCase();
            const status = cells[3].textContent.toLowerCase();
            const priority = cells[4].textContent.toLowerCase();

            const matchesSearch = taskName.includes(searchText) || 
                                assignedTo.includes(searchText) || 
                                team.includes(searchText);
            
            const matchesStatus = !statusValue || status.includes(statusValue);
            const matchesPriority = !priorityValue || priority.includes(priorityValue);

            row.style.display = matchesSearch && matchesStatus && matchesPriority ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterTable);
    statusFilter.addEventListener('change', filterTable);
    priorityFilter.addEventListener('change', filterTable);
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
.btn-outline-info, .btn-outline-warning, .btn-outline-danger {
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
.btn-outline-warning:hover {
    background-color: #ffc107;
    color: white;
}
.btn-outline-danger:hover {
    background-color: #dc3545;
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