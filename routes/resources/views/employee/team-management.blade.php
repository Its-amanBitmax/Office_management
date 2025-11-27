@extends('layouts.employee')

@section('title', 'Team Management')

@section('page-title', 'Team Management')

@section('content')
<div class="container-fluid">
    <!-- Team Reports Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-file-alt me-2"></i>Team Reports
                        </h5>
                        <span class="badge bg-light text-dark">{{ $reports->total() }} Reports</span>
                    </div>
                </div>
                <div class="card-body">
                    @if($reports->isEmpty())
                        <div class="text-center py-4">
                            <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No team reports found.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Report Title</th>
                                        <th>Employee</th>
                                        <th>Task</th>
                                        <th>Status</th>
                                        <th>Review</th>
                                        <th>Submitted</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reports as $report)
                                        <tr>
                                            <td>
                                                <strong>{{ $report->title }}</strong>
                                                @if($report->attachment)
                                                    <br><small class="text-muted"><i class="fas fa-paperclip"></i> Attachment</small>
                                                @endif
                                            </td>
                                            <td>{{ $report->employee->name }}</td>
                                            <td>{{ $report->task->task_name }}</td>
                                            <td>
                                                @if($report->team_lead_status == 'sent')
                                                    <span class="badge bg-secondary">Sent</span>
                                                @elseif($report->team_lead_status == 'read')
                                                    <span class="badge bg-info">Read</span>
                                                @elseif($report->team_lead_status == 'responded')
                                                    <span class="badge bg-success">Responded</span>
                                                @else
                                                    <span class="badge bg-light text-dark">{{ $report->team_lead_status }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($report->admin_rating)
                                                    <div class="d-flex flex-column">
                                                        <small class="text-primary fw-bold mb-1">Admin</small>
                                                        <div class="d-flex align-items-center">
                                                            <div class="me-2">
                                                                @for($i = 1; $i <= 5; $i++)
                                                                    <i class="fas fa-star {{ $i <= $report->admin_rating ? 'text-warning' : 'text-muted' }}"></i>
                                                                @endfor
                                                            </div>
                                                            <span class="badge bg-primary">{{ $report->admin_rating }}/5</span>
                                                        </div>
                                                    </div>
                                                @elseif($report->team_lead_rating)
                                                    <div class="d-flex flex-column">
                                                        <small class="text-success fw-bold mb-1">Team Leader</small>
                                                        <div class="d-flex align-items-center">
                                                            <div class="me-2">
                                                                @for($i = 1; $i <= 5; $i++)
                                                                    <i class="fas fa-star {{ $i <= $report->team_lead_rating ? 'text-warning' : 'text-muted' }}"></i>
                                                                @endfor
                                                            </div>
                                                            <span class="badge bg-success">{{ $report->team_lead_rating }}/5</span>
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-muted">Not reviewed</span>
                                                @endif
                                            </td>
                                            <td>{{ $report->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <a href="{{ route('employee.team-reports.show', $report) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-3">
                            {{ $reports->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Team Tasks Section -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">My Team Tasks</h5>
                    </div>
                </div>
                <div class="card-body">
                    @if($teamTasks->isEmpty())
                        <p class="text-muted">No team tasks found where you are the team leader.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Task Name</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Progress</th>
                                        <th>Team Members</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($teamTasks as $task)
                                        <tr>
                                            <td>{{ $task->task_name }}</td>
                                            <td>{{ Str::limit($task->description, 50) }}</td>
                                            <td>
                                                <span class="badge bg-{{ $task->status == 'Completed' ? 'success' : ($task->status == 'In Progress' ? 'primary' : 'secondary') }}">
                                                    {{ $task->status }}
                                                </span>
                                            </td>
                                            <td>{{ $task->progress }}%</td>
                                            <td>
                                                @if($task->teamMembers()->isNotEmpty())
                                                    <ul class="list-unstyled mb-0">
                                                        @foreach($task->teamMembers() as $member)
                                                            <li>{{ $member->name }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    No team members
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('employee.tasks.show', $task) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                <a href="{{ route('employee.tasks.edit', $task) }}" class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
