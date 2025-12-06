@extends('layouts.admin')

@section('title', 'Edit Interaction')

@section('page-title', 'Edit Interaction')
@section('page-description', 'Update interaction information')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.interactions.update', $interaction) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="lead_id" class="form-label">Lead *</label>
                                <select class="form-control @error('lead_id') is-invalid @enderror" id="lead_id" name="lead_id" required>
                                    <option value="">Select Lead</option>
                                    @foreach($leads as $lead)
                                        <option value="{{ $lead->id }}" {{ old('lead_id', $interaction->lead_id) == $lead->id ? 'selected' : '' }}>
                                            {{ $lead->name }} ({{ $lead->company_name }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('lead_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="activity_type" class="form-label">Activity Type *</label>
                                <select class="form-control @error('activity_type') is-invalid @enderror" id="activity_type" name="activity_type" required>
                                    <option value="">Select Activity Type</option>
                                    <option value="Call" {{ old('activity_type', $interaction->activity_type) == 'Call' ? 'selected' : '' }}>Call</option>
                                    <option value="WhatsApp" {{ old('activity_type', $interaction->activity_type) == 'WhatsApp' ? 'selected' : '' }}>WhatsApp</option>
                                    <option value="Email" {{ old('activity_type', $interaction->activity_type) == 'Email' ? 'selected' : '' }}>Email</option>
                                    <option value="Meeting" {{ old('activity_type', $interaction->activity_type) == 'Meeting' ? 'selected' : '' }}>Meeting</option>
                                    <option value="Note" {{ old('activity_type', $interaction->activity_type) == 'Note' ? 'selected' : '' }}>Note</option>
                                </select>
                                @error('activity_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject *</label>
                        <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" value="{{ old('subject', $interaction->subject) }}" required>
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $interaction->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="activity_status" class="form-label">Activity Status *</label>
                                <select class="form-control @error('activity_status') is-invalid @enderror" id="activity_status" name="activity_status" required>
                                    <option value="Pending" {{ old('activity_status', $interaction->activity_status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Completed" {{ old('activity_status', $interaction->activity_status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                                @error('activity_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="activity_date" class="form-label">Activity Date *</label>
                                <input type="date" class="form-control @error('activity_date') is-invalid @enderror" id="activity_date" name="activity_date" value="{{ old('activity_date', $interaction->activity_date) }}" required>
                                @error('activity_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="next_follow_up" class="form-label">Next Follow-up</label>
                        <input type="date" class="form-control @error('next_follow_up') is-invalid @enderror" id="next_follow_up" name="next_follow_up" value="{{ old('next_follow_up', $interaction->next_follow_up) }}">
                        @error('next_follow_up')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Interaction
                        </button>
                        <a href="{{ route('admin.interactions.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
