@extends('layouts.employee')

@section('title', 'My Leave Requests')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">My Leave Requests</h5>
                <a href="{{ route('employee.leave-requests.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i>New Request
                </a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($leaveRequests->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Leave Type</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Days</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                    <th>Applied On</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($leaveRequests as $request)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ ucfirst($request->leave_type) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($request->start_date)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($request->end_date)->format('d/m/Y') }}</td>
                                    <td>{{ $request->days }}</td>
                                    <td>{{ Str::limit($request->reason, 30) }}</td>
                                    <td>
                                        @if($request->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($request->status == 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @elseif($request->status == 'rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($request->created_at)->format('d/m/Y') }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" onclick="viewDetails({{ $request->id }})">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $leaveRequests->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No Leave Requests Found</h5>
                        <p class="text-muted">You haven't submitted any leave requests yet.</p>
                        <a href="{{ route('employee.leave-requests.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Submit Your First Leave Request
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Leave Request Details Modal -->
<div class="modal fade" id="leaveDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Leave Request Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="leaveDetailsContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
function viewDetails(id) {
    fetch(`{{ url('/employee/leave-requests') }}/${id}`)
        .then(response => response.json())
        .then(data => {
            const content = `
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Leave Type:</strong> ${data.leave_type.charAt(0).toUpperCase() + data.leave_type.slice(1)}</p>
                        <p><strong>Start Date:</strong> ${new Date(data.start_date).toLocaleDateString()}</p>
                        <p><strong>End Date:</strong> ${new Date(data.end_date).toLocaleDateString()}</p>
                        <p><strong>Days:</strong> ${data.days}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Status:</strong>
                            ${data.status === 'pending' ? '<span class="badge bg-warning">Pending</span>' :
                              data.status === 'approved' ? '<span class="badge bg-success">Approved</span>' :
                              '<span class="badge bg-danger">Rejected</span>'}
                        </p>
                        <p><strong>Applied On:</strong> ${new Date(data.created_at).toLocaleDateString()}</p>
                        ${data.admin_remarks ? `<p><strong>Admin Remarks:</strong> ${data.admin_remarks}</p>` : ''}
                    </div>
                    <div class="col-12">
                        <p><strong>Reason:</strong></p>
                        <p>${data.reason}</p>
                    </div>
                </div>
            `;
            document.getElementById('leaveDetailsContent').innerHTML = content;
            new bootstrap.Modal(document.getElementById('leaveDetailsModal')).show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading leave request details');
        });
}
</script>
@endsection
