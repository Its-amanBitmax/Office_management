@extends('layouts.employee')

@section('title', 'Activity Evaluation')
@section('page-title', 'Evaluate Activity')
@section('page-description', 'Provide scores for criteria and select the best employee')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if ($isPending ?? false)
                <div class="alert alert-danger">
                    THIS ACTIVITY IS PENDING AND CANNOT BE STARTED YET.
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Activity: {{ $activity->title }}</h5>
                    @if(isset($hasSubmitted) && $hasSubmitted)
                        <div class="alert alert-info mt-2">
                            <i class="fas fa-info-circle me-2"></i>You have already submitted your evaluation for this activity. You can view your submitted scores below.
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <form action="{{ route('employee.activities.submit', $activity) }}" method="POST">
                        @csrf

                        {{-- Activity Description --}}
                        <div class="mb-4">
                            <h6>Activity Description</h6>
                            <p class="text-muted">{{ $activity->description }}</p>
                        </div>

                        {{-- Criteria Scoring --}}
                        <div class="mb-4">
                            <h6>Evaluation Criteria</h6>
                            @if($activity->criteria->count() > 0 && $activity->employees->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Employee</th>
                                        @foreach($activity->criteria as $criterion)
                                            <th>{{ $criterion->name }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employeesForScoring as $empIndex => $employee)
                                        <tr>
                                            <td class="text-start">
                                                {{ $employee->name }} ({{ $employee->employee_code }})
                                            </td>
                                            @foreach($activity->criteria as $critIndex => $criterion)
                                                <td>
                                                    <select name="scores[{{ $employee->id }}][{{ $criterion->id }}]" class="form-select @error('scores.' . $employee->id . '.' . $criterion->id) is-invalid @enderror" {{ isset($hasSubmitted) && $hasSubmitted ? 'disabled' : 'required' }}>
                                                        <option value="">Select</option>
                                                        @for($i = 0; $i <= $criterion->max_points; $i++)
                                                            <option value="{{ $i }}" {{ (isset($submittedPoints[$employee->id][$criterion->id]) && $submittedPoints[$employee->id][$criterion->id] == $i) || old('scores.' . $employee->id . '.' . $criterion->id) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                    @error('scores.' . $employee->id . '.' . $criterion->id)
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                            @else
                                <p class="text-muted">No criteria or participants defined for this activity.</p>
                            @endif
                        </div>

                        {{-- Best Employee Selection --}}
                        @if($activity->enable_best_employee)
                            <div class="mb-4">
                                <h6>Best Employee Selection</h6>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="best_employee_id" class="form-label">Select Best Employee</label>
                                            <select class="form-select @error('best_employee_id') is-invalid @enderror" id="best_employee_id" name="best_employee_id" {{ isset($hasSubmitted) && $hasSubmitted ? 'disabled' : '' }}>
                                                <option value="">Select Best Employee</option>
                                                @foreach($activity->employees as $employee)
                                                    <option value="{{ $employee->id }}" {{ (isset($activity->best_employee_id) && $activity->best_employee_id == $employee->id) || old('best_employee_id') == $employee->id ? 'selected' : '' }}>
                                                        {{ $employee->name }} ({{ $employee->employee_code }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('best_employee_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="best_employee_description" class="form-label">Description (Why is this employee the best?)</label>
                                            <textarea class="form-control @error('best_employee_description') is-invalid @enderror"
                                                      id="best_employee_description" name="best_employee_description" rows="4" {{ isset($hasSubmitted) && $hasSubmitted ? 'readonly' : '' }}>{{ isset($activity->best_employee_description) ? $activity->best_employee_description : old('best_employee_description') }}</textarea>
                                            @error('best_employee_description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Buttons --}}
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('employee.activities.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Activities
                            </a>
                            @if(isset($hasSubmitted) && $hasSubmitted)
                                <div class="alert alert-success mb-0">
                                    <i class="fas fa-check-circle me-2"></i>Your evaluation has been submitted successfully.
                                </div>
                            @else
                                <button type="submit" class="btn btn-primary" @if($isPending ?? false) disabled @endif>
                                    <i class="fas fa-save"></i> Submit Evaluation
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
