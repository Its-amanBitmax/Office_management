<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" 
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    @stack('styles')

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            overflow-x: hidden;
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
        }

        .header .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header .user-name {
            font-weight: 500;
        }

        .header .profile-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid rgba(255, 255, 255, 0.3);
            transition: border-color 0.3s ease;
            overflow: hidden;
        }

        .header .profile-avatar:hover {
            border-color: rgba(255, 255, 255, 0.8);
        }

        .header .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .header .profile-avatar .avatar-placeholder {
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

        /* Dropdown menu styling to match sidebar */
        .sidebar-menu .dropdown-menu {
            position: static;
            background: #f8f9fa;
            border: none;
            border-radius: 0;
            box-shadow: none;
            padding: 0;
            margin: 0;
            width: 100%;
            display: none;
        }

        .sidebar-menu .dropdown-menu.show {
            display: block;
        }

        .sidebar-menu .dropdown-item {
            display: flex;
            align-items: center;
            padding: 0.5rem 2rem 0.5rem 3.5rem;
            color: #666;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            font-size: 0.9rem;
        }

        .sidebar-menu .dropdown-item:hover,
        .sidebar-menu .dropdown-item.active {
            background-color: #e9ecef;
            color: #007bff;
            border-left-color: #007bff;
        }

        .sidebar-menu .dropdown-item i {
            margin-right: 0.75rem;
            width: 20px;
            text-align: center;
            font-size: 0.8rem;
        }

        .sidebar-menu .dropdown-toggle::after {
            content: "▼";
            margin-left: auto;
            font-size: 0.7rem;
            transition: transform 0.3s ease;
        }

        .sidebar-menu .dropdown-toggle[aria-expanded="true"]::after {
            transform: rotate(180deg);
        }

        .main-content {
            margin-left: 250px;
            margin-top: 70px;
            padding: 2rem;
            min-height: calc(100vh - 70px);
        }

        .content-wrapper {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .page-header {
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f8f9fa;
        }

        .page-header h2 {
            color: #333;
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .page-header p {
            color: #666;
            font-size: 1rem;
        }

        .footer {
            background: white;
            padding: 1rem 2rem;
            border-top: 1px solid #e9ecef;
            text-align: center;
            color: #666;
            font-size: 0.9rem;
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
        }

        .logout-btn:hover {
            background: #c82333;
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

            .header {
                padding: 1rem;
            }

            .header h1 {
                font-size: 1.2rem;
            }
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
            .menu-toggle {
                display: block;
            }
        }
    </style>
</head>
<body>

    <!-- Bootstrap 5 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Header -->
    <header class="header">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <button class="menu-toggle" onclick="toggleSidebar()">☰</button>
            @if(auth('admin')->user() && auth('admin')->user()->company_logo)
                <img src="{{ asset('storage/company_logos/' . auth('admin')->user()->company_logo) }}" alt="Company Logo" style="height: 40px; border-radius: 4px; object-fit: contain;">
            @endif
            <h1>{{ auth('admin')->user()->company_name ?? 'Admin Panel' }}</h1>
        </div>
        <div class="user-info">
            <span class="user-name">Welcome, {{ auth('admin')->user()->name ?? 'Admin' }}👋</span>
            <div class="profile-avatar" onclick="openProfileModal()">
                @if(auth('admin')->user() && auth('admin')->user()->company_logo)
                    <img src="{{ asset('storage/company_logos/' . auth('admin')->user()->company_logo) }}" alt="Company Logo" style="width: 40px; height: 40px; border-radius: 4px; object-fit: cover; margin-right: 0.5rem;">
                @elseif(auth('admin')->user() && auth('admin')->user()->profile_image)
                    <img src="{{ asset('storage/profile_images/' . auth('admin')->user()->profile_image) }}" alt="Profile Image">
                @else
                    <div class="avatar-placeholder">
                        {{ auth('admin')->user() ? strtoupper(substr(auth('admin')->user()->name, 0, 1)) : 'A' }}
                    </div>
                @endif
            </div>
            <form method="POST" action="{{ route('admin.logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="logout-btn"> <i class="fas fa-sign-out-alt"></i></button>
            </form>
        </div>
    </header>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <nav>
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i>📊</i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('employees.index') }}" class="{{ request()->routeIs('employees.*') ? 'active' : '' }}">
                        <i>👥</i> Employees
                    </a>
                </li>
               <li class="dropdown">
                    <a href="#" class="dropdown-toggle" id="hrm-dropdown-toggle" onclick="toggleDropdown('hrm')" aria-expanded="false">
                        <i>👨‍💼</i> HRM
                    </a>
                    <ul class="dropdown-menu" id="hrm-dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('attendance.index') }}"><i>⏰</i> Attendance</a></li>
                        <li><a class="dropdown-item" href="{{ route('salary-slips.index') }}"><i>💰</i> Salary Slips</a></li>
                        <li><a class="dropdown-item" href="{{ route('employee.card.index') }}"><i>🪪</i> Employee Card</a></li>
                   </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" id="front-desk-dropdown-toggle" onclick="toggleDropdown('front-desk')" aria-expanded="false">
                        <i>🏢</i> Front Desk
                    </a>
                    <ul class="dropdown-menu" id="front-desk-dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('invited-visitors.index') }}"><i>📧</i> Visitor Invites</a></li>
                        <li><a class="dropdown-item" href="{{ route('visitors.index') }}"><i>👤</i> Visitor</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.stock.index') }}"><i>📦</i> Stock Management</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.stock.view.assigned') }}"><i>📋</i> Assign Items</a></li>
                        {{-- <li><a class="dropdown-item" href="{{ route('admin.stock.view.assigned') }}"><i>👁️</i> View Assigned Items</a></li> --}}
                    </ul>
                </li>
                <li>
                    <a href="{{ route('tasks.index') }}" class="{{ request()->routeIs('tasks.*') ? 'active' : '' }}">
                        <i>📋</i> Tasks
                    </a>
                </li>
                <li>
                    <a href="{{ route('activities.index') }}" class="{{ request()->routeIs('activities.*') ? 'active' : '' }}">
                        <i>📅</i> Activities
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.reports.index') }}" class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                        <i>📈</i> Reports
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.performance') }}" class="{{ request()->routeIs('admin.performance') ? 'active' : '' }}">
                        <i>📊</i> Performance
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.profile') }}" class="{{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                        <i>⚙️</i> Settings
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i>📝</i> Logs
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="content-wrapper">
            <div class="page-header">
                <h2>@yield('page-title', 'Dashboard')</h2>
                <p>@yield('page-description', 'Welcome to your admin dashboard')</p>
            </div>

            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
    </footer>

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

                @isset($errors)
                    @if($errors->any())
                        <div style="background: #f8d7da; color: #721c24; padding: 0.75rem; border-radius: 4px; margin-bottom: 1rem; border: 1px solid #f5c6cb; font-size: 0.9rem;">
                            <ul style="margin: 0; padding-left: 1rem;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @endisset

                <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div style="margin-bottom: 1rem;">
                        <label for="modal-name" style="display: block; margin-bottom: 0.25rem; color: #333; font-weight: 500; font-size: 0.9rem;">Name</label>
                        <input type="text" id="modal-name" name="name" value="{{ old('name', auth('admin')->user()->name ?? '') }}" required
                               style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px; font-size: 0.9rem;">
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label for="modal-email" style="display: block; margin-bottom: 0.25rem; color: #333; font-weight: 500; font-size: 0.9rem;">Email</label>
                        <input type="email" id="modal-email" name="email" value="{{ old('email', auth('admin')->user()->email ?? '') }}" required
                               style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px; font-size: 0.9rem;">
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label for="modal-phone" style="display: block; margin-bottom: 0.25rem; color: #333; font-weight: 500; font-size: 0.9rem;">Phone</label>
                        <input type="tel" id="modal-phone" name="phone" value="{{ old('phone', auth('admin')->user()->phone ?? '') }}"
                               style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px; font-size: 0.9rem;">
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label for="modal-bio" style="display: block; margin-bottom: 0.25rem; color: #333; font-weight: 500; font-size: 0.9rem;">Bio</label>
                        <textarea id="modal-bio" name="bio" rows="3" style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px; font-size: 0.9rem; resize: vertical;">{{ old('bio', auth('admin')->user()->bio ?? '') }}</textarea>
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label for="modal-company_name" style="display: block; margin-bottom: 0.25rem; color: #333; font-weight: 500; font-size: 0.9rem;">Company Name</label>
                        <input type="text" id="modal-company_name" name="company_name" value="{{ old('company_name', auth('admin')->user()->company_name ?? '') }}"
                               style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px; font-size: 0.9rem;">
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label for="modal-company_logo" style="display: block; margin-bottom: 0.25rem; color: #333; font-weight: 500; font-size: 0.9rem;">Company Logo</label>
                        <input type="file" id="modal-company_logo" name="company_logo" accept="image/*"
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
        // Dropdown persistence functions
        function toggleDropdown(dropdownId) {
            const toggle = document.getElementById(dropdownId + '-dropdown-toggle');
            const menu = document.getElementById(dropdownId + '-dropdown-menu');

            if (menu.style.display === 'block') {
                menu.style.display = 'none';
                toggle.setAttribute('aria-expanded', 'false');
                localStorage.setItem(dropdownId + '-dropdown-state', 'closed');
            } else {
                menu.style.display = 'block';
                toggle.setAttribute('aria-expanded', 'true');
                localStorage.setItem(dropdownId + '-dropdown-state', 'open');
            }
        }

        // Initialize dropdown states on page load
        function initializeDropdowns() {
            const dropdowns = ['hrm','front-desk'];

            dropdowns.forEach(function(dropdownId) {
                const toggle = document.getElementById(dropdownId + '-dropdown-toggle');
                const menu = document.getElementById(dropdownId + '-dropdown-menu');
                const state = localStorage.getItem(dropdownId + '-dropdown-state');

                if (state === 'open') {
                    menu.style.display = 'block';
                    toggle.setAttribute('aria-expanded', 'true');
                } else {
                    menu.style.display = 'none';
                    toggle.setAttribute('aria-expanded', 'false');
                }
            });
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const menuToggle = document.querySelector('.menu-toggle');

            if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                sidebar.classList.remove('show');
            }
        });

        // Profile Modal Functions
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

        // Initialize dropdowns when page loads
        document.addEventListener('DOMContentLoaded', function() {
            initializeDropdowns();
        });
    </script>
</body>
</html>
