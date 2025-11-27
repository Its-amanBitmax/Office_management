@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Task Details</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Task Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th>Task Name:</th>
                                    <td>{{ $task->task_name }}</td>
                                </tr>
                                <tr>
                                    <th>Description:</th>
                                    <td>{{ $task->description }}</td>
                                </tr>
                                <tr>
                                    <th>Assignment Type:</th>
                                    <td>{{ $task->assigned_team }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        <span class="badge bg-{{ $task->status == 'Completed' ? 'success' : ($task->status == 'In Progress' ? 'primary' : 'secondary') }}">
                                            {{ $task->status }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Priority:</th>
                                    <td>
                                        <span class="badge bg-{{ $task->priority == 'High' ? 'danger' : ($task->priority == 'Medium' ? 'warning' : 'info') }}">
                                            {{ $task->priority }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Progress:</th>
                                    <td>{{ $task->progress }}%</td>
                                </tr>
                                <tr>
                                    <th>Start Date:</th>
                                    <td>{{ $task->start_date ? \Carbon\Carbon::parse($task->start_date)->format('d M Y') : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>End Date:</th>
                                    <td>{{ $task->end_date ? \Carbon\Carbon::parse($task->end_date)->format('d M Y') : 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            @if($task->assigned_team == 'Individual')
                                <h5>Assigned Employee</h5>
                                @if($task->assignedEmployee)
                                    <div class="card">
                                        <div class="card-body">
                                            <h6>{{ $task->assignedEmployee->name }}</h6>
                                            <p class="text-muted">{{ $task->assignedEmployee->employee_code }}</p>
                                            <p>{{ $task->assignedEmployee->position }}</p>
                                            <p>{{ $task->assignedEmployee->email }}</p>
                                            <p>{{ $task->assignedEmployee->phone }}</p>
                                        </div>
                                    </div>
                                @else
                                    <p>No employee assigned.</p>
                                @endif
                            @else
                                <h5>Team Information</h5>
                                @if($task->teamLead)
                                    <div class="mb-3">
                                        <strong>Team Lead:</strong>
                                        <div class="card">
                                            <div class="card-body">
                                                <h6>{{ $task->teamLead->name }}</h6>
                                                <p class="text-muted">{{ $task->teamLead->employee_code }}</p>
                                                <p>{{ $task->teamLead->position }}</p>
                                                <p>{{ $task->teamLead->email }}</p>
                                                <p>{{ $task->teamLead->phone }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <strong>Team Members:</strong>
                                @if($task->teamMembers()->count() > 0)
                                    <div class="row">
                                        @foreach($task->teamMembers() as $member)
                                            <div class="col-md-6 mb-3">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h6>{{ $member->name }}</h6>
                                                        <p class="text-muted">{{ $member->employee_code }}</p>
                                                        <p>{{ $member->position }}</p>
                                                        <p>{{ $member->email }}</p>
                                                        <p>{{ $member->phone }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p>No team members assigned.</p>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="mt-3 d-flex justify-content-end gap-2">
                        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning">Edit Task</a>
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this task?')">Delete Task</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
