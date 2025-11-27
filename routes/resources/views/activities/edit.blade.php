@extends('layouts.admin')

@section('title', 'Edit Activity')
@section('page-title', 'Edit Activity')
@section('page-description', 'Modify the details of the activity')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Activity Details</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('activities.update', $activity) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Title --}}
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $activity->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Employees --}}
                        <div class="mb-3">
                            <label for="employees" class="form-label">Select Employees</label>
                            <select multiple class="form-select @error('employees') is-invalid @enderror" id="employees" name="employees[]">
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}" {{ (collect(old('employees', $activity->employees->pluck('id')->toArray()))->contains($employee->id)) ? 'selected' : '' }}>
                                        {{ $employee->name }} ({{ $employee->employee_code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('employees')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $activity->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="">Select Status</option>
                                <option value="pending" {{ old('status', $activity->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="active" {{ old('status', $activity->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="completed" {{ old('status', $activity->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Enable Best Employee --}}
                        <div class="mb-3 form-check">
                            <input type="hidden" name="enable_best_employee" value="0">
                            <input type="checkbox" class="form-check-input @error('enable_best_employee') is-invalid @enderror" id="enable_best_employee" name="enable_best_employee" value="1" {{ old('enable_best_employee', $activity->enable_best_employee) ? 'checked' : '' }}>
                            <label class="form-check-label" for="enable_best_employee">Enable Best Employee Selection</label>
                            @error('enable_best_employee')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        {{-- Schedule --}}
                        <div class="mb-3">
                            <label for="schedule_at" class="form-label">Schedule Date & Time</label>
                            <input type="datetime-local" class="form-control @error('schedule_at') is-invalid @enderror" id="schedule_at" name="schedule_at" value="{{ old('schedule_at', $activity->schedule_at ? $activity->schedule_at->format('Y-m-d\TH:i') : '') }}">
                            @error('schedule_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Criteria Section --}}
                        <div class="mb-3">
                            <label class="form-label">Evaluation Criteria</label>
                            <div id="criteria-wrapper">
                                @foreach(old('criteria', $activity->criteria ?? []) as $index => $criterion)
                                    <div class="criteria-item border p-3 mb-2 rounded">
                                        <input type="hidden" name="criteria[{{ $index }}][id]" value="{{ $criterion->id ?? '' }}">
                                        <div class="mb-2">
                                            <input type="text" name="criteria[{{ $index }}][name]" class="form-control" placeholder="Criteria Name" value="{{ $criterion['name'] ?? '' }}" required>
                                        </div>
                                        <div class="mb-2">
                                            <textarea name="criteria[{{ $index }}][description]" class="form-control" rows="2" placeholder="Criteria Description">{{ $criterion['description'] ?? '' }}</textarea>
                                        </div>
                                        <div>
                                            <input type="number" name="criteria[{{ $index }}][max_points]" class="form-control" placeholder="Max Points" value="{{ $criterion['max_points'] ?? 10 }}" required>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-secondary btn-sm mt-2" onclick="addCriteria()">+ Add More Criteria</button>
                        </div>
                                                <div class="mb-3">
    <label for="scoring_scope" class="form-label">Who Can Give Points? <span class="text-danger">*</span></label>
    <select class="form-select @error('scoring_scope') is-invalid @enderror" id="scoring_scope" name="scoring_scope" required>
        <option value="selected" {{ old('scoring_scope', $activity->scoring_scope ?? '') == 'selected' ? 'selected' : '' }}>Selected Participants</option>
        <option value="all" {{ old('scoring_scope', $activity->scoring_scope ?? '') == 'all' ? 'selected' : '' }}>All Employees</option>
    </select>
    @error('scoring_scope')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

                        {{-- Buttons --}}
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('activities.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Activities
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Activity
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let criteriaIndex = {{ count($activity->criteria ?? []) }};
    function addCriteria() {
        let wrapper = document.getElementById('criteria-wrapper');
        let div = document.createElement('div');
        div.classList.add('criteria-item', 'border', 'p-3', 'mb-2', 'rounded');
        div.innerHTML = `
            <div class="mb-2">
                <input type="text" name="criteria[${criteriaIndex}][name]" class="form-control" placeholder="Criteria Name" required>
            </div>
            <div class="mb-2">
                <textarea name="criteria[${criteriaIndex}][description]" class="form-control" rows="2" placeholder="Criteria Description"></textarea>
            </div>
            <div>
                <input type="number" name="criteria[${criteriaIndex}][max_points]" class="form-control" placeholder="Max Points" required>
            </div>
        `;
        wrapper.appendChild(div);
        criteriaIndex++;
    }

    // Toggle best employee section
    document.getElementById('enable_best_employee').addEventListener('change', function() {
        const section = document.getElementById('best-employee-section');
        if (this.checked) {
            section.style.display = 'block';
        } else {
            section.style.display = 'none';
        }
    });

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        const checkbox = document.getElementById('enable_best_employee');
        const section = document.getElementById('best-employee-section');
        if (checkbox.checked) {
            section.style.display = 'block';
        }
    });
</script>
@endsection
