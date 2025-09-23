@extends('layouts.admin')

@section('page-title', 'Attendance Management')
@section('page-description', 'Manage employee attendance records')

@section('content')
<div class="mb-3 d-flex justify-content-between align-items-center">
    <form method="GET" action="{{ route('attendance.index') }}" class="d-flex align-items-center gap-2">
        <label for="date" class="form-label mb-0">Select Date:</label>
        <input type="date" id="date" name="date" value="{{ $date ?? \Carbon\Carbon::today()->format('Y-m-d') }}" class="form-control" style="max-width: 200px;">
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>

    <a href="{{ route('attendance.monthly') }}" class="btn btn-info">View Monthly Attendance</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="mb-3">
    <h5>Quick Attendance Actions</h5>
    <small class="text-muted">Click the buttons below to mark attendance for each employee</small>
</div>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Employee</th>
            <th>Current Status</th>
            <th>Marked At</th>
            <th>Quick Actions</th>
            {{-- <th>Remarks</th> --}}
            <th>Management</th>
        </tr>
    </thead>
    <tbody>
        @foreach($employees as $employee)
            @php
                $attendance = $employee->attendance->first();
                $currentStatus = $attendance ? $attendance->status : 'Not Marked';
                $markedAt = $attendance ? $attendance->updated_at->setTimezone('Asia/Kolkata')->format('H:i:s') : '-';
            @endphp
            <tr id="employee-row-{{ $employee->id }}">
                <td>{{ $employee->name }}</td>
                <td>
                    <span id="status-{{ $employee->id }}" class="badge
                        @if($currentStatus == 'Present') bg-success
                        @elseif($currentStatus == 'Absent') bg-danger
                        @elseif($currentStatus == 'Leave') bg-warning
                        @elseif($currentStatus == 'Half Day') bg-info
                        @else bg-secondary
                        @endif">
                        {{ $currentStatus }}
                    </span>
                </td>
                <td>
                    {{ $markedAt }}
                </td>
                <td>
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn {{ $attendance ? 'btn-secondary' : 'btn-success' }}" {{ $attendance ? 'disabled' : '' }} onclick="{{ $attendance ? '' : 'markAttendance(' . $employee->id . ', \'Present\', \'' . ($date ?? \Carbon\Carbon::today()->format('Y-m-d')) . '\')' }}" title="Present">{{ $attendance ? 'Marked' : 'P' }}</button>
                        <button type="button" class="btn {{ $attendance ? 'btn-secondary' : 'btn-danger' }}" {{ $attendance ? 'disabled' : '' }} onclick="{{ $attendance ? '' : 'markAttendance(' . $employee->id . ', \'Absent\', \'' . ($date ?? \Carbon\Carbon::today()->format('Y-m-d')) . '\')' }}" title="Absent">{{ $attendance ? 'Marked' : 'A' }}</button>
                        <button type="button" class="btn {{ $attendance ? 'btn-secondary' : 'btn-warning' }}" {{ $attendance ? 'disabled' : '' }} onclick="{{ $attendance ? '' : 'markAttendance(' . $employee->id . ', \'Leave\', \'' . ($date ?? \Carbon\Carbon::today()->format('Y-m-d')) . '\')' }}" title="Leave">{{ $attendance ? 'Marked' : 'L' }}</button>
                        <button type="button" class="btn {{ $attendance ? 'btn-secondary' : 'btn-info' }}" {{ $attendance ? 'disabled' : '' }} onclick="{{ $attendance ? '' : 'markAttendance(' . $employee->id . ', \'Half Day\', \'' . ($date ?? \Carbon\Carbon::today()->format('Y-m-d')) . '\')' }}" title="Half Day">{{ $attendance ? 'Marked' : 'HD' }}</button>
                    </div>
                </td>
                {{-- <td>
                    @if($attendance)
                        <input type="text" id="remarks-{{ $employee->id }}" class="form-control form-control-sm" value="{{ $attendance->remarks }}" placeholder="Add remarks..." onchange="updateRemarks({{ $employee->id }}, this.value)">
                    @else
                        <input type="text" id="remarks-{{ $employee->id }}" class="form-control form-control-sm" placeholder="Add remarks..." onchange="updateRemarks({{ $employee->id }}, this.value)">
                    @endif
                </td> --}}
                <td>
                    @if($attendance)
                        <a href="{{ route('attendance.edit', $attendance->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('attendance.destroy', $attendance->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this attendance record?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    @else
                        <a href="{{ route('attendance.create') }}" class="btn btn-sm btn-success">Add</a>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Hidden form for AJAX submission -->
