@extends('layouts.admin')

@section('page-title', 'Attendance Management')
@section('page-description', 'Manage employee attendance records')

@section('content')
<div class="mb-3 d-flex justify-content-between align-items-center">
    <form method="GET" action="{{ route('attendance.index') }}" class="d-flex align-items-center gap-2">
        <label for="date" class="form-label mb-0">Select Date:</label>
        <input type="date" id="date" name="date" value="{{ $date ?? \Carbon\Carbon::today('Asia/Kolkata')->format('Y-m-d') }}" class="form-control" style="max-width: 200px;">
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>

    <div class="d-flex gap-2">
        <a href="{{ route('admin.sync-office-ip') }}" class="btn btn-warning">
            <i class="fas fa-sync"></i> Sync Office IP
        </a>
        <a href="{{ route('attendance.monthly') }}" class="btn btn-info">View Monthly Attendance</a>
        <a href="{{ route('admin.leave-requests.index') }}" class="btn btn-success">Manage Leave Requests</a>
        <a href="{{ route('attendance.export-today-pdf', ['date' => $date ?? \Carbon\Carbon::today()->format('Y-m-d')]) }}" class="btn btn-danger" target="_blank">
            <i class="fas fa-download"></i> Download PDF
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="mb-3">
    <h5>Quick Attendance Actions</h5>
    <small class="text-muted">Click the buttons below to mark attendance for each employee</small>
</div>

