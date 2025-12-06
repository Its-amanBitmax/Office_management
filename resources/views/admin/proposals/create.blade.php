@extends('layouts.admin')

@section('title', 'Create Proposal')

@section('page-title', 'Create Proposal')
@section('page-description', 'Create a new proposal for a lead')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Create New Proposal</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.proposals.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="lead_id" class="form-label">Lead <span class="text-danger">*</span></label>
                            <select name="lead_id" id="lead_id" class="form-select @error('lead_id') is-invalid @enderror" required>
                                <option value="">Select Lead</option>
                                @foreach($leads as $lead)
                                <option value="{{ $lead->id }}" {{ old('lead_id') == $lead->id ? 'selected' : '' }} {{ $leadId == $lead->id ? 'selected' : '' }}>
                                    {{ $lead->name }} ({{ $lead->email }})
                                </option>
                                @endforeach
                            </select>
                            @error('lead_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror"
                                   value="{{ old('amount') }}" placeholder="Enter proposal amount" required>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="">Select Status</option>
                                <option value="sent" {{ old('status') == 'sent' ? 'selected' : '' }}>Sent</option>
                                <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="file" class="form-label">Proposal File (PDF)</label>
                            <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror" accept=".pdf">
                            <div class="form-text">Upload a PDF file (max 10MB)</div>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.proposals.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Create Proposal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
