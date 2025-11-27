@extends('layouts.admin')

@section('page-title', 'Edit Attendance')
@section('page-description', 'Update attendance record details')

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
                <h5 class="mb-0">Edit Attendance Record</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('attendance.update', $attendance->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="employee_id" class="form-label">Employee <span class="text-danger">*</span></label>
                            <select name="employee_id" id="employee_id" class="form-select" required>
                                <option value="">Select Employee</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}" {{ $attendance->employee_id == $employee->id ? 'selected' : '' }}>
                                        {{ $employee->name }} ({{ $employee->employee_code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" name="date" id="date" class="form-control" value="{{ $attendance->date->format('Y-m-d') }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="Present" {{ $attendance->status == 'Present' ? 'selected' : '' }}>Present</option>
                                <option value="Absent" {{ $attendance->status == 'Absent' ? 'selected' : '' }}>Absent</option>
                                <option value="Leave" {{ $attendance->status == 'Leave' ? 'selected' : '' }}>Leave</option>
                                <option value="Half Day" {{ $attendance->status == 'Half Day' ? 'selected' : '' }}>Half Day</option>
                                <option value="Holiday" {{ $attendance->status == 'Holiday' ? 'selected' : '' }}>Holiday</option>
                                <option value="NCNS" {{ $attendance->status == 'NCNS' ? 'selected' : '' }}>NCNS</option>
                                <option value="LWP" {{ $attendance->status == 'LWP' ? 'selected' : '' }}>LWP</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="marked_time" class="form-label">Marked Time <span class="text-danger">*</span></label>
                            <input type="time" name="marked_time" id="marked_time" class="form-control" value="{{ $attendance->updated_at->setTimezone('Asia/Kolkata')->format('H:i') }}" required>
                            <small class="form-text text-muted">Time when attendance was marked</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea name="remarks" id="remarks" class="form-control" rows="3" placeholder="Optional remarks...">{{ $attendance->remarks }}</textarea>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Attendance
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
                <h6 class="mb-0">Attendance Information</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Employee:</strong><br>
                    {{ $attendance->employee->name }}
                </div>
                <div class="mb-3">
                    <strong>Employee Code:</strong><br>
                    {{ $attendance->employee->employee_code }}
                </div>
                <div class="mb-3">
                    <strong>Current Status:</strong><br>
                    <span class="badge
                        @if($attendance->status == 'Present') bg-success
                        @elseif($attendance->status == 'Absent') bg-danger
                        @elseif($attendance->status == 'Leave') bg-warning
                        @elseif($attendance->status == 'Half Day') bg-info
                        @elseif($attendance->status == 'Holiday') bg-primary
                        @endif">
                        {{ $attendance->status }}
                    </span>
                </div>
                <div class="mb-3">
                    <strong>Date:</strong><br>
                    {{ $attendance->date->format('F j, Y') }}
                </div>
                <div class="mb-3">
                    <strong>Created:</strong><br>
                    {{ $attendance->created_at->format('M j, Y g:i A') }}
                </div>
                <div class="mb-3">
                    <strong>Last Updated:</strong><br>
                    {{ $attendance->updated_at->format('M j, Y g:i A') }}
                </div>
                @if($attendance->remarks)
                    <div class="mb-3">
                        <strong>Remarks:</strong><br>
                        <em>{{ $attendance->remarks }}</em>
                    </div>
                @endif
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('attendance.show', $attendance->id) }}" class="btn btn-outline-info btn-sm">
                        <i class="fas fa-eye"></i> View Details
                    </a>
                    <form method="POST" action="{{ route('attendance.destroy', $attendance->id) }}" onsubmit="return confirm('Are you sure you want to delete this attendance record?');" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                            <i class="fas fa-trash"></i> Delete Record
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection