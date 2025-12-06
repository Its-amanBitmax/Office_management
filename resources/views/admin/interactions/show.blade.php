@extends('layouts.admin')

@section('title', 'Interaction Details')

@section('page-title', 'Interaction Details')
@section('page-description', 'View interaction information')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Interaction #{{ $interaction->id }}</h5>
                    <div>
                        <a href="{{ route('admin.interactions.edit', $interaction) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.interactions.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Lead</label>
                            <p class="form-control-plaintext">{{ $interaction->lead->name ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Activity Type</label>
                            <p class="form-control-plaintext">{{ $interaction->activity_type }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Subject</label>
                            <p class="form-control-plaintext">{{ $interaction->subject }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <p class="form-control-plaintext">
                                <span class="badge bg-{{ $interaction->activity_status == 'Completed' ? 'success' : 'warning' }}">
                                    {{ $interaction->activity_status }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Activity Date</label>
                            <p class="form-control-plaintext">{{ $interaction->activity_date ? \Carbon\Carbon::parse($interaction->activity_date)->format('d M Y') : 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Next Follow Up</label>
                            <p class="form-control-plaintext">{{ $interaction->next_follow_up ? \Carbon\Carbon::parse($interaction->next_follow_up)->format('d M Y') : 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Created By</label>
                            <p class="form-control-plaintext">{{ $interaction->creator->name ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Created At</label>
                            <p class="form-control-plaintext">{{ $interaction->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Description</label>
                            <p class="form-control-plaintext">{{ $interaction->description ?: 'No description provided.' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
