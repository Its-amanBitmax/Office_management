@extends('layouts.admin')

@section('page-title', 'Monthly Attendance')
@section('page-description', 'View attendance for selected employee and month')

@section('content')
<div class="mb-3">
    <form method="GET" action="{{ route('attendance.showMonthly') }}" class="row g-3 align-items-center">
        <div class="col-auto">
            <label for="employee_id" class="form-label">Select Employee:</label>
            <select name="employee_id" id="employee_id" class="form-select" required>
                <option value="">-- Select Employee --</option>
                @foreach($employees as $emp)
                    <option value="{{ $emp->id }}" {{ (isset($selectedEmployee) && $selectedEmployee->id == $emp->id) ? 'selected' : '' }}>
                        {{ $emp->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <label for="month" class="form-label">Select Month:</label>
            <input type="month" name="month" id="month" class="form-control" value="{{ $month ?? \Carbon\Carbon::now()->format('Y-m') }}" required>
        </div>
        <div class="col-auto align-self-end">
            <button type="submit" class="btn btn-primary">View Attendance</button>
        </div>
    </form>
</div>

@if(isset($monthlyData) && isset($summary))
    <h5>Attendance for {{ $employee->name }} - {{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y') }}</h5>

    <table class="table table-bordered table-striped">
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
            @foreach($monthlyData as $dayData)
                <tr>
                    <td>{{ $dayData['date'] }}</td>
                    <td>{{ $dayData['day_name'] }}</td>
                    <td>
                        @if($dayData['status'] == 'Present')
                            <span class="badge bg-success">P</span>
                        @elseif($dayData['status'] == 'Absent')
                            <span class="badge bg-danger">A</span>
                        @elseif($dayData['status'] == 'Leave')
                            <span class="badge bg-warning text-dark">L</span>
                        @elseif($dayData['status'] == 'Half Day')
                            <span class="badge bg-info text-dark">HD</span>
                        @else
                            <span class="badge bg-secondary">NM</span>
                        @endif
                    </td>
                    <td>{{ $dayData['marked_at'] ?? '-' }}</td>
                    <td>{{ $dayData['remarks'] ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">Total Days: {{ $summary['total_days'] }}</th>
                <th>
                    P: {{ $summary['present'] }} |
                    A: {{ $summary['absent'] }} |
                    L: {{ $summary['leave'] }} |
                    HD: {{ $summary['half_day'] }}
                </th>
                <th colspan="2"></th>
            </tr>
        </tfoot>
    </table>
@endif
@endsection