<div style="overflow-x: auto;">
<table class="table table-striped table-bordered" style="min-width: 1200px;">
    <thead>
        <tr>
            <th>Employee</th>
            <th>Current Status</th>
            <th>Quick Actions</th>
            <th>Mark In</th>
            <th>Mark Out</th>
            <th>Break Time</th>
            <th>TWH</th>
            {{-- <th>Remarks</th> --}}
            <th style="min-width: 280px;">Management</th>
        </tr>
    </thead>
    <tbody>
        @foreach($employees as $employee)
            @php
                $attendance = $employee->attendance->first();
                $currentStatus = $attendance ? $attendance->status : 'Not Marked';
                $markedAt = $attendance ? $attendance->updated_at->setTimezone('Asia/Kolkata')->format('H:i:s') : '-';
                $twh = '-';
                if ($attendance && $attendance->mark_in && $attendance->mark_out) {
                    $markIn = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' . $attendance->mark_in);
                    $markOut = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' . $attendance->mark_out);
                    $totalSeconds = $markOut->diffInSeconds($markIn, false);

                    // TWH = Mark Out - Mark In
                    $workingSeconds = max(0, $totalSeconds);
                    $hours = floor($workingSeconds / 3600);
                    $minutes = floor(($workingSeconds % 3600) / 60);
                    $seconds = $workingSeconds % 60;
                    $twh = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
                }
            @endphp
            <tr id="employee-row-{{ $employee->id }}">
                <td>{{ $employee->name }}</td>
                <td>
                    <span id="status-{{ $employee->id }}" class="badge
                        @if($currentStatus == 'Present') bg-success
                        @elseif($currentStatus == 'Absent') bg-danger
                        @elseif($currentStatus == 'Leave') bg-warning
                        @elseif($currentStatus == 'Half Day') bg-info
                        @elseif($currentStatus == 'Holiday') bg-primary
                        @elseif($currentStatus == 'NCNS') bg-danger
                        @elseif($currentStatus == 'LWP') bg-warning
                        @else bg-secondary
                        @endif">
                        {{ $currentStatus }}
                    </span>
                </td>
                <td>
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn {{ $attendance ? 'btn-secondary' : 'btn-success' }}" {{ $attendance ? 'disabled' : '' }} onclick="{{ $attendance ? '' : 'markAttendance(' . $employee->id . ', \'Present\', \'' . ($date ?? \Carbon\Carbon::today()->format('Y-m-d')) . '\')' }}" title="Present">{{ $attendance ? 'Marked' : 'P' }}</button>
                        <button type="button" class="btn {{ $attendance ? 'btn-secondary' : 'btn-danger' }}" {{ $attendance ? 'disabled' : '' }} onclick="{{ $attendance ? '' : 'markAttendance(' . $employee->id . ', \'Absent\', \'' . ($date ?? \Carbon\Carbon::today()->format('Y-m-d')) . '\')' }}" title="Absent">{{ $attendance ? 'Marked' : 'A' }}</button>
                        <button type="button" class="btn {{ $attendance ? 'btn-secondary' : 'btn-warning' }}" {{ $attendance ? 'disabled' : '' }} onclick="{{ $attendance ? '' : 'markAttendance(' . $employee->id . ', \'Leave\', \'' . ($date ?? \Carbon\Carbon::today()->format('Y-m-d')) . '\')' }}" title="Leave">{{ $attendance ? 'Marked' : 'L' }}</button>
                        <button type="button" class="btn {{ $attendance ? 'btn-secondary' : 'btn-info' }}" {{ $attendance ? 'disabled' : '' }} onclick="{{ $attendance ? '' : 'markAttendance(' . $employee->id . ', \'Half Day\', \'' . ($date ?? \Carbon\Carbon::today()->format('Y-m-d')) . '\')' }}" title="Half Day">{{ $attendance ? 'Marked' : 'HD' }}</button>
                        <button type="button" class="btn {{ $attendance ? 'btn-secondary' : 'btn-primary' }}" {{ $attendance ? 'disabled' : '' }} onclick="{{ $attendance ? '' : 'markAttendance(' . $employee->id . ', \'Holiday\', \'' . ($date ?? \Carbon\Carbon::today()->format('Y-m-d')) . '\')' }}" title="Holiday">{{ $attendance ? 'Marked' : 'H' }}</button>
                        <button type="button" class="btn {{ $attendance ? 'btn-secondary' : 'btn-danger' }}" {{ $attendance ? 'disabled' : '' }} onclick="{{ $attendance ? '' : 'markAttendance(' . $employee->id . ', \'NCNS\', \'' . ($date ?? \Carbon\Carbon::today()->format('Y-m-d')) . '\')' }}" title="NCNS">{{ $attendance ? 'Marked' : 'NCNS' }}</button>
                        <button type="button" class="btn {{ $attendance ? 'btn-secondary' : 'btn-warning' }}" {{ $attendance ? 'disabled' : '' }} onclick="{{ $attendance ? '' : 'markAttendance(' . $employee->id . ', \'LWP\', \'' . ($date ?? \Carbon\Carbon::today()->format('Y-m-d')) . '\')' }}" title="LWP">{{ $attendance ? 'Marked' : 'LWP' }}</button>
                    </div>
                </td>
                <td>
                    @if($attendance && $attendance->mark_in)
                        {{ $attendance->mark_in }}
                    @elseif($attendance)
                        <button class="btn btn-sm btn-primary" onclick="markIn({{ $attendance->id }}, {{ $employee->id }})">Mark In</button>
                    @else
                        <button class="btn btn-sm btn-primary" onclick="markInDirect({{ $employee->id }}, '{{ $date ?? \Carbon\Carbon::today()->format('Y-m-d') }}')">Mark In</button>
                    @endif
                </td>
                <td>
                    @if($attendance && $attendance->mark_out)
                        {{ $attendance->mark_out }}
                    @elseif($attendance && $attendance->mark_in)
                        <button class="btn btn-sm btn-success" onclick="markTime({{ $attendance->id }}, {{ $employee->id }}, 'mark_out')">Mark Out</button>
                    @elseif($attendance)
                        <button class="btn btn-sm btn-success" onclick="markOutDirect({{ $employee->id }}, '{{ $date ?? \Carbon\Carbon::today()->format('Y-m-d') }}')">Mark Out</button>
                    @else
                        <button class="btn btn-sm btn-success" onclick="markOutDirect({{ $employee->id }}, '{{ $date ?? \Carbon\Carbon::today()->format('Y-m-d') }}')">Mark Out</button>
                    @endif
                </td>
                <td>
                    @if($attendance && $attendance->break_time)
                        {{ $attendance->break_time }}
                    @elseif($attendance && $attendance->break_start)
                        <button class="btn btn-sm btn-danger" id="break-btn-{{ $employee->id }}" onclick="endBreakDirect({{ $employee->id }}, '{{ $date ?? \Carbon\Carbon::today()->format('Y-m-d') }}')">End Break</button>
                    @elseif($attendance && $attendance->mark_in)
                        <button class="btn btn-sm btn-warning" id="break-btn-{{ $employee->id }}" onclick="startBreakDirect({{ $employee->id }}, '{{ $date ?? \Carbon\Carbon::today()->format('Y-m-d') }}')">Start Break</button>
                    @elseif($attendance)
                        <button class="btn btn-sm btn-warning" id="break-btn-{{ $employee->id }}" onclick="startBreakDirect({{ $employee->id }}, '{{ $date ?? \Carbon\Carbon::today()->format('Y-m-d') }}')">Start Break</button>
                    @else
                        <button class="btn btn-sm btn-warning" id="break-btn-{{ $employee->id }}" onclick="startBreakDirect({{ $employee->id }}, '{{ $date ?? \Carbon\Carbon::today()->format('Y-m-d') }}')">Start Break</button>
                    @endif
                </td>
                <td>{{ $twh }}</td>
                {{-- <td>
                    @if($attendance)
                        <input type="text" id="remarks-{{ $employee->id }}" class="form-control form-control-sm" value="{{ $attendance->remarks }}" placeholder="Add remarks..." onchange="updateRemarks({{ $employee->id }}, this.value)">
                    @else
                        <input type="text" id="remarks-{{ $employee->id }}" class="form-control form-control-sm" placeholder="Add remarks..." onchange="updateRemarks({{ $employee->id }}, this.value)">
                    @endif
                </td> --}}
                <td>
    @if($attendance)
        <button class="btn btn-sm btn-info"
                onclick="openAttendanceModal({{ $attendance->id }})">
            View
        </button>

        <a href="{{ route('attendance.edit', $attendance->id) }}" class="btn btn-sm btn-warning">Edit</a>

        <form action="{{ route('attendance.destroy', $attendance->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this attendance record?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
        </form>
    @else
        <a href="{{ route('attendance.create') }}" class="btn btn-sm btn-success">Add</a>
    @endif

    @if($employee->status === 'active')
        <form action="{{ route('employees.terminate', $employee) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to terminate this employee?');">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-sm btn-outline-danger mx-1" title="Terminate">
                <i class="fas fa-user-times"></i>
            </button>
        </form>
        <form action="{{ route('employees.resign', $employee) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to mark this employee as resigned?');">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-sm btn-outline-warning mx-1" title="Resign">
                <i class="fas fa-sign-out-alt"></i>
            </button>
        </form>
    @endif
