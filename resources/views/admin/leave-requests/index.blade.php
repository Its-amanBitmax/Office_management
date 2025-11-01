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
                            <td>{{ $request->id }}</td>
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
                                        <form action="{{ route('admin.leave-requests.update', $request->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Approve this leave request?')">Approve</button>
                                        </form>
                                        <form action="{{ route('admin.leave-requests.update', $request->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Reject this leave request?')">Reject</button>
                                        </form>
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
@endsection
