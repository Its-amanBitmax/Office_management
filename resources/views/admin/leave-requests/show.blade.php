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
                        <form action="{{ route('admin.leave-requests.update', $leaveRequest->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" class="btn btn-success" onclick="return confirm('Approve this leave request?')">Approve Request</button>
                        </form>
                        <form action="{{ route('admin.leave-requests.update', $leaveRequest->id) }}" method="POST" class="d-inline ms-2">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Reject this leave request?')">Reject Request</button>
                        </form>
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
@endsection
