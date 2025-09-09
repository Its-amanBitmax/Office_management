@extends('layouts.admin')

@section('title', 'Activity Details')
@section('page-title', 'Activity Details')
@section('page-description', 'View detailed information about the activity')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ $activity->title }}</h5>
                </div>
                <div class="card-body">
                    <p><strong>Description:</strong></p>
                    <p>{{ $activity->description }}</p>

                    <p><strong>Status:</strong>
                        <span class="badge bg-{{ $activity->status == 'active' ? 'success' : ($activity->status == 'completed' ? 'secondary' : 'warning') }}">
                            {{ ucfirst($activity->status) }}
                        </span>
                    </p>

                    @if($activity->schedule_at)
                        <p><strong>Scheduled At:</strong> {{ $activity->schedule_at->format('M d, Y H:i') }}</p>
                    @endif

                    <!-- Employee Selection Dropdown -->
                    <div class="mt-4">
                        <h6>Select Employee to View Their Form:</h6>
                        <form method="GET" action="{{ route('activities.show', $activity) }}">
                            <div class="form-group">
                                <select name="employee_id" class="form-control" onchange="this.form.submit()">
                                    <option value="">-- Select Employee --</option>
                                    @foreach($employees as $emp)
                                        <option value="{{ $emp->id }}" {{ request('employee_id') == $emp->id ? 'selected' : '' }}>
                                            {{ $emp->name }} ({{ $emp->employee_code }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>

                    <!-- Display Selected Employee's Form -->
                    @if(request('employee_id'))
                        @php
                            $selectedEmployee = $employees->find(request('employee_id'));
                            $submittedPoints = $points->where('from_employee_id', $selectedEmployee->id)->groupBy(['to_employee_id', 'criteria_id']);
                        @endphp
                        <div class="mt-4">
                            <h6>Filled Form for {{ $selectedEmployee->name }}:</h6>
                            @if($submittedPoints->isNotEmpty())
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>To Employee</th>
                                            <th>Criteria</th>
                                            <th>Points</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($submittedPoints as $toEmployeeId => $criteriaPoints)
                                            @php
                                                $toEmployee = $employees->find($toEmployeeId);
                                            @endphp
                                            @foreach($criteriaPoints as $criteriaId => $point)
                                                @php
                                                    $criteria = $criterias->find($criteriaId);
                                                @endphp
                                                <tr>
                                                    <td>{{ $toEmployee ? $toEmployee->name : 'N/A' }}</td>
                                                    <td>{{ $criteria ? $criteria->name : 'N/A' }}</td>
                                                    <td>{{ $point->first()->points ?? 0 }}</td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>No submissions found for this employee.</p>
                            @endif
                        </div>
                    @endif

                    <!-- List of Employees with Total Points -->
                    <div class="mt-4">
                        <h6>Employee Total Points Received:</h6>
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Employee Code</th>
                                    <th>Total Points</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employees as $emp)
                                    @php
                                        $totalPoints = $points->where('to_employee_id', $emp->id)->sum('points');
                                    @endphp
                                    <tr>
                                        <td>{{ $emp->name }}</td>
                                        <td>{{ $emp->employee_code }}</td>
                                        <td>{{ $totalPoints }}</td>
                                        <td>
                                            @php
                                                $existingRating = \App\Models\Rating::where('employee_id', $emp->id)
                                                    ->first();
                                            @endphp
                                            @if(!$existingRating)
                                                <form method="POST" action="{{ route('activities.add-to-ratings', [$activity, $emp]) }}" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm">Add</button>
                                                </form>
                                                <form method="POST" action="{{ route('activities.reject-rating', [$activity, $emp]) }}" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                                </form>
                                            @else
                                                <span class="text-muted">Already Processed</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <a href="{{ route('activities.edit', $activity) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('activities.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left"></i> Back to Activities
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
