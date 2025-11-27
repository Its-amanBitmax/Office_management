@extends('layouts.admin')

@section('page-title', 'Leave Requests Management')
@section('page-description', 'Manage employee leave requests')

@section('content')
<div class="mb-3 d-flex justify-content-between align-items-center">
    <h5>Leave Requests</h5>
    <a href="{{ route('admin.leave-requests.create') }}" class="btn btn-primary">Create Leave Request</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Employee</th>
                        <th>Leave Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Days</th>
                        <th>Status</th>
                        <th>Submitted At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leaveRequests as $request)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $request->employee->name }}</td>
                            <td>{{ ucfirst($request->leave_type) }}</td>
                            <td>{{ $request->start_date ? \Carbon\Carbon::parse($request->start_date)->format('M d, Y') : '-' }}</td>
                            <td>{{ $request->end_date ? \Carbon\Carbon::parse($request->end_date)->format('M d, Y') : '-' }}</td>
                            <td>{{ $request->days ?? '-' }}</td>
                            <td>
                                <span class="badge
                                    @if($request->status == 'approved') bg-success
                                    @elseif($request->status == 'rejected') bg-danger
                                    @elseif($request->status == 'pending') bg-warning
                                    @else bg-secondary
                                    @endif">
                                    {{ ucfirst($request->status) }}
                                </span>
                            </td>
                            <td>{{ $request->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.leave-requests.show', $request->id) }}" class="btn btn-info btn-sm">View</a>
                                    @if($request->status == 'pending')
                                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#approveModal{{ $request->id }}">Approve</button>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $request->id }}">Reject</button>
                                    @endif
                                    <form action="{{ route('admin.leave-requests.destroy', $request->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this leave request?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">No leave requests found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($leaveRequests->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $leaveRequests->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Approve Modals -->
@foreach($leaveRequests as $request)
    @if($request->status == 'pending')
        <!-- Approve Modal -->
        <div class="modal fade" id="approveModal{{ $request->id }}" tabindex="-1" aria-labelledby="approveModalLabel{{ $request->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="approveModalLabel{{ $request->id }}">Approve Leave Request</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.leave-requests.update', $request->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <p>Are you sure you want to approve the leave request for <strong>{{ $request->employee->name }}</strong>?</p>
                            <div class="mb-3">
                                <label for="remarks{{ $request->id }}" class="form-label">Remarks (Optional)</label>
                                <textarea class="form-control" id="remarks{{ $request->id }}" name="remarks" rows="3" placeholder="Add any remarks for approval..."></textarea>
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
        <div class="modal fade" id="rejectModal{{ $request->id }}" tabindex="-1" aria-labelledby="rejectModalLabel{{ $request->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rejectModalLabel{{ $request->id }}">Reject Leave Request</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.leave-requests.update', $request->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <p>Are you sure you want to reject the leave request for <strong>{{ $request->employee->name }}</strong>?</p>
                            <div class="mb-3">
                                <label for="remarks{{ $request->id }}" class="form-label">Remarks (Required)</label>
                                <textarea class="form-control" id="remarks{{ $request->id }}" name="remarks" rows="3" placeholder="Please provide a reason for rejection..." required></textarea>
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
@endforeach
@endsection