</td>

            </tr>
        @endforeach
    </tbody>
</table>
</div>

<!-- Hidden form for AJAX submission -->
<form id="attendance-form" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="employee_id" id="form-employee-id">
    <input type="hidden" name="date" id="form-date">
    <input type="hidden" name="status" id="form-status">
    <input type="hidden" name="remarks" id="form-remarks">
</form>
<!-- Attendance View Modal -->
<div class="modal fade" id="attendanceViewModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Attendance Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="attendance-modal-content">
                <div class="text-center">
                    <div class="spinner-border text-primary"></div>
                    <p class="mt-2">Loading attendance...</p>
                </div>
            </div>

        </div>
    </div>
</div>


<script>
function markAttendance(employeeId, status, date) {
    // Add validation/confirmation before proceeding
    const employeeName = document.querySelector(`#employee-row-${employeeId} td:first-child`).textContent.trim();
    const confirmed = confirm(`Are you sure you want to mark ${employeeName} as "${status}" for ${date}?`);

    if (!confirmed) {
        return; // Exit if user cancels
    }

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
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
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
                    <button class="btn btn-sm btn-info"
                            onclick="openAttendanceModal(${data.attendance.id})">
                        View
                    </button>
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

            // Do not refresh the page - buttons are already disabled and UI updated
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
        case 'Holiday': return 'bg-primary';
        case 'NCNS': return 'bg-danger';
        case 'LWP': return 'bg-warning';
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

function markIn(attendanceId, employeeId) {
    const now = new Date();
    const kolkataTime = new Intl.DateTimeFormat('en-IN', {
        timeZone: 'Asia/Kolkata',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false
    }).format(now);

    // Determine status based on time
    const [hours, minutes] = kolkataTime.split(':').map(Number);
    const totalMinutes = hours * 60 + minutes;
    const cutoffMinutes = 9 * 60 + 30; // 9:30 AM
    const status = totalMinutes <= cutoffMinutes ? 'Present' : 'Half Day';

    // Update the UI immediately
    const markInCell = document.querySelector(`#employee-row-${employeeId} td:nth-child(4)`);
    if (markInCell) {
        markInCell.innerHTML = kolkataTime;
    }

    const statusCell = document.querySelector(`#employee-row-${employeeId} td:nth-child(2) span`);
    if (statusCell) {
        statusCell.className = 'badge ' + getStatusClass(status);
        statusCell.textContent = status;
    }

    // Send AJAX request to update the backend
    fetch(`/admin/attendance/${attendanceId}/mark-in`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            mark_in: kolkataTime,
            status: status
        })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            showAlert('Error updating mark in time: ' + (data.message || 'Unknown error'), 'danger');
            // Revert UI changes on error
            if (markInCell) markInCell.innerHTML = '<button class="btn btn-sm btn-primary" onclick="markIn(' + attendanceId + ', ' + employeeId + ')">Mark In</button>';
            if (statusCell) {
                statusCell.className = 'badge bg-secondary';
                statusCell.textContent = 'Not Marked';
            }
        } else {
            showAlert('Mark in time updated successfully!', 'success');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error updating mark in time: ' + error.message, 'danger');
        // Revert UI changes on error
        if (markInCell) markInCell.innerHTML = '<button class="btn btn-sm btn-primary" onclick="markIn(' + attendanceId + ', ' + employeeId + ')">Mark In</button>';
        if (statusCell) {
            statusCell.className = 'badge bg-secondary';
            statusCell.textContent = 'Not Marked';
        }
    });
}

