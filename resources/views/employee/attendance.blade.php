@extends('layouts.employee')

@section('title', 'My Attendance')
@section('page-title', 'My Attendance')

@section('content')

{{-- ✅ Session error (non-AJAX cases) --}}
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- ✅ Session success --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- ✅ AJAX error container --}}
<div id="attendance-alert"></div>

<div class="row">

    {{-- ✅ SIDEBAR --}}
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

                    {{-- ✅ MARK ATTENDANCE --}}
                    <button id="mark-attendance-btn" class="btn btn-success btn-sm">
                        <i class="fas fa-clock me-1"></i> Mark Attendance
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ✅ MAIN CONTENT --}}
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Select Month to View Attendance</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('employee.attendance.show') }}" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Select Month</label>
                        <input type="month"
                               class="form-control"
                               name="month"
                               value="{{ $month ?? now()->format('Y-m') }}"
                               required>
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

{{-- ✅ SUMMARY --}}
@if(isset($summary))
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    Attendance Summary for {{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y') }}
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    @php
                        $stats = [
                            'Total Days' => ['total_days', 'primary'],
                            'Present' => ['present', 'success'],
                            'Absent' => ['absent', 'danger'],
                            'Leave' => ['leave', 'warning'],
                            'Half Day' => ['half_day', 'info'],
                            'Holiday' => ['holiday', 'secondary'],
                        ];
                    @endphp

                    @foreach($stats as $label => [$key, $color])
                    <div class="col-md-2">
                        <div class="h4 text-{{ $color }}">{{ $summary[$key] }}</div>
                        <small class="text-muted">{{ $label }}</small>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ✅ DAILY TABLE --}}
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Daily Attendance Details</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
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
                                    @php
                                        $badgeClass = match($data['status']) {
                                            'Present' => 'bg-success text-white',
                                            'Absent' => 'bg-danger text-white',
                                            'Leave' => 'bg-warning text-dark',
                                            'Half Day' => 'bg-info text-dark',
                                            'Holiday' => 'bg-secondary text-white',
                                            'NCNS' => 'bg-danger text-white',
                                            'LWP' => 'bg-warning text-dark',
                                            default => 'bg-light text-dark'
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">
                                        {{ $data['status'] }}
                                    </span>
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

{{-- ✅ SCRIPTS --}}
@section('scripts')
<script>
$(document).ready(function () {

    $('#mark-attendance-btn').on('click', function (e) {
        e.preventDefault();

        const btn = $(this);

        // ✅ Local time-based automatic status (UX only)
        const now = new Date();
        const currentMinutes = (now.getHours() * 60) + now.getMinutes();
        const halfDayTime = (9 * 60) + 30;

        const autoStatus = currentMinutes > halfDayTime ? 'Half Day' : 'Present';

        btn.prop('disabled', true)
           .html('<i class="fas fa-spinner fa-spin me-1"></i> Checking...');

        $('#attendance-alert').html('');

        $.ajax({
            url: '{{ route("employee.attendance.mark") }}',
            type: 'GET',
            dataType: 'json',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },

            success: function (response) {
                if (response && response.success === true) {
                    window.location.href =
                        '{{ route("employee.attendance.mark") }}?auto_status=' + autoStatus;
                } else {
                    showError('Attendance not allowed');
                }
            },

            error: function (xhr) {
                let message = 'Attendance not allowed';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                showError(message);
            },

            complete: function () {
                btn.prop('disabled', false)
                   .html('<i class="fas fa-clock me-1"></i> Mark Attendance');
            }
        });
    });

    function showError(msg) {
        $('#attendance-alert').html(`
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-triangle me-2"></i>${msg}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);
        $('html, body').animate({ scrollTop: 0 }, 'fast');
    }

});
</script>
@endsection
