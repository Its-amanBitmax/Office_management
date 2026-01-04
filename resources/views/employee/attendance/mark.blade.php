@extends('layouts.employee')

@section('title', 'Mark Attendance')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Mark Attendance</h5>
    </div>

    <div class="card-body text-center">
        <div id="attendance-error" class="alert alert-danger d-none"></div>



        {{-- ✅ Auto status preview --}}
        <div id="status-preview" class="alert alert-info">
            Checking attendance status...
        </div>

        {{-- ✅ Camera --}}
        <video id="video" width="300" autoplay playsinline></video>
        <canvas id="canvas" width="300" class="d-none"></canvas>

        <form method="POST"
              action="{{ route('employee.attendance.submit') }}"
              enctype="multipart/form-data"
              onsubmit="return validateBeforeSubmit()">

            @csrf

            {{-- ✅ Hidden fields --}}
            <input type="hidden" name="image" id="image">
            <input type="hidden" name="auto_status" id="auto_status">

            <div class="mt-3">
                <button type="button"
                        class="btn btn-warning"
                        onclick="takeSnapshot()">
                    <i class="fas fa-camera me-1"></i> Capture Photo
                </button>
            </div>

            

            {{-- ✅ Additional Action Buttons --}}
            <div class="mt-3 d-flex gap-2 flex-wrap">
                <button type="button"
                        class="btn btn-primary"
                        onclick="markIn()">
                    <i class="fas fa-sign-in-alt me-1"></i> Mark In
                </button>

                <button type="button"
                        class="btn btn-warning"
                        onclick="markOut()"
                        @if(!$hasMarkedIn) disabled @endif>
                    <i class="fas fa-sign-out-alt me-1"></i> Mark Out
                </button>

                <button type="button"
                        class="btn btn-success"
                        onclick="startBreak()"
                        id="startBreakBtn"
                        @if(!$hasMarkedIn || $breakStarted) disabled @endif>
                    <i class="fas fa-coffee me-1"></i> Start Break
                </button>

                <button type="button"
                        class="btn btn-info @if(!$breakStarted) d-none @endif"
                        onclick="endBreak()"
                        id="endBreakBtn"
                        @if(!$hasMarkedIn) disabled @endif>
                    <i class="fas fa-coffee me-1"></i> End Break
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ✅ SCRIPT --}}
<script>
/* -----------------------------
   Camera access
------------------------------ */
navigator.mediaDevices.getUserMedia({ video: true })
    .then(stream => {
        document.getElementById('video').srcObject = stream;
    })
    .catch(() => {
        
    });

/* -----------------------------
   Auto status logic (9:30 AM)
------------------------------ */
(function () {
    const now = new Date();
    const currentMinutes = (now.getHours() * 60) + now.getMinutes();
    const halfDayTime = (9 * 60) + 30;

    const status = currentMinutes > halfDayTime ? 'Half Day' : 'Present';

    document.getElementById('auto_status').value = status;
    document.getElementById('status-preview').innerHTML =
        `<i class="fas fa-info-circle me-1"></i>
         Attendance will be marked as <strong>${status}</strong>`;
})();

/* -----------------------------
   Capture image
------------------------------ */
function takeSnapshot() {
    const canvas = document.getElementById('canvas');
    const video = document.getElementById('video');
    const context = canvas.getContext('2d');

    context.drawImage(video, 0, 0, canvas.width, canvas.height);
    document.getElementById('image').value =
        canvas.toDataURL('image/png');

    document.getElementById('status-preview').classList.remove('alert-info');
document.getElementById('status-preview').classList.add('alert-success');
document.getElementById('status-preview').innerHTML =
    '<i class="fas fa-check-circle me-1"></i> Photo captured successfully';

} 



/* -----------------------------
   Final validation
------------------------------ */
function validateBeforeSubmit() {
    if (!document.getElementById('image').value) {
        alert('Please capture photo before submitting');
        return false;
    }
    return true;
}
function showAttendanceError(message) {
    const errorDiv = document.getElementById('attendance-error');
    errorDiv.innerHTML = `
        <i class="fas fa-exclamation-triangle me-1"></i> ${message}
    `;
    errorDiv.classList.remove('d-none');

    window.scrollTo({ top: 0, behavior: 'smooth' });
}

