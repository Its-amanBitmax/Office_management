{{-- Use the employee layout if available, fallback to admin layout if not --}}
{{-- @extends('employee.layouts.app') --}}
@extends('layouts.employee')

@section('content')
<style>
.leave-card {
    border-radius: 18px;
    box-shadow: 0 4px 18px rgba(79,70,229,0.08), 0 1.5px 4px rgba(0,0,0,0.06);
    border: none;
    transition: box-shadow 0.2s;
    background: linear-gradient(135deg, #f8fafc 60%, #e0e7ff 100%);
    position: relative;
    overflow: hidden;
}
.leave-card:hover {
    box-shadow: 0 8px 32px rgba(79,70,229,0.13), 0 2px 8px rgba(0,0,0,0.08);
    transform: translateY(-2px) scale(1.01);
}
.leave-card .card-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #3730a3;
    margin-bottom: 0.5rem;
    letter-spacing: 0.5px;
}
.leave-card .badge {
    font-size: 0.85rem;
    padding: 0.45em 1em;
    border-radius: 20px;
    letter-spacing: 0.5px;
}
.leave-card .status-badge {
    font-weight: 600;
    font-size: 0.9rem;
    margin-left: 0.5rem;
}
.leave-card .card-body {
    display: flex;
    flex-direction: column;
    min-height: 320px;
}
.leave-card .leave-label {
    color: #64748b;
    font-size: 0.97rem;
    font-weight: 500;
    margin-bottom: 0.15rem;
}
.leave-card .leave-value {
    color: #1e293b;
    font-size: 1.01rem;
    font-weight: 600;
    margin-bottom: 0.3rem;
}
.leave-card .leave-meta {
    color: #64748b;
    font-size: 0.92rem;
    margin-bottom: 0.2rem;
}
.leave-card .attachment-link {
    color: #4f46e5;
    font-weight: 600;
    text-decoration: underline;
    font-size: 0.97rem;
}
.leave-card .attachment-link:hover {
    color: #3730a3;
}
.leave-card .applied-on {
    font-size: 0.85rem;
    color: #94a3b8;
    margin-top: 0.5rem;
}
.leave-card .action-btns {
    margin-top: auto;
    display: flex;
    gap: 0.5rem;
}
.leave-card .action-btns .btn {
    border-radius: 8px;
    font-size: 0.97rem;
    font-weight: 500;
    padding: 0.4em 1.1em;
}
@media (max-width: 767px) {
    .leave-card .card-body { min-height: 0; }
}
</style>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0" style="font-weight:700;color:#3730a3;letter-spacing:0.5px;">
            <i class="fas fa-calendar-check me-2 text-primary"></i>My Leave Requests
        </h2>
        <a href="{{ route('employee.leave-requests.create') }}" class="btn btn-success shadow-sm" style="border-radius:8px;">
            <i class="fas fa-plus"></i> Apply for Leave
        </a>
    </div>
    <div class="row">
        @forelse($leaveRequests as $leave)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card leave-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge bg-primary text-uppercase">{{ ucfirst($leave->leave_type) }}</span>
                        <span class="status-badge badge bg-{{ $leave->status == 'approved' ? 'success' : ($leave->status == 'rejected' ? 'danger' : 'warning') }}">
                            {{ ucfirst($leave->status) }}
                        </span>
                    </div>
                    <div class="leave-label">Subject</div>
                    <div class="leave-value">{{ $leave->subject }}</div>
                    <div class="leave-label">Description</div>
                    <div class="leave-meta">{{ $leave->description }}</div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <div class="leave-label">From</div>
                            <div class="leave-value">{{ \Carbon\Carbon::parse($leave->start_date)->format('d M Y') }}</div>
                        </div>
                        <div class="col-6">
                            <div class="leave-label">To</div>
                            <div class="leave-value">{{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}</div>
                        </div>
                    </div>
                    <div class="leave-label">Days</div>
                    <div class="leave-value">{{ $leave->days }}</div>
                    @if($leave->remarks)
                        <div class="leave-label">Remarks</div>
                        <div class="leave-meta">{{ $leave->remarks }}</div>
                    @endif
                    @if($leave->file_path)
                        <div class="leave-label">Attachment</div>
                        <a href="{{ asset('storage/'.$leave->file_path) }}" target="_blank" class="attachment-link">
                            <i class="fas fa-paperclip"></i> View File
                        </a>
                    @endif
                    <div class="applied-on">
                        <i class="far fa-clock me-1"></i>
                        Applied on: {{ $leave->created_at->format('d M Y, h:i A') }}
                    </div>
                    <div class="action-btns mt-3">
                        
                        {{-- Uncomment below if edit/delete routes are available --}}
                        {{--
                        @if($leave->status == 'pending')
                            <a href="{{ route('employee.leave-requests.edit', $leave->id) }}" class="btn btn-outline-secondary">Edit</a>
                            <form action="{{ route('employee.leave-requests.destroy', $leave->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this leave request?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger" type="submit">Delete</button>
                            </form>
                        @endif
                        --}}
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center shadow-sm" style="border-radius:12px;">No leave requests found.</div>
        </div>
        @endforelse
    </div>
    <div class="d-flex justify-content-center">
        {{ $leaveRequests->links() }}
    </div>
</div>
@endsection
