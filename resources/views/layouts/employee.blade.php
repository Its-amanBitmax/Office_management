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
            box-shadow: 0 0 0 2px rgba(0,123,255,0.25);
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


<!--End of Tawk.to Script-->

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

    <!-- Chat Modal -->
    <div id="chatModal" class="chat-modal">
        <div class="chat-header">
            <span>🤖 BotGuru</span>
            <button onclick="closeChatBot()" style="background: none; border: none; color: white; font-size: 18px; cursor: pointer;">&times;</button>
        </div>
        <div id="chatBody" class="chat-body">
            <div class="chat-message bot">
                Hello! I'm your chat assistant. How can I help you today?
            </div>
        </div>
        <div class="chat-footer">
            <input type="text" id="chatInput" class="chat-input" placeholder="Type your message...">
            <button onclick="sendMessage()" class="chat-send">Send</button>
        </div>
    </div>

    <!-- Chat Bot Icon -->
    <div class="chatbot-icon" onclick="openChatBot()">
        <i class="fas fa-comments"></i>
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
</body>
</html>
