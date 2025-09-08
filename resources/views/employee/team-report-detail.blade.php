@extends('layouts.employee')

@section('title', 'Team Report Details')

@section('page-title', 'Team Report Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Report Details</h5>
                        <a href="{{ route('employee.team-reports') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Reports
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Report Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <h6>Title:</h6>
                                        <p>{{ $report->title }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <h6>Content:</h6>
                                        <p>{{ $report->content }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <h6>Employee:</h6>
                                        <p>{{ $report->employee->name ?? 'N/A' }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <h6>Task:</h6>
                                        <p>{{ $report->task->task_name ?? 'N/A' }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <h6>Date Sent:</h6>
                                        <p>{{ \Carbon\Carbon::parse($report->created_at)->format('M d, Y H:i') }}</p>
                                    </div>
                                    @if($report->attachment)
                                        <div class="mb-3">
                                            <h6>Attachment:</h6>
                                            <a href="{{ asset('storage/' . $report->attachment) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-download me-2"></i>Download Attachment
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <!-- Admin Review Section -->
                            @if($report->admin_review || $report->admin_rating)
                            <div class="card mb-3">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0"><i class="fas fa-user-shield me-2"></i>Admin Review</h6>
                                </div>
                                <div class="card-body">
                                    @if($report->admin_rating)
                                        <div class="mb-2">
                                            <strong>Rating:</strong>
                                            <div class="stars">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <span class="star {{ $i <= $report->admin_rating ? 'filled' : 'empty' }}" data-rating="{{ $i }}">
                                                        &#9733;
                                                    </span>
                                                @endfor
                                                <small class="rating-text ms-2">{{ $report->admin_rating }}/5</small>
                                            </div>
                                        </div>
                                    @endif
                                    @if($report->admin_review)
                                        <div class="mb-2">
                                            <strong>Comments:</strong>
                                            <p class="mb-0">{{ $report->admin_review }}</p>
                                        </div>
                                    @endif
                                    @if($report->admin_status)
                                        <div>
                                            <strong>Status:</strong>
                                            <span class="badge bg-{{ $report->admin_status === 'responded' ? 'success' : ($report->admin_status === 'read' ? 'info' : 'secondary') }}">
                                                {{ ucfirst($report->admin_status) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @endif

                            <!-- Team Lead Review Section -->
                            <div class="card">
                                <div class="card-header bg-success text-white">
                                    <h6 class="mb-0"><i class="fas fa-users me-2"></i>Team Lead Review</h6>
                                </div>
                                <div class="card-body">
                                    @if($report->team_lead_rating)
                                        <div class="mb-2">
                                            <strong>Rating:</strong>
                                            <div class="stars">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <span class="star {{ $i <= $report->team_lead_rating ? 'filled' : 'empty' }}" data-rating="{{ $i }}">
                                                        &#9733;
                                                    </span>
                                                @endfor
                                                <small class="rating-text ms-2">{{ $report->team_lead_rating }}/5</small>
                                            </div>
                                        </div>
                                    @endif
                                    @if($report->team_lead_review)
                                        <div class="mb-2">
                                            <strong>Comments:</strong>
                                            <p class="mb-0">{{ $report->team_lead_review }}</p>
                                        </div>
                                    @endif
                                    @if($report->team_lead_status)
                                        <div class="mb-3">
                                            <strong>Status:</strong>
                                            <span class="badge bg-{{ $report->team_lead_status === 'responded' ? 'success' : ($report->team_lead_status === 'read' ? 'info' : 'secondary') }}">
                                                {{ ucfirst($report->team_lead_status) }}
                                            </span>
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ route('employee.team-reports.update', $report) }}">
                                        @csrf
                                        @method('PUT')

                                        <div class="mb-3">
                                            <label for="team_lead_status" class="form-label">Status</label>
                                            <select name="team_lead_status" id="team_lead_status" class="form-select" required>
                                                <option value="sent" {{ $report->team_lead_status === 'sent' ? 'selected' : '' }}>Sent</option>
                                                <option value="read" {{ $report->team_lead_status === 'read' ? 'selected' : '' }}>Read</option>
                                                <option value="responded" {{ $report->team_lead_status === 'responded' ? 'selected' : '' }}>Responded</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="team_lead_review" class="form-label">Review/Comments (Optional)</label>
                                            <textarea name="team_lead_review" id="team_lead_review" class="form-control" rows="4" placeholder="Add your review or comments here...">{{ old('team_lead_review', $report->team_lead_review) }}</textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Rating (Optional)</label>
                                            <div class="star-rating">
                                                <input type="radio" id="star5" name="team_lead_rating" value="5" {{ old('team_lead_rating', $report->team_lead_rating) == 5 ? 'checked' : '' }} />
                                                <label for="star5" title="5 stars">★</label>
                                                <input type="radio" id="star4" name="team_lead_rating" value="4" {{ old('team_lead_rating', $report->team_lead_rating) == 4 ? 'checked' : '' }} />
                                                <label for="star4" title="4 stars">★</label>
                                                <input type="radio" id="star3" name="team_lead_rating" value="3" {{ old('team_lead_rating', $report->team_lead_rating) == 3 ? 'checked' : '' }} />
                                                <label for="star3" title="3 stars">★</label>
                                                <input type="radio" id="star2" name="team_lead_rating" value="2" {{ old('team_lead_rating', $report->team_lead_rating) == 2 ? 'checked' : '' }} />
                                                <label for="star2" title="2 stars">★</label>
                                                <input type="radio" id="star1" name="team_lead_rating" value="1" {{ old('team_lead_rating', $report->team_lead_rating) == 1 ? 'checked' : '' }} />
                                                <label for="star1" title="1 star">★</label>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-save me-2"></i>Update Team Lead Review
                                        </button>
                                    </form>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
.star-rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
}

.star-rating input[type="radio"] {
    display: none;
}

.star-rating label {
    color: #ddd;
    font-size: 24px;
    cursor: pointer;
    transition: color 0.2s;
}

.star-rating input[type="radio"]:checked ~ label,
.star-rating label:hover,
.star-rating label:hover ~ label {
    color: #ffc107;
}

.star-rating input[type="radio"]:checked ~ label {
    color: #ffc107;
}
</style>
