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

            <div class="mt-3">
                <button type="submit"
                        class="btn btn-success">
                    <i class="fas fa-check me-1"></i> Submit Attendance
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
        alert('Camera access denied');
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

    alert('Photo captured successfully ✅');
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

</script>
@endsection
