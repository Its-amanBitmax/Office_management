@extends('layouts.employee')

@section('title', 'My Attendance')

@section('page-title', 'My Attendance')

@section('content')
<div class="row">
    <!-- Attendance Sidebar -->
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Leave Management</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('employee.leave-requests.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-2"></i>Request Leave
                    </a>
                    <a href="{{ route('employee.leave-requests.index') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-list me-2"></i>View My Requests
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Select Month to View Attendance</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('employee.attendance.show') }}" class="row g-3">
                    <div class="col-md-4">
                        <label for="month" class="form-label">Select Month</label>
                        <input type="month" class="form-control" id="month" name="month" value="{{ $month ?? now()->format('Y-m') }}" required>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>View Attendance
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if(isset($summary))
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Attendance Summary for {{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y') }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="text-center">
                            <div class="h4 text-primary">{{ $summary['total_days'] }}</div>
                            <small class="text-muted">Total Days</small>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="text-center">
                            <div class="h4 text-success">{{ $summary['present'] }}</div>
                            <small class="text-muted">Present</small>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="text-center">
                            <div class="h4 text-danger">{{ $summary['absent'] }}</div>
                            <small class="text-muted">Absent</small>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="text-center">
                            <div class="h4 text-warning">{{ $summary['leave'] }}</div>
                            <small class="text-muted">Leave</small>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="text-center">
                            <div class="h4 text-info">{{ $summary['half_day'] }}</div>
                            <small class="text-muted">Half Day</small>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="text-center">
                            <div class="h4 text-secondary">{{ $summary['holiday'] }}</div>
                            <small class="text-muted">Holiday</small>
                        </div>
                    </div>
                </div>
             
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Daily Attendance Details</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Day</th>
                                <th>Status</th>
                                <th>Marked At</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($monthlyData as $data)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($data['date'])->format('d/m/Y') }}</td>
                                <td>{{ $data['day_name'] }}</td>
                                <td>
                                    @if($data['status'] == 'Present')
                                        <span class="badge bg-success">{{ $data['status'] }}</span>
                                    @elseif($data['status'] == 'Absent')
                                        <span class="badge bg-danger">{{ $data['status'] }}</span>
                                    @elseif($data['status'] == 'Leave')
                                        <span class="badge bg-warning">{{ $data['status'] }}</span>
                                    @elseif($data['status'] == 'Half Day')
                                        <span class="badge bg-info">{{ $data['status'] }}</span>
                                    @elseif($data['status'] == 'Holiday')
                                        <span class="badge bg-secondary">{{ $data['status'] }}</span>
                                    @else
                                        <span class="badge bg-light text-dark">{{ $data['status'] }}</span>
                                    @endif
                                </td>
                                <td>{{ $data['marked_at'] ?? '-' }}</td>
                                <td>{{ $data['remarks'] ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