function markInDirect(employeeId, date) {

    const now = new Date();
    const kolkataTime = new Intl.DateTimeFormat('en-IN', {
        timeZone: 'Asia/Kolkata',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false
    }).format(now);

    // Determine status based on time
    const [hours, minutes] = kolkataTime.split(':').map(Number);
    const totalMinutes = hours * 60 + minutes;
    const cutoffMinutes = 9 * 60 + 30; // 9:30 AM
    const status = totalMinutes <= cutoffMinutes ? 'Present' : 'Half Day';

    // Update the UI immediately
    const markInCell = document.querySelector(`#employee-row-${employeeId} td:nth-child(4)`);
    if (markInCell) {
        markInCell.innerHTML = kolkataTime;
    }

    const statusCell = document.querySelector(`#employee-row-${employeeId} td:nth-child(2) span`);
    if (statusCell) {
        statusCell.className = 'badge ' + getStatusClass(status);
        statusCell.textContent = status;
    }

    // Update management buttons
    const managementCell = document.querySelector(`#employee-row-${employeeId} td:last-child`);
    if (managementCell) {
        managementCell.innerHTML = `
            <button class="btn btn-sm btn-info" onclick="openAttendanceModal(0)">
                View
            </button>
            <a href="#" class="btn btn-sm btn-warning">Edit</a>
            <form action="#" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this attendance record?');">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
            </form>
        `;
    }

    // Send AJAX request to create attendance and mark in
    fetch('/admin/attendance/mark-in-direct', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            employee_id: employeeId,
            date: date,
            mark_in: kolkataTime,
            status: status
        })
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
        if (!data.success) {
            showAlert('Error marking in: ' + (data.message || 'Unknown error'), 'danger');
            // Revert UI changes on error
            if (markInCell) markInCell.innerHTML = '<button class="btn btn-sm btn-primary" onclick="markInDirect(' + employeeId + ', \'' + date + '\')">Mark In</button>';
            if (statusCell) {
                statusCell.className = 'badge bg-secondary';
                statusCell.textContent = 'Not Marked';
            }
            if (managementCell) {
                managementCell.innerHTML = '<a href="{{ route('attendance.create') }}" class="btn btn-sm btn-success">Add</a>';
            }
        } else {
            showAlert('Mark in successful! Status: ' + status, 'success');
            // Update the attendance ID in the buttons for future operations
            if (data.attendance && data.attendance.id) {
                const markOutCell = document.querySelector(`#employee-row-${employeeId} td:nth-child(5)`);
                const breakCell = document.querySelector(`#employee-row-${employeeId} td:nth-child(6)`);

                if (markOutCell && markOutCell.innerHTML === '-') {
                    markOutCell.innerHTML = '<button class="btn btn-sm btn-success" onclick="markTime(' + data.attendance.id + ', ' + employeeId + ', \'mark_out\')">Mark Out</button>';
                }
                if (breakCell && breakCell.innerHTML === '-') {
                    breakCell.innerHTML = '<button class="btn btn-sm btn-warning" id="break-btn-' + employeeId + '" onclick="startBreak(' + data.attendance.id + ', ' + employeeId + ')">Start Break</button>';
                }
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error marking in: ' + error.message, 'danger');
        // Revert UI changes on error
        if (markInCell) markInCell.innerHTML = '<button class="btn btn-sm btn-primary" onclick="markInDirect(' + employeeId + ', \'' + date + '\')">Mark In</button>';
        if (statusCell) {
            statusCell.className = 'badge bg-secondary';
            statusCell.textContent = 'Not Marked';
        }
        if (managementCell) {
            managementCell.innerHTML = '<a href="{{ route('attendance.create') }}" class="btn btn-sm btn-success">Add</a>';
        }
    });
}

function markOutDirect(employeeId, date) {
    // Frontend validation: Check if Mark In has been done
    const markInCell = document.querySelector(`#employee-row-${employeeId} td:nth-child(4)`);
    if (markInCell && (markInCell.textContent.trim() === '-' || markInCell.querySelector('button'))) {
        toastr.error('Mark In is required before Mark Out.');
        return;
    }

    const now = new Date();
    const kolkataTime = new Intl.DateTimeFormat('en-IN', {
        timeZone: 'Asia/Kolkata',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false
    }).format(now);

    // Update the UI immediately
    const markOutCell = document.querySelector(`#employee-row-${employeeId} td:nth-child(5)`);
    if (markOutCell) {
        markOutCell.innerHTML = kolkataTime;
    }

    // Calculate and update TWH immediately if mark in exists
    const breakTimeCell = document.querySelector(`#employee-row-${employeeId} td:nth-child(6)`);
    const twhCell = document.querySelector(`#employee-row-${employeeId} td:nth-child(7)`);

    if (markInCell && twhCell) {
        const markInTime = markInCell.textContent.trim();
        if (markInTime && markInTime !== '-') {
            // Calculate TWH = Mark Out - Mark In - Break Time
            let totalSeconds = timeDifferenceInSeconds(markInTime, kolkataTime);

            // Subtract break time if it exists
            if (breakTimeCell) {
                const breakTimeText = breakTimeCell.textContent.trim();
                if (breakTimeText && breakTimeText !== '-') {
                    const breakSeconds = timeToSeconds(breakTimeText);
                    totalSeconds = Math.max(0, totalSeconds - breakSeconds);
                }
            }

            const hours = Math.floor(totalSeconds / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            const seconds = Math.floor(totalSeconds % 60);
            const twh = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            twhCell.textContent = twh;
        }
    }

    // Update management buttons
    const managementCell = document.querySelector(`#employee-row-${employeeId} td:last-child`);
    if (managementCell) {
        managementCell.innerHTML = `
            <button class="btn btn-sm btn-info" onclick="openAttendanceModal(0)">
                View
            </button>
            <a href="#" class="btn btn-sm btn-warning">Edit</a>
            <form action="#" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this attendance record?');">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
            </form>
        `;
    }

    // Send AJAX request to create attendance and mark out
    fetch('/admin/attendance/mark-out-direct', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            employee_id: employeeId,
            date: date,
            mark_out: kolkataTime
        })
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
        if (!data.success) {
            showAlert('Error marking out: ' + (data.message || 'Unknown error'), 'danger');
            // Revert UI changes on error
            if (markOutCell) markOutCell.innerHTML = '<button class="btn btn-sm btn-success" onclick="markOutDirect(' + employeeId + ', \'' + date + '\')">Mark Out</button>';
            if (twhCell) twhCell.textContent = '-';
            if (managementCell) {
                managementCell.innerHTML = '<a href="{{ route('attendance.create') }}" class="btn btn-sm btn-success">Add</a>';
            }
        } else {
            showAlert('Mark out successful!', 'success');
            // Update the attendance ID in the buttons for future operations
            if (data.attendance && data.attendance.id) {
                const markInCell = document.querySelector(`#employee-row-${employeeId} td:nth-child(4)`);
                const breakCell = document.querySelector(`#employee-row-${employeeId} td:nth-child(6)`);

                if (markInCell && markInCell.innerHTML === '-') {
                    markInCell.innerHTML = '<button class="btn btn-sm btn-primary" onclick="markIn(' + data.attendance.id + ', ' + employeeId + ')">Mark In</button>';
                }
                if (breakCell && breakCell.innerHTML === '-') {
                    breakCell.innerHTML = '<button class="btn btn-sm btn-warning" id="break-btn-' + employeeId + '" onclick="startBreak(' + data.attendance.id + ', ' + employeeId + ')">Start Break</button>';
                }
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error marking out: ' + error.message, 'danger');
        // Revert UI changes on error
        if (markOutCell) markOutCell.innerHTML = '<button class="btn btn-sm btn-success" onclick="markOutDirect(' + employeeId + ', \'' + date + '\')">Mark Out</button>';
        if (twhCell) twhCell.textContent = '-';
        if (managementCell) {
            managementCell.innerHTML = '<a href="{{ route('attendance.create') }}" class="btn btn-sm btn-success">Add</a>';
        }
    });
}

