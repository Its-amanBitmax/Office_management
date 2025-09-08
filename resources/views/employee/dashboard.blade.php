@extends('layouts.employee')

@section('title', 'Dashboard')

@section('page-title', 'Employee Dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Welcome back, {{ auth('employee')->user()->name ?? 'Employee' }}!</h4>
                <p class="card-text">Here's an overview of your employee dashboard. You can view your profile, tasks, and other important information here.</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-id-card fa-2x text-primary mb-3"></i>
                <h5 class="card-title">{{ auth('employee')->user()->employee_code ?? 'N/A' }}</h5>
                <p class="card-text">Employee Code</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-envelope fa-2x text-primary mb-3"></i>
                <h5 class="card-title">{{ auth('employee')->user()->email ?? 'N/A' }}</h5>
                <p class="card-text">Email Address</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-phone fa-2x text-primary mb-3"></i>
                <h5 class="card-title">{{ auth('employee')->user()->phone ?? 'N/A' }}</h5>
                <p class="card-text">Phone Number</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-building fa-2x text-primary mb-3"></i>
                <h5 class="card-title">{{ auth('employee')->user()->department ?? 'N/A' }}</h5>
                <p class="card-text">Department</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('employee.profile') }}" class="btn btn-outline-primary btn-lg w-100">
                            <i class="fas fa-user me-2"></i>View Profile
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('employee.tasks') }}" class="btn btn-outline-primary btn-lg w-100">
                            <i class="fas fa-tasks me-2"></i>My Tasks
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
