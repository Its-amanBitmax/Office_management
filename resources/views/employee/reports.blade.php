@extends('layouts.employee')

@section('title', 'My Reports')

@section('page-title', 'My Reports')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Daily Report Template Card -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5 class="card-title mb-2">
                            <i class="fas fa-file-alt text-primary me-2"></i>Daily Work Report Template
                        </h5>
                        <p class="card-text text-muted mb-0">
                            Generate and fill out your daily work report with a comprehensive template including project information, tasks completed, and more.
                        </p>
                    </div>
                    <div class="col-md-4 text-end">
                        <a href="{{ route('employee.daily-report') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Create Daily Report
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">My Reports</h5>
                <a href="{{ route('employee.reports.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Send New Report
                </a>
            </div>
            <div class="card-body">
                @if($reports->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Sent To</th>
                                    <th>Status</th>
                                    <th>Review</th>
                                    <th>Date Sent</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reports as $report)
                                    <tr>
                                        <td>{{ $report->title }}</td>
                                        <td>
                                            @if($report->sent_to_admin)
                                                <span class="badge bg-primary">Admin</span>
                                            @endif
                                            @if($report->sent_to_team_lead)
                                                <span class="badge bg-info">Team Lead</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $adminStatus = $report->admin_status && $report->admin_status !== 'sent' ? ucfirst($report->admin_status) : null;
                                                $teamLeadStatus = $report->team_lead_status && $report->team_lead_status !== 'sent' ? ucfirst($report->team_lead_status) : null;
                                            @endphp
                                            @if($adminStatus && $teamLeadStatus)
                                                <div class="d-flex flex-column gap-1">
                                                    <span class="badge bg-primary">Admin: {{ $adminStatus }}</span>
                                                    <span class="badge bg-info">Team Lead: {{ $teamLeadStatus }}</span>
                                                </div>
                                            @elseif($adminStatus)
                                                <span class="badge bg-primary">Admin: {{ $adminStatus }}</span>
                                            @elseif($teamLeadStatus)
                                                <span class="badge bg-info">Team Lead: {{ $teamLeadStatus }}</span>
                                            @else
                                                <span class="badge bg-{{ $report->status === 'sent' ? 'warning' : ($report->status === 'read' ? 'info' : 'success') }}">
                                                    {{ ucfirst($report->status) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $adminReviewed = $report->admin_status && $report->admin_status !== 'sent';
                                                $teamLeadReviewed = $report->team_lead_status && $report->team_lead_status !== 'sent';
                                            @endphp
                                            @if($adminReviewed && $teamLeadReviewed)
                                                <span class="badge bg-primary me-1">Admin</span>
                                                <span class="badge bg-info">Team Lead</span>
                                            @elseif($adminReviewed)
                                                <span class="badge bg-primary">Admin</span>
                                            @elseif($teamLeadReviewed)
                                                <span class="badge bg-info">Team Lead</span>
                                            @else
                                                <span class="text-muted">Pending</span>
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($report->created_at)->format('M d, Y H:i') }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="viewReport({{ $report->id }})">
                                                <i class="fas fa-eye"></i> View
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $reports->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No reports found</h5>
                        <p class="text-muted">You haven't sent any reports yet.</p>
                        <a href="{{ route('employee.reports.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Send Your First Report
                        </a>
                    </div>
                @endif
            </div>
        </div> --}}
    </div>
</div>

<!-- Report Detail Modal -->
<div class="modal fade" id="reportModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Report Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="reportContent">
                <!-- Report content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
function viewReport(reportId) {
    fetch(`/employee/reports/${reportId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('reportContent').innerHTML = `
                <div class="mb-3">
                    <h6>Title:</h6>
                    <p>${data.title}</p>
                </div>
                <div class="mb-3">
                    <h6>Sent To:</h6>
                    <p>
                        ${data.sent_to_admin ? '<span class="badge bg-primary me-2">Admin</span>' : ''}
                        ${data.sent_to_team_lead ? '<span class="badge bg-info">Team Lead</span>' : ''}
                    </p>
                </div>
                <div class="mb-3">
                    <h6>Status:</h6>
                    <span class="badge bg-${data.status === 'sent' ? 'warning' : (data.status === 'read' ? 'info' : 'success')}">${data.status.charAt(0).toUpperCase() + data.status.slice(1)}</span>
                </div>
                <!-- Employee's Report Content -->
                <div class="mb-3">
                    <h6>Employee's Report:</h6>
                    <div class="alert alert-secondary">
                        <p class="mb-0">${data.content}</p>
                    </div>
                </div>

                <!-- Team Lead Review -->
                ${data.team_lead_review ? `
                    <div class="mb-3">
                        <h6>Team Lead Review:</h6>
                        <div class="alert alert-success">
                            <p class="mb-0">${data.team_lead_review}</p>
                        </div>
                    </div>
                ` : ''}

                <!-- Admin Review -->
                ${data.admin_review ? `
                    <div class="mb-3">
                        <h6>Admin Review:</h6>
                        <div class="alert alert-primary">
                            <p class="mb-0">${data.admin_review}</p>
                        </div>
                    </div>
                ` : ''}
                <div class="mb-3">
                    <h6>Date Sent:</h6>
                    <p>${new Date(data.created_at).toLocaleString()}</p>
                </div>
                ${data.attachment ? `
                    <div class="mb-3">
                        <h6>Attachment:</h6>
                        <a href="/storage/${data.attachment}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-download me-2"></i>Download
                        </a>
                    </div>
                ` : ''}
            `;
            new bootstrap.Modal(document.getElementById('reportModal')).show();
        });
}
</script>


@endsection
