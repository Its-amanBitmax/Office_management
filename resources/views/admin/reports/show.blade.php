@extends('layouts.admin')

@section('page-title', 'Report Details')
@section('page-description', 'View report details and add review')

@section('content')
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
    font-size: 2rem;
    color: #ddd;
    cursor: pointer;
    transition: color 0.3s;
    margin: 0 2px;
}

.star-rating input[type="radio"]:checked ~ label,
.star-rating label:hover,
.star-rating label:hover ~ label {
    color: #ffc107;
}

.star-rating label:hover ~ label {
    color: #ddd;
}

.rating-disabled {
    cursor: not-allowed !important;
    opacity: 0.5;
}
</style>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Report Details</h5>
                <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Reports
                </a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="row mb-4">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <h6>Title:</h6>
                                    <p>{{ $report->title }}</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <h6>Employee:</h6>
                                    <p>{{ $report->employee->name ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <h6>Task Name:</h6>
                                    <p>{{ $report->task->task_name ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <h6>Date Sent:</h6>
                                    <p>{{ \Carbon\Carbon::parse($report->created_at)->format('M d, Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h6>Content:</h6>
                                    <p>{{ $report->content }}</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <h6>Sent To:</h6>
                                    <p>
                                        @if($report->sent_to_admin)
                                            <span class="badge bg-primary me-2">Admin</span>
                                        @endif
                                        @if($report->sent_to_team_lead)
                                            <span class="badge bg-info">Team Lead</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-3">
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
                </div>

                @if($report->task && $report->task->assigned_team === 'Team')
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Team Reviews</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Reviewer</th>
                                                <th>Member</th>
                                                <th>Comments</th>
                                                <th>Rating</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($report->team_lead_review || $report->team_lead_rating || $report->team_lead_status)
                                                <tr>
                                                    <td><span class="badge bg-info">Team Lead</span></td>
                                                    <td>{{ $report->employee->name ?? 'N/A' }}</td>
                                                    <td>{{ $report->team_lead_review ?? 'N/A' }}</td>
                                                    <td>
                                                        @if($report->team_lead_rating)
                                                            @for($i = 1; $i <= 5; $i++)
                                                                <span class="text-warning">{{ $i <= $report->team_lead_rating ? '★' : '☆' }}</span>
                                                            @endfor
                                                            ({{ $report->team_lead_rating }}/5)
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($report->team_lead_status)
                                                            <span class="badge bg-secondary">{{ ucfirst($report->team_lead_status) }}</span>
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif

                                            @if($report->admin_review || $report->admin_rating || $report->admin_status)
                                                <tr>
                                                    <td><span class="badge bg-primary">Admin</span></td>
                                                    <td>{{ $report->employee->name ?? 'N/A' }}</td>
                                                    <td>{{ $report->admin_review ?? 'N/A' }}</td>
                                                    <td>
                                                        @if($report->admin_rating)
                                                            @for($i = 1; $i <= 5; $i++)
                                                                <span class="text-warning">{{ $i <= $report->admin_rating ? '★' : '☆' }}</span>
                                                            @endfor
                                                            ({{ $report->admin_rating }}/5)
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($report->admin_status)
                                                            <span class="badge bg-success">{{ ucfirst($report->admin_status) }}</span>
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Add/Update Admin Review</h6>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('admin.reports.update', $report->id) }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Admin Status</label>
                                                <select name="status" id="status" class="form-select" required>
                                                    <option value="sent" {{ $report->admin_status === 'sent' ? 'selected' : '' }}>Sent</option>
                                                    <option value="read" {{ $report->admin_status === 'read' ? 'selected' : '' }}>Read</option>
                                                    <option value="responded" {{ $report->admin_status === 'responded' ? 'selected' : '' }}>Responded</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <label for="review" class="form-label">Admin Review/Comments (Optional)</label>
                                                <textarea name="review" id="review" class="form-control" rows="3" placeholder="Add your review or comments here...">{{ old('review', $report->admin_review) }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Admin Rating</label>
                                                @php
                                                    $ratingDisabled = (!$report->task || $report->task->status !== 'Completed') ? 'disabled' : '';
                                                    $ratingDisabledClass = (!$report->task || $report->task->status !== 'Completed') ? 'rating-disabled' : '';
                                                @endphp
                                                <div class="star-rating {{ $ratingDisabledClass }}">
                                                    <input type="radio" id="star5" name="rating" value="5" {{ old('rating', $report->admin_rating) == 5 ? 'checked' : '' }} {{ $ratingDisabled }} />
                                                    <label for="star5" title="5 stars">★</label>
                                                    <input type="radio" id="star4" name="rating" value="4" {{ old('rating', $report->admin_rating) == 4 ? 'checked' : '' }} {{ $ratingDisabled }} />
                                                    <label for="star4" title="4 stars">★</label>
                                                    <input type="radio" id="star3" name="rating" value="3" {{ old('rating', $report->admin_rating) == 3 ? 'checked' : '' }} {{ $ratingDisabled }} />
                                                    <label for="star3" title="3 stars">★</label>
                                                    <input type="radio" id="star2" name="rating" value="2" {{ old('rating', $report->admin_rating) == 2 ? 'checked' : '' }} {{ $ratingDisabled }} />
                                                    <label for="star2" title="2 stars">★</label>
                                                    <input type="radio" id="star1" name="rating" value="1" {{ old('rating', $report->admin_rating) == 1 ? 'checked' : '' }} {{ $ratingDisabled }} />
                                                    <label for="star1" title="1 star">★</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <button type="submit" class="btn btn-primary w-100">
                                                    <i class="fas fa-save me-2"></i>Update Report
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all rating labels
    const ratingLabels = document.querySelectorAll('.star-rating label');

    ratingLabels.forEach(label => {
        label.addEventListener('click', function(e) {
            // Check if rating is disabled (task not completed)
            if (document.querySelector('.star-rating').classList.contains('rating-disabled')) {
                e.preventDefault();
                // Show alert message
                alert('Task is not completed yet. Rating can only be given for completed tasks.');
                return false;
            }
        });
    });
});
</script>
@endsection
