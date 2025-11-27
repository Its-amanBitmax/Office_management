@extends('layouts.admin')

@section('page-title', 'Leave Request Details')
@section('page-description', 'View detailed information about the leave request')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Leave Request #{{ $leaveRequest->id }}</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Employee:</strong>
                        <p>{{ $leaveRequest->employee->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Employee Code:</strong>
                        <p>{{ $leaveRequest->employee->employee_code }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Leave Type:</strong>
                        <p>{{ ucfirst($leaveRequest->leave_type) }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <p>
                            <span class="badge
                                @if($leaveRequest->status == 'approved') bg-success
                                @elseif($leaveRequest->status == 'rejected') bg-danger
                                @elseif($leaveRequest->status == 'pending') bg-warning
                                @else bg-secondary
                                @endif">
                                {{ ucfirst($leaveRequest->status) }}
                            </span>
                        </p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Start Date:</strong>
                        <p>{{ $leaveRequest->start_date ? \Carbon\Carbon::parse($leaveRequest->start_date)->format('M d, Y') : '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>End Date:</strong>
                        <p>{{ $leaveRequest->end_date ? \Carbon\Carbon::parse($leaveRequest->end_date)->format('M d, Y') : '-' }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Number of Days:</strong>
                        <p>{{ $leaveRequest->days ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Submitted At:</strong>
                        <p>{{ $leaveRequest->created_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>

                <div class="mb-3">
                    <strong>Subject:</strong>
                    <p>{{ $leaveRequest->subject }}</p>
                </div>

                <div class="mb-3">
                    <strong>Description:</strong>
                    <p>{{ $leaveRequest->description }}</p>
                </div>

                @if($leaveRequest->file_path)
                    <div class="mb-3">
                        <strong>Attachment:</strong>
                        <p><a href="{{ asset('storage/' . $leaveRequest->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">View Attachment</a></p>
                    </div>
                @endif

                @if($leaveRequest->status == 'pending')
                    <div class="mt-4">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#approveModal">Approve Request</button>
                        <button type="button" class="btn btn-danger ms-2" data-bs-toggle="modal" data-bs-target="#rejectModal">Reject Request</button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6>Actions</h6>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.leave-requests.index') }}" class="btn btn-secondary w-100 mb-2">Back to List</a>
                <a href="{{ route('admin.leave-requests.edit', $leaveRequest->id) }}" class="btn btn-warning w-100 mb-2">Edit Request</a>
                <form action="{{ route('admin.leave-requests.destroy', $leaveRequest->id) }}" method="POST" onsubmit="return confirm('Delete this leave request?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">Delete Request</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Approve Modal -->
@if($leaveRequest->status == 'pending')
    <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approveModalLabel">Approve Leave Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.leave-requests.update', $leaveRequest->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <p>Are you sure you want to approve the leave request for <strong>{{ $leaveRequest->employee->name }}</strong>?</p>
                        <div class="mb-3">
                            <label for="remarks" class="form-label">Remarks (Optional)</label>
                            <textarea class="form-control" id="remarks" name="remarks" rows="3" placeholder="Add any remarks for approval..."></textarea>
                        </div>
                        <input type="hidden" name="status" value="approved">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Approve</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Reject Leave Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.leave-requests.update', $leaveRequest->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <p>Are you sure you want to reject the leave request for <strong>{{ $leaveRequest->employee->name }}</strong>?</p>
                        <div class="mb-3">
                            <label for="remarks" class="form-label">Remarks (Required)</label>
                            <textarea class="form-control" id="remarks" name="remarks" rows="3" placeholder="Please provide a reason for rejection..." required></textarea>
                        </div>
                        <input type="hidden" name="status" value="rejected">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Reject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
@endsection
