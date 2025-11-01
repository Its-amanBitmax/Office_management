@extends('layouts.admin')

@section('page-title', 'Create Leave Request')
@section('page-description', 'Create a new leave request for an employee')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Create Leave Request</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.leave-requests.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="employee_id" class="form-label">Employee <span class="text-danger">*</span></label>
                        <select name="employee_id" id="employee_id" class="form-select" required>
                            <option value="">Select Employee</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->name }} ({{ $employee->employee_code }})
                                </option>
                            @endforeach
                        </select>
                        @error('employee_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="leave_type" class="form-label">Leave Type <span class="text-danger">*</span></label>
                        <select name="leave_type" id="leave_type" class="form-select" required>
                            <option value="">Select Leave Type</option>
                            <option value="sick" {{ old('leave_type') == 'sick' ? 'selected' : '' }}>Sick Leave</option>
                            <option value="casual" {{ old('leave_type') == 'casual' ? 'selected' : '' }}>Casual Leave</option>
                            <option value="annual" {{ old('leave_type') == 'annual' ? 'selected' : '' }}>Annual Leave</option>
                            <option value="maternity" {{ old('leave_type') == 'maternity' ? 'selected' : '' }}>Maternity Leave</option>
                            <option value="paternity" {{ old('leave_type') == 'paternity' ? 'selected' : '' }}>Paternity Leave</option>
                            <option value="emergency" {{ old('leave_type') == 'emergency' ? 'selected' : '' }}>Emergency Leave</option>
                            <option value="other" {{ old('leave_type') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('leave_type')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') }}" required>
                                @error('start_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date') }}" required>
                                @error('end_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="days" class="form-label">Number of Days</label>
                        <input type="number" name="days" id="days" class="form-control" value="{{ old('days') }}" min="0.5" step="0.5">
                        @error('days')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject <span class="text-danger">*</span></label>
                        <input type="text" name="subject" id="subject" class="form-control" value="{{ old('subject') }}" placeholder="Brief subject for the leave request" required>
                        @error('subject')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea name="description" id="description" class="form-control" rows="4" placeholder="Detailed description of the leave request" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="file" class="form-label">Attachment (Optional)</label>
                        <input type="file" name="file" id="file" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        @error('file')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.leave-requests.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Leave Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('start_date').addEventListener('change', calculateDays);
document.getElementById('end_date').addEventListener('change', calculateDays);

function calculateDays() {
    const startDate = new Date(document.getElementById('start_date').value);
    const endDate = new Date(document.getElementById('end_date').value);

    if (startDate && endDate && startDate <= endDate) {
        const timeDiff = endDate.getTime() - startDate.getTime();
        const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1; // +1 to include both start and end dates
        document.getElementById('days').value = daysDiff;
    }
}
</script>
@endsection
