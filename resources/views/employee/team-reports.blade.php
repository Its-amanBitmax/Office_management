@extends('layouts.employee')

@section('title', 'Team Reports')

@section('page-title', 'Team Reports')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Reports from Team Members</h5>
                </div>
                <div class="card-body">
                    @if($reports->isEmpty())
                        <p class="text-muted">No reports have been sent to you by your team members.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Task</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Review</th>
                                        <th>Date Sent</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reports as $report)
                                        <tr>
                                            <td>{{ $report->employee->name ?? 'N/A' }}</td>
                                            <td>{{ $report->task->task_name ?? 'N/A' }}</td>
                                            <td>{{ $report->title }}</td>
                                            <td>
                                                <span class="badge bg-{{ $report->status === 'sent' ? 'warning' : ($report->status === 'read' ? 'info' : 'success') }}">
                                                    {{ ucfirst($report->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                @php
                                                    $adminReviewed = $report->admin_rating !== null || $report->admin_review_status ?? false;
                                                    $teamLeadReviewed = $report->team_lead_rating !== null || $report->team_lead_review_status ?? false;
                                                @endphp
                                                @if($adminReviewed)
                                                    <span class="badge bg-primary">Admin</span>
                                                @elseif($teamLeadReviewed)
                                                    <span class="badge bg-success">Team Lead</span>
                                                @else
                                                    <span class="text-muted">Pending</span>
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($report->created_at)->format('M d, Y H:i') }}</td>
                                            <td>
                                                <a href="{{ route('employee.team-reports.show', $report) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> View & Review
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $reports->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
.stars {
    display: inline-block;
}

.star {
    color: #ddd;
    font-size: 18px;
}

.star.filled {
    color: #ffc107;
}

.rating-text {
    display: block;
    font-size: 12px;
    color: #666;
}
</style>
