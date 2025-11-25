<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Interview Room - {{ $interview->candidate_name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        :root{
            --primary:#4f46e5;--primary-dark:#3730a3;--success:#10b981;--warning:#f59e0b;--error:#ef4444;
            --gray-50:#f8fafc;--gray-100:#f1f5f9;--gray-200:#e2e8f0;--gray-300:#cbd5e1;--gray-500:#64748b;
            --gray-700:#334155;--gray-800:#1e293b;--gray-900:#0f172a;--border-radius:12px;
            --shadow:0 4px 6px -1px rgba(0,0,0,.1),0 2px 4px -1px rgba(0,0,0,.06);
        }
        *{margin:0;padding:0;box-sizing:border-box;}
        body{font-family:'Inter',sans-serif;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);min-height:100vh;color:var(--gray-800);}
        .container{max-width:1400px;margin:0 auto;padding:20px;}
        .header{background:rgba(255,255,255,.95);backdrop-filter:blur(10px);border-radius:var(--border-radius);padding:20px;margin-bottom:20px;box-shadow:var(--shadow);display:flex;justify-content:space-between;align-items:center;}
        .header-left h1{font-size:24px;font-weight:700;color:var(--gray-900);margin-bottom:4px;}
        .header-left p{color:var(--gray-600);font-size:14px;}
        .debug-info{font-size:10px;color:var(--gray-500);margin-top:4px;}
        .status-badge{padding:6px 12px;border-radius:20px;font-size:12px;font-weight:600;text-transform:uppercase;}
        .status-live{background:var(--success);color:#fff;}
        .status-waiting{background:var(--warning);color:#fff;}
        .time-display{background:var(--gray-100);color:var(--gray-700);padding:6px 12px;border-radius:20px;font-size:12px;font-weight:600;}
        .main-content{display:flex;height:calc(100vh - 140px);}
        .video-section{flex:0 0 400px;background:rgba(255,255,255,.95);backdrop-filter:blur(10px);border-radius:var(--border-radius);padding:20px;box-shadow:var(--shadow);display:flex;flex-direction:column;position:relative;}
        .resizer{width:5px;height:100%;background:transparent;cursor:col-resize;flex-shrink:0;position:relative;}
        .resizer:hover,.resizer.active{background:var(--primary);}
        .sidebar{flex:1;min-width:300px;overflow-y:auto;scrollbar-width:none;}
        .sidebar::-webkit-scrollbar{display:none;}
        .video-container{flex:1;background:var(--gray-900);border-radius:8px;position:relative;overflow:hidden;display:flex;align-items:center;justify-content:center;}
        #remoteVideo{width:100%;height:100%;object-fit:cover;border-radius:8px;display:none;}
        #remoteAudio{display:none;}
        .local-video-overlay{position:absolute;bottom:20px;left:20px;width:200px;height:150px;border-radius:8px;border:3px solid #fff;box-shadow:0 4px 12px rgba(0,0,0,.3);z-index:10;cursor:pointer;}
        .local-video-overlay video{width:100%;height:100%;object-fit:cover;border-radius:5px;}
        .video-controls-toggle{position:absolute;top:20px;right:20px;width:40px;height:40px;border-radius:50%;background:var(--primary);border:none;color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:16px;z-index:15;}
        .video-controls{position:absolute;bottom:20px;left:50%;transform:translateX(-50%);display:flex;gap:16px;padding:12px 20px;background:rgba(0,0,0,.5);border-radius:25px;backdrop-filter:blur(5px);z-index:15;}
        .video-controls.hidden{display:none !important;}
        .control-btn{width:50px;height:50px;border-radius:50%;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:18px;transition:all .3s;box-shadow:var(--shadow);}
        .control-btn:hover{transform:translateY(-2px);}
        .btn-mic{background:var(--success);color:#fff;}
        .btn-camera{background:var(--primary);color:#fff;}
        .btn-screen{background:var(--warning);color:#fff;}
        .btn-end{background:var(--error);color:#fff;}
        .panel{background:rgba(255,255,255,.95);backdrop-filter:blur(10px);border-radius:var(--border-radius);box-shadow:var(--shadow);margin-bottom:20px;}
        .panel-header{padding:16px 20px;border-bottom:1px solid var(--gray-200);display:flex;align-items:center;gap:12px;}
        .panel-header i{color:var(--primary);font-size:18px;}
        .panel-header h3{font-size:16px;font-weight:600;color:var(--gray-900);}
        .panel-content{padding:20px;}
        .question-input{width:100%;min-height:100px;padding:12px;border:2px solid var(--gray-200);border-radius:8px;font-family:inherit;font-size:14px;resize:vertical;}
        .question-input:focus{outline:none;border-color:var(--primary);}
        .btn-send{width:100%;padding:12px;background:var(--primary);color:#fff;border:none;border-radius:8px;font-weight:600;cursor:pointer;margin-top:12px;}
        .btn-send:hover{background:var(--primary-dark);}
        .questions-list{overflow-y:auto;max-height:60vh;scrollbar-width:none;}
        .questions-list::-webkit-scrollbar{display:none;}
        .question-item{padding:12px;border:1px solid var(--gray-200);border-radius:8px;margin-bottom:8px;background:var(--gray-50);}
        .question-text{font-size:14px;color:var(--gray-800);margin-bottom:8px;}
        .question-meta{font-size:12px;color:var(--gray-500);}
        .answer-input{width:100%;min-height:60px;padding:8px;border:2px solid var(--gray-200);border-radius:6px;font-size:14px;margin-top:8px;resize:vertical;}
        .answer-input:focus{outline:none;border-color:var(--primary);}
        .btn-send-answer{width:100%;padding:8px;background:var(--success);color:#fff;border:none;border-radius:6px;font-weight:600;cursor:pointer;margin-top:8px;font-size:12px;}
        .btn-send-answer:hover{background:#059669;}
        .answer-display{margin-top:8px;padding:8px;background:var(--gray-100);border-radius:6px;font-size:14px;color:var(--gray-700);}
        .connection-status{display:flex;align-items:center;gap:8px;padding:8px 12px;border-radius:6px;font-size:12px;font-weight:600;margin-bottom:16px;}
        .status-connected{background:var(--success);color:#fff;}
        .status-connecting{background:var(--warning);color:#fff;}
        .status-disconnected{background:var(--error);color:#fff;}
        .modal{position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.5);display:flex;align-items:center;justify-content:center;z-index:1000;}
        .modal-content{background:#fff;padding:24px;border-radius:var(--border-radius);box-shadow:var(--shadow);max-width:500px;width:90%;text-align:center;}
        .permission-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:16px;margin:20px 0;}
        .permission-item{padding:16px;border:2px solid var(--gray-200);border-radius:8px;background:var(--gray-50);text-align:center;}
        .permission-item.requesting{border-color:var(--warning);background:rgba(245,158,11,.1);}
        .permission-item.granted{border-color:var(--success);background:rgba(16,185,129,.1);}
        .permission-item.denied{border-color:var(--error);background:rgba(239,68,68,.1);}
        .permission-icon{font-size:32px;margin-bottom:8px;color:var(--gray-400);}
        .permission-item.requesting .permission-icon{color:var(--warning);animation:pulse 1s infinite;}
        .permission-item.granted .permission-icon{color:var(--success);}
        .permission-item.denied .permission-icon{color:var(--error);}
        @keyframes pulse{0%,100%{opacity:1}50%{opacity:.5}}
        .btn{padding:12px 24px;border:none;border-radius:8px;font-weight:600;cursor:pointer;}
        .btn-primary{background:var(--primary);color:#fff;}
        .btn-primary:hover{background:var(--primary-dark);}
        .btn-secondary{background:var(--gray-200);color:var(--gray-700);}
        .btn-secondary:hover{background:var(--gray-300);}
        @media(max-width:1024px){.main-content{flex-direction:column;height:auto;}.video-section{flex:none;height:50vh;}.sidebar{order:-1;}}
    </style>
</head>
<body>
<div class="container">
    <!-- Header -->
    <div class="header">
        <div class="header-left">
            <h1>Interview Room</h1>
            <p>{{ $interview->candidate_name }} - {{ $interview->date->format('M j, Y') }} at {{ $interview->time->format('g:i A') }}</p>
            <div class="debug-info">Room: {{ $interview->unique_link }} | User: {{ $is_interviewer ? 'Interviewer' : 'Candidate' }}</div>
        </div>
        <div class="header-right">
            <div class="status-badge {{ $interview->is_started ? 'status-live' : 'status-waiting' }}">
                {{ $interview->is_started ? 'Live' : 'Waiting' }}
            </div>
            <div class="time-display" id="current-time">00:00:00</div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Video Section -->
        <div class="video-section">
            <div class="video-container" id="videoContainer">
                <div class="video-placeholder"><h3>Connecting...</h3></div>
                <div class="connection-info" id="connectionInfo" style="position:absolute;top:10px;left:10px;background:rgba(0,0,0,0.7);color:#fff;padding:5px 10px;border-radius:5px;font-size:12px;z-index:20;">Initializing...</div>
                <button id="enableAudioBtn" style="position:absolute;bottom:10px;left:10px;background:#10b981;color:#fff;border:none;padding:8px 16px;border-radius:6px;cursor:pointer;z-index:25;display:none;">Enable Audio</button>
            </div>

            <button class="video-controls-toggle" id="controlsToggle"><i class="fas fa-cog"></i></button>

            <div class="video-controls" id="videoControls">
                <button class="control-btn btn-mic" id="btnMic" title="Toggle Mic"><i class="fas fa-microphone"></i></button>
                <button class="control-btn btn-camera" id="btnCamera" title="Toggle Camera"><i class="fas fa-video"></i></button>
                <button class="control-btn btn-screen" id="btnScreen" title="Share Screen"><i class="fas fa-desktop"></i></button>
                <button class="control-btn btn-end" id="btnEnd" title="End Interview"><i class="fas fa-phone-slash"></i></button>
            </div>
        </div>

        <!-- Resizer -->
        <div class="resizer" id="resizer"></div>

        <!-- Sidebar -->
        <div class="sidebar">
            @if($is_interviewer ?? false)
            <div class="panel">
                <div class="panel-header">Interviewer Panel</div>
                <div class="panel-content">
                    <div class="connection-status status-connecting" id="connStatus">Connecting...</div>
                    <textarea class="question-input" id="questionInput" placeholder="Type your question..."></textarea>
                    <button class="btn-send" id="btnSendQuestion">Send Question</button>
                </div>
            </div>
            @endif

            <div class="panel">
                <div class="panel-header">Questions & Answers</div>
                <div class="panel-content">
                    <div class="questions-list" id="questionsList"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Media Modal -->
<div class="modal" id="mediaModal" style="display:flex;">
    <div class="modal-content">
        <h3>Allow Camera & Mic</h3>
        <p>We need access to start the video call.</p>
        <div class="permission-grid">
            <div class="permission-item" id="camPerm"><div class="permission-label">Camera</div><div class="permission-status">Waiting...</div></div>
            <div class="permission-item" id="micPerm"><div class="permission-label">Microphone</div><div class="permission-status">Waiting...</div></div>
        </div>
        <button class="btn btn-secondary" onclick="skipMedia()">Skip</button>
        <button class="btn btn-primary" onclick="requestMedia()">Allow</button>
    </div>
</div>

@if($is_interviewer && !$interview->is_started)
<div class="modal" id="startModal">
    <div class="modal-content">
        <h3>Start Interview?</h3>
        <p>Let the candidate join.</p>
        <button class="btn btn-primary" onclick="startInterview()">Yes, Start</button>
    </div>
</div>
@endif

<!-- RECORDING PANEL (Interviewer Only) -->
@if($is_interviewer ?? false)
<div class="panel" id="recordingPanel" style="display:none;">
    <div class="panel-header">Recording</div>
    <div class="panel-content">
        <button class="btn-send" id="btnStartRecord" style="background:#dc2626;">Start Recording</button>
        <button class="btn-send hidden" id="btnStopRecord" style="background:#16a34a;">Stop & Download</button>
        <p id="recordStatus" style="margin-top:8px; color:#64748b;">Ready</p>
    </div>
</div>
@endif

<script>
/* ==================== FULL DEBUG MODE ON ==================== */
console.log('%c[DEBUG MODE] FULLY ACTIVATED – 10:23 PM IST, 10 Nov 2025', 'color: red; font-weight: bold; font-size: 18px');
console.log('%c[USER] Interviewer:', {{ $is_interviewer ? 'true' : 'false' }}, 'Candidate:', {{ $is_candidate ? 'true' : 'false' }});
console.log('%c[ROOM] Unique Link:', '{{ $interview->unique_link }}', 'Started:', {{ $interview->is_started ? 'true' : 'false' }});
console.log('%c[SESSION] Unique Link:', '{{ $interview->unique_link }}', 'Is Interviewer:', {{ $is_interviewer ? 'true' : 'false' }});

/* ==================== CONFIG ==================== */
const isInterviewer = {{ $is_interviewer ? 'true' : 'false' }};
const isCandidate   = {{ $is_candidate ? 'true' : 'false' }};
const uniqueLink    = "{{ $interview->unique_link }}";

/* ==================== STATE ==================== */
let localStream = null, screenStream = null, peerConnection = null;
let iceQueue = [], lastMsgId = 0, pollInterval = null;
let isMicOn = false, isCamOn = false, isScreenSharing = false;
let peerOnline = false, offerTimeout = null, answerTimeout = null;
let pollFrequency = 1000, pollBackoff = 1.2, maxPollFrequency = 5000;
let connectionAttempts = 0, maxConnectionAttempts = 3;

/* ==================== WebRTC CONFIG ==================== */
const rtcConfig = {
    iceServers: [
        { urls: ["stun:31.97.206.139:3478", "turn:31.97.206.139:3478"], username: "demo", credential: "12345" },
        { urls: 'stun:stun.l.google.com:19302' }
    ]
};

/* ==================== DOM ==================== */
const videoContainer = document.getElementById('videoContainer');
const connStatus = document.getElementById('connStatus');
const videoControls = document.getElementById('videoControls');
const controlsToggle = document.getElementById('controlsToggle');

/* ==================== SDP CLEANER (DISABLED - USE RAW SDP) ==================== */
function cleanSDP(sdp) {
    console.log('%c[SDP] Using RAW SDP (no cleaning to avoid corruption)', 'color: blue');
    return sdp;
}

/* ==================== SDP LENGTH LOGGING ==================== */
function logSDPLength(sdp, context) {
    console.log(`%c[${context}] SDP length: ${sdp.length}`, 'color: purple');
    return sdp.length;
}

/* ==================== MEDIA ==================== */
async function requestMedia(retryCount = 0) {
    console.log('%c[MEDIA] Requesting access... (attempt ' + (retryCount + 1) + ')', 'color: #10b981');
    try {
        localStream = await navigator.mediaDevices.getUserMedia({
            video: { width: 1280, height: 720, facingMode: 'user' },
            audio: { echoCancellation: true, noiseSuppression: true, autoGainControl: true }
        });
        isMicOn = isCamOn = true;

        // Debug audio tracks specifically
        const audioTracks = localStream.getAudioTracks();
        const videoTracks = localStream.getVideoTracks();
        console.log('%c[MEDIA] GRANTED - Video tracks:', 'color: green', videoTracks.length, 'Audio tracks:', audioTracks.length);

        // Log audio track details
        audioTracks.forEach((track, index) => {
            console.log(`%c[AUDIO] Track ${index}:`, 'color: blue', {
                label: track.label,
                enabled: track.enabled,
                muted: track.muted,
                readyState: track.readyState,
                settings: track.getSettings()
            });
        });

        document.getElementById('mediaModal').style.display = 'none';
        initWebRTC();
    } catch (e) {
        console.error('%c[MEDIA] DENIED (attempt ' + (retryCount + 1) + ')', 'color: red', e);
        if (retryCount < 2) {
            console.log('%c[MEDIA] Retrying in 2 seconds...', 'color: orange');
            setTimeout(() => requestMedia(retryCount + 1), 2000);
        } else {
            alert('Camera & mic access failed after 3 attempts. Please check permissions and refresh the page.');
            // Still initialize WebRTC for signaling even without media
            initWebRTC();
        }
    }
}
function skipMedia() {
    console.log('%c[MEDIA] SKIPPED - No local media', 'color: orange');
    document.getElementById('mediaModal').style.display = 'none';
    initWebRTC();
}

/* ==================== PEER CONNECTIVITY CHECK ==================== */
async function checkPeerOnline() {
    console.log('%c[PEER] Checking if other peer is online...', 'color: blue');
    try {
        const res = await fetch(`/interview/${uniqueLink}/signaling/messages?receiver_type=${isInterviewer?'interviewer':'candidate'}&last_message_id=${lastMsgId}&check_online=1`);
        const data = await res.json();
        peerOnline = data.peer_online || false;
        console.log('%c[PEER] Other peer online:', 'color: blue', peerOnline);
        return peerOnline;
    } catch (e) {
        console.error('%c[PEER] Online check failed', 'color: red', e);
        peerOnline = false;
        return false;
    }
}

/* ==================== NETWORK CONNECTIVITY TEST ==================== */
async function testWebRTCConnectivity() {
    console.log('%c[NETWORK] Testing WebRTC connectivity...', 'color: purple');
    return new Promise((resolve) => {
        const testPC = new RTCPeerConnection(rtcConfig);
        let hasCandidate = false;

        testPC.onicecandidate = (e) => {
            if (e.candidate && !hasCandidate) {
                hasCandidate = true;
                console.log('%c[NETWORK] ICE candidate received - connectivity OK', 'color: green');
                testPC.close();
                resolve(true);
            }
        };

        testPC.createDataChannel('test');
        testPC.createOffer().then(offer => testPC.setLocalDescription(offer));

        setTimeout(() => {
            if (!hasCandidate) {
                console.warn('%c[NETWORK] No ICE candidates - possible firewall/network issue', 'color: orange');
                testPC.close();
                resolve(false);
            }
        }, 5000);
    });
}

/* ==================== SCREEN SHARE ==================== */
async function toggleScreenShare() {
    if (isScreenSharing) {
        screenStream?.getTracks().forEach(t => t.stop());
        screenStream = null; isScreenSharing = false;
        replaceTrack(localStream);
        // Update local video to show camera stream again
        const localVideo = document.getElementById('localVideo');
        if (localVideo && localStream) {
            localVideo.srcObject = localStream;
            console.log('%c[SCREEN] Local video switched back to camera', 'color: purple');
        }
        document.getElementById('btnScreen').innerHTML = 'Screen';
    } else {
        try {
            screenStream = await navigator.mediaDevices.getDisplayMedia({ video: true });
            isScreenSharing = true;
            replaceTrack(screenStream);
            // Update local video to show screen stream
            const localVideo = document.getElementById('localVideo');
            if (localVideo && screenStream) {
                localVideo.srcObject = screenStream;
                console.log('%c[SCREEN] Local video switched to screen share', 'color: purple');
            }
            document.getElementById('btnScreen').innerHTML = 'Stop';
            screenStream.getTracks()[0].onended = toggleScreenShare;
        } catch (e) {
            console.error('%c[SCREEN] Denied', 'color: red', e);
        }
    }
}
function replaceTrack(stream) {
    const sender = peerConnection?.getSenders().find(s => s.track?.kind === 'video');
    if (sender && stream?.getVideoTracks()[0]) {
        sender.replaceTrack(stream.getVideoTracks()[0]);
        console.log('%c[TRACK] Replaced', 'color: purple');
    }
}

/* ==================== VIDEO SETUP ==================== */
function setupVideoElements() {
    console.log('%c[VIDEO] Setting up elements...', 'color: cyan');
    videoContainer.innerHTML = '';

    // Create remote video element
    const remote = document.createElement('video');
    remote.id = 'remoteVideo';
    remote.autoplay = true;
    remote.playsInline = true;
    remote.controls = false;
    remote.volume = 1;
    remote.muted = false;
    remote.style.width = '100%';
    remote.style.height = '100%';
    remote.style.objectFit = 'cover';
    remote.style.display = 'none'; // Initially hidden until we get a stream

    // Create remote audio element
    const remoteAudio = document.createElement('audio');
    remoteAudio.id = 'remoteAudio';
    remoteAudio.autoplay = true;
    remoteAudio.volume = 1;
    remoteAudio.muted = false;

    // Create local video overlay
    const overlay = document.createElement('div');
    overlay.className = 'local-video-overlay';
    overlay.onclick = toggleLayout;

    const local = document.createElement('video');
    local.id = 'localVideo';
    local.autoplay = true;
    local.muted = true;
    local.playsInline = true;
    local.controls = false;
    local.style.width = '100%';
    local.style.height = '100%';
    local.style.objectFit = 'cover';

    overlay.appendChild(local);
    videoContainer.appendChild(remote);
    videoContainer.appendChild(remoteAudio);
    videoContainer.appendChild(overlay);

    // Set local stream if available
    if (localStream) {
        local.srcObject = localStream;
        console.log('%c[VIDEO] Local stream set to local video element', 'color: cyan');
    } else {
        console.warn('%c[VIDEO] No local stream available for local video', 'color: orange');
    }

    console.log('%c[VIDEO] Elements created:', 'color: cyan', {
        remoteVideo: !!document.getElementById('remoteVideo'),
        localVideo: !!document.getElementById('localVideo')
    });
}

/* ==================== WEBRTC ==================== */
async function initWebRTC() {
    console.log('%c[WEBRTC] INITIALIZING...', 'color: #4f46e5; font-weight: bold');

    // Test network connectivity first
    const networkOk = await testWebRTCConnectivity();
    if (!networkOk) {
        console.warn('%c[WEBRTC] Network connectivity test failed - may have firewall issues', 'color: orange');
        updateConnectionStatus('Network issues detected - check firewall');
    }

    setupVideoElements();
    peerConnection = new RTCPeerConnection(rtcConfig);

    // Add local tracks to peer connection
    if (localStream) {
        localStream.getTracks().forEach(track => {
            console.log('%c[WEBRTC] Adding local track:', 'color: cyan', track.kind, track.label);
            peerConnection.addTrack(track, localStream);
        });
    } else {
        console.warn('%c[WEBRTC] No local stream available', 'color: orange');
    }

    peerConnection.ontrack = e => {
        console.log('%c[WEBRTC] Remote track received:', 'color: green', e.track.kind, e.track.label, 'enabled:', e.track.enabled, 'readyState:', e.track.readyState);
        console.log('%c[WEBRTC] Event streams:', e.streams.length, 'Stream 0 tracks:', e.streams[0]?.getTracks().length || 0);

        const v = document.getElementById('remoteVideo');
        const a = document.getElementById('remoteAudio');
        if (v && a) {
            // Always use the stream from the event if available
            if (e.streams[0]) {
                v.srcObject = e.streams[0];
                a.srcObject = e.streams[0];
                console.log('%c[WEBRTC] REMOTE STREAM ASSIGNED FROM EVENT', 'color: green; font-weight: bold');
            } else {
                // Fallback: create new stream and add track
                if (!v.srcObject) {
                    v.srcObject = new MediaStream();
                }
                if (!a.srcObject) {
                    a.srcObject = new MediaStream();
                }
                v.srcObject.addTrack(e.track);
                a.srcObject.addTrack(e.track);
                console.log('%c[WEBRTC] INDIVIDUAL TRACK ADDED TO STREAM', 'color: cyan', e.track.kind);
            }

            // Ensure video is visible and playing
            v.style.display = 'block';
            v.volume = 1;
            v.muted = false; // Explicitly unmute for audio
            a.volume = 1;
            a.muted = false;

            // Force play with better error handling
            const playPromise = v.play();
            if (playPromise !== undefined) {
                playPromise.then(() => {
                    console.log('%c[VIDEO] Remote video playing successfully', 'color: green; font-weight: bold');
                    // Update UI to show remote video is active
                    const placeholder = document.querySelector('.video-placeholder');
                    if (placeholder) placeholder.style.display = 'none';

                    // Check if audio is working
                    if (v.srcObject) {
                        const audioTracks = v.srcObject.getAudioTracks();
                        const videoTracks = v.srcObject.getVideoTracks();
                        console.log('%c[AUDIO] Remote stream audio tracks:', 'color: blue', audioTracks.length);
                        audioTracks.forEach((track, index) => {
                            console.log(`%c[AUDIO] Remote track ${index}:`, 'color: blue', {
                                enabled: track.enabled,
                                muted: track.muted,
                                readyState: track.readyState
                            });
                        });
                    }
                }).catch(err => {
                    console.warn('%c[VIDEO] Play failed, trying muted:', 'color: orange', err);
                    v.muted = true;
                    v.play().then(() => {
                        console.log('%c[VIDEO] Remote video playing muted', 'color: yellow');
                        // Show enable audio button since video is muted
                        document.getElementById('enableAudioBtn').style.display = 'block';
                    }).catch(err2 => {
                        console.error('%c[VIDEO] Play failed even muted:', 'color: red', err2);
                        // Try one more time with user interaction
                        v.onclick = () => {
                            v.play().then(() => {
                                console.log('%c[VIDEO] Remote video started on user click', 'color: green');
                                v.onclick = null;
                            });
                        };
                    });
                });
            }

            console.log('%c[VIDEO] Remote video element state:', 'color: blue', {
                display: v.style.display,
                srcObject: !!v.srcObject,
                tracks: v.srcObject ? v.srcObject.getTracks().length : 0,
                videoTracks: v.srcObject ? v.srcObject.getVideoTracks().length : 0,
                audioTracks: v.srcObject ? v.srcObject.getAudioTracks().length : 0,
                readyState: v.readyState,
                networkState: v.networkState,
                muted: v.muted,
                volume: v.volume
            });
        } else {
            console.error('%c[WEBRTC] Remote video or audio element not found!', 'color: red');
        }
    };

    peerConnection.onicecandidate = e => {
        if (e.candidate) {
            console.log('%c[ICE] Generated:', 'color: orange', e.candidate.type, e.candidate.address);
            sendSignal({ type: 'ice-candidate', candidate: e.candidate.toJSON() });
        }
    };

    peerConnection.onconnectionstatechange = () => {
        const s = peerConnection.connectionState;
        console.log('%c[WEBRTC] Connection state:', 'color: purple; font-weight: bold', s);

        // Safely update connection status element (only exists for interviewer)
        const connStatusEl = document.getElementById('connStatus');
        if (connStatusEl) {
            connStatusEl.className = s === 'connected' ? 'status-connected' : s === 'failed' ? 'status-disconnected' : 'status-connecting';
            connStatusEl.innerHTML = s === 'connected' ? 'Connected' : s === 'failed' ? 'Failed' : 'Connecting...';
        }

        // Update connection info display
        const connInfo = document.getElementById('connectionInfo');
        if (connInfo) {
            connInfo.textContent = `WebRTC: ${s.toUpperCase()}`;
            connInfo.style.backgroundColor = s === 'connected' ? 'rgba(16,185,129,0.8)' : s === 'failed' ? 'rgba(239,68,68,0.8)' : 'rgba(245,158,11,0.8)';
        }

        if (s === 'connected') {
            document.querySelector('.status-badge').className = 'status-badge status-live';
            document.querySelector('.status-badge').innerHTML = 'Live';
            flushIceQueue();
            if (isInterviewer) document.getElementById('recordingPanel').style.display = 'block';
            // Reset connection attempts on success
            connectionAttempts = 0;
        } else if (s === 'failed') {
            connectionAttempts++;
            if (connectionAttempts < maxConnectionAttempts) {
                console.log('%c[WEBRTC] Connection failed, retrying... (attempt ' + connectionAttempts + ')', 'color: orange');
                updateConnectionStatus('Connection failed, retrying...');
                setTimeout(() => {
                    if (isInterviewer) createOffer();
                }, 2000);
            } else {
                updateConnectionStatus('Connection failed after ' + maxConnectionAttempts + ' attempts');
            }
        }
    };

    peerConnection.oniceconnectionstatechange = () => {
        const iceState = peerConnection.iceConnectionState;
        console.log('%c[WEBRTC] ICE connection state:', 'color: blue', iceState);

        // Update connection info with ICE state
        const connInfo = document.getElementById('connectionInfo');
        if (connInfo) {
            const currentText = connInfo.textContent.split(' | ')[0]; // Get WebRTC state part
            connInfo.textContent = `${currentText} | ICE: ${iceState.toUpperCase()}`;
        }
    };

    peerConnection.onsignalingstatechange = () => {
        console.log('%c[WEBRTC] Signaling state:', 'color: teal', peerConnection.signalingState);
    };

    startPolling();
    if (isInterviewer) {
        setTimeout(createOffer, 1500);
    } else {
        // Candidate should wait for offer, but also start polling immediately
        console.log('%c[CANDIDATE] Waiting for interviewer offer...', 'color: blue');
    }
}

/* ==================== SIGNALING ==================== */
async function sendSignal(msg) {
    const payload = { type: msg.type, sender_type: isInterviewer ? 'interviewer' : 'candidate' };
    if (msg.sdp) payload.sdp = msg.sdp;
    if (msg.candidate) payload.ice_candidate = msg.candidate;
    if (msg.text !== undefined) payload.text = msg.text || '';
    if (msg.question_id) payload.question_id = msg.question_id;

    console.log('%c[SIGNAL] Sending:', 'color: #10b981', payload);

    try {
        // safe CSRF token retrieval (won't throw if meta tag missing)
        const meta = document.querySelector('meta[name="csrf-token"]');
        const csrf = meta?.getAttribute ? meta.getAttribute('content') : (meta?.content || '');

        const headers = { 'Accept': 'application/json' };
        if (csrf) headers['X-CSRF-TOKEN'] = csrf;
        let body;
        let url;

        // For SDP keep sending raw text, but use a clearer content-type
        if (payload.type === 'offer' || payload.type === 'answer') {
            headers['Content-Type'] = 'application/sdp; charset=utf-8';
            body = payload.sdp || '';
            // include other metadata as query params so server can validate 'type' and 'sender_type'
            url = `/interview/${uniqueLink}/signaling/send?type=${encodeURIComponent(payload.type)}&sender_type=${encodeURIComponent(payload.sender_type)}`;
            console.log('%c[SDP] Sending as plain text, length:', 'color: purple', body.length);
        } else {
            headers['Content-Type'] = 'application/json; charset=utf-8';
            body = JSON.stringify(payload);
            url = `/interview/${uniqueLink}/signaling/send`;
        }

        const res = await fetch(url, {
            method: 'POST',
            headers,
            body
        });

        // resilient response parsing: try JSON, fallback to text
        let data;
        const contentType = res.headers.get('content-type') || '';
        if (contentType.includes('application/json')) {
            try {
                data = await res.json();
            } catch (je) {
                console.warn('%c[SIGNAL] Failed to parse JSON response', 'color: orange', je);
                data = { success: false, parseError: true, text: await res.text() };
            }
        } else {
            const text = await res.text();
            data = { success: res.ok, contentType, text };
        }

        console.log('%c[SIGNAL] Response:', 'color: cyan', data);
        return data;
    } catch (e) {
        console.error('%c[SIGNAL] FAILED', 'color: red', e);
        return { success: false, error: e.toString() };
    }
}

async function createOffer() {
    try {
        console.log('%c[OFFER] Creating offer...', 'color: green');
        const offer = await peerConnection.createOffer();
        await peerConnection.setLocalDescription(offer);
        logSDPLength(offer.sdp, 'INTERVIEWER SDP');
        console.log('%c[OFFER] Created & sending', 'color: green');
        sendSignal({ type: 'offer', sdp: offer.sdp });

        // Set timeout for answer
        offerTimeout = setTimeout(() => {
            console.warn('%c[OFFER] No answer received within 30 seconds', 'color: orange');
            updateConnectionStatus('No response from peer - check connection');
            if (connectionAttempts < maxConnectionAttempts) {
                connectionAttempts++;
                console.log('%c[OFFER] Retrying offer... (attempt ' + connectionAttempts + ')', 'color: orange');
                setTimeout(createOffer, 2000);
            }
        }, 30000);

    } catch (e) {
        console.error('%c[OFFER] Failed', 'color: red', e);
    }
}

async function handleOffer(msg) {
    try {
        console.log('%c[OFFER] Received id=', msg.id, 'sdp length=', (msg.sdp ? msg.sdp.length : 'MISSING'));
        // Defensive: if no SDP or it doesn't start with v=, log full message and notify server
        const sdpCandidate = msg.sdp || '';
        if (!sdpCandidate || !sdpCandidate.trim().startsWith('v=')) {
            console.error('%c[OFFER] Invalid or missing SDP in message:', 'color: red', msg);
            // Tell server for debugging (non-fatal)
            sendSignal({ type: 'offer-error', error: 'missing-or-invalid-sdp', message_id: msg.id });
            return;
        }

        console.log('%c[OFFER] pc.signalingState before setRemoteDescription:', 'color: orange', peerConnection.signalingState);

        // Use raw SDP without cleaning to avoid corruption
        await peerConnection.setRemoteDescription(new RTCSessionDescription({ type: 'offer', sdp: sdpCandidate }));
        console.log('%c[OFFER] setRemoteDescription OK, creating answer', 'color: green');

        flushIceQueue();
        const answer = await peerConnection.createAnswer();
        await peerConnection.setLocalDescription(answer);
        console.log('%c[ANSWER] Created & sending', 'color: green');
        sendSignal({ type: 'answer', sdp: answer.sdp });
    } catch (e) {
        console.error('%c[OFFER] Handle failed', 'color: red', e);
        console.error('%c[OFFER] Full message object:', 'color: red', msg);
        sendSignal({ type: 'offer-error', error: e.toString(), message_id: msg.id });
    }
}

async function handleAnswer(msg) {
    try {
        console.log('%c[ANSWER] Received id=', msg.id, 'sdp length=', msg.sdp.length);
        console.log('%c[ANSWER] pc.signalingState before setRemoteDescription:', 'color: orange', peerConnection.signalingState);

        // Use raw SDP without cleaning to avoid corruption
        await peerConnection.setRemoteDescription(new RTCSessionDescription({ type: 'answer', sdp: msg.sdp }));
        console.log('%c[ANSWER] setRemoteDescription OK', 'color: green');

        clearTimeout(offerTimeout); // Clear offer timeout
        offerTimeout = null;
        flushIceQueue();
        console.log('%c[ANSWER] Successfully processed', 'color: green');
    } catch (e) {
        console.error('%c[ANSWER] Failed', 'color: red', e);
        console.error('%c[ANSWER] SDP first 400 chars:', 'color: red', msg.sdp.substring(0, 400));
        // Send error back to candidate for debugging
        sendSignal({ type: 'answer-error', error: e.toString(), message_id: msg.id });
    }
}

async function handleIce(msg) {
    const cand = new RTCIceCandidate(msg.ice_candidate);
    if (peerConnection.remoteDescription) {
        await peerConnection.addIceCandidate(cand);
    } else {
        iceQueue.push(cand);
    }
}

/* ==================== CONNECTION STATUS ==================== */
function updateConnectionStatus(message) {
    const connInfo = document.getElementById('connectionInfo');
    if (connInfo) {
        const currentText = connInfo.textContent.split(' | ')[0]; // Keep WebRTC state
        connInfo.textContent = currentText + (message ? ` | ${message}` : '');
    }
    console.log('%c[STATUS] Updated:', 'color: blue', message);
}

function flushIceQueue() {
    while (iceQueue.length) peerConnection.addIceCandidate(iceQueue.shift()).catch(() => {});
}

/* ==================== POLLING ==================== */
function startPolling() {
    console.log('%c[POLL] Starting with adaptive frequency', 'color: purple');
    pollInterval = setInterval(poll, pollFrequency);
}

async function poll() {
    try {
        const res = await fetch(`/interview/${uniqueLink}/signaling/messages?receiver_type=${isInterviewer?'interviewer':'candidate'}&last_message_id=${lastMsgId}`);
        const data = await res.json();

        if (data.success && data.messages?.length) {
            console.log('%c[POLL] Received:', 'color: cyan', data.messages.length, 'messages');
            data.messages.forEach(m => {
                lastMsgId = Math.max(lastMsgId, m.id);
                console.log('%c[POLL] Processing message:', 'color: cyan', m.type, 'from', m.sender_type, 'id:', m.id);
                if (m.type === 'offer') handleOffer(m);
                else if (m.type === 'answer') handleAnswer(m);
                else if (m.type === 'ice-candidate') handleIce(m);
                else if (m.type === 'question') displayQuestion(m.text || '', m.question_id, m.sender_type);
            });

            // Reset polling frequency on activity
            pollFrequency = 1000;
            adjustPollingFrequency();
        } else {
            console.log('%c[POLL] No new messages', 'color: gray');
            // Increase polling frequency when idle
            pollFrequency = Math.min(pollFrequency * pollBackoff, maxPollFrequency);
            adjustPollingFrequency();
        }

        // Reset connection error status on successful poll
        const connInfo = document.getElementById('connectionInfo');
        if (connInfo && connInfo.textContent.includes('Connection Error')) {
            connInfo.textContent = connInfo.textContent.replace('Connection Error - Retrying...', 'Initializing...');
            connInfo.style.backgroundColor = 'rgba(245,158,11,0.8)';
        }

    } catch (e) {
        console.error('%c[POLL] Error', 'color: red', e);
        // Update connection info on poll error
        const connInfo = document.getElementById('connectionInfo');
        if (connInfo) {
            connInfo.textContent = 'Connection Error - Retrying...';
            connInfo.style.backgroundColor = 'rgba(239,68,68,0.8)';
        }
        // Increase polling frequency on error
        pollFrequency = Math.min(pollFrequency * pollBackoff, maxPollFrequency);
        adjustPollingFrequency();
    }
}

function adjustPollingFrequency() {
    if (pollInterval) {
        clearInterval(pollInterval);
        pollInterval = setInterval(poll, pollFrequency);
        console.log('%c[POLL] Adjusted frequency to:', 'color: purple', pollFrequency + 'ms');
    }
}

/* ==================== QUESTIONS ==================== */
function displayQuestion(text, qid, senderType) {
    console.log('%c[QUESTION] Displaying:', 'color: green', { text: text?.substring(0, 50) + '...', qid, senderType, isInterviewer, isCandidate });
    const list = document.getElementById('questionsList');

    // Check if this is an answer to an existing question
    if ((isInterviewer && senderType === 'candidate') || (isCandidate && senderType === 'interviewer')) {
        // This is an answer - find existing question item and update it
        const existingItem = list.querySelector(`[data-qid="${qid}"]`);
        if (existingItem) {
            const answerDisplay = existingItem.querySelector('.answer-display');
            if (answerDisplay) {
                if (isInterviewer) {
                    answerDisplay.innerHTML = `<strong>Candidate:</strong> ${text}`;
                } else {
                    answerDisplay.innerHTML = `<strong>Interviewer:</strong> ${text}`;
                }
                console.log('%c[ANSWER] Updated existing question', 'color: blue', qid);
            } else {
                console.warn('%c[ANSWER] Answer display not found for qid:', qid, 'color: orange');
            }
            return;
        } else {
            console.warn('%c[ANSWER] No existing question found for answer qid:', qid, 'color: orange');
        }
    }

    // This is a new question
    const item = document.createElement('div');
    item.className = 'question-item';
    item.setAttribute('data-qid', qid);
    item.innerHTML = `<div class="question-text">${text || '<em>No text</em>'}</div><div class="question-meta">Just now</div>`;

    if (isCandidate && senderType === 'interviewer') {
        item.innerHTML += `<textarea class="answer-input" placeholder="Your answer..."></textarea>
                           <button class="btn-send-answer" onclick="sendAnswer(this, ${qid})">Send</button>`;
        console.log('%c[QUESTION] Added answer input for candidate', 'color: green');
    } else if (!isCandidate && senderType === 'candidate') {
        item.innerHTML += `<div class="answer-display"><strong>Candidate:</strong> ${text}</div>`;
        console.log('%c[QUESTION] Displayed candidate answer for interviewer', 'color: green');
    } else if (!isCandidate && senderType === 'interviewer') {
        item.innerHTML += `<div class="answer-display"><em>No answer yet</em></div>`;
        console.log('%c[QUESTION] Waiting for candidate answer', 'color: green');
    }

    list.appendChild(item);
    list.scrollTop = list.scrollHeight;
    console.log('%c[QUESTION] New question displayed', 'color: green', qid);
}

function sendAnswer(button, qid) {
    console.log('%c[ANSWER] Sending answer for qid:', qid, 'color: blue');
    const item = button.closest('.question-item');
    const ta = item.querySelector('.answer-input');
    if (!ta) {
        console.error('%c[ANSWER] Textarea not found for qid:', qid, 'color: red');
        return;
    }
    const ans = ta.value.trim();
    if (!ans) {
        console.warn('%c[ANSWER] Empty answer, not sending', 'color: orange');
        return;
    }
    console.log('%c[ANSWER] Answer text:', ans.substring(0, 50) + '...', 'color: blue');
    sendSignal({ type: 'question', text: ans, question_id: qid });
    item.innerHTML = `<div class="question-text">${item.querySelector('.question-text').textContent}</div>
                      <div class="question-meta">Answered</div>
                      <div class="answer-display"><strong>You:</strong> ${ans}</div>`;
    console.log('%c[ANSWER] Sent answer for question', qid, 'color: blue');
}

document.getElementById('btnSendQuestion')?.addEventListener('click', () => {
    const input = document.getElementById('questionInput');
    const text = input.value.trim();
    if (!text) {
        console.warn('%c[QUESTION] Empty question, not sending', 'color: orange');
        return;
    }
    const qid = Date.now();
    console.log('%c[QUESTION] Sending question:', text.substring(0, 50) + '...', 'qid:', qid, 'color: green');
    displayQuestion(text, qid, 'interviewer');
    sendSignal({ type: 'question', text, question_id: qid });
    input.value = '';
});

/* ==================== CONTROLS ==================== */
document.getElementById('btnMic')?.addEventListener('click', () => {
    if (localStream) {
        localStream.getAudioTracks().forEach(t => {
            t.enabled = !t.enabled;
            console.log('%c[AUDIO] Track enabled:', 'color: blue', t.enabled);
        });
        isMicOn = !isMicOn;
        document.getElementById('btnMic').innerHTML = isMicOn ? 'Mic' : 'Mic Off';
        console.log('%c[MIC] Toggled:', 'color: blue', isMicOn ? 'ON' : 'OFF');
    }
});
document.getElementById('btnCamera')?.addEventListener('click', () => {
    if (localStream) {
        localStream.getVideoTracks().forEach(t => {
            t.enabled = !t.enabled;
            console.log('%c[VIDEO] Track enabled:', 'color: purple', t.enabled);
        });
        isCamOn = !isCamOn;
        document.getElementById('btnCamera').innerHTML = isCamOn ? 'Cam' : 'Cam Off';
        console.log('%c[CAMERA] Toggled:', 'color: purple', isCamOn ? 'ON' : 'OFF');
    }
});
document.getElementById('btnScreen')?.addEventListener('click', toggleScreenShare);
document.getElementById('btnEnd')?.addEventListener('click', () => {
    if (!confirm('End interview?')) return;
    localStream?.getTracks().forEach(t => t.stop());
    screenStream?.getTracks().forEach(t => t.stop());
    peerConnection?.close();
    clearInterval(pollInterval);
    fetch(`/interview/${uniqueLink}/signaling/clear`, { method: 'DELETE' });
    window.location.href = '/admin/interviews';
});

/* ==================== CONTROL TOGGLE ==================== */
controlsToggle?.addEventListener('click', () => {
    const isHidden = videoControls.classList.toggle('hidden');
    controlsToggle.innerHTML = isHidden ? '<i class="fas fa-eye"></i> Show Controls' : '<i class="fas fa-eye-slash"></i> Hide Controls';
    controlsToggle.title = isHidden ? 'Show Controls' : 'Hide Controls';
});

/* ==================== RESIZER (FIXED) ==================== */
const resizer = document.getElementById('resizer');
const videoSec = document.querySelector('.video-section');
let isResizing = false, startX, startWidth;

resizer?.addEventListener('mousedown', e => {
    isResizing = true;
    startX = e.clientX;
    startWidth = videoSec.offsetWidth;
    resizer.classList.add('active');
    document.body.style.cursor = 'col-resize';
    document.body.style.userSelect = 'none';
    console.log('%c[RESIZER] Started', 'color: yellow');
});

document.addEventListener('mousemove', e => {
    if (!isResizing) return;
    const delta = e.clientX - startX;
    const newWidth = Math.max(250, Math.min(startWidth + delta, window.innerWidth - 350));
    videoSec.style.flex = `0 0 ${newWidth}px`;
});

document.addEventListener('mouseup', () => {
    if (isResizing) {
        isResizing = false;
        resizer.classList.remove('active');
        document.body.style.cursor = '';
        document.body.style.userSelect = '';
        console.log('%c[RESIZER] Stopped', 'color: yellow');
    }
});

/* ==================== LAYOUT & CLOCK ==================== */
function toggleLayout() {
    const r = document.getElementById('remoteVideo');
    const o = document.querySelector('.local-video-overlay');
    if (r && o) {
        if (r.style.display !== 'none') {
            r.style.display = 'none';
            o.style.cssText = 'width:100%;height:100%;bottom:0;left:0;border:none;z-index:10;';
            console.log('%c[LAYOUT] Switched to local video fullscreen', 'color: blue');
        } else {
            r.style.display = 'block';
            o.style.cssText = 'width:200px;height:150px;bottom:20px;left:20px;border:3px solid white;z-index:10;';
            console.log('%c[LAYOUT] Switched to remote video with local overlay', 'color: blue');
        }
    }
}

setInterval(() => {
    document.getElementById('current-time').textContent = new Date().toLocaleTimeString('en-US', {
        hour12: false, hour: '2-digit', minute: '2-digit', second: '2-digit'
    });
}, 1000);

if ({{ $interview->is_started ? 'true' : 'false' }}) requestMedia();

/* ==================== START INTERVIEW ==================== */
function startInterview() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    const csrf = meta ? meta.getAttribute('content') : '';

    fetch(`{{ route('interview.start', $interview->unique_link) }}`, {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
            'X-CSRF-TOKEN': csrf,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Hide the start modal and initialize WebRTC
            document.getElementById('startModal').style.display = 'none';
            requestMedia();
        } else {
            alert('Failed to start interview. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    });
}

/* ==================== RECORDING ==================== */
let recorder = null, recordedChunks = [];
function startRecording() {
    const remote = document.getElementById('remoteVideo');
    const local = document.getElementById('localVideo');
    if (!remote.srcObject) return alert('Wait for video');

    const mixed = new MediaStream([...remote.srcObject.getTracks(), ...local.srcObject.getTracks()]);
    recorder = new MediaRecorder(mixed, { mimeType: 'video/webm;codecs=vp9' });
    recorder.ondataavailable = e => e.data.size > 0 && recordedChunks.push(e.data);
    recorder.onstop = () => {
        const blob = new Blob(recordedChunks, { type: 'video/webm' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url; a.download = `interview-${new Date().toISOString().slice(0,19).replace(/:/g,'-')}.webm`;
        a.click();
        recordedChunks = [];
        document.getElementById('btnStartRecord').classList.remove('hidden');
        document.getElementById('btnStopRecord').classList.add('hidden');
        document.getElementById('recordStatus').textContent = 'Download ready!';
    };
    recorder.start(1000);
    document.getElementById('btnStartRecord').classList.add('hidden');
    document.getElementById('btnStopRecord').classList.remove('hidden');
    document.getElementById('recordStatus').textContent = 'Recording...';
}
document.getElementById('btnStartRecord')?.addEventListener('click', startRecording);
document.getElementById('btnStopRecord')?.addEventListener('click', () => recorder?.stop());

// Enable Audio Button Handler
document.getElementById('enableAudioBtn')?.addEventListener('click', () => {
    const remoteVideo = document.getElementById('remoteVideo');
    const remoteAudio = document.getElementById('remoteAudio');
    if (remoteVideo) {
        remoteVideo.muted = false;
        remoteVideo.volume = 1.0;
        remoteVideo.play();
    }
    if (remoteAudio) {
        remoteAudio.muted = false;
        remoteAudio.volume = 1.0;
    }
    document.getElementById('enableAudioBtn').style.display = 'none';
    console.log('%c[AUDIO] Audio enabled via button click', 'color: green');
});

// Ensure local audio track is enabled
if (localStream) {
    localStream.getAudioTracks().forEach(track => {
        track.enabled = true;
        console.log('%c[AUDIO] Local audio track enabled:', 'color: blue', track.enabled);
    });
}

console.log('%c[DEBUG] FULLY LOADED – 10:23 PM IST, 10 Nov 2025', 'color: red; font-weight: bold; font-size: 18px');
</script>
</body>
</html>