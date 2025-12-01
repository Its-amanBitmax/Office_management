@extends('layouts.admin')

@section('page-title', 'Schedule New Interview')
@section('page-description', 'Create a new interview schedule')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Schedule Interview</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.interviews.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="candidate_name" class="form-label">
                                    Candidate Name <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    class="form-control @error('candidate_name') is-invalid @enderror"
                                    id="candidate_name"
                                    name="candidate_name"
                                    value="{{ old('candidate_name') }}"
                                    required
                                >
                                @error('candidate_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="candidate_email" class="form-label">
                                    Candidate Email <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="email"
                                    class="form-control @error('candidate_email') is-invalid @enderror"
                                    id="candidate_email"
                                    name="candidate_email"
                                    value="{{ old('candidate_email') }}"
                                    required
                                >
                                @error('candidate_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="candidate_phone" class="form-label">Candidate Phone</label>
                                <input
                                    type="text"
                                    class="form-control @error('candidate_phone') is-invalid @enderror"
                                    id="candidate_phone"
                                    name="candidate_phone"
                                    value="{{ old('candidate_phone') }}"
                                    maxlength="15"
                                >
                                @error('candidate_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="candidate_resume_path" class="form-label">Candidate Resume</label>
                                <input
                                    type="file"
                                    class="form-control @error('candidate_resume_path') is-invalid @enderror"
                                    id="candidate_resume_path"
                                    name="candidate_resume_path"
                                    accept=".pdf,.doc,.docx"
                                >
                                @error('candidate_resume_path')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    Accepted formats: PDF, DOC, DOCX
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="candidate_profile" class="form-label">Candidate Profile</label>
                                <textarea
                                    class="form-control @error('candidate_profile') is-invalid @enderror"
                                    id="candidate_profile"
                                    name="candidate_profile"
                                    rows="3"
                                    placeholder="Brief profile/bio of the candidate"
                                >{{ old('candidate_profile') }}</textarea>
                                @error('candidate_profile')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="candidate_experience" class="form-label">Candidate Experience</label>
                                <textarea
                                    class="form-control @error('candidate_experience') is-invalid @enderror"
                                    id="candidate_experience"
                                    name="candidate_experience"
                                    rows="3"
                                    placeholder="Work experience details"
                                >{{ old('candidate_experience') }}</textarea>
                                @error('candidate_experience')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date" class="form-label">
                                    Interview Date <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="date"
                                    class="form-control @error('date') is-invalid @enderror"
                                    id="date"
                                    name="date"
                                    value="{{ old('date') }}"
                                    required
                                >
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="time" class="form-label">
                                    Interview Time <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="time"
                                    class="form-control @error('time') is-invalid @enderror"
                                    id="time"
                                    name="time"
                                    value="{{ old('time') }}"
                                    required
                                >
                                @error('time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">
                                    Status <span class="text-danger">*</span>
                                </label>
                                <select
                                    class="form-control @error('status') is-invalid @enderror"
                                    id="status"
                                    name="status"
                                    required
                                >
                                    <option value="scheduled" {{ old('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    <option value="rescheduled" {{ old('status') == 'rescheduled' ? 'selected' : '' }}>Rescheduled</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="interview_code" class="form-label">Interview Code</label>
                                <input
                                    type="text"
                                    class="form-control @error('interview_code') is-invalid @enderror"
                                    id="interview_code"
                                    name="interview_code"
                                    value="{{ old('interview_code') }}"
                                >
                                @error('interview_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input
                                    type="text"
                                    class="form-control @error('password') is-invalid @enderror"
                                    id="password"
                                    name="password"
                                    value="{{ old('password') }}"
                                >
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="results" class="form-label">Results</label>
                                <select
                                    class="form-control @error('results') is-invalid @enderror"
                                    id="results"
                                    name="results"
                                >
                                    <option value="" {{ old('results') == '' ? 'selected' : '' }}>Select Results</option>
                                    <option value="pending" {{ old('results') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="selected" {{ old('results') == 'selected' ? 'selected' : '' }}>Selected</option>
                                    <option value="rejected" {{ old('results') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                                @error('results')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    Leave blank if not applicable
                                </small>
                            </div>
                        </div>
                    </div>

                  

                    <div class="mb-3">
                        <label class="form-label">Round Details</label>
                        <div id="rounds-container">
                            <!-- Dynamic rounds will be added here -->
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm" id="add-round-btn">
                            Add Round
                        </button>
                        <small class="form-text text-muted">
                            Add details for each interview round including remarks and who conducted it
                        </small>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.interviews.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Schedule Interview</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let roundIndex = 0;
    const roundsContainer = document.getElementById('rounds-container');
    const addRoundBtn = document.getElementById('add-round-btn');

    function createRoundElement(index, roundData = null) {
        const roundDiv = document.createElement('div');
        roundDiv.className = 'round-item border p-3 mb-3';
        roundDiv.innerHTML = `
            <div class="row">
                <div class="col-md-3">
                    <label class="form-label">Round ${index + 1}</label>
                    <input
                        type="number"
                        class="form-control"
                        name="rounds[${index}][round_number]"
                        value="${roundData ? (roundData.round_number || (index + 1)) : (index + 1)}"
                        min="1"
                        required
                    >
                </div>
                <div class="col-md-4">
                    <label class="form-label">Remarks</label>
                    <textarea
                        class="form-control"
                        name="rounds[${index}][remarks]"
                        rows="2"
                        placeholder="Remarks for this round"
                    >${roundData ? (roundData.remarks || '') : ''}</textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Conducted By</label>
                    <input
                        type="text"
                        class="form-control"
                        name="rounds[${index}][conducted_by]"
                        value="${roundData ? (roundData.conducted_by || '') : ''}"
                        placeholder="Name of interviewer"
                    >
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-sm remove-round-btn">Remove</button>
                </div>
            </div>
        `;
        return roundDiv;
    }

    addRoundBtn.addEventListener('click', function() {
        const roundElement = createRoundElement(roundIndex);
        roundsContainer.appendChild(roundElement);
        roundIndex++;
    });

    roundsContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-round-btn')) {
            e.target.closest('.round-item').remove();
        }
    });
});
</script>
@endsection
