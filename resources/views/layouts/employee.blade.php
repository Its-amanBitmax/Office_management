<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'Employee Dashboard') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous" />

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-name {
            font-weight: 500;
        }

        .profile-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid rgba(255, 255, 255, 0.3);
            transition: border-color 0.3s ease;
            overflow: hidden;
        }

        .profile-avatar:hover {
            border-color: rgba(255, 255, 255, 0.8);
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-avatar .avatar-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .logout-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        .logout-btn:hover {
            background: #c82333;
            color: white;
            text-decoration: none;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.3s ease;
        }

        .modal-content {
            background-color: white;
            margin: 5% auto;
            padding: 0;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            animation: slideIn 0.3s ease;
        }

        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 8px 8px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            margin: 0;
            font-size: 1.3rem;
            font-weight: 600;
        }

        .modal-close {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s ease;
        }

        .modal-close:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .modal-body {
            padding: 1.5rem;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideIn {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .sidebar {
            position: fixed;
            top: 70px;
            left: 0;
            width: 250px;
            height: calc(100vh - 70px);
            background: white;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            padding: 1rem 0;
            overflow-y: auto;
            z-index: 999;
        }

        .sidebar-menu {
            list-style: none;
        }

        .sidebar-menu li {
            margin: 0.5rem 0;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 0.75rem 2rem;
            color: #666;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background-color: #f8f9fa;
            color: #007bff;
            border-left-color: #007bff;
        }

        .sidebar-menu a i {
            margin-right: 0.75rem;
            width: 20px;
            text-align: center;
        }

        .main-content {
            margin-left: 250px;
            margin-top: 70px;
            padding: 2rem;
            min-height: calc(100vh - 70px);
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .menu-toggle {
                display: block;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        @php $admin = \App\Models\Admin::first(); @endphp
        <div style="display: flex; align-items: center; gap: 1rem;">
            <button class="menu-toggle" onclick="toggleSidebar()">☰</button>
            @if($admin && $admin->company_logo)
                <img src="{{ asset('storage/company_logos/' . $admin->company_logo) }}" alt="Company Logo" style="height: 40px; border-radius: 4px; object-fit: contain;">
            @endif
            <h1>{{ $admin->company_name ?? 'Employee Panel' }}</h1>
        </div>
        <div class="user-info">
            <span class="user-name">Welcome, {{ auth('employee')->user()->name ?? 'Employee' }}👋</span>
            <div class="profile-avatar" onclick="openProfileModal()">
                @if(auth('employee')->user() && auth('employee')->user()->profile_image)
                    <img src="{{ asset('storage/' . auth('employee')->user()->profile_image) }}" alt="Profile Image">
                @else
                    <div class="avatar-placeholder">
                        {{ auth('employee')->user() ? strtoupper(substr(auth('employee')->user()->name, 0, 1)) : 'E' }}
                    </div>
                @endif
            </div>
            <form method="POST" action="{{ route('employee.logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
        </div>
    </header>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('employee.dashboard') }}" class="{{ request()->routeIs('employee.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('employee.tasks') }}" class="{{ request()->routeIs('employee.tasks*') ? 'active' : '' }}">
                    <i class="fas fa-tasks"></i> Tasks
                </a>
            </li>
            <li>
                <a href="{{ route('employee.activities.index') }}" class="{{ request()->routeIs('employee.activities.index') ? 'active' : '' }}">
                    <i class="fas fa-list"></i> Activities
                </a>
            </li>
            <li>
                <a href="{{ route('employee.reports') }}" class="{{ request()->routeIs('employee.reports*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i> Reports
                </a>
            </li>
            @if(auth('employee')->user() && auth('employee')->user()->teamLeadedTasks()->exists())
            <li>
                <a href="{{ route('employee.team.management') }}" class="{{ request()->routeIs('employee.team.management') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Team Management
                </a>
            </li>

            @endif
            <li>
                <a href="{{ route('employee.profile') }}" class="{{ request()->routeIs('employee.profile') ? 'active' : '' }}">
                    <i class="fas fa-user"></i> Profile
                </a>
            </li>
            <li>
                <a href="#" onclick="openProfileModal()">
                    <i class="fas fa-cog"></i> Settings
                </a>
            </li>
        </ul>
    </aside>

    <main class="main-content">
        @yield('content')
    </main>

    <!-- Bootstrap 5 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

    <!-- Profile Update Modal -->
    <div id="profileModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Update Profile</h3>
                <button class="modal-close" onclick="closeProfileModal()">&times;</button>
            </div>
            <div class="modal-body">
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

                <form method="POST" action="{{ route('employee.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div style="margin-bottom: 1rem;">
                        <label for="modal-name" style="display: block; margin-bottom: 0.25rem; color: #333; font-weight: 500; font-size: 0.9rem;">Name</label>
                        <input type="text" id="modal-name" name="name" value="{{ old('name', auth('employee')->user()->name ?? '') }}" required
                               style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px; font-size: 0.9rem;">
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label for="modal-email" style="display: block; margin-bottom: 0.25rem; color: #333; font-weight: 500; font-size: 0.9rem;">Email</label>
                        <input type="email" id="modal-email" name="email" value="{{ old('email', auth('employee')->user()->email ?? '') }}" required
                               style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px; font-size: 0.9rem;">
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label for="modal-phone" style="display: block; margin-bottom: 0.25rem; color: #333; font-weight: 500; font-size: 0.9rem;">Phone</label>
                        <input type="tel" id="modal-phone" name="phone" value="{{ old('phone', auth('employee')->user()->phone ?? '') }}"
                               style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px; font-size: 0.9rem;">
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label for="modal-profile_image" style="display: block; margin-bottom: 0.25rem; color: #333; font-weight: 500; font-size: 0.9rem;">Profile Image</label>
                        <input type="file" id="modal-profile_image" name="profile_image" accept="image/*"
                               style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px; font-size: 0.9rem;">
                    </div>

                    <div style="display: flex; gap: 0.5rem;">
                        <button type="submit" style="background: #28a745; color: white; border: none; padding: 0.5rem 1rem; border-radius: 4px; cursor: pointer; font-size: 0.9rem; flex: 1;">
                            Save Changes
                        </button>
                        <button type="button" onclick="closeProfileModal()" style="background: #6c757d; color: white; border: none; padding: 0.5rem 1rem; border-radius: 4px; cursor: pointer; font-size: 0.9rem; flex: 1;">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openProfileModal() {
            const modal = document.getElementById('profileModal');
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function closeProfileModal() {
            const modal = document.getElementById('profileModal');
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('profileModal');
            if (event.target == modal) {
                closeProfileModal();
            }
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeProfileModal();
            }
        });
    </script>
</body>
</html>
