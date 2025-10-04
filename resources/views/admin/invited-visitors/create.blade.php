@extends('layouts.admin')

@section('page-title', 'Add Invited Visitor')
@section('page-description', 'Create a new invited visitor record')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Add New Invited Visitor</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('invited-visitors.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="invited_at" class="form-label">Invited At</label>
                            <input type="datetime-local" class="form-control @error('invited_at') is-invalid @enderror" id="invited_at" name="invited_at" value="{{ old('invited_at') }}">
                            @error('invited_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="first_contact_person_name" class="form-label">First Contact Person Name</label>
                            <input type="text" class="form-control @error('first_contact_person_name') is-invalid @enderror" id="first_contact_person_name" name="first_contact_person_name" value="{{ old('first_contact_person_name') }}">
                            @error('first_contact_person_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="contact_person_phone" class="form-label">Contact Person Phone</label>
                            <input type="tel" class="form-control @error('contact_person_phone') is-invalid @enderror" id="contact_person_phone" name="contact_person_phone" value="{{ old('contact_person_phone') }}">
                            @error('contact_person_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="purpose" class="form-label">Purpose</label>
                        <textarea class="form-control @error('purpose') is-invalid @enderror" id="purpose" name="purpose" rows="3">{{ old('purpose') }}</textarea>
                        @error('purpose')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Invited Visitor
                        </button>
                        <a href="{{ route('invited-visitors.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
