@extends('layouts.admin')

@section('page-title', 'Create Attendance')
@section('page-description', 'Add new attendance record')

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Create New Attendance Record</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('attendance.store') }}">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="employee_id" class="form-label">Employee <span class="text-danger">*</span></label>
                            <select name="employee_id" id="employee_id" class="form-select" required>
                                <option value="">Select Employee</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">
                                        {{ $employee->name }} ({{ $employee->employee_code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" name="date" id="date" class="form-control" value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="">Select Status</option>
                                <option value="Present">Present</option>
                                <option value="Absent">Absent</option>
                                <option value="Leave">Leave</option>
                                <option value="Half Day">Half Day</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea name="remarks" id="remarks" class="form-control" rows="3" placeholder="Optional remarks..."></textarea>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Create Attendance
                        </button>
                        <a href="{{ route('attendance.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Quick Attendance Actions</h6>
            </div>
            <div class="card-body">
                <p class="text-muted small mb-3">For bulk attendance marking, use the main attendance page with quick action buttons.</p>
                <div class="d-grid gap-2">
                    <a href="{{ route('attendance.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-list"></i> View All Attendance
                    </a>
                    <a href="{{ route('attendance.report') }}" class="btn btn-outline-info">
                        <i class="fas fa-chart-bar"></i> View Reports
                    </a>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Status Guide</h6>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <span class="badge bg-success me-2">Present</span>
                    <small>Employee is present for the full day</small>
                </div>
                <div class="mb-2">
                    <span class="badge bg-danger me-2">Absent</span>
                    <small>Employee is absent for the day</small>
                </div>
                <div class="mb-2">
                    <span class="badge bg-warning me-2">Leave</span>
                    <small>Employee is on approved leave</small>
                </div>
                <div class="mb-2">
                    <span class="badge bg-info me-2">Half Day</span>
                    <small>Employee is present for half day</small>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-fill employee details when employee is selected
document.getElementById('employee_id').addEventListener('change', function() {
    const employeeId = this.value;
    if (employeeId) {
        // You can add AJAX call here to fetch employee details if needed
        console.log('Employee selected:', employeeId);
    }
});

// Set default date to today
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('date').value = today;
});
</script>
@endsection
