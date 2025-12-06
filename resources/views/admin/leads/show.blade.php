@extends('layouts.admin')

@section('title', 'Lead Details')

@section('page-title', 'Lead Details')
@section('page-description', 'View lead information')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Lead #{{ $lead->lead_id }}</h5>
                    <div>
                        <a href="{{ route('admin.leads.edit', $lead) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.leads.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Name</label>
                            <p class="form-control-plaintext">{{ $lead->name }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <p class="form-control-plaintext">{{ $lead->email }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Phone</label>
                            <p class="form-control-plaintext">{{ $lead->phone }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Company Name</label>
                            <p class="form-control-plaintext">{{ $lead->company_name ?: 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Source</label>
                            <p class="form-control-plaintext">{{ $lead->source }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <p class="form-control-plaintext">
                                <span class="badge bg-{{ $lead->status == 'Open' ? 'success' : ($lead->status == 'Closed' ? 'danger' : 'warning') }}">
                                    {{ $lead->status }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Priority</label>
                            <p class="form-control-plaintext">
                                <span class="badge bg-{{ $lead->priority == 'Hot' ? 'danger' : ($lead->priority == 'Warm' ? 'warning' : 'secondary') }}">
                                    {{ $lead->priority }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Assigned To</label>
                            <p class="form-control-plaintext">{{ $lead->assignedAdmin ? $lead->assignedAdmin->name : 'Unassigned' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Created At</label>
                            <p class="form-control-plaintext">{{ $lead->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Updated At</label>
                            <p class="form-control-plaintext">{{ $lead->updated_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