function startBreakDirect(employeeId, date) {
    // Frontend validation: Check if Mark In has been done
    const markInCell = document.querySelector(`#employee-row-${employeeId} td:nth-child(4)`);
    if (markInCell && (markInCell.textContent.trim() === '-' || markInCell.querySelector('button'))) {
        toastr.error('Mark In is required before starting break.');
        return;
    }

    const now = new Date();
    const kolkataTime = new Intl.DateTimeFormat('en-IN', {
        timeZone: 'Asia/Kolkata',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false
    }).format(now);

    // Store break start time
    if (!window.breakStartTimes) {
        window.breakStartTimes = {};
    }
    window.breakStartTimes[employeeId] = now;

    // Update the UI immediately - change button to "End Break"
    const breakCell = document.querySelector(`#employee-row-${employeeId} td:nth-child(6)`);
    if (breakCell) {
        breakCell.innerHTML = '<button class="btn btn-sm btn-danger" onclick="endBreakDirect(' + employeeId + ', \'' + date + '\')">End Break</button>';
    }

    // Update management buttons
    const managementCell = document.querySelector(`#employee-row-${employeeId} td:last-child`);
    if (managementCell) {
        managementCell.innerHTML = `
            <button class="btn btn-sm btn-info" onclick="openAttendanceModal(0)">
                View
            </button>
            <a href="#" class="btn btn-sm btn-warning">Edit</a>
            <form action="#" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this attendance record?');">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
            </form>
        `;
    }

    showAlert('Break started! Click "End Break" to stop timing.', 'info');
}

