@extends('layouts.admin')

@section('page-title', 'Reports')
@section('page-description', 'View and manage employee reports')

@push('styles')
<style>
.rating-display {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 2px;
}

.stars {
    display: flex;
    gap: 2px;
}

.star {
    font-size: 16px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.star.filled {
    color: #ffc107;
}

.star.empty {
    color: #ddd;
}

.star:hover {
    transform: scale(1.2);
}

.rating-text {
    color: #666;
    font-weight: 500;
    margin-top: 2px;
}
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Employee Reports</h5>
            </div>
            <div class="card-body">
                @if($reports->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Task Name</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Rating</th>
                                    <th>Date Sent</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reports as $report)
                                    <tr>
                                        <td>{{ $report->employee ? $report->employee->name : 'N/A' }}</td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold">{{ $report->task ? $report->task->task_name : 'N/A' }}</span>
                                                @if($report->task)
                                                    <span class="badge bg-{{ $report->task->assigned_team === 'Team' ? 'info' : 'secondary' }} mt-1" style="font-size: 0.75rem;">
                                                        <i class="fas fa-{{ $report->task->assigned_team === 'Team' ? 'users' : 'user' }} me-1"></i>
                                                        {{ $report->task->assigned_team }}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>{{ $report->title }}</td>
                                        <td>
                                            <span class="badge bg-{{ $report->admin_status === 'sent' ? 'warning' : ($report->admin_status === 'read' ? 'info' : 'success') }}">
                                                {{ ucfirst($report->admin_status ?? 'N/A') }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="rating-display">
                                                @if($report->rating)
                                                    <div class="stars">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <span class="star {{ $i <= $report->rating ? 'filled' : 'empty' }}" data-rating="{{ $i }}">
                                                                &#9733;
                                                            </span>
                                                        @endfor
                                                    </div>
                                                    <small class="rating-text">{{ $report->rating }}/5</small>
                                                @else
                                                    <span class="text-muted">No rating</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($report->created_at)->format('M d, Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.reports.show', $report->id) }}" class="btn btn-sm btn-outline-primary">
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
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No reports found</h5>
                        <p class="text-muted">No reports have been sent to admin yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
