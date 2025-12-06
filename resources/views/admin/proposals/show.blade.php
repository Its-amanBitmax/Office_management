@extends('layouts.admin')

@section('title', 'Proposal Details')

@section('page-title', 'Proposal Details')
@section('page-description', 'View proposal information')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Proposal #{{ $proposal->proposal_no }}</h5>
                    <div>
                        <a href="{{ route('admin.proposals.edit', $proposal) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.proposals.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Proposal No</label>
                            <p class="form-control-plaintext">{{ $proposal->proposal_no }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Lead</label>
                            <p class="form-control-plaintext">{{ $proposal->lead->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Amount</label>
                            <p class="form-control-plaintext">${{ number_format($proposal->amount, 2) }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <p class="form-control-plaintext">
                                <span class="badge bg-{{ $proposal->status == 'approved' ? 'success' : ($proposal->status == 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($proposal->status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Created At</label>
                            <p class="form-control-plaintext">{{ $proposal->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Updated At</label>
                            <p class="form-control-plaintext">{{ $proposal->updated_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Proposal File</label>
                            <p class="form-control-plaintext">
                                @if($proposal->file)
                                    <a href="{{ Storage::url($proposal->file) }}" target="_blank" class="btn btn-primary">
                                        <i class="fas fa-file-pdf"></i> View Proposal PDF
                                    </a>
                                @else
                                    No file uploaded
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
