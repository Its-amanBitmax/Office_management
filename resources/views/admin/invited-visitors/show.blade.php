@extends('layouts.admin')

@section('page-title', 'Invited Visitor Details')
@section('page-description', 'View invited visitor information')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Invited Visitor Details</h5>
                    <div>
                        {{-- <a href="{{ route('invited-visitors.card', $invitedVisitor) }}" class="btn btn-primary btn-sm" target="_blank">
                            <i class="fas fa-id-card"></i> View Card
                        </a> --}}
                        <a href="{{ route('invited-visitors.invitation-pdf', $invitedVisitor) }}" class="btn btn-success btn-sm" target="_blank">
                            <i class="fas fa-file-pdf"></i> Download Invitation PDF
                        </a>
                        <a href="{{ route('invited-visitors.edit', $invitedVisitor) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('invited-visitors.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Name:</label>
                            <p class="form-control-plaintext">{{ $invitedVisitor->name }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email:</label>
                            <p class="form-control-plaintext">{{ $invitedVisitor->email ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Phone:</label>
                            <p class="form-control-plaintext">{{ $invitedVisitor->phone ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Invited At:</label>
                            <p class="form-control-plaintext">{{ $invitedVisitor->invited_at ? $invitedVisitor->invited_at->format('M d, Y H:i') : 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">First Contact Person Name:</label>
                            <p class="form-control-plaintext">{{ $invitedVisitor->first_contact_person_name ?? 'N/A' }}</p>
                        </div>
                        
                <div class="mb-3">
                    <label class="form-label fw-bold">Purpose:</label>
                    <p class="form-control-plaintext">{{ $invitedVisitor->purpose ?? 'N/A' }}</p>
                </div>

                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Contact Person Phone:</label>
                            <p class="form-control-plaintext">{{ $invitedVisitor->contact_person_phone ?? 'N/A' }}</p>
                        </div>
                   

                <div class="mb-3">
                    <label class="form-label fw-bold">Invitation Code:</label>
                    <p class="form-control-plaintext">{{ $invitedVisitor->invitation_code ?? 'N/A' }}</p>
                </div>
                 </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Created At:</label>
                            <p class="form-control-plaintext">{{ $invitedVisitor->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Updated At:</label>
                            <p class="form-control-plaintext">{{ $invitedVisitor->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
