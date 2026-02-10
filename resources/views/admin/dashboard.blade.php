@extends('layouts.admin')

@section('page-title', 'Dashboard')
@section('page-description', 'Welcome to your admin dashboard')

@section('content')
<div class="row">
    <div class="col-xl-8 col-lg-7">
        <!-- Welcome Card -->
        <div class="card welcome-card mb-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="avatar-lg bg-gradient-primary rounded-circle d-flex align-items-center justify-content-center">
                            <i class="fas fa-user-shield fa-2x text-white"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-4">
                        <h3 class="text-white mb-1">Welcome back, {{ $admin->name }}!</h3>
                        <p class="text-white-50 mb-0">Here's what's happening with your system today.</p>
                        <small class="text-white-75">{{ now()->format('l, F j, Y') }}</small>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="badge bg-white text-primary py-2 px-3">
                            <i class="fas fa-calendar-alt me-2"></i>Week {{ now()->weekOfYear }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card stat-card border-start border-primary border-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Total Employees</h6>
                                <h3 class="mb-0 text-primary">{{ number_format($totalUsers) }}</h3>
                            </div>
                            <div class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fas fa-users text-primary fa-lg"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="badge bg-primary bg-opacity-10 text-primary">
                                <i class="fas fa-clock me-1"></i> Updated just now
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="col-md-4 mb-3">
                <div class="card stat-card border-start border-warning border-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Pending Reviews</h6>
                                <h3 class="mb-0 text-warning">{{ number_format($pendingReviews) }}</h3>
                            </div>
                            <div class="avatar-sm bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fas fa-clipboard-check text-warning fa-lg"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('admin.reviews.index') }}" class="text-decoration-none small">
                                <i class="fas fa-external-link-alt me-1"></i> View all
                            </a>
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="col-md-4 mb-3">
                <div class="card stat-card border-start border-info border-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Monthly Salary Expenses</h6>
                                <h3 class="mb-0 text-info">₹{{ number_format($totalSalaryExpenses, 2) }}</h3>
                            </div>
                            <div class="avatar-sm bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fas fa-rupee-sign text-info fa-lg"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="badge bg-success bg-opacity-10 text-success">
                                <i class="fas fa-arrow-up me-1"></i> Budget on track
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card stat-card border-start border-danger border-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Other Expenses (This Month)</h6>
                                <h3 class="mb-0 text-danger">₹{{ number_format($totalOtherExpenses, 2) }}</h3>
                            </div>
                            <div class="avatar-sm bg-danger bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fas fa-receipt text-danger fa-lg"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="badge bg-warning bg-opacity-10 text-warning">
                                <i class="fas fa-calendar-alt me-1"></i> Current month
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Chart -->
        <div class="card mb-4">
            <div class="card-header bg-white border-bottom-0 py-3">
                <h5 class="mb-0 d-flex align-items-center">
                    <i class="fas fa-chart-line text-primary me-2"></i>
                    Employee Performance (Last 30 Days)
                </h5>
            </div>
            <div class="card-body">
                <div class="chart-container" style="position: relative; height: 300px;">
                    @if($performanceData['hasData'])
                        <canvas id="employeePerformanceChart"></canvas>
                    @else
                        <div class="text-center py-5">
                            <div class="avatar-lg bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3">
                                <i class="fas fa-chart-bar fa-2x text-muted"></i>
                            </div>
                            <h5 class="text-muted">No Performance Data Available</h5>
                            <p class="text-muted mb-0">Performance data will appear here once evaluation reports are created.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Employees -->
        <div class="card">
            <div class="card-header bg-white border-bottom-0 py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 d-flex align-items-center">
                    <i class="fas fa-user-plus text-success me-2"></i>
                    Recent Employees
                </h5>
                <a href="{{ route('employees.index') }}" class="btn btn-sm btn-outline-primary">
                    View All <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Employee</th>
                                <th>Employee Code</th>
                                <th>Position</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Salary</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentEmployees as $employee)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-light rounded-circle me-3">
                                            @if($employee->profile_image && file_exists(public_path('storage/profile_images/' . $employee->profile_image)))
                                                <img src="{{ asset('storage/profile_images/' . $employee->profile_image) }}" 
                                                     alt="{{ $employee->name }}" 
                                                     class="rounded-circle" 
                                                     style="width: 36px; height: 36px; object-fit: cover;">
                                            @else
                                                <div class="avatar-initials bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                                     style="width: 36px; height: 36px;">
                                                    {{ strtoupper(substr($employee->name, 0, 1)) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $employee->name }}</h6>
                                            <small class="text-muted">{{ $employee->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">{{ $employee->employee_code }}</span>
                                </td>
                                <td>{{ $employee->position }}</td>
                                <td>
                                    <span class="badge bg-{{ $employee->status == 'active' ? 'success' : ($employee->status == 'inactive' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($employee->status) }}
                                    </span>
                                </td>
                                <td class="text-end pe-4 fw-bold">
                                    ₹{{ number_format(($employee->basic_salary ?? 0) + ($employee->hra ?? 0) + ($employee->conveyance ?? 0) + ($employee->medical ?? 0), 2) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="col-xl-4 col-lg-5">
        <!-- Profile Card -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center mb-4">
                    <div class="flex-shrink-0">
                        @if($admin->profile_image && file_exists(public_path('storage/profile_images/' . $admin->profile_image)))
                            <img src="{{ asset('storage/profile_images/' . $admin->profile_image) }}" 
                                 alt="{{ $admin->name }}" 
                                 class="rounded-circle border border-3 border-primary"
                                 style="width: 80px; height: 80px; object-fit: cover;">
                        @else
                            <div class="avatar-lg bg-gradient-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                 style="width: 80px; height: 80px; font-size: 2rem; font-weight: bold;">
                                {{ strtoupper(substr($admin->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h5 class="mb-1">{{ $admin->name }}</h5>
                        <p class="text-muted mb-2">Administrator</p>
                        <div class="d-flex gap-2">
                            <button onclick="toggleProfileForm()" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit me-1"></i> Edit Profile
                            </button>
                            <a href="{{ route('admin.profile') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-cog"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Profile Form (Hidden by default) -->
                <div id="profileForm" class="d-none">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Profile Image</label>
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    @if($admin->profile_image && file_exists(public_path('storage/profile_images/' . $admin->profile_image)))
                                        <img src="{{ asset('storage/profile_images/' . $admin->profile_image) }}" 
                                             alt="Current Profile" 
                                             class="rounded-circle"
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <div class="avatar-initials bg-light rounded-circle d-flex align-items-center justify-content-center"
                                             style="width: 60px; height: 60px;">
                                            {{ strtoupper(substr($admin->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="{{ old('name', $admin->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="{{ old('email', $admin->email) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone" 
                                   value="{{ old('phone', $admin->phone ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label for="bio" class="form-label">Bio</label>
                            <textarea class="form-control" id="bio" name="bio" rows="3">{{ old('bio', $admin->bio ?? '') }}</textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="fas fa-save me-1"></i> Save Changes
                            </button>
                            <button type="button" onclick="toggleProfileForm()" class="btn btn-outline-secondary">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Profile Info (Default view) -->
                <div id="profileInfo">
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex align-items-center py-2 border-bottom">
                            <i class="fas fa-envelope text-muted me-3" style="width: 20px;"></i>
                            <span class="text-truncate">{{ $admin->email }}</span>
                        </li>
                        <li class="d-flex align-items-center py-2 border-bottom">
                            <i class="fas fa-phone text-muted me-3" style="width: 20px;"></i>
                            <span>{{ $admin->phone ?? 'Not set' }}</span>
                        </li>
                        <li class="d-flex align-items-start py-2 border-bottom">
                            <i class="fas fa-info-circle text-muted me-3 mt-1" style="width: 20px;"></i>
                            <span>{{ $admin->bio ?? 'No bio provided' }}</span>
                        </li>
                        <li class="d-flex align-items-center py-2">
                            <i class="fas fa-clock text-muted me-3" style="width: 20px;"></i>
                            <span>Last login: {{ now()->format('M d, Y g:i A') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Leave Requests -->
        <div class="card mb-4">
            <div class="card-header bg-white border-bottom-0 py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 d-flex align-items-center">
                    <i class="fas fa-calendar-alt text-danger me-2"></i>
                    Recent Leave Requests
                </h5>
                <span class="badge bg-danger">{{ $recentLeaveRequests->count() }}</span>
            </div>
            <div class="card-body p-0">
                @if($recentLeaveRequests->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentLeaveRequests as $leaveRequest)
                        <div class="list-group-item border-0 py-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="mb-1">{{ $leaveRequest->subject }}</h6>
                                    <small class="text-muted">{{ $leaveRequest->employee->name ?? 'N/A' }}</small>
                                </div>
                                <span class="badge bg-{{ $leaveRequest->status === 'approved' ? 'success' : ($leaveRequest->status === 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($leaveRequest->status) }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small">
                                    <i class="fas fa-calendar-day me-1"></i>
                                    {{ \Carbon\Carbon::parse($leaveRequest->start_date)->format('M d') }} - 
                                    {{ \Carbon\Carbon::parse($leaveRequest->end_date)->format('M d, Y') }}
                                </span>
                                <span class="badge bg-light text-dark">
                                    {{ ucfirst($leaveRequest->leave_type) }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="card-footer bg-white border-top-0 py-3 text-center">
                        <a href="{{ route('admin.leave-requests.index') }}" class="btn btn-sm btn-outline-primary">
                            View All Requests <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="avatar-lg bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3">
                            <i class="fas fa-calendar-check fa-2x text-muted"></i>
                        </div>
                        <h6 class="text-muted">No Leave Requests</h6>
                        <p class="text-muted small mb-0">No pending leave requests at the moment</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Employee Report Status -->
        <div class="card">
            <div class="card-header bg-white border-bottom-0 py-3">
                <h5 class="mb-0 d-flex align-items-center">
                    <i class="fas fa-clipboard-list text-info me-2"></i>
                    Daily Report Status
                    <small class="text-muted ms-2">{{ \Carbon\Carbon::parse($today)->format('M d, Y') }}</small>
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Employee</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employees as $employee)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-xs bg-light rounded-circle me-2">
                                            <div class="avatar-initials bg-light text-dark rounded-circle d-flex align-items-center justify-content-center"
                                                 style="width: 24px; height: 24px; font-size: 0.75rem;">
                                                {{ strtoupper(substr($employee->name, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="fw-medium">{{ $employee->name }}</div>
                                            <small class="text-muted">{{ $employee->employee_code }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if(isset($reportStatuses[$employee->id]))
                                        <span class="badge bg-success">
                                            <i class="fas fa-check me-1"></i> Submitted
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="fas fa-clock me-1"></i> Pending
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white border-top-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            {{ $reportStatuses->count() }} of {{ $totalEmployeesCount }} submitted
                        </small>
                        <div class="progress" style="width: 100px; height: 6px;">
                            <div class="progress-bar bg-success"
                                 style="width: {{ $totalEmployeesCount > 0 ? ($reportStatuses->count() / $totalEmployeesCount) * 100 : 0 }}%">
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.welcome-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
}

.stat-card {
    transition: transform 0.2s, box-shadow 0.2s;
    border: none;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.1) !important;
}

.avatar-lg {
    width: 60px;
    height: 60px;
}

.avatar-sm {
    width: 48px;
    height: 48px;
}

.avatar-xs {
    width: 32px;
    height: 32px;
}

.border-start {
    border-left-width: 4px !important;
}

.table th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
}

.list-group-item {
    transition: background-color 0.2s;
}

.list-group-item:hover {
    background-color: #f8f9fa;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if($performanceData['hasData'])
    const ctx = document.getElementById('employeePerformanceChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($performanceData['labels'] ?? []),
            datasets: [{
                label: 'Performance Score',
                data: @json($performanceData['scores'] ?? []),
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                borderRadius: 4,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    grid: {
                        drawBorder: false,
                    },
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleFont: {
                        size: 14
                    },
                    bodyFont: {
                        size: 13
                    },
                    callbacks: {
                        label: function(context) {
                            return 'Score: ' + context.parsed.y + '/100';
                        }
                    }
                }
            }
        }
    });
    @endif
});

function toggleProfileForm() {
    const form = document.getElementById('profileForm');
    const info = document.getElementById('profileInfo');
    
    if (form.classList.contains('d-none')) {
        form.classList.remove('d-none');
        info.classList.add('d-none');
    } else {
        form.classList.add('d-none');
        info.classList.remove('d-none');
    }
}
</script>
@endpush
@endsection