function endBreakDirect(employeeId, date) {
    const now = new Date();
    const kolkataTime = new Intl.DateTimeFormat('en-IN', {
        timeZone: 'Asia/Kolkata',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false
    }).format(now);

    // If we have stored break start time, calculate duration on frontend
    let breakTimeString = kolkataTime; // Default to current time as end time
    let calculatedDuration = null;

    if (window.breakStartTimes && window.breakStartTimes[employeeId]) {
        const breakStartTime = window.breakStartTimes[employeeId];
        const breakEndTime = now;
        const breakDurationMs = breakEndTime - breakStartTime;
        const breakDurationSeconds = Math.floor(breakDurationMs / 1000);
        const breakDurationHours = Math.floor(breakDurationSeconds / 3600);
        const breakDurationMinutes = Math.floor((breakDurationSeconds % 3600) / 60);
        const breakDurationSecondsRemainder = breakDurationSeconds % 60;
        calculatedDuration = `${breakDurationHours.toString().padStart(2, '0')}:${breakDurationMinutes.toString().padStart(2, '0')}:${breakDurationSecondsRemainder.toString().padStart(2, '0')}`;
        breakTimeString = calculatedDuration;
    }

    // Update the UI immediately with calculated duration or placeholder
    const breakCell = document.querySelector(`#employee-row-${employeeId} td:nth-child(6)`);
    if (breakCell) {
        breakCell.innerHTML = calculatedDuration || 'Processing...';
    }

    // Send AJAX request to create attendance and save break time
    fetch('/admin/attendance/end-break-direct', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            employee_id: employeeId,
            date: date,
            break_time: kolkataTime // Always send current time as end time
        })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            showAlert('Error saving break time: ' + (data.message || 'Unknown error'), 'danger');
            // Revert UI changes on error
            if (breakCell) breakCell.innerHTML = '<button class="btn btn-sm btn-warning" id="break-btn-' + employeeId + '" onclick="startBreakDirect(' + employeeId + ', \'' + date + '\')">Start Break</button>';
        } else {
            // Update UI with actual break duration from backend
            if (breakCell && data.attendance && data.attendance.break_time) {
                breakCell.innerHTML = data.attendance.break_time;
            }

            // Calculate and update TWH if mark in and mark out exist
            const markInCell = document.querySelector(`#employee-row-${employeeId} td:nth-child(4)`);
            const markOutCell = document.querySelector(`#employee-row-${employeeId} td:nth-child(5)`);
            const twhCell = document.querySelector(`#employee-row-${employeeId} td:nth-child(7)`);

            if (markInCell && markOutCell && twhCell && data.attendance && data.attendance.break_time) {
                const markInTime = markInCell.textContent.trim();
                const markOutTime = markOutCell.textContent.trim();

                if (markInTime && markInTime !== '-' && markOutTime && markOutTime !== '-') {
                    // Calculate TWH = Mark Out - Mark In - Break Time
                    let totalSeconds = timeDifferenceInSeconds(markInTime, markOutTime);
                    const breakSeconds = timeToSeconds(data.attendance.break_time);
                    totalSeconds = Math.max(0, totalSeconds - breakSeconds);

                    const hours = Math.floor(totalSeconds / 3600);
                    const minutes = Math.floor((totalSeconds % 3600) / 60);
                    const seconds = Math.floor(totalSeconds % 60);
                    const twh = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                    twhCell.textContent = twh;
                }
            }

            showAlert('Break ended successfully!', 'success');

            // Update the attendance ID in the buttons for future operations
            if (data.attendance && data.attendance.id) {
                const markInCell = document.querySelector(`#employee-row-${employeeId} td:nth-child(4)`);
                const markOutCell = document.querySelector(`#employee-row-${employeeId} td:nth-child(5)`);

                if (markInCell && markInCell.innerHTML === '-') {
                    markInCell.innerHTML = '<button class="btn btn-sm btn-primary" onclick="markIn(' + data.attendance.id + ', ' + employeeId + ')">Mark In</button>';
                }
                if (markOutCell && markOutCell.innerHTML === '-') {
                    markOutCell.innerHTML = '<button class="btn btn-sm btn-success" onclick="markTime(' + data.attendance.id + ', ' + employeeId + ', \'mark_out\')">Mark Out</button>';
                }
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error saving break time: ' + error.message, 'danger');
        // Revert UI changes on error
        if (breakCell) breakCell.innerHTML = '<button class="btn btn-sm btn-warning" id="break-btn-' + employeeId + '" onclick="startBreakDirect(' + employeeId + ', \'' + date + '\')">Start Break</button>';
    });

    // Clean up break start time
    if (window.breakStartTimes && window.breakStartTimes[employeeId]) {
        delete window.breakStartTimes[employeeId];
    }
}

function markTime(attendanceId, employeeId, action) {
    // Frontend validation: For mark_out, check if Mark In has been done
    if (action === 'mark_out') {
        const markInCell = document.querySelector(`#employee-row-${employeeId} td:nth-child(4)`);
        if (markInCell && (markInCell.textContent.trim() === '-' || markInCell.querySelector('button'))) {
            toastr.error('Mark In is required before Mark Out.');
            return;
        }
    }

    const now = new Date();
    const kolkataTime = new Intl.DateTimeFormat('en-IN', {
        timeZone: 'Asia/Kolkata',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false
    }).format(now);

    // Update the UI immediately
    const cell = document.querySelector(`#employee-row-${employeeId} td:nth-child(${action === 'mark_out' ? 5 : 6})`);
    if (cell) {
        cell.innerHTML = kolkataTime;
    }

    // If marking out, calculate and update TWH
    if (action === 'mark_out') {
        console.log('Marking out for employee:', employeeId);
        const markInCell = document.querySelector(`#employee-row-${employeeId} td:nth-child(4)`);
        const twhCell = document.querySelector(`#employee-row-${employeeId} td:nth-child(7)`);

        console.log('markInCell:', markInCell);
        console.log('twhCell:', twhCell);

        if (markInCell && twhCell) {
            const markInTime = markInCell.textContent.trim();
            console.log('markInTime:', markInTime);
            console.log('kolkataTime:', kolkataTime);

            if (markInTime && markInTime !== '-') {
                // Calculate TWH = Mark Out - Mark In
                const totalSeconds = timeDifferenceInSeconds(markInTime, kolkataTime);
                console.log('totalSeconds:', totalSeconds);

                const hours = Math.floor(totalSeconds / 3600);
                const minutes = Math.floor((totalSeconds % 3600) / 60);
                const seconds = Math.floor(totalSeconds % 60);
                const twh = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                console.log('calculated TWH:', twh);

                twhCell.textContent = twh;
                console.log('TWH cell updated to:', twhCell.textContent);
            } else {
                console.log('markInTime is empty or "-"');
            }
        } else {
            console.log('markInCell or twhCell not found');
        }
    }

    // Determine the route and data key based on action
    let route, dataKey;
    if (action === 'mark_out') {
        route = `/admin/attendance/${attendanceId}/mark-out`;
        dataKey = 'mark_out';
    } else if (action === 'break_time') {
        route = `/admin/attendance/${attendanceId}/mark-break`;
        dataKey = 'break_time';
    }

    // Send AJAX request to update the backend
    fetch(route, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            [dataKey]: kolkataTime
        })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            showAlert('Error updating ' + (action === 'mark_out' ? 'mark out' : 'break') + ' time: ' + (data.message || 'Unknown error'), 'danger');
            // Revert UI changes on error
            if (cell) cell.innerHTML = '<button class="btn btn-sm btn-' + (action === 'mark_out' ? 'success' : 'warning') + '" onclick="markTime(' + attendanceId + ', ' + employeeId + ', \'' + action + '\')">' + (action === 'mark_out' ? 'Mark Out' : 'Mark Break') + '</button>';
        } else {
            showAlert((action === 'mark_out' ? 'Mark out' : 'Break') + ' time updated successfully!', 'success');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error updating ' + (action === 'mark_out' ? 'mark out' : 'break') + ' time: ' + error.message, 'danger');
        // Revert UI changes on error
        if (cell) cell.innerHTML = '<button class="btn btn-sm btn-' + (action === 'mark_out' ? 'success' : 'warning') + '" onclick="markTime(' + attendanceId + ', ' + employeeId + ', \'' + action + '\')">' + (action === 'mark_out' ? 'Mark Out' : 'Mark Break') + '</button>';
    });
}

