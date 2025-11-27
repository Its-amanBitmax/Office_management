@extends('layouts.employee')

@section('title', 'Send Report')

@section('page-title', 'Send Report')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Send New Report</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('employee.reports.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="task_id" class="form-label">Select Task <span class="text-danger">*</span></label>
                            <select name="task_id" id="task_id" class="form-select @error('task_id') is-invalid @enderror" required>
                                <option value="">-- Select Task --</option>
                                @foreach($tasks as $task)
                <option value="{{ $task->id }}" {{ old('task_id') == $task->id ? 'selected' : '' }}>
                    {{ $task->task_name }}
                </option>
                                @endforeach
                            </select>
                            @error('task_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="title" class="form-label">Report Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="content" class="form-label">Report Content <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('content') is-invalid @enderror"
                                      id="content" name="content" rows="8" required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    @if($hasTeamLead)
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="send_to_team_lead" name="send_to_team_lead" value="1" {{ old('send_to_team_lead') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="send_to_team_lead">
                                        Also send to Team Lead ({{ $teamLead->name ?? 'N/A' }})
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="attachment" class="form-label">Attachment (Optional)</label>
                            <input type="file" class="form-control @error('attachment') is-invalid @enderror"
                                   id="attachment" name="attachment" accept=".pdf,.doc,.docx,.txt,.jpg,.jpeg,.png">
                            @error('attachment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Allowed file types: PDF, DOC, DOCX, TXT, JPG, JPEG, PNG (Max: 2MB)</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                This report will be sent to Admin{{ $hasTeamLead ? ' and optionally to your Team Lead' : '' }}.
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>Send Report
                            </button>
                            <a href="{{ route('employee.reports') }}" class="btn btn-secondary ms-2">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
