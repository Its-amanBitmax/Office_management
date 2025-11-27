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
           z-index: 1005;
            display: flex;
            justify-content: space-between;
            align-items: center;
            opacity: 0.9;
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
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            background: white;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            padding: 1rem 0;
            overflow-y: auto;
            z-index: 1006;
            transform: translateX(0);
            transition: transform 0.3s ease;
            /* Hide scrollbar for WebKit browsers (Chrome, Safari) */
            scrollbar-width: none; /* Firefox */
        }

        .sidebar.hidden {
            transform: translateX(-250px);
        }

        .sidebar::-webkit-scrollbar {
            display: none; /* Chrome, Safari */
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

        .sidebar-header {
           
            text-align: center;
            border-bottom: 1px solid #e9ecef;
            background: white;
        }

        .sidebar-header img {
            height: 60px;
            object-fit: contain;
            padding-bottom: 0.5rem;
          
        }

        .sidebar-header h2 {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
            margin: 0;
        }

        .header-toggle {
            background: none;
            border: none;
            color: #666;
            font-size: 0.8rem;
            cursor: pointer;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            margin-top: 0.5rem;
        }

        .header-toggle:hover {
            background-color: #f8f9fa;
        }


        .main-content {
            margin-left: 260px;
            margin-top: 70px;
            margin-bottom: 0;
            padding: 2rem;
            min-height: calc(100vh - 70px);
        }

        .sidebar.hidden ~ .main-content {
            margin-left: 0;
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
            .menu-toggle {
                display: block;
            }

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

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: margin-left 0.3s ease;
        }

        .header-left.sidebar-shown {
            margin-left: 250px;
        }

        .search-container {
            position: relative;
            flex: 1;
            max-width: 400px;
        }

        .search-input {
            width: 100%;
            padding: 0.5rem 2.5rem 0.5rem 1rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 0.9rem;
            outline: none;
            transition: all 0.3s ease;
            margin-right: 100px
        }

        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .search-input:focus {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.1);
        }

        .search-icon {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        .search-results {
            position: absolute;
            top: calc(100% + 5px);
            left: 0;
            right: 0;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            max-height: 300px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
            border: 1px solid #e0e0e0;
        }

        .search-result-item {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .search-result-item:hover {
            background-color: #f8f9fa;
        }

        .search-result-item:last-child {
            border-bottom: none;
        }

        .result-content {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .result-icon {
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .result-text {
            flex: 1;
            min-width: 0;
        }

        .result-name {
            font-weight: 500;
            color: #333;
            margin-bottom: 0.25rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .result-module {
            font-size: 0.8rem;
            color: #666;
            text-transform: uppercase;
        }

        .company-name {
            color: white;
            font-weight: 600;
            font-size: 1.8rem;
        }

        .menu-toggle {
            display: block;
            background: none;
            border: none;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;

        }

        /* Chat Bot Icon Styles */
        .chatbot-icon {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            background-color: #007bff;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            z-index: 1001;
            transition: background-color 0.3s ease;
        }

        .chatbot-icon:hover {
            background-color: #0056b3;
        }

        /* Chat Modal Styles */
        .chat-modal {
            display: none;
            position: fixed;
            bottom: 90px;
            right: 20px;
            width: 350px;
            height: 450px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            z-index: 1002;
            overflow: hidden;
        }

        .chat-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 15px;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chat-body {
            height: 320px;
            overflow-y: auto;
            padding: 12px;
            background: #f8f9fa;
        }

        .chat-message {
            margin-bottom: 12px;
            padding: 8px 12px;
            border-radius: 8px;
            max-width: 85%;
            font-size: 14px;
        }

        .chat-message.user {
            background: #007bff;
            color: white;
            margin-left: auto;
            text-align: right;
        }

        .chat-message.bot {
            background: white;
            color: #333;
            border: 1px solid #ddd;
        }

        .chat-footer {
            padding: 10px 12px;
            border-top: 1px solid #ddd;
            display: flex;
            gap: 8px;
            background: white;
        }

        .chat-input {
            flex: 1;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            outline: none;
        }

        .chat-input:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 2px rgba(255,255,255,0.1);
        }

        .chat-send {
            background: #007bff;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .chat-send:hover {
            background: #0056b3;
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
    <div class="header-left sidebar-shown">
        <button class="menu-toggle" onclick="toggleSidebar()">☰</button>
        <span class="company-name">
            {{ auth('admin')->user()->company_name ?? 'Admin Panel' }}
        </span>
    </div>

    <div class="user-info">

        {{-- 🔍 SEARCH --}}
        <div class="search-container">
            <input type="text" class="search-input"
                   placeholder="Search employees, tasks, admins, visitors..."
                   id="global-search">
            <i class="fas fa-search search-icon"></i>
            <div class="search-results" id="search-results"></div>
        </div>

        {{-- 🔔 NOTIFICATION ICON (ALL ADMINS) --}}
        <div class="notification-icon"
             onclick="toggleAdminNotificationDropdown()"
             style="position: relative; margin: 0 1rem; cursor: pointer;">

            <i class="fas fa-bell"
               style="font-size:1.4rem; color:white; opacity:0.85;"></i>

            <span id="admin-notification-count"
                  style="display:none;
                         position:absolute; top:-4px; right:-4px;
                         background:#dc3545; color:white;
                         border-radius:50%; font-size:0.7rem;
                         padding:2px 6px; font-weight:bold;">
            </span>

            <div id="admin-notification-dropdown"
                 style="display:none; position:absolute; right:0; top:36px;
                        background:white; color:#333; min-width:320px;
                        box-shadow:0 2px 8px rgba(0,0,0,0.15);
                        border-radius:6px; z-index:2001;">
            </div>
        </div>

        {{-- 👤 PROFILE --}}
        <div class="profile-avatar" onclick="openProfileModal()">
            @if(auth('admin')->user()->profile_image)
                <img src="{{ asset('storage/profile_images/' . auth('admin')->user()->profile_image) }}">
            @else
                <div class="avatar-placeholder">
                    {{ strtoupper(substr(auth('admin')->user()->name,0,1)) }}
                </div>
            @endif
        </div>

        {{-- 🚪 LOGOUT --}}
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
            </button>
        </form>
    </div>
    <audio id="notificationSound" preload="auto">
    <source src="{{ asset('sound/notification.mp3') }}" type="audio/mpeg">
</audio>

</header>

<script>
let lastUnreadCount = 0;
let canPlaySound = false;

/* ✅ Browser sound unlock */
document.addEventListener('click', () => {
    canPlaySound = true;
}, { once: true });

function playNotificationSound() {
    if (!canPlaySound) return;

    const audio = document.getElementById('notificationSound');
    if (!audio) return;

    audio.currentTime = 0;
    audio.play().catch(() => {});
}

/* ✅ Dropdown toggle */
function toggleAdminNotificationDropdown() {
    const el = document.getElementById('admin-notification-dropdown');
    el.style.display = el.style.display === 'block' ? 'none' : 'block';
}

/* ✅ Fetch notifications */
function fetchAdminNotifications() {

    fetch("{{ route('admin.notifications.ajax') }}")
        .then(res => res.json())
        .then(data => {

            const countEl = document.getElementById('admin-notification-count');
            const dropdown = document.getElementById('admin-notification-dropdown');

            /* 🔔 SOUND ONLY WHEN COUNT INCREASES */
            if (data.unread_count > lastUnreadCount) {
                playNotificationSound();
            }
            lastUnreadCount = data.unread_count;

            /* ✅ Counter update */
            if (data.unread_count > 0) {
                countEl.innerText = data.unread_count;
                countEl.style.display = 'inline-block';
            } else {
                countEl.style.display = 'none';
            }

            dropdown.innerHTML = '';

            if (data.notifications.length === 0) {
                dropdown.innerHTML = `
                    <div style="padding:10px;text-align:center;">
                        No notifications
                    </div>`;
                return;
            }

            data.notifications.forEach(n => {
                dropdown.insertAdjacentHTML('beforeend', `
                    <div class="notification-item"
                         style="padding:10px;border-bottom:1px solid #eee;
                                background:#f8f9fa;cursor:pointer;"
                         onclick="markAdminNotificationRead(${n.id}, this)">
                        <strong>${n.title}</strong><br>
                        <span style="font-size:0.9em;">${n.message}</span>
                        <div style="font-size:0.8em;color:#888;">
                            ${new Date(n.created_at).toLocaleString()}
                        </div>
                    </div>
                `);
            });

            dropdown.insertAdjacentHTML('beforeend', `
                <div style="text-align:center;padding:8px;">
                    <a href="{{ route('admin.notifications.index') }}"
                       style="font-size:0.95em;color:#007bff;">
                        View All Notifications
                    </a>
                </div>
            `);
        });
}

/* ✅ Mark as read */
function markAdminNotificationRead(id, el) {
    fetch(`/admin/notifications/read/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    }).then(() => {
        el.remove();
        fetchAdminNotifications();
    });
}

/* ✅ Auto polling */
fetchAdminNotifications();
setInterval(fetchAdminNotifications, 5000);

/* ✅ Close dropdown */
document.addEventListener('click', function(e) {
    const bell = document.querySelector('.notification-icon');
    const dropdown = document.getElementById('admin-notification-dropdown');
    if (dropdown && bell && !bell.contains(e.target)) {
        dropdown.style.display = 'none';
    }
});
</script>
   <!-- Sidebar -->
    <aside class="sidebar show" id="sidebar">
        <div class="sidebar-header">
            @if(auth('admin')->user() && auth('admin')->user()->company_logo)
                <img src="{{ asset('storage/company_logos/' . auth('admin')->user()->company_logo) }}" alt="Company Logo">
            @endif
          
        </div>
        <nav>
            <ul class="sidebar-menu">
                @php
                    $admin = auth('admin')->user();
                    $accessibleModules = $admin ? $admin->getAccessibleModules() : [];
                @endphp

                @if($admin && $admin->hasPermission('Dashboard'))
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i>📊</i> Dashboard
                    </a>
                </li>
                @endif

                @if($admin && $admin->hasPermission('employees'))
                <li>
                    <a href="{{ route('employees.index') }}" class="{{ request()->routeIs('employees.*') ? 'active' : '' }}">
                        <i>👥</i> Employees
                    </a>
                </li>
                @endif

                @if($admin && $admin->hasAnyPermission(['attendance', 'salary-slips', 'Employee Card', 'expenses']))
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" id="hrm-dropdown-toggle" onclick="toggleDropdown('hrm')" aria-expanded="false">
                        <i>👨‍💼</i> HRM
                    </a>
                    <ul class="dropdown-menu" id="hrm-dropdown-menu">
                        @if($admin->hasPermission('attendance'))
                        <li><a class="dropdown-item" href="{{ route('attendance.index') }}"><i>⏰</i> Attendance</a></li>
                        @endif
                        @if($admin->hasPermission('leave-requests'))
                        <li><a class="dropdown-item" href="{{ route('admin.leave-requests.index') }}"><i>📝</i> Leave Requests</a></li>
                        @endif
                        @if($admin->hasPermission('salary-slips'))
                        <li><a class="dropdown-item" href="{{ route('salary-slips.index') }}"><i>💰</i> Salary Slips</a></li>
                        @endif
                        @if($admin->hasPermission('Employee Card'))
                        <li><a class="dropdown-item" href="{{ route('employee.card.index') }}"><i>🪪</i> Employee Card</a></li>
                        @endif
                        @if($admin->hasPermission('expenses'))
                        <li><a class="dropdown-item" href="{{ route('admin.expenses.index') }}"><i>💸</i> Expenses</a></li>
                        @endif
                        @if($admin->hasPermission('interviews'))
                        <li><a class="dropdown-item" href="{{ route('admin.interviews.index') }}"><i>👥</i> Interviews</a></li>
                        @endif
                   </ul>
                </li>
                @endif

                @if($admin && $admin->hasAnyPermission(['invited-visitors', 'visitors', 'stock', 'Assigned Items']))
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" id="front-desk-dropdown-toggle" onclick="toggleDropdown('front-desk')" aria-expanded="false">
                        <i>🏢</i> Front Desk
                    </a>
                    <ul class="dropdown-menu" id="front-desk-dropdown-menu">
                        @if($admin->hasPermission('invited-visitors'))
                        <li><a class="dropdown-item" href="{{ route('invited-visitors.index') }}"><i>📧</i> Visitor Invites</a></li>
                        @endif
                        @if($admin->hasPermission('visitors'))
                        <li><a class="dropdown-item" href="{{ route('visitors.index') }}"><i>👤</i> Visitor</a></li>
                        @endif
                        @if($admin->hasPermission('stock'))
                        <li><a class="dropdown-item" href="{{ route('admin.stock.index') }}"><i>📦</i> Stock Management</a></li>
                        @endif
                        @if($admin->hasPermission('Assigned Items'))
                        <li><a class="dropdown-item" href="{{ route('admin.stock.all-assigned') }}"><i>📋</i> Assign Items</a></li>
                        @endif
                    </ul>
                </li>
                @endif

                @if($admin && $admin->hasPermission('tasks'))
                <li>
                    <a href="{{ route('tasks.index') }}" class="{{ request()->routeIs('tasks.*') ? 'active' : '' }}">
                        <i>📋</i> Tasks
                    </a>
                </li>
                @endif

                @if($admin && $admin->hasPermission('activities'))
                <li>
                    <a href="{{ route('activities.index') }}" class="{{ request()->routeIs('activities.*') ? 'active' : '' }}">
                        <i>📅</i> Activities
                    </a>
                </li>
                @endif

                @if($admin && $admin->hasPermission('reports'))
                <li>
                    <a href="{{ route('admin.reports.index') }}" class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                        <i>📈</i> Reports
                    </a>
                </li>
                @endif

                @if($admin && $admin->hasPermission('performance'))
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" id="performance-dropdown-toggle" onclick="toggleDropdown('performance')" aria-expanded="false">
                        <i>📊</i> Performance
                    </a>
                    <ul class="dropdown-menu" id="performance-dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('admin.performance') }}"><i>📊</i> Performance Overview</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.evaluation-report') }}"><i>📈</i> Evaluation report</a></li>
                    </ul>
                </li>
                @endif

                @if($admin && $admin->hasPermission('settings'))
                <li>
                    <a href="{{ route('admin.profile') }}" class="{{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                        <i>⚙️</i> Settings
                    </a>
                </li>
                @endif

                 @if($admin && $admin->role === 'super_admin')
                <li>
                    <a href="{{ route('admin.sub-admins.index') }}" class="{{ request()->routeIs('admin.sub-admins.*') ? 'active' : '' }}">
                        <i>👤</i> Sub Admins
                    </a>
                </li>
                @endif

                @if($admin && $admin->hasPermission('logs'))
                <li>
                    <a href="{{ route('admin.logs') }}" class="{{ request()->routeIs('admin.logs') ? 'active' : '' }}">
                        <i>📝</i> Logs
                    </a>
                </li>
                @endif

               
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
            const dropdowns = ['hrm','front-desk','performance'];

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
            const toggle = document.querySelector('.header-left');
            sidebar.classList.toggle('hidden');
            toggle.classList.toggle('sidebar-shown');
        }



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
            const profileModal = document.getElementById('profileModal');
            const chatModal = document.getElementById('chatModal');

            if (event.target == profileModal) {
                closeProfileModal();
            } else if (event.target == chatModal) {
                closeChatBot();
            }
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeProfileModal();
                closeChatBot();
            }
        });

        // Initialize dropdowns when page loads
        document.addEventListener('DOMContentLoaded', function() {
            initializeDropdowns();
        });

        // Chat Bot Functions
        function openChatBot() {
            const chatModal = document.getElementById('chatModal');
            chatModal.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function closeChatBot() {
            const chatModal = document.getElementById('chatModal');
            chatModal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        function sendMessage() {
            const input = document.getElementById('chatInput');
            const message = input.value.trim();
            if (message) {
                addMessage('user', message);
                input.value = '';

                // Simulate bot response
                setTimeout(() => {
                    addMessage('bot', 'Thanks for your message! This is a demo chat bot. How can I help you today?');
                }, 1000);
            }
        }

        function addMessage(type, message) {
            const chatBody = document.getElementById('chatBody');
            const messageDiv = document.createElement('div');
            messageDiv.className = `chat-message ${type}`;
            messageDiv.textContent = message;
            chatBody.appendChild(messageDiv);
            chatBody.scrollTop = chatBody.scrollHeight;
        }

        // Handle Enter key in chat input
        document.addEventListener('DOMContentLoaded', function() {
            const chatInput = document.getElementById('chatInput');
            if (chatInput) {
                chatInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        sendMessage();
                    }
                });
            }
        });

        // Global Search Functionality
        let searchTimeout;
        const searchInput = document.getElementById('global-search');
        const searchResults = document.getElementById('search-results');

        searchInput.addEventListener('keyup', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();
            if (query.length < 2) {
                searchResults.style.display = 'none';
                return;
            }
            searchTimeout = setTimeout(() => {
                fetch(`{{ route('admin.search') }}?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        displaySearchResults(data);
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                    });
            }, 300);
        });

        function displaySearchResults(results) {
            searchResults.innerHTML = '';
            if (results.length === 0) {
                searchResults.style.display = 'none';
                return;
            }
            const moduleIcons = {
                'Employee': '👥',
                'Task': '📋',
                'Sub Admin': '👤',
                'Visitor': '👤',
                'Invited Visitor': '📧'
            };
            results.forEach(result => {
                const item = document.createElement('div');
                item.className = 'search-result-item';
                const icon = moduleIcons[result.module] || '📄';
                item.innerHTML = `
                    <div class="result-content">
                        <span class="result-icon">${icon}</span>
                        <div class="result-text">
                            <div class="result-name">${result.name}</div>
                            <div class="result-module">${result.module}</div>
                        </div>
                    </div>
                `;
                item.addEventListener('click', () => {
                    window.location.href = result.url;
                });
                searchResults.appendChild(item);
            });
            searchResults.style.display = 'block';
        }

        // Hide search results when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.style.display = 'none';
            }
        });
    </script>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/68d43430ae823e19250b7c93/1j5uenoav';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
   
</body>
</html>