<form id="attendance-form" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="employee_id" id="form-employee-id">
    <input type="hidden" name="date" id="form-date">
    <input type="hidden" name="status" id="form-status">
    <input type="hidden" name="remarks" id="form-remarks">
</form>

<script>
function markAttendance(employeeId, status, date) {
    // Disable the buttons to prevent multiple clicks
    const buttons = document.querySelectorAll('#employee-row-' + employeeId + ' .btn-group button');
    buttons.forEach(button => {
        button.disabled = true;
        button.textContent = 'Marked';
        button.classList.add('btn-secondary');
    });

    // Update the status badge immediately
    const statusElement = document.getElementById('status-' + employeeId);
    statusElement.className = 'badge ' + getStatusClass(status);
    statusElement.textContent = status;

    // Update the "Marked At" time immediately
    const now = new Date();
    const kolkataTime = new Intl.DateTimeFormat('en-IN', {
        timeZone: 'Asia/Kolkata',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    }).format(now);
    const markedAtElement = document.querySelector('#employee-row-' + employeeId + ' td:nth-child(3)');
    if (markedAtElement) {
        markedAtElement.textContent = kolkataTime;
    }

    // Prepare form data
    document.getElementById('form-employee-id').value = employeeId;
    document.getElementById('form-date').value = date;
    document.getElementById('form-status').value = status;
    const remarksElement = document.getElementById('remarks-' + employeeId);
    document.getElementById('form-remarks').value = remarksElement ? remarksElement.value : '';

    // Submit the form via AJAX
    const form = document.getElementById('attendance-form');
    const formData = new FormData(form);

    fetch('{{ route("attendance.store") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => {
        // Check if response is JSON
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
            return response.json();
        } else {
            // If not JSON, it's likely an HTML error page (e.g., login redirect)
            if (response.status === 401 || response.status === 419) {
                throw new Error('Authentication required. Please refresh the page and log in again.');
            } else {
                throw new Error('Server returned an unexpected response. Please try again.');
            }
        }
    })
    .then(data => {
        if (data.success) {
            // Update management buttons
            const managementCell = document.querySelector('#employee-row-' + employeeId + ' td:last-child');
            if (managementCell && data.attendance) {
                const editUrl = '{{ route("attendance.edit", ":id") }}'.replace(':id', data.attendance.id);
                const deleteUrl = '{{ route("attendance.destroy", ":id") }}'.replace(':id', data.attendance.id);
                const csrfToken = '{{ csrf_token() }}';

                managementCell.innerHTML = `
                    <a href="${editUrl}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="${deleteUrl}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this attendance record?');">
                        <input type="hidden" name="_token" value="${csrfToken}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                `;
            }

            // Show success message
            showAlert('Attendance marked successfully!', 'success');
        } else {
            // Re-enable buttons on error
            buttons.forEach(button => {
                button.disabled = false;
                button.textContent = button.title;
                button.classList.remove('btn-secondary');
            });
            // Show error message
            showAlert('Error marking attendance: ' + (data.message || 'Unknown error'), 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Re-enable buttons on error
        buttons.forEach(button => {
            button.disabled = false;
            button.textContent = button.title;
            button.classList.remove('btn-secondary');
        });
        if (error.message.includes('Authentication required')) {
            showAlert(error.message, 'warning');
        } else {
            showAlert('Error marking attendance: ' + error.message, 'danger');
        }
    });
}

function updateRemarks(employeeId, remarks) {
    // This will be called when remarks input changes
    // You can implement AJAX update for remarks here if needed
    console.log('Remarks updated for employee ' + employeeId + ': ' + remarks);
}

function getStatusClass(status) {
    switch(status) {
        case 'Present': return 'bg-success';
        case 'Absent': return 'bg-danger';
        case 'Leave': return 'bg-warning';
        case 'Half Day': return 'bg-info';
        default: return 'bg-secondary';
    }
}

function showAlert(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    // Insert at the top of the content
    const contentWrapper = document.querySelector('.content-wrapper');
    contentWrapper.insertBefore(alertDiv, contentWrapper.firstChild);

    // Auto remove after 3 seconds
    setTimeout(() => {
        alertDiv.remove();
    }, 3000);
}
</script>
@endsection