function startBreak(attendanceId, employeeId) {
    const now = new Date();
    const kolkataTime = new Intl.DateTimeFormat('en-IN', {
        timeZone: 'Asia/Kolkata',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false
    }).format(now);

    // Store break start time for duration calculation
    if (!window.breakStartTimes) {
        window.breakStartTimes = {};
    }
    window.breakStartTimes[employeeId] = now;

    // Update the UI immediately - change button to "End Break"
    const breakCell = document.querySelector(`#employee-row-${employeeId} td:nth-child(6)`);
    if (breakCell) {
        breakCell.innerHTML = '<button class="btn btn-sm btn-danger" onclick="endBreak(' + attendanceId + ', ' + employeeId + ')">End Break</button>';
    }

    // Send AJAX request to start break
    fetch(`/admin/attendance/${attendanceId}/start-break`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            break_start: kolkataTime
        })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            showAlert('Error starting break: ' + (data.message || 'Unknown error'), 'danger');
            // Revert UI changes on error
            if (breakCell) breakCell.innerHTML = '<button class="btn btn-sm btn-warning" id="break-btn-' + employeeId + '" onclick="startBreak(' + attendanceId + ', ' + employeeId + ')">Start Break</button>';
            // Clean up break start time on error
            delete window.breakStartTimes[employeeId];
        } else {
            showAlert('Break started! Click "End Break" to stop timing.', 'info');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error starting break: ' + error.message, 'danger');
        // Revert UI changes on error
        if (breakCell) breakCell.innerHTML = '<button class="btn btn-sm btn-warning" id="break-btn-' + employeeId + '" onclick="startBreak(' + attendanceId + ', ' + employeeId + ')">Start Break</button>';
        // Clean up break start time on error
        delete window.breakStartTimes[employeeId];
    });
}

function endBreak(attendanceId, employeeId) {
    // Check if break start time is stored
    if (!window.breakStartTimes || !window.breakStartTimes[employeeId]) {
        showAlert('Break start time not found!', 'danger');
        return;
    }

    const breakStartTime = window.breakStartTimes[employeeId];
    const breakEndTime = new Date();
    const breakDurationMs = breakEndTime - breakStartTime;
    const breakDurationSeconds = Math.floor(breakDurationMs / 1000);
    const breakDurationHours = Math.floor(breakDurationSeconds / 3600);
    const breakDurationMinutes = Math.floor((breakDurationSeconds % 3600) / 60);
    const breakDurationSecondsRemainder = breakDurationSeconds % 60;
    const breakTimeString = `${breakDurationHours.toString().padStart(2, '0')}:${breakDurationMinutes.toString().padStart(2, '0')}:${breakDurationSecondsRemainder.toString().padStart(2, '0')}`;

    // Update the UI immediately
    const breakCell = document.querySelector(`#employee-row-${employeeId} td:nth-child(6)`);
    if (breakCell) {
        breakCell.innerHTML = breakTimeString;
    }

    // Calculate and update TWH if mark in and mark out exist
    const markInCell = document.querySelector(`#employee-row-${employeeId} td:nth-child(4)`);
    const markOutCell = document.querySelector(`#employee-row-${employeeId} td:nth-child(5)`);
    const twhCell = document.querySelector(`#employee-row-${employeeId} td:nth-child(7)`);

    if (markInCell && markOutCell && twhCell) {
        const markInTime = markInCell.textContent.trim();
        const markOutTime = markOutCell.textContent.trim();

        if (markInTime && markInTime !== '-' && markOutTime && markOutTime !== '-') {
            // Calculate TWH = Mark Out - Mark In - Break Time
            let totalSeconds = timeDifferenceInSeconds(markInTime, markOutTime);
            const breakSeconds = timeToSeconds(breakTimeString);
            totalSeconds = Math.max(0, totalSeconds - breakSeconds);

            const hours = Math.floor(totalSeconds / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            const seconds = Math.floor(totalSeconds % 60);
            const twh = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            twhCell.textContent = twh;
        }
    }

    // Send AJAX request to end break
    fetch(`/admin/attendance/${attendanceId}/mark-break`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            break_time: breakTimeString
        })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            showAlert('Error ending break: ' + (data.message || 'Unknown error'), 'danger');
            // Revert UI changes on error
            if (breakCell) breakCell.innerHTML = '<button class="btn btn-sm btn-danger" onclick="endBreak(' + attendanceId + ', ' + employeeId + ')">End Break</button>';
        } else {
            showAlert('Break ended! Duration: ' + breakTimeString, 'success');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error ending break: ' + error.message, 'danger');
        // Revert UI changes on error
        if (breakCell) breakCell.innerHTML = '<button class="btn btn-sm btn-danger" onclick="endBreak(' + attendanceId + ', ' + employeeId + ')">End Break</button>';
    });

    // Clean up break start time
    delete window.breakStartTimes[employeeId];
}