/* -----------------------------
   Mark In Function
------------------------------ */
function markIn() {
    if (!document.getElementById('image').value) {
        alert('Please capture photo before marking in');
        return;
    }

    const formData = new FormData();
    formData.append('employee_id', {{ auth('employee')->id() }});
    formData.append('date', new Date().toISOString().split('T')[0]);
    formData.append('mark_in', new Date().toTimeString().split(' ')[0]);
    formData.append('image', document.getElementById('image').value);
    formData.append('_token', '{{ csrf_token() }}');

    fetch('{{ route("employee.attendance.mark-in-direct") }}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Marked in successfully');
            document.getElementById('status-preview').classList.remove('alert-info', 'alert-success');
            document.getElementById('status-preview').classList.add('alert-success');
            document.getElementById('status-preview').innerHTML = '<i class="fas fa-check-circle me-1"></i> Marked in successfully';

            // Enable Mark Out and Start Break buttons
            document.querySelector('button[onclick="markOut()"]').disabled = false;
            document.getElementById('startBreakBtn').disabled = false;

            // Reload the page to update server-side variables and button states
            window.location.reload();
        } else {
            showAttendanceError(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAttendanceError('Something went wrong');
    });
}

/* -----------------------------
   Mark Out Function
------------------------------ */
function markOut() {
    // Frontend validation: Check if Mark In has been done
    @if(!$hasMarkedIn)
    alert('Mark In is required before Mark Out.');
    return;
    @endif

    if (!document.getElementById('image').value) {
        alert('Please capture photo before marking out');
        return;
    }

    const formData = new FormData();
    formData.append('employee_id', {{ auth('employee')->id() }});
    formData.append('date', new Date().toISOString().split('T')[0]);
    formData.append('mark_out', new Date().toTimeString().split(' ')[0]);
    formData.append('image', document.getElementById('image').value);
    formData.append('_token', '{{ csrf_token() }}');

    fetch('{{ route("employee.attendance.mark-out-direct") }}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Marked out successfully');
            document.getElementById('status-preview').classList.remove('alert-info', 'alert-success');
            document.getElementById('status-preview').classList.add('alert-success');
            document.getElementById('status-preview').innerHTML = '<i class="fas fa-check-circle me-1"></i> Marked out successfully';
        } else {
            showAttendanceError(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAttendanceError('Something went wrong');
    });
}

/* -----------------------------
   Start Break Function
------------------------------ */
function startBreak() {
    // Frontend validation: Check if Mark In has been done
    @if(!$hasMarkedIn)
    alert('Mark In is required before starting break.');
    return;
    @endif

    if (!document.getElementById('image').value) {
        alert('Please capture photo before starting break');
        return;
    }

    const formData = new FormData();
    formData.append('employee_id', {{ auth('employee')->id() }});
    formData.append('date', new Date().toISOString().split('T')[0]);
    formData.append('break_start', new Date().toTimeString().split(' ')[0]);
    formData.append('image', document.getElementById('image').value);
    formData.append('_token', '{{ csrf_token() }}');

    fetch('{{ route("employee.attendance.start-break-direct") }}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Break started successfully');
            document.getElementById('status-preview').classList.remove('alert-info', 'alert-success');
            document.getElementById('status-preview').classList.add('alert-success');
            document.getElementById('status-preview').innerHTML = '<i class="fas fa-check-circle me-1"></i> Break started successfully';

            // Hide Start Break button and show End Break button
            document.getElementById('startBreakBtn').classList.add('d-none');
            document.getElementById('endBreakBtn').classList.remove('d-none');
        } else {
            showAttendanceError(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAttendanceError('Something went wrong');
    });
}

/* -----------------------------
   End Break Function
------------------------------ */
function endBreak() {
    const formData = new FormData();
    formData.append('employee_id', {{ auth('employee')->id() }});
    formData.append('date', new Date().toISOString().split('T')[0]);
    formData.append('break_time', new Date().toTimeString().split(' ')[0]);
    formData.append('_token', '{{ csrf_token() }}');

    fetch('{{ route("employee.attendance.end-break-direct") }}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const breakDuration = data.attendance.break_time || '00:00:00';
            alert('Break ended successfully. Break duration: ' + breakDuration);
            document.getElementById('status-preview').classList.remove('alert-info', 'alert-success');
            document.getElementById('status-preview').classList.add('alert-success');
            document.getElementById('status-preview').innerHTML = '<i class="fas fa-check-circle me-1"></i> Break ended successfully (Duration: ' + breakDuration + ')';

            // Hide End Break button and show Start Break button
            document.getElementById('endBreakBtn').classList.add('d-none');
            document.getElementById('startBreakBtn').classList.remove('d-none');
        } else {
            showAttendanceError(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAttendanceError('Something went wrong');
    });
}

</script>
@endsection
