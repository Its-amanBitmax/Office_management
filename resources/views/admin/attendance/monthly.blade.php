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
                    <option value="all" {{ (isset($selectedEmployee) && $selectedEmployee == 'all') ? 'selected' : '' }}>All Employees</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}" {{ (isset($selectedEmployee) && is_object($selectedEmployee) && $selectedEmployee->id == $emp->id) ? 'selected' : '' }}>
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
            @if((isset($employee) && isset($month)) || (isset($selectedEmployee) && $selectedEmployee == 'all' && isset($month)))
            <div class="col-auto align-self-end">
                @if(isset($selectedEmployee) && $selectedEmployee == 'all')
                    <a href="{{ route('attendance.exportMonthly', ['employee_id' => 'all', 'month' => $month]) }}" class="btn btn-success">Export All Employees Excel</a>
                @else
                    <a href="{{ route('attendance.exportMonthly', ['employee_id' => $employee->id, 'month' => $month]) }}" class="btn btn-success">Export Monthly Excel</a>
                @endif
            </div>
            @endif
        </form>
    </div>

    @if(isset($employeeSummaries))
        <h5>All Employees Day-wise Attendance - {{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y') }}</h5>

        @php
            $date = \Carbon\Carbon::createFromFormat('Y-m', $month);
            $daysInMonth = $date->daysInMonth;
            $allAttendances = $attendances;
        @endphp

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th rowspan="2" class="align-middle">Employee Name</th>
                        @for($day = 1; $day <= $daysInMonth; $day++)
                            @php
                                $currentDate = \Carbon\Carbon::create($date->year, $date->month, $day);
                            @endphp
                            <th class="text-center">{{ $day }}<br><small>{{ $currentDate->format('D') }}</small></th>
                        @endfor
                        <th rowspan="2" class="align-middle">Total<br>Days</th>
                        <th rowspan="2" class="align-middle">P</th>
                        <th rowspan="2" class="align-middle">A</th>
                        <th rowspan="2" class="align-middle">L</th>
                        <th rowspan="2" class="align-middle">HD</th>
                        <th rowspan="2" class="align-middle">H</th>
                    </tr>
                    <tr>
                        @for($day = 1; $day <= $daysInMonth; $day++)
                            @php
                                $currentDate = \Carbon\Carbon::create($date->year, $date->month, $day);
                            @endphp
                            <th class="text-center">{{ $currentDate->format('d') }}</th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    @foreach($employeeSummaries as $employeeId => $summary)
                        <tr>
                            <td class="fw-bold">{{ $summary['employee']->name }}</td>
                            @for($day = 1; $day <= $daysInMonth; $day++)
                                @php
                                    $currentDate = \Carbon\Carbon::create($date->year, $date->month, $day)->format('Y-m-d');
                                    $attendanceCollection = $allAttendances->get($employeeId, collect())->get($currentDate);
                                    $attendance = $attendanceCollection ? $attendanceCollection->first() : null;
                                @endphp
                                <td class="text-center">
                                    @if($attendance)
                                        @if($attendance->status == 'Present')
                                            <span class="badge bg-success">P</span>
                                        @elseif($attendance->status == 'Absent')
                                            <span class="badge bg-danger">A</span>
                                        @elseif($attendance->status == 'Leave')
                                            <span class="badge bg-warning text-dark">L</span>
                                        @elseif($attendance->status == 'Half Day')
                                            <span class="badge bg-info text-dark">HD</span>
                                        @elseif($attendance->status == 'Holiday')
                                            <span class="badge bg-primary">H</span>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary">NM</span>
                                    @endif
                                </td>
                            @endfor
                            <td class="text-center fw-bold">{{ $summary['total_days'] }}</td>
                            <td class="text-center"><span class="badge bg-success">{{ $summary['present'] }}</span></td>
                            <td class="text-center"><span class="badge bg-danger">{{ $summary['absent'] }}</span></td>
                            <td class="text-center"><span class="badge bg-warning text-dark">{{ $summary['leave'] }}</span></td>
                            <td class="text-center"><span class="badge bg-info text-dark">{{ $summary['half_day'] }}</span></td>
                            <td class="text-center"><span class="badge bg-primary">{{ $summary['holiday'] }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @elseif(isset($monthlyData) && isset($summary))
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
                            @elseif($dayData['status'] == 'Holiday')
                                <span class="badge bg-primary">H</span>
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
                        HD: {{ $summary['half_day'] }} |
                        H: {{ $summary['holiday'] }}
                    </th>
                    <th colspan="2"></th>
                </tr>
            </tfoot>
        </table>
    @endif
    @endsection