// Helper function to parse time string to Date object
function parseTime(timeString) {
    if (!timeString || typeof timeString !== 'string') return null;
    const parts = timeString.split(':');
    if (parts.length < 2 || parts.length > 3) return null;
    const [hours, minutes, seconds] = parts.map(Number);
    if (isNaN(hours) || isNaN(minutes) || (parts.length === 3 && isNaN(seconds))) return null;
    if (hours < 0 || hours > 23 || minutes < 0 || minutes > 59 || (parts.length === 3 && (seconds < 0 || seconds > 59))) return null;
    // Use a fixed date to avoid date differences affecting time calculations
    const date = new Date('2000-01-01');
    date.setHours(hours, minutes, seconds || 0, 0);
    return date;
}

// Helper function to convert time string to minutes
function timeToMinutes(timeString) {
    const [hours, minutes, seconds] = timeString.split(':').map(Number);
    return hours * 60 + minutes + (seconds || 0) / 60;
}

// Helper function to convert time string to total seconds
function timeToSeconds(timeString) {
    console.log('timeToSeconds called with:', timeString);
    if (!timeString || typeof timeString !== 'string' || !timeString.includes(':')) {
        console.log('Invalid time string, returning 0');
        return 0;
    }
    const parts = timeString.split(':');
    if (parts.length !== 3) {
        console.log('Not 3 parts, returning 0');
        return 0;
    }
    const [hours, minutes, seconds] = parts.map(Number);
    if (isNaN(hours) || isNaN(minutes) || isNaN(seconds)) {
        console.log('NaN values, returning 0');
        return 0;
    }
    const total = hours * 3600 + minutes * 60 + seconds;
    console.log('Total seconds:', total);
    return total;
}

// Helper function to calculate time difference in seconds
function timeDifferenceInSeconds(startTime, endTime) {
    const [startHours, startMinutes, startSeconds] = startTime.split(':').map(Number);
    const [endHours, endMinutes, endSeconds] = endTime.split(':').map(Number);

    const startTotalSeconds = startHours * 3600 + startMinutes * 60 + startSeconds;
    const endTotalSeconds = endHours * 3600 + endMinutes * 60 + endSeconds;

    return Math.max(0, endTotalSeconds - startTotalSeconds);
}

function openAttendanceModal(attendanceId)
{
    const modalContent = document.getElementById('attendance-modal-content');
    modalContent.innerHTML = `
        <div class="text-center">
            <div class="spinner-border text-primary"></div>
            <p class="mt-2">Loading attendance...</p>
        </div>
    `;

    const modal = new bootstrap.Modal(
        document.getElementById('attendanceViewModal')
    );
    modal.show();

    fetch(`/admin/attendance/${attendanceId}`, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => {
        if (!res.ok) {
            throw new Error(`HTTP error! status: ${res.status}`);
        }
        return res.json();
    })
    .then(data => {
        if (!data.success) {
            modalContent.innerHTML = `<p class="text-danger">Unable to load attendance</p>`;
            return;
        }

        modalContent.innerHTML = `
            <table class="table table-bordered">
                <tr><th>Employee</th><td>${data.employee}</td></tr>
                <tr><th>Status</th><td>${data.status}</td></tr>
                <tr><th>Mark In</th><td>${data.mark_in || '-'}</td></tr>
                <tr><th>Mark Out</th><td>${data.mark_out || '-'}</td></tr>
                <tr><th>Break Time</th><td>${data.break_time || '-'}</td></tr>
                <tr><th>Marked Time</th><td>${data.marked_time}</td></tr>
                <tr><th>Marked By</th><td>${data.marked_by}</td></tr>
                <tr><th>IP Address</th><td>${data.ip}</td></tr>
            </table>

            ${data.image ? `
                <div class="mt-3 text-center">
                    <h6>Captured Image</h6>
                    <img src="${data.image}" class="img-fluid rounded" style="max-height:400px">
                </div>
            ` : '<p class="text-muted">No image available</p>'}
        `;
    })
    .catch(error => {
        console.error('Error loading attendance:', error);
        modalContent.innerHTML = `<p class="text-danger">Error loading attendance: ${error.message}</p>`;
    });
}

</script>
@endsection