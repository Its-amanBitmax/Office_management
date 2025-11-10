<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interview Room - {{ $interview->candidate_name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-light: #6366f1;
            --primary-dark: #3730a3;
            --secondary: #f8fafc;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --gray-900: #0f172a;
            --success: #10b981;
            --warning: #f59e0b;
            --error: #ef4444;
            --border-radius: 12px;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: var(--gray-800);
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: var(--border-radius);
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: var(--shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-left h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 4px;
        }

        .header-left p {
            color: var(--gray-600);
            font-size: 14px;
        }

        .header-right {
            display: flex;
            gap: 12px;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-live {
            background: var(--success);
            color: white;
        }

        .status-waiting {
            background: var(--warning);
            color: white;
        }

        /* Modal Styles */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal-content {
            background: white;
            padding: 24px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            max-width: 500px;
            width: 90%;
            text-align: center;
        }

        .modal-header h3 {
            margin-bottom: 16px;
            color: var(--gray-900);
            font-size: 20px;
            font-weight: 600;
        }

        .modal-body p {
            margin-bottom: 20px;
            color: var(--gray-700);
            font-size: 16px;
        }

        .modal-footer {
            display: flex;
            justify-content: center;
            gap: 12px;
        }

        .permission-modal .modal-content {
            max-width: 600px;
        }

        .permission-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .permission-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 16px;
            border: 2px solid var(--gray-200);
            border-radius: 8px;
            background: var(--gray-50);
            transition: all 0.3s ease;
        }

        .permission-item.requesting {
            border-color: var(--warning);
            background: rgba(245, 158, 11, 0.1);
        }

        .permission-item.granted {
            border-color: var(--success);
            background: rgba(16, 185, 129, 0.1);
        }

        .permission-item.denied {
            border-color: var(--error);
            background: rgba(239, 68, 68, 0.1);
        }

        .permission-icon {
            font-size: 32px;
            margin-bottom: 8px;
            color: var(--gray-400);
        }

        .permission-item.requesting .permission-icon {
            color: var(--warning);
            animation: pulse 1s infinite;
        }

        .permission-item.granted .permission-icon {
            color: var(--success);
        }

        .permission-item.denied .permission-icon {
            color: var(--error);
        }

        .permission-label {
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 4px;
        }

        .permission-status {
            font-size: 12px;
            color: var(--gray-500);
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .btn-secondary {
            background: var(--gray-200);
            color: var(--gray-700);
        }

        .btn-secondary:hover {
            background: var(--gray-300);
        }

        .media-status {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 16px;
        }

        .status-granted {
            background: var(--success);
            color: white;
        }

        .status-denied {
            background: var(--error);
            color: white;
        }

        .status-requesting {
            background: var(--warning);
            color: white;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .time-display {
            background: var(--gray-100);
            color: var(--gray-700);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .main-content {
            display: flex;
            height: calc(100vh - 140px);
        }

        .video-section {
            flex: 0 0 400px;
            overflow: hidden;
        }

        .resizer {
            width: 5px;
            height: 100%;
            background: transparent;
            cursor: col-resize;
            position: relative;
            flex-shrink: 0;
        }

        .resizer:hover {
            background: var(--primary);
        }

        .sidebar {
            flex: 1;
            min-width: 300px;
            overflow-y: auto;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE and Edge */
        }

        .sidebar::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
        }

        .video-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: var(--shadow);
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .video-container {
            flex: 1;
            background: var(--gray-900);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .video-controls-toggle {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(0, 0, 0, 0.5);
            border: none;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            transition: all 0.3s ease;
            z-index: 15;
        }

        .video-controls-toggle:hover {
            background: rgba(0, 0, 0, 0.7);
            transform: scale(1.1);
        }

        .video-controls {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            justify-content: center;
            gap: 16px;
            padding: 12px 20px;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 25px;
            backdrop-filter: blur(5px);
            transition: all 0.3s ease;
            z-index: 15;
        }

        .video-controls.hidden {
            display: none;
        }

        .remote-video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
        }

        .local-video-overlay {
            position: absolute;
            bottom: 20px;
            left: 20px;
            width: 200px;
            height: 150px;
            border-radius: 8px;
            border: 3px solid white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            z-index: 10;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .local-video-overlay:hover {
            transform: scale(1.05);
        }

        .local-video-overlay video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 5px;
        }

        .video-placeholder-full {
            text-align: center;
            color: var(--gray-400);
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .video-placeholder {
            text-align: center;
            color: var(--gray-400);
        }

        .video-placeholder i {
            font-size: 48px;
            margin-bottom: 16px;
            display: block;
        }

        .video-placeholder h3 {
            font-size: 18px;
            margin-bottom: 8px;
        }

        .video-placeholder p {
            font-size: 14px;
        }



        .control-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            transition: all 0.3s ease;
            box-shadow: var(--shadow);
        }

        .control-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-mic { background: var(--success); color: white; }
        .btn-camera { background: var(--primary); color: white; }
        .btn-screen { background: var(--warning); color: white; }
        .btn-end { background: var(--error); color: white; }

        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .panel {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
        }

        .panel-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .panel-header i {
            color: var(--primary);
            font-size: 18px;
        }

        .panel-header h3 {
            font-size: 16px;
            font-weight: 600;
            color: var(--gray-900);
        }

        .panel-content {
            padding: 20px;
        }

        .question-input {
            width: 100%;
            min-height: 100px;
            padding: 12px;
            border: 2px solid var(--gray-200);
            border-radius: 8px;
            font-family: inherit;
            font-size: 14px;
            resize: vertical;
            transition: border-color 0.3s ease;
        }

        .question-input:focus {
            outline: none;
            border-color: var(--primary);
        }

        .btn-send {
            width: 100%;
            padding: 12px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
            margin-top: 12px;
        }

        .btn-send:hover {
            background: var(--primary-dark);
        }

        .questions-list {
            overflow-y: auto;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE and Edge */
        }

        .questions-list::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
        }

        .question-item {
            padding: 12px;
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            margin-bottom: 8px;
            background: var(--gray-50);
        }

        .question-text {
            font-size: 14px;
            color: var(--gray-800);
            margin-bottom: 8px;
        }

        .question-meta {
            font-size: 12px;
            color: var(--gray-500);
        }

        .answer-input {
            width: 100%;
            min-height: 60px;
            padding: 8px;
            border: 2px solid var(--gray-200);
            border-radius: 6px;
            font-family: inherit;
            font-size: 14px;
            resize: vertical;
            transition: border-color 0.3s ease;
            margin-top: 8px;
        }

        .answer-input:focus {
            outline: none;
            border-color: var(--primary);
        }

        .btn-send-answer {
            width: 100%;
            padding: 8px;
            background: var(--success);
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
            margin-top: 8px;
            font-size: 12px;
        }

        .btn-send-answer:hover {
            background: #059669;
        }

        .answer-display {
            margin-top: 8px;
            padding: 8px;
            background: var(--gray-100);
            border-radius: 6px;
            font-size: 14px;
            color: var(--gray-700);
        }

        .candidate-info {
            background: var(--gray-50);
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 16px;
        }

        .candidate-name {
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 4px;
        }

        .candidate-detail {
            font-size: 14px;
            color: var(--gray-600);
            margin-bottom: 2px;
        }

        .connection-status {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-connected {
            background: var(--success);
            color: white;
        }

        .status-connecting {
            background: var(--warning);
            color: white;
        }

        .status-disconnected {
            background: var(--error);
            color: white;
        }

        @media (max-width: 1024px) {
            .main-content {
                grid-template-columns: 1fr;
                height: auto;
            }

            .sidebar {
                order: -1;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            .header {
                flex-direction: column;
                gap: 16px;
                text-align: center;
            }

            .video-controls {
                flex-wrap: wrap;
            }

            .control-btn {
                width: 45px;
                height: 45px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <h1>Interview Room</h1>
                <p>{{ $interview->candidate_name }} - {{ $interview->date->format('M j, Y') }} at {{ $interview->time->format('g:i A') }}</p>
            </div>
            <div class="header-right">
                <div class="status-badge {{ $interview->is_started ? 'status-live' : 'status-waiting' }}">
                    <i class="fas fa-circle"></i> {{ $interview->is_started ? 'Live' : 'Waiting' }}
                </div>
                <div class="time-display" id="current-time">
                    00:00:00
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Video Section -->
            <div class="video-section">
                <div class="video-container">
                    <div class="video-placeholder">
                        <i class="fas fa-video"></i>
                        <h3>Video Call in Progress</h3>
                        <p>WebRTC video calling will be implemented here</p>
                    </div>

                    <button class="video-controls-toggle" id="controlsToggle" title="Show/Hide Controls">
                        <i class="fas fa-bars"></i>
                    </button>

                    <div class="video-controls hidden" id="videoControls">
                        <button class="control-btn btn-mic" title="Toggle Microphone">
                            <i class="fas fa-microphone"></i>
                        </button>
                        <button class="control-btn btn-camera" title="Toggle Camera">
                            <i class="fas fa-video"></i>
                        </button>
                        <button class="control-btn btn-screen" title="Share Screen">
                            <i class="fas fa-desktop"></i>
                        </button>
                        <button class="control-btn btn-end" title="End Interview">
                            <i class="fas fa-phone-slash"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Resizer -->
            <div class="resizer" id="resizer"></div>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Interviewer Panel (Only for interviewers) -->
                @if($is_interviewer ?? false)
                <div class="panel">
                    <div class="panel-header">
                        <i class="fas fa-user-tie"></i>
                        <h3>Interviewer Panel</h3>
                    </div>
                    <div class="panel-content">
                        <!-- <div class="candidate-info">
                            <div class="candidate-name">{{ $interview->candidate_name }}</div>
                            <div class="candidate-detail"><strong>Email:</strong> {{ $interview->candidate_email }}</div>
                            <div class="candidate-detail"><strong>Phone:</strong> {{ $interview->candidate_phone ?: 'N/A' }}</div>
                            @if($interview->candidate_profile)
                            <div class="candidate-detail"><strong>Profile:</strong> {{ $interview->candidate_profile }}</div>
                            @endif
                            @if($interview->candidate_experience)
                            <div class="candidate-detail"><strong>Experience:</strong> {{ $interview->candidate_experience }}</div>
                            @endif
                        </div> -->

                        <div class="connection-status status-connected">
                            <i class="fas fa-wifi"></i>
                            Connected
                        </div>

                        <textarea
                            class="question-input"
                            placeholder="Type your question here..."
                            id="question-input"
                        ></textarea>
                        <button class="btn-send" onclick="sendQuestion()">
                            <i class="fas fa-paper-plane"></i> Send Question
                        </button>
                    </div>
                </div>
                @endif

                <!-- Questions & Answers Panel -->
                <div class="panel">
                    <div class="panel-header">
                        <i class="fas fa-comments"></i>
                        <h3>Questions & Answers</h3>
                    </div>
                    <div class="panel-content">
                        <div class="questions-list" id="questions-list">
                            <!-- Questions will be dynamically added here -->
                            <div class="question-item">
                                <div class="question-text">Welcome to the interview! Can you tell us about yourself?</div>
                                <div class="question-meta">Sent 2 minutes ago</div>
                                @if($is_candidate ?? false)
                                <textarea class="answer-input" placeholder="Type your answer here..." data-question-id="1"></textarea>
                                <button class="btn-send-answer" onclick="sendAnswer(1)">
                                    <i class="fas fa-reply"></i> Send Answer
                                </button>
                                @else
                                <div class="answer-display" style="margin-top: 8px; padding: 8px; background: var(--gray-100); border-radius: 6px; font-size: 14px; color: var(--gray-700);">
                                    <em>No answer yet</em>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Media Permission Modal -->
    <div class="modal permission-modal" id="mediaPermissionModal" style="display: flex;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Setup Your Audio & Video</h3>
            </div>
            <div class="modal-body">
                <p>Please allow access to your camera and microphone to join the interview.</p>
                <div class="permission-grid">
                    <div class="permission-item" id="camera-permission">
                        <i class="fas fa-video permission-icon"></i>
                        <div class="permission-label">Camera</div>
                        <div class="permission-status">Waiting...</div>
                    </div>
                    <div class="permission-item" id="mic-permission">
                        <i class="fas fa-microphone permission-icon"></i>
                        <div class="permission-label">Microphone</div>
                        <div class="permission-status">Waiting...</div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="skipMediaSetup()">Skip Setup</button>
                <button class="btn btn-primary" onclick="requestMediaPermissions()">Allow Access</button>
            </div>
        </div>
    </div>

    <!-- Start Interview Modal (for interviewers) -->
    @if($is_interviewer ?? false)
    <div class="modal" id="startInterviewModal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Start Interview</h3>
            </div>
            <div class="modal-body">
                <p>Can the candidate enter the room?</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="startInterview()">Yes, Start Interview</button>
            </div>
        </div>
    </div>
    @endif

    <script>
        // User role status
        var isInterviewer = {!! json_encode($is_interviewer ?? false) !!};
        var isCandidate = {!! json_encode($is_candidate ?? false) !!};
        var uniqueLink = {!! json_encode($interview->unique_link ?? '') !!};

        // Media variables
        let localStream = null;
        let remoteStream = null;
        let peerConnection = null;
        let isMicEnabled = false;
        let isCameraEnabled = false;
        let isScreenSharing = false;

        // WebRTC configuration
        const rtcConfiguration = {
            iceServers: [
                { urls: 'stun:stun.l.google.com:19302' },
                { urls: 'stun:stun1.l.google.com:19302' }
            ]
        };

        // Error logging function
        function logError(message, filename, lineno, colno, error) {
            fetch('/interview/log-error', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    message: message,
                    filename: filename,
                    lineno: lineno,
                    colno: colno,
                    error: error ? error.toString() : null
                })
            }).catch(function(err) {
                console.error('Failed to log error:', err);
            });
        }

        // Global error handler
        window.addEventListener('error', function(e) {
            logError(e.message, e.filename, e.lineno, e.colno, e.error);
        });

        // Unhandled promise rejection handler
        window.addEventListener('unhandledrejection', function(e) {
            logError('Unhandled Promise Rejection: ' + e.reason, null, null, null, e.reason);
        });

        // Update permission status
        function updatePermissionStatus(elementId, status, message) {
            const element = document.getElementById(elementId);
            if (element) {
                element.className = `permission-item ${status}`;
                const statusEl = element.querySelector('.permission-status');
                if (statusEl) {
                    statusEl.textContent = message;
                }
            }
        }

        // Request media permissions
        async function requestMediaPermissions() {
            try {
                updatePermissionStatus('camera-permission', 'requesting', 'Requesting...');
                updatePermissionStatus('mic-permission', 'requesting', 'Requesting...');

                localStream = await navigator.mediaDevices.getUserMedia({
                    video: true,
                    audio: true
                });

                // Success - update UI
                updatePermissionStatus('camera-permission', 'granted', 'Granted');
                updatePermissionStatus('mic-permission', 'granted', 'Granted');

                // Set initial states
                isMicEnabled = true;
                isCameraEnabled = true;

                // Display video
                displayLocalVideo();

                // Update control buttons
                updateControlButtons();

                // Hide modal after a short delay
                setTimeout(() => {
                    document.getElementById('mediaPermissionModal').style.display = 'none';
                    showInterviewModalIfNeeded();
                }, 1500);

            } catch (error) {
                console.error('Media permission error:', error);

                // Update UI based on error
                if (error.name === 'NotAllowedError') {
                    updatePermissionStatus('camera-permission', 'denied', 'Denied');
                    updatePermissionStatus('mic-permission', 'denied', 'Denied');
                    alert('Camera and microphone access denied. Please allow access to continue.');
                } else if (error.name === 'NotFoundError') {
                    updatePermissionStatus('camera-permission', 'denied', 'Not Found');
                    updatePermissionStatus('mic-permission', 'denied', 'Not Found');
                    alert('Camera or microphone not found. Please check your devices.');
                } else {
                    updatePermissionStatus('camera-permission', 'denied', 'Error');
                    updatePermissionStatus('mic-permission', 'denied', 'Error');
                    alert('Error accessing media devices: ' + error.message);
                }
            }
        }

        // Skip media setup
        function skipMediaSetup() {
            document.getElementById('mediaPermissionModal').style.display = 'none';
            showInterviewModalIfNeeded();
        }

        // Display local video
        function displayLocalVideo() {
            const videoContainer = document.querySelector('.video-container');
            const placeholder = videoContainer.querySelector('.video-placeholder');

            if (placeholder) {
                placeholder.remove();
            }

            // Create remote video element (full screen)
            const remoteVideo = document.createElement('video');
            remoteVideo.id = 'remoteVideo';
            remoteVideo.className = 'remote-video';
            remoteVideo.autoplay = true;
            remoteVideo.playsInline = true;
            remoteVideo.style.display = 'none'; // Initially hidden until remote stream is available

            // Create local video overlay (bottom left)
            const localVideoOverlay = document.createElement('div');
            localVideoOverlay.className = 'local-video-overlay';
            localVideoOverlay.onclick = toggleVideoLayout;

            const localVideo = document.createElement('video');
            localVideo.id = 'localVideo';
            localVideo.autoplay = true;
            localVideo.muted = true; // Mute to avoid feedback
            localVideo.playsInline = true;

            localVideoOverlay.appendChild(localVideo);
            videoContainer.appendChild(remoteVideo);
            videoContainer.appendChild(localVideoOverlay);

            localVideo.srcObject = localStream;

            // Initialize WebRTC connection
            initializeWebRTC();
        }

        // Toggle between local and remote video layout
        function toggleVideoLayout() {
            const remoteVideo = document.getElementById('remoteVideo');
            const localVideoOverlay = document.querySelector('.local-video-overlay');
            const localVideo = document.getElementById('localVideo');

            if (remoteVideo && remoteVideo.style.display !== 'none') {
                // Switch to local video full screen
                remoteVideo.style.display = 'none';
                localVideo.style.width = '100%';
                localVideo.style.height = '100%';
                localVideo.style.objectFit = 'cover';
                localVideoOverlay.style.width = '100%';
                localVideoOverlay.style.height = '100%';
                localVideoOverlay.style.bottom = '0';
                localVideoOverlay.style.left = '0';
                localVideoOverlay.style.border = 'none';
                localVideoOverlay.style.boxShadow = 'none';
            } else {
                // Switch back to remote video full screen with local overlay
                remoteVideo.style.display = 'block';
                localVideo.style.width = '100%';
                localVideo.style.height = '100%';
                localVideo.style.objectFit = 'cover';
                localVideoOverlay.style.width = '200px';
                localVideoOverlay.style.height = '150px';
                localVideoOverlay.style.bottom = '20px';
                localVideoOverlay.style.left = '20px';
                localVideoOverlay.style.border = '3px solid white';
                localVideoOverlay.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.3)';
            }
        }

        // Initialize WebRTC connection
        function initializeWebRTC() {
            try {
                peerConnection = new RTCPeerConnection(rtcConfiguration);

                // Add local stream tracks to peer connection
                if (localStream) {
                    localStream.getTracks().forEach(track => {
                        peerConnection.addTrack(track, localStream);
                    });
                }

                // Handle remote stream
                peerConnection.ontrack = (event) => {
                    if (event.streams && event.streams[0]) {
                        remoteStream = event.streams[0];
                        const remoteVideo = document.getElementById('remoteVideo');
                        if (remoteVideo) {
                            remoteVideo.srcObject = remoteStream;
                            remoteVideo.style.display = 'block';
                        }
                    }
                };

                // Handle ICE candidates
                peerConnection.onicecandidate = (event) => {
                    if (event.candidate) {
                        // Send ICE candidate to signaling server
                        sendSignalingMessage({
                            type: 'ice-candidate',
                            candidate: event.candidate
                        });
                    }
                };

                // Handle connection state changes
                peerConnection.onconnectionstatechange = () => {
                    console.log('Connection state:', peerConnection.connectionState);
                };

                // Create offer if interviewer
                if (isInterviewer) {
                    createOffer();
                }

            } catch (error) {
                console.error('WebRTC initialization error:', error);
            }
        }

        // Create WebRTC offer
        async function createOffer() {
            try {
                const offer = await peerConnection.createOffer();
                await peerConnection.setLocalDescription(offer);

                // Send offer to signaling server
                sendSignalingMessage({
                    type: 'offer',
                    offer: offer
                });
            } catch (error) {
                console.error('Error creating offer:', error);
            }
        }

        // Handle WebRTC answer
        async function handleAnswer(answer) {
            try {
                await peerConnection.setRemoteDescription(new RTCSessionDescription(answer));
            } catch (error) {
                console.error('Error handling answer:', error);
            }
        }

        // Handle WebRTC offer
        async function handleOffer(offer) {
            try {
                await peerConnection.setRemoteDescription(new RTCSessionDescription(offer));

                const answer = await peerConnection.createAnswer();
                await peerConnection.setLocalDescription(answer);

                // Send answer to signaling server
                sendSignalingMessage({
                    type: 'answer',
                    answer: answer
                });
            } catch (error) {
                console.error('Error handling offer:', error);
            }
        }

        // Handle ICE candidate
        async function handleIceCandidate(candidate) {
            try {
                await peerConnection.addIceCandidate(new RTCIceCandidate(candidate));
            } catch (error) {
                console.error('Error handling ICE candidate:', error);
            }
        }

        // Send signaling message (placeholder - would connect to actual signaling server)
        function sendSignalingMessage(message) {
            // This would send the message to your signaling server
            // For now, just log it
            console.log('Signaling message:', message);

            // In a real implementation, you would use WebSocket or HTTP to send to server
            // Example: ws.send(JSON.stringify(message));
        }

        // Receive signaling message (placeholder - would be called by WebSocket listener)
        function receiveSignalingMessage(message) {
            switch (message.type) {
                case 'offer':
                    handleOffer(message.offer);
                    break;
                case 'answer':
                    handleAnswer(message.answer);
                    break;
                case 'ice-candidate':
                    handleIceCandidate(message.candidate);
                    break;
            }
        }

        // Update control buttons
        function updateControlButtons() {
            const micBtn = document.querySelector('.btn-mic');
            const cameraBtn = document.querySelector('.btn-camera');

            if (micBtn) {
                const micIcon = micBtn.querySelector('i');
                if (isMicEnabled) {
                    micBtn.style.background = 'var(--success)';
                    micIcon.className = 'fas fa-microphone';
                } else {
                    micBtn.style.background = 'var(--error)';
                    micIcon.className = 'fas fa-microphone-slash';
                }
            }

            if (cameraBtn) {
                const cameraIcon = cameraBtn.querySelector('i');
                if (isCameraEnabled) {
                    cameraBtn.style.background = 'var(--primary)';
                    cameraIcon.className = 'fas fa-video';
                } else {
                    cameraBtn.style.background = 'var(--error)';
                    cameraIcon.className = 'fas fa-video-slash';
                }
            }
        }

        // Toggle microphone
        function toggleMicrophone() {
            if (!localStream) return;

            const audioTracks = localStream.getAudioTracks();
            audioTracks.forEach(track => {
                track.enabled = !track.enabled;
                isMicEnabled = track.enabled;
            });

            updateControlButtons();
        }

        // Toggle camera
        function toggleCamera() {
            if (!localStream) return;

            const videoTracks = localStream.getVideoTracks();
            videoTracks.forEach(track => {
                track.enabled = !track.enabled;
                isCameraEnabled = track.enabled;
            });

            updateControlButtons();
        }

        // Test speaker
        function testSpeaker() {
            const audio = new Audio();
            audio.volume = 0.5;
            // Create a simple beep sound
            const context = new (window.AudioContext || window.webkitAudioContext)();
            const oscillator = context.createOscillator();
            const gainNode = context.createGain();

            oscillator.connect(gainNode);
            gainNode.connect(context.destination);

            oscillator.frequency.setValueAtTime(800, context.currentTime);
            oscillator.frequency.setValueAtTime(600, context.currentTime + 0.1);

            gainNode.gain.setValueAtTime(0.3, context.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, context.currentTime + 0.3);

            oscillator.start(context.currentTime);
            oscillator.stop(context.currentTime + 0.3);
        }

        // Show interview modal if needed
        function showInterviewModalIfNeeded() {
            if (isInterviewer && !{{ $interview->is_started ? 'true' : 'false' }}) {
                document.getElementById('startInterviewModal').style.display = 'flex';
            }
        }

        // Update current time
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('en-US', {
                hour12: false,
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            document.getElementById('current-time').textContent = timeString;
        }

        // Update time every second
        setInterval(updateTime, 1000);
        updateTime();

        // Send question function
        function sendQuestion() {
            const input = document.getElementById('question-input');
            const question = input.value.trim();

            if (!question) {
                alert('Please enter a question first.');
                return;
            }

            // Create question item
            const questionsList = document.getElementById('questions-list');
            const questionItem = document.createElement('div');
            questionItem.className = 'question-item';

            let answerSection = '';
            if (isInterviewer) {
                // For interviewers: show answer display
                answerSection = `<div class="answer-display" style="margin-top: 8px; padding: 8px; background: var(--gray-100); border-radius: 6px; font-size: 14px; color: var(--gray-700);">
                    <em>No answer yet</em>
                </div>`;
            } else {
                // For candidates: show answer input
                const questionId = Date.now(); // Simple ID for demo
                answerSection = `<textarea class="answer-input" placeholder="Type your answer here..." data-question-id="${questionId}"></textarea>
                <button class="btn-send-answer" onclick="sendAnswer(${questionId})">
                    <i class="fas fa-reply"></i> Send Answer
                </button>`;
            }

            questionItem.innerHTML = `
                <div class="question-text">${question}</div>
                <div class="question-meta">Sent just now</div>
                ${answerSection}
            `;

            // Add to list
            questionsList.appendChild(questionItem);

            // Clear input
            input.value = '';

            // Scroll to bottom
            questionsList.scrollTop = questionsList.scrollHeight;

            // Here you would typically send the question via AJAX/WebSocket
            console.log('Question sent:', question);
        }

        // Send answer function
        function sendAnswer(questionId) {
            const answerInput = document.querySelector(`[data-question-id="${questionId}"]`);
            const answer = answerInput.value.trim();

            if (!answer) {
                alert('Please enter an answer first.');
                return;
            }

            // Here you would typically send the answer via AJAX/WebSocket
            console.log('Answer sent for question', questionId, ':', answer);

            // For now, just hide the input and show the answer
            const questionItem = answerInput.closest('.question-item');
            const answerDisplay = questionItem.querySelector('.answer-display') || document.createElement('div');
            answerDisplay.className = 'answer-display';
            answerDisplay.style.marginTop = '8px';
            answerDisplay.style.padding = '8px';
            answerDisplay.style.background = 'var(--gray-100)';
            answerDisplay.style.borderRadius = '6px';
            answerDisplay.style.fontSize = '14px';
            answerDisplay.style.color = 'var(--gray-700)';
            answerDisplay.innerHTML = `<strong>Answer:</strong> ${answer}`;

            // Replace input and button with answer display
            answerInput.style.display = 'none';
            const sendButton = questionItem.querySelector('.btn-send-answer');
            sendButton.style.display = 'none';

            if (!questionItem.querySelector('.answer-display')) {
                questionItem.appendChild(answerDisplay);
            }
        }

        // Handle Enter key in question input
        const questionInput = document.getElementById('question-input');
        if (questionInput) {
            questionInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    sendQuestion();
                }
            });
        }

        // Video controls toggle button
        const controlsToggle = document.getElementById('controlsToggle');
        if (controlsToggle) {
            controlsToggle.addEventListener('click', function() {
                const controls = document.getElementById('videoControls');
                if (controls) {
                    controls.classList.toggle('hidden');
                }
            });
        }

        // Video control buttons
        document.querySelectorAll('.control-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                if (this.classList.contains('btn-mic')) {
                    toggleMicrophone();
                } else if (this.classList.contains('btn-camera')) {
                    toggleCamera();
                } else if (this.classList.contains('btn-screen')) {
                    testSpeaker();
                } else if (this.classList.contains('btn-end')) {
                    if (confirm('Are you sure you want to end the interview?')) {
                        // Stop media tracks
                        if (localStream) {
                            localStream.getTracks().forEach(track => track.stop());
                        }
                        // Redirect or end interview
                        window.location.href = '/admin/interviews';
                    }
                }

                console.log('Control button clicked:', this.title);
            });
        });

        // Start Interview function
        function startInterview() {
            fetch('/interview/' + uniqueLink + '/start', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Hide modal
                    document.getElementById('startInterviewModal').style.display = 'none';
                    // Update status badge
                    const statusBadge = document.querySelector('.status-badge');
                    statusBadge.className = 'status-badge status-live';
                    statusBadge.innerHTML = '<i class="fas fa-circle"></i> Live';
                    // Optionally reload or update UI
                    console.log('Interview started successfully');
                } else {
                    alert('Failed to start interview. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        }



        // Resizer functionality
        let isResizing = false;
        let startX = 0;
        let startWidth = 0;

        const resizer = document.getElementById('resizer');
        const videoSection = document.querySelector('.video-section');
        const mainContent = document.querySelector('.main-content');

        if (resizer && videoSection && mainContent) {
            resizer.addEventListener('mousedown', function(e) {
                isResizing = true;
                startX = e.clientX;
                startWidth = videoSection.offsetWidth;
                document.body.style.cursor = 'col-resize';
                document.body.style.userSelect = 'none';
            });

            document.addEventListener('mousemove', function(e) {
                if (!isResizing) return;

                const deltaX = e.clientX - startX;
                const newWidth = Math.max(200, Math.min(startWidth + deltaX, mainContent.offsetWidth - 300)); // Min 200px, max leaving 300px for sidebar

                videoSection.style.flex = `0 0 ${newWidth}px`;
            });

            document.addEventListener('mouseup', function() {
                if (isResizing) {
                    isResizing = false;
                    document.body.style.cursor = '';
                    document.body.style.userSelect = '';
                }
            });
        }

        // Placeholder for WebRTC implementation
        console.log('Interview room loaded. Ready for WebRTC integration.');
    </script>
</body>
</html>
