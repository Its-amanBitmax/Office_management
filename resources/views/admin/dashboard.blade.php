@extends('layouts.admin')

@section('page-title', 'Dashboard')
@section('page-description', 'Welcome to your admin dashboard')

@section('content')
<div class="row">
        <div class="col-md-8">
            <div class="welcome-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 2rem; border-radius: 8px; margin-bottom: 2rem;">
                <h3 style="margin-bottom: 0.5rem;">Welcome back, {{ $admin->name }}!</h3>
                <p style="margin: 0; opacity: 0.9;">Here's what's happening with your system today.</p>
            </div>

            <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
                <div class="stat-card" style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #007bff;">
                    <h4 style="margin: 0 0 0.5rem 0; color: #333;">Total Users</h4>
                    <p style="font-size: 2rem; font-weight: bold; color: #007bff; margin: 0;">{{ number_format($totalUsers) }}</p>
                </div>
                <div class="stat-card" style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #28a745;">
                    <h4 style="margin: 0 0 0.5rem 0; color: #333;">Active Tasks</h4>
                    <p style="font-size: 2rem; font-weight: bold; color: #28a745; margin: 0;">{{ number_format($incompleteTasks) }}</p>
                </div>
                <div class="stat-card" style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #ffc107;">
                    <h4 style="margin: 0 0 0.5rem 0; color: #333;">Pending Reviews</h4>
                    <p style="font-size: 2rem; font-weight: bold; color: #ffc107; margin: 0;">{{ number_format($pendingReviews) }}</p>
                </div>
                <div class="stat-card" style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #17a2b8;">
                    <h4 style="margin: 0 0 0.5rem 0; color: #333;">Total Salary Expenses</h4>
                    <p style="font-size: 2rem; font-weight: bold; color: #17a2b8; margin: 0;">{{ number_format($totalSalaryExpenses, 2) }}</p>
                </div>
                {{-- <div class="stat-card" style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #dc3545;">
                    <h4 style="margin: 0 0 0.5rem 0; color: #333;">System Alerts</h4>
                    <p style="font-size: 2rem; font-weight: bold; color: #dc3545; margin: 0;">{{ number_format($systemAlerts) }}</p>
                </div> --}}
            </div>

            <div class="task-assignment-section" style="background: white; padding: 1rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-top: 2rem;">
                <h4 style="color: #333; margin-bottom: 1rem;">Task Assignments</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Task Name</th>
                            <th>Assigned To</th>
                            <th>Assignment Type</th>
                            <th>Team Created By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                        <tr>
                            <td>{{ $task->task_name }}</td>
                            <td>
                                @if($task->assigned_team === 'Individual' && $task->assignedEmployee)
                                    {{ $task->assignedEmployee->name }}
                                @elseif($task->assigned_team === 'Team' && $task->teamLead)
                                    {{ $task->teamLead->name }} (Team Lead)
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $task->assigned_team }}</td>
                            <td>{{ ucfirst($task->team_created_by ?? 'Admin') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $tasks->links() }}
            </div>
        </div>

    <div class="col-md-4">
        <div class="profile-section" style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <h4 style="color: #333; margin-bottom: 1rem; border-bottom: 2px solid #dc3545; padding-bottom: 0.5rem;">Profile Information</h4>

            @if(session('success'))
                <div style="background: #d4edda; color: #155724; padding: 0.75rem; border-radius: 4px; margin-bottom: 1rem; border: 1px solid #c3e6cb; font-size: 0.9rem;">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div style="background: #f8d7da; color: #721c24; padding: 0.75rem; border-radius: 4px; margin-bottom: 1rem; border: 1px solid #f5c6cb; font-size: 0.9rem;">
                    <ul style="margin: 0; padding-left: 1rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="profile-info">
                <div style="display: flex; align-items: center; margin-bottom: 1rem;">
                    <div style="width: 50px; height: 50px; border-radius: 50%; margin-right: 1rem; overflow: hidden;">
                        @if($admin->profile_image)
                            <img src="{{ asset('storage/profile_images/' . $admin->profile_image) }}" alt="Profile Image" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 1.2rem;">
                                {{ strtoupper(substr($admin->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div>
                        <h5 style="margin: 0; color: #333;">{{ $admin->name }}</h5>
                        <p style="margin: 0; color: #666; font-size: 0.9rem;">Administrator</p>
                    </div>
                </div>
                <ul style="list-style: none; padding: 0; margin-bottom: 1rem;">
                    <li style="padding: 0.5rem 0; border-bottom: 1px solid #eee;">
                        <span style="font-weight: bold; color: #555;">Email:</span> {{ $admin->email }}
                    </li>
                    <li style="padding: 0.5rem 0; border-bottom: 1px solid #eee;">
                        <span style="font-weight: bold; color: #555;">Phone:</span> {{ $admin->phone ?? 'Not set' }}
                    </li>
                    <li style="padding: 0.5rem 0; border-bottom: 1px solid #eee;">
                        <span style="font-weight: bold; color: #555;">Bio:</span> {{ $admin->bio ?? 'Not set' }}
                    </li>
                    <li style="padding: 0.5rem 0;">
                        <span style="font-weight: bold; color: #555;">Last Login:</span> {{ now()->format('M d, Y H:i') }}
                    </li>
                </ul>
{{-- 
                <button onclick="toggleProfileForm()" style="background: #007bff; color: white; border: none; padding: 0.5rem 1rem; border-radius: 4px; cursor: pointer; font-size: 0.9rem; width: 100%; margin-bottom: 1rem;">
                    Update Profile
                </button> --}}

                <div id="profileForm" style="display: none;">
                    <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div style="margin-bottom: 1rem;">
                            <label for="name" style="display: block; margin-bottom: 0.25rem; color: #333; font-weight: 500; font-size: 0.9rem;">Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $admin->name) }}" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px; font-size: 0.9rem;">
                        </div>

                        <div style="margin-bottom: 1rem;">
                            <label for="email" style="display: block; margin-bottom: 0.25rem; color: #333; font-weight: 500; font-size: 0.9rem;">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $admin->email) }}" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px; font-size: 0.9rem;">
                        </div>

                        <div style="margin-bottom: 1rem;">
                            <label for="phone" style="display: block; margin-bottom: 0.25rem; color: #333; font-weight: 500; font-size: 0.9rem;">Phone</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone', $admin->phone ?? '') }}"
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px; font-size: 0.9rem;">
                        </div>

                        <div style="margin-bottom: 1rem;">
                            <label for="bio" style="display: block; margin-bottom: 0.25rem; color: #333; font-weight: 500; font-size: 0.9rem;">Bio</label>
                            <textarea id="bio" name="bio" rows="3" style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px; font-size: 0.9rem; resize: vertical;">{{ old('bio', $admin->bio ?? '') }}</textarea>
                        </div>

                        <div style="margin-bottom: 1rem;">
                            <label for="profile_image" style="display: block; margin-bottom: 0.25rem; color: #333; font-weight: 500; font-size: 0.9rem;">Profile Image</label>
                            <input type="file" id="profile_image" name="profile_image" accept="image/*"
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px; font-size: 0.9rem;">
                        </div>

                        <div style="display: flex; gap: 0.5rem;">
                            <button type="submit" style="background: #28a745; color: white; border: none; padding: 0.5rem 1rem; border-radius: 4px; cursor: pointer; font-size: 0.9rem; flex: 1;">
                                Save Changes
                            </button>
                            <button type="button" onclick="toggleProfileForm()" style="background: #6c757d; color: white; border: none; padding: 0.5rem 1rem; border-radius: 4px; cursor: pointer; font-size: 0.9rem; flex: 1;">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="quick-actions" style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-top: 1rem;">
            <h4 style="color: #333; margin-bottom: 1rem;">Quick Actions</h4>
            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                <a href="{{ route('employees.create') }}" style="background: #007bff; color: white; border: none; padding: 0.5rem 1rem; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block;">Add New User</a>
                <a href="{{ route('tasks.create') }}" style="background: #28a745; color: white; border: none; padding: 0.5rem 1rem; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block;">Create Task</a>
                <a href="{{ route('admin.reports.index') }}" style="background: #ffc107; color: white; border: none; padding: 0.5rem 1rem; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block;">View Reports</a>
            </div>
        </div>
    </div>
</div>

<div class="recent-employees" style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-top: 2rem;">
    <h4 style="color: #333; margin-bottom: 1rem;">Recent Employees</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Employee Code</th>
                <th>Position</th>
                <th>Email</th>
                <th>Status</th>
                <th>Salary</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentEmployees as $employee)
            <tr>
                <td>{{ $employee->name }}</td>
                <td>{{ $employee->employee_code }}</td>
                <td>{{ $employee->position }}</td>
                <td>{{ $employee->email }}</td>
                <td>{{ ucfirst($employee->status) }}</td>
                <td>
                    ₹{{ number_format(($employee->basic_salary ?? 0) + ($employee->hra ?? 0) + ($employee->conveyance ?? 0) + ($employee->medical ?? 0), 2) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
function toggleProfileForm() {
    const form = document.getElementById('profileForm');
    if (form.style.display === 'none' || form.style.display === '') {
        form.style.display = 'block';
    } else {
        form.style.display = 'none';
    }
}
</script>
@endsection
