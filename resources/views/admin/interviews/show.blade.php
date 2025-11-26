@extends('layouts.admin')

@section('page-title', 'Interview Details')
@section('page-description', 'View interview information')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Interview Details</h5>
                <div>
                    <a href="{{ route('admin.interviews.edit', $interview) }}" class="btn btn-warning btn-sm">Edit</a>
                    <a href="{{ route('admin.interviews.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted">Candidate Information</h6>
                        <table class="table table-sm">
                            <tr>
                                <th width="40%">Name:</th>
                                <td>{{ $interview->candidate_name }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ $interview->candidate_email }}</td>
                            </tr>
                            <tr>
                                <th>Phone:</th>
                                <td>{{ $interview->candidate_phone ?: 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Profile:</th>
                                <td>{{ $interview->candidate_profile ?: 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Experience:</th>
                                <td>{{ $interview->candidate_experience ?: 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <h6 class="text-muted">Interview Schedule</h6>
                        <table class="table table-sm">
                            <tr>
                                <th width="40%">Date:</th>
                                <td>{{ $interview->date->format('M d, Y') }}</td>
                            </tr>
                            <tr>
                                <th>Time:</th>
                                <td>{{ $interview->time->format('H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Scheduled At:</th>
                                <td>{{ $interview->scheduled_at->format('M d, Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>
                                    <span class="badge
                                        @if($interview->status == 'scheduled') bg-primary
                                        @elseif($interview->status == 'completed') bg-success
                                        @elseif($interview->status == 'cancelled') bg-danger
                                        @elseif($interview->status == 'rescheduled') bg-warning
                                        @endif">
                                        {{ ucfirst($interview->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
    <th>Link Status:</th>
    <td>
        <span class="badge {{ $interview->link_status == '1' ? 'bg-success' : 'bg-danger' }}">
            {{ $interview->link_status == '1' ? 'Active' : 'Inactive' }}
        </span>

        <form action="{{ route('interviews.toggleLinkStatus', $interview->id) }}"
              method="POST"
              class="d-inline ms-2">
            @csrf
            @method('PUT')

            <button type="submit"
                class="btn btn-sm {{ $interview->link_status == '1' ? 'btn-outline-danger' : 'btn-outline-success' }}">
                {{ $interview->link_status == '1' ? 'Disable' : 'Enable' }}
            </button>
        </form>
    </td>
</tr>

                        </table>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <h6 class="text-muted">Interview Links & IDs</h6>
                        <table class="table table-sm">
                            <tr>
                                <th>Interview Code:</th>
                                <td>{{ $interview->interview_code ?: 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Interview Link:</th>
                              <td>
    @if($interview->link_status == '1')
        <a href="{{ route('interview.link', $interview->unique_link) }}"
           target="_blank"
           class="btn btn-sm btn-primary">
            <i class="fas fa-external-link-alt"></i> Open Interview Link
        </a>

        <button class="btn btn-sm btn-outline-secondary ms-2"
                onclick="copyToClipboard('{{ route('interview.link', $interview->unique_link) }}')">
            <i class="fas fa-copy"></i> Copy Link
        </button>
    @else
        <button class="btn btn-sm btn-secondary" disabled>
            <i class="fas fa-lock"></i> Link Disabled
        </button>

        <button class="btn btn-sm btn-outline-secondary ms-2" disabled>
            <i class="fas fa-copy"></i> Copy Disabled
        </button>
    @endif
</td>

                            </tr>
                            <tr>
                                <th>Interview Room:</th>
                                <td>
                                    <a href="{{ route('admin.interviews.room', $interview) }}" target="_blank" class="btn btn-sm btn-success">
                                        <i class="fas fa-video"></i> Enter Interview Room
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th>Results:</th>
                                <td>
                                    @if($interview->results)
                                        <span class="badge
                                            @if($interview->results == 'selected') bg-success
                                            @elseif($interview->results == 'rejected') bg-danger
                                            @elseif($interview->results == 'pending') bg-warning
                                            @endif">
                                            {{ ucfirst($interview->results) }}
                                        </span>
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <h6 class="text-muted">Documents</h6>
                        @if($interview->candidate_resume_path)
                            <table class="table table-sm">
                                <tr>
                                    <th width="40%">Candidate Resume:</th>
                                    <td>
                                        <a href="{{ Storage::url($interview->candidate_resume_path) }}" target="_blank" class="btn btn-sm btn-info">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        @else
                            <p class="text-muted">No candidate resume uploaded.</p>
                        @endif
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <h6 class="text-muted">Timestamps</h6>
                        <table class="table table-sm">
                            <tr>
                                <th width="20%">Created At:</th>
                                <td>{{ $interview->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Updated At:</th>
                                <td>{{ $interview->updated_at->format('M d, Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    const button = event.target;

    // Try modern clipboard API first
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(text).then(function() {
            showSuccess(button);
        }).catch(function(err) {
            console.error('Failed to copy: ', err);
            fallbackCopyTextToClipboard(text, button);
        });
    } else {
        // Fallback for older browsers or non-HTTPS
        fallbackCopyTextToClipboard(text, button);
    }
}

function fallbackCopyTextToClipboard(text, button) {
    const textArea = document.createElement("textarea");
    textArea.value = text;

    // Avoid scrolling to bottom
    textArea.style.top = "0";
    textArea.style.left = "0";
    textArea.style.position = "fixed";
    textArea.style.opacity = "0";

    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();

    try {
        const successful = document.execCommand('copy');
        if (successful) {
            showSuccess(button);
        } else {
            showErrorMessage('Failed to copy link to clipboard.');
        }
    } catch (err) {
        console.error('Fallback copy failed: ', err);
        showErrorMessage('Failed to copy link to clipboard.');
    }

    document.body.removeChild(textArea);
}

function showSuccess(button) {
    // Show a temporary success message
    const originalText = button.textContent;
    button.textContent = 'Copied!';
    button.classList.remove('btn-outline-secondary');
    button.classList.add('btn-success');

    // Show success alert
    showSuccessMessage('Interview link copied to clipboard successfully!');

    setTimeout(() => {
        button.textContent = originalText;
        button.classList.remove('btn-success');
        button.classList.add('btn-outline-secondary');
    }, 2000);
}

function showSuccessMessage(message) {
    // Remove any existing alerts
    const existingAlert = document.querySelector('.alert');
    if (existingAlert) {
        existingAlert.remove();
    }

    // Create success alert
    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-success alert-dismissible fade show position-fixed';
    alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    alertDiv.innerHTML = `
        <i class="fas fa-check-circle"></i> ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    document.body.appendChild(alertDiv);

    // Auto remove after 3 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 3000);
}

function showErrorMessage(message) {
    // Remove any existing alerts
    const existingAlert = document.querySelector('.alert');
    if (existingAlert) {
        existingAlert.remove();
    }

    // Create error alert
    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-danger alert-dismissible fade show position-fixed';
    alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    alertDiv.innerHTML = `
        <i class="fas fa-exclamation-triangle"></i> ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    document.body.appendChild(alertDiv);

    // Auto remove after 3 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 3000);
}
</script>
@endsection
