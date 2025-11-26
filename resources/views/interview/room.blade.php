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
        .header{background:rgba(255,255,255,.95);backdrop-filter:blur(10px);border-radius:var(--border-radius);padding:20px;margin-bottom:20px;box-shadow:var(--shadow);display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;}
        .header-left h1{font-size:24px;font-weight:700;color:var(--gray-900);margin-bottom:4px;}
        .header-left p{color:var(--gray-600);font-size:14px;}
        .debug-info{font-size:10px;color:var(--gray-500);margin-top:4px;}
        .status-badge{padding:6px 12px;border-radius:20px;font-size:12px;font-weight:600;text-transform:uppercase;}
        .status-live{background:var(--success);color:#fff;}
        .status-waiting{background:var(--warning);color:#fff;}
        .time-display{background:var(--gray-100);color:var(--gray-700);padding:6px 12px;border-radius:20px;font-size:12px;font-weight:600;}
        .main-content{display:flex;height:calc(100vh - 140px);}
        .video-section{flex:0 0 400px;background:rgba(255,255,255,.95);backdrop-filter:blur(10px);border-radius:var(--border-radius);padding:20px;box-shadow:var(--shadow);display:flex;flex-direction:column;position:relative;min-width:0;}
        .resizer{width:5px;height:100%;background:transparent;cursor:col-resize;flex-shrink:0;position:relative;}
        .resizer:hover,.resizer.active{background:var(--primary);}
        .sidebar{flex:1;min-width:300px;overflow-y:auto;scrollbar-width:none;}
        .sidebar::-webkit-scrollbar{display:none;}
        .video-container{flex:1;background:var(--gray-900);border-radius:8px;position:relative;overflow:hidden;display:flex;align-items:center;justify-content:center;min-height:220px;}
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
        /* Responsive styles for mobile */
        @media (max-width: 1024px) {
            .main-content{flex-direction:column;height:auto;}
            .video-section{flex:none;height:auto;width:100%;min-width:0;}
            .sidebar{order:-1;width:100%;min-width:0;}
            .video-container{min-height:220px;}
        }
        @media (max-width: 600px) {
            .container{padding:8px;}
            .header{flex-direction:column;align-items:flex-start;padding:12px;}
            .main-content{flex-direction:column;height:auto;}
            .video-section{padding:8px;width:100%;min-width:0;}
            .sidebar{padding:0 2px;width:100%;min-width:0;}
            .video-container{min-height:180px;}
            #localVideo{width:90px !important;height:68px !important;bottom:10px !important;left:10px !important;}
            .video-controls{flex-wrap:wrap;gap:8px;padding:8px 6px;bottom:10px;}
            .panel{margin-bottom:10px;}
            .panel-content{padding:10px;}
            .question-input{min-height:60px;}
            .questions-list{max-height:200px;}
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
                <video id="remoteVideo" autoplay playsinline style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px; display: none;"></video>
                <audio id="remoteAudio" autoplay></audio>
                <video id="localVideo" autoplay muted playsinline style="position: absolute; bottom: 20px; left: 20px; width: 200px; height: 150px; border-radius: 8px; border: 3px solid #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.3); z-index: 10; cursor: pointer;"></video>
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
                <!-- Fullscreen Button -->
                <button class="control-btn" id="btnFullscreen" title="Fullscreen"><i class="fas fa-expand"></i></button>
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
<button class="btn btn-primary" id="btnAllowMedia">Allow</button>
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

<script src="https://cdn.socket.io/4.6.1/socket.io.min.js"></script>
<script>
/* ==================== CONFIG ==================== */
const isInterviewer = {{ $is_interviewer ? 'true' : 'false' }};
const isCandidate   = {{ $is_candidate ? 'true' : 'false' }};
const uniqueLink    = "{{ $interview->unique_link }}";

let localStream = null;
let peerConnection = null;
let isMicOn = false;
let isCamOn = false;

/* ==================== SOCKET.IO CLIENT ==================== */
const socket = io("https://socket.bitmaxgroup.com", {
    secure: true,
    withCredentials: false,
    transports: ["websocket"]
});



socket.on('connect', () => {
    console.log('Connected to socket.io server');
    socket.emit('joinRoom', {
        room: 'interview.' + uniqueLink
    });
});

socket.on('SignalingMessageBroadcast', (data) => {
    console.log('[Socket.io] Received signaling message:', data);
    if (data.type === 'offer') handleOffer(data);
    else if (data.type === 'answer' && data.sdp) handleAnswer(data);
    else if (data.type === 'ice-candidate') handleIce(data);
    else if (data.type === 'question') displayQuestion(data.text || '', data.question_id, data.sender_type);
    else if (data.type === 'answer' && data.text) displayAnswer(data.text, data.question_id, data.sender_type);
});

// Listen for force-end event from socket server
socket.on('force-end', function(data) {
    // Clean up media and connection on both sides
    try {
        if (peerConnection) {
            peerConnection.close();
            peerConnection = null;
        }
        if (localStream) {
            localStream.getTracks().forEach(track => track.stop());
            localStream = null;
        }
    } catch (e) {}
    // Always redirect, even if already on end screen
    if (window.location.href !== 'https://www.bitmaxgroup.com/') {
        window.location.replace('https://www.bitmaxgroup.com/');
    }
});

function sendSignal(msg) {
    console.log('[Socket.io] Sending signaling message:', msg);
    socket.emit('SignalingMessageBroadcast', msg);
}

/* ==================== MEDIA ==================== */
    window.requestMedia = async function requestMedia(retryCount = 0) {
        console.log('%c[MEDIA] Requesting access... (attempt ' + (retryCount + 1) + ')', 'color: #10b981');
        try {
            localStream = await navigator.mediaDevices.getUserMedia({
                video: { width: 1920, height: 1080, frameRate: 30, facingMode: 'user' },
                audio: { echoCancellation: true, noiseSuppression: true, autoGainControl: true }
            });
            isMicOn = isCamOn = true;

        // Attach local stream to localVideo element for preview
        const localVideo = document.getElementById('localVideo');
        if (localVideo) {
            localVideo.srcObject = localStream;
            localVideo.style.display = 'block';
        }

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
            setTimeout(() => window.requestMedia(retryCount + 1), 2000);
        } else {
            alert('Camera & mic access failed after 3 attempts. Please check permissions and refresh the page.');
            // Still initialize WebRTC for signaling even without media
            initWebRTC();
        }
    }
}

/* ==================== WEBRTC ==================== */
    function initWebRTC() {
        console.log('[WebRTC] Initializing');
    
        const config = {
            iceServers: [
                { urls: 'stun:stun.l.google.com:19302' },
                {
                    urls: 'turn:socket.bitmaxgroup.com:3478',
                    username: 'webrtcuser',
                    credential: 'StrongPass@123'
                }
            ]
        };
    
        peerConnection = new RTCPeerConnection(config);
    
        // Add all tracks from localStream to peer connection
        if (localStream) {
            localStream.getTracks().forEach(track => {
                const sender = peerConnection.addTrack(track, localStream);
                // Attempt to set max bitrate on video track sender
                if (track.kind === 'video' && sender.setParameters) {
                    const parameters = sender.getParameters();
                    if (!parameters.encodings) parameters.encodings = [{}];
                    parameters.encodings[0].maxBitrate = 2500000; // 2.5 Mbps
                    sender.setParameters(parameters).then(() => {
                        console.log('[WebRTC] Max bitrate set to 2.5 Mbps on video sender');
                    }).catch(err => {
                        console.warn('[WebRTC] Failed to set max bitrate:', err);
                    });
                }
            });
        }
    
        peerConnection.onicecandidate = event => {
            if (event.candidate) {
                sendSignal({
                    type: 'ice-candidate',
                    candidate: event.candidate
                });
            }
        };
    
        peerConnection.onconnectionstatechange = () => {
            console.log('[WebRTC] Connection state change:', peerConnection.connectionState);
            const connStatus = document.getElementById('connStatus');
            if (!connStatus) return;
            if (peerConnection.connectionState === 'connected') {
                connStatus.textContent = 'Connected';
                connStatus.className = 'connection-status status-connected';
            } else if (peerConnection.connectionState === 'connecting') {
                connStatus.textContent = 'Connecting...';
                connStatus.className = 'connection-status status-connecting';
            } else if (peerConnection.connectionState === 'disconnected' || peerConnection.connectionState === 'failed') {
                connStatus.textContent = 'Disconnected';
                connStatus.className = 'connection-status status-disconnected';
            }
        };
    
        peerConnection.ontrack = event => {
            console.log('[WebRTC] Remote track received');
            const remoteVideo = document.getElementById('remoteVideo');
            const remoteAudio = document.getElementById('remoteAudio');
            const placeholder = document.querySelector('.video-placeholder');
            const connectionInfo = document.getElementById('connectionInfo');
            if (remoteVideo.srcObject !== event.streams[0]) {
                remoteVideo.srcObject = event.streams[0];
                remoteVideo.style.display = 'block';
                remoteAudio.srcObject = event.streams[0];
                remoteAudio.style.display = 'block';
                if (placeholder) {
                    placeholder.style.display = 'none';
                    console.log('[WebRTC] Hiding video placeholder');
                }
                if (connectionInfo) {
                    connectionInfo.style.display = 'none';
                    console.log('[WebRTC] Hiding connection info');
                }
            }
        };
    
        // Create and send offer if interviewer
        if (isInterviewer) {
            peerConnection.onnegotiationneeded = async () => {
                try {
                    const offer = await peerConnection.createOffer();
                    await peerConnection.setLocalDescription(offer);
                    sendSignal({
                        type: 'offer',
                        sdp: peerConnection.localDescription
                    });
                } catch (error) {
                    console.error('[WebRTC] Error during negotiation:', error);
                }
            };
        }
    }

async function handleOffer(data) {
    if (!peerConnection) {
        initWebRTC();
    }
    try {
        console.log('[WebRTC] Handling offer');
        await peerConnection.setRemoteDescription(new RTCSessionDescription(data.sdp));
        const answer = await peerConnection.createAnswer();
        await peerConnection.setLocalDescription(answer);
        sendSignal({
            type: 'answer',
            sdp: peerConnection.localDescription
        });
    } catch (error) {
        console.error('[WebRTC] Error handling offer:', error);
    }
}

async function handleAnswer(data) {
    try {
        console.log('[WebRTC] Handling answer');
        await peerConnection.setRemoteDescription(new RTCSessionDescription(data.sdp));
    } catch (error) {
        console.error('[WebRTC] Error handling answer:', error);
    }
}

async function handleIce(data) {
    try {
        console.log('[WebRTC] Adding ICE candidate');
        if (peerConnection && data.candidate) {
            // Only add ICE candidate if remote description is set
            if (peerConnection.remoteDescription && peerConnection.remoteDescription.type) {
                await peerConnection.addIceCandidate(new RTCIceCandidate(data.candidate));
            } else {
                console.warn('[WebRTC] Skipped ICE candidate: remoteDescription not set yet');
            }
        }
    } catch (error) {
        console.error('[WebRTC] Error adding ICE candidate:', error);
    }
}

document.addEventListener('DOMContentLoaded', () => {
  const btnAllowMedia = document.getElementById('btnAllowMedia');
  btnAllowMedia?.addEventListener('click', requestMedia);

  if ({{ $interview->is_started ? 'true' : 'false' }}) {
    requestMedia();
  }
});
    // Chat send question handler
    document.getElementById('btnSendQuestion')?.addEventListener('click', () => {
        const questionInput = document.getElementById('questionInput');
        if (!questionInput) {
            console.error('[Chat] Question input not found');
            return;
        }
        const questionText = questionInput.value.trim();
        if (!questionText) {
            console.warn('[Chat] Empty question text, ignoring send');
            return;
        }
        console.log('[Chat] Sending question:', questionText);
        const questionId = 'q_' + Date.now() + '_' + Math.floor(Math.random() * 1000);
        const senderType = isInterviewer ? 'interviewer' : 'candidate';
        sendSignal({
            type: 'question',
            question_id: questionId,
            text: questionText,
            sender_type: senderType
        });
        questionInput.value = '';
        displayQuestion(questionText, questionId, senderType);
    });

    // Display question in questions list
    function displayQuestion(text, questionId, senderType) {
        console.log('[Chat] Displaying question:', {text, questionId, senderType});
        const questionsList = document.getElementById('questionsList');
        if (!questionsList) {
            console.error('[Chat] Questions list element not found');
            return;
        }
        const questionDiv = document.createElement('div');
        questionDiv.className = 'question-item';
        questionDiv.id = questionId;

        const questionTextDiv = document.createElement('div');
        questionTextDiv.className = 'question-text';
        questionTextDiv.textContent = text;

        const questionMetaDiv = document.createElement('div');
        questionMetaDiv.className = 'question-meta';
        const timeString = new Date().toLocaleTimeString();
        questionMetaDiv.textContent = `${senderType} @ ${timeString}`;

        questionDiv.appendChild(questionTextDiv);
        questionDiv.appendChild(questionMetaDiv);

        // Add answer textarea and send button only for candidates
        if (isCandidate) {
            const answerInput = document.createElement('textarea');
            answerInput.className = 'answer-input';
            answerInput.placeholder = 'Type your answer...';
            answerInput.rows = 3;

            const sendAnswerBtn = document.createElement('button');
            sendAnswerBtn.className = 'btn-send-answer';
            sendAnswerBtn.textContent = 'Send Answer';

            // Track if answer is already sent for this question
            const sentAnswers = new Set();

            sendAnswerBtn.addEventListener('click', () => {
                if (sentAnswers.has(questionId)) {
                    console.warn('[Chat] Answer already sent for this question:', questionId);
                    alert('You can only send one answer per question.');
                    return;
                }
                const answerText = answerInput.value.trim();
                if (!answerText) {
                    console.warn('[Chat] Empty answer text, ignoring send');
                    return;
                }
                console.log('[Chat] Sending answer:', answerText, 'for question:', questionId);
                sendSignal({
                    type: 'answer',
                    question_id: questionId,
                    text: answerText,
                    sender_type: 'candidate'
                });
                displayAnswer(answerText, questionId, 'candidate');
                answerInput.value = '';
                sentAnswers.add(questionId);
                // Disable input UI to prevent further editing/sending
                answerInput.disabled = true;
                sendAnswerBtn.disabled = true;
                // Hide input and button after send
                answerInput.style.display = 'none';
                sendAnswerBtn.style.display = 'none';
            });

            questionDiv.appendChild(answerInput);
            questionDiv.appendChild(sendAnswerBtn);
        }

        questionsList.appendChild(questionDiv);
        questionsList.scrollTop = questionsList.scrollHeight;
    }

    // Display answer under question
    function displayAnswer(text, questionId, senderType) {
        console.log('[Chat] Displaying answer:', {text, questionId, senderType});
        const questionDiv = document.getElementById(questionId);
        if (!questionDiv) {
            console.error('[Chat] Question div not found for answer display:', questionId);
            return;
        }

        const answerDiv = document.createElement('div');
        answerDiv.className = 'answer-display';
        const timeString = new Date().toLocaleTimeString();
        answerDiv.textContent = `${senderType} @ ${timeString}: ${text}`;

        questionDiv.appendChild(answerDiv);
    }

    // Video section resizer logic
    (function() {
        const resizer = document.getElementById('resizer');
        const videoSection = document.querySelector('.video-section');
        const sidebar = document.querySelector('.sidebar');

        if (!(resizer && videoSection && sidebar)) {
            console.error('[Resizer] Important elements missing, cannot initialize resizer');
            return;
        }

        let startX, startWidth;

        const minWidth = 200;
        const maxWidth = 800;

        const onMouseMove = (e) => {
            const dx = e.clientX - startX;
            let newWidth = startWidth + dx;
            if (newWidth < minWidth) newWidth = minWidth;
            if (newWidth > maxWidth) newWidth = maxWidth;
            videoSection.style.flex = `0 0 ${newWidth}px`;
            sidebar.style.flex = `1 1 calc(100% - ${newWidth}px - 5px)`;
            console.log(`[Resizer] Resizing: ${newWidth}px`);
        };

        const onMouseUp = (e) => {
            console.log('[Resizer] Resize stopped');
            document.removeEventListener('mousemove', onMouseMove);
            document.removeEventListener('mouseup', onMouseUp);
        };

        resizer.addEventListener('mousedown', (e) => {
            console.log('[Resizer] Resize started');
            startX = e.clientX;
            startWidth = videoSection.getBoundingClientRect().width;
            document.addEventListener('mousemove', onMouseMove);
            document.addEventListener('mouseup', onMouseUp);
        });
    })();

    // Video control buttons handlers
    (function() {
        const btnMic = document.getElementById('btnMic');
        const btnCamera = document.getElementById('btnCamera');
        const btnScreen = document.getElementById('btnScreen');
        const btnEnd = document.getElementById('btnEnd');

        // Add controls toggle button logic
        const controlsToggle = document.getElementById('controlsToggle');
        const videoControls = document.getElementById('videoControls');
        if (controlsToggle && videoControls) {
            controlsToggle.addEventListener('click', () => {
                const isHidden = videoControls.classList.toggle('hidden');
                console.log(`[Video Controls] Toggled video controls visibility: ${isHidden ? 'Hidden' : 'Visible'}`);
            });
        } else {
            console.warn('[Video Controls] controlsToggle or videoControls element missing');
        }

        if (!btnMic || !btnCamera || !btnScreen || !btnEnd) {
            console.error('[Video Controls] Missing one or more control buttons');
            return;
        }

        btnMic.addEventListener('click', () => {
            if (!localStream) {
                console.warn('[Video Controls] No local stream to toggle mic');
                return;
            }
            isMicOn = !isMicOn;
            localStream.getAudioTracks().forEach(track => track.enabled = isMicOn);
            console.log(`[Video Controls] Mic toggled: ${isMicOn ? 'On' : 'Off'}`);
            btnMic.classList.toggle('btn-mic', isMicOn);
            btnMic.classList.toggle('btn-mic-off', !isMicOn);
        });

        btnCamera.addEventListener('click', () => {
            if (!localStream) {
                console.warn('[Video Controls] No local stream to toggle camera');
                return;
            }
            isCamOn = !isCamOn;
            localStream.getVideoTracks().forEach(track => track.enabled = isCamOn);
            console.log(`[Video Controls] Camera toggled: ${isCamOn ? 'On' : 'Off'}`);
            btnCamera.classList.toggle('btn-camera', isCamOn);
            btnCamera.classList.toggle('btn-camera-off', !isCamOn);
        });

        btnScreen.addEventListener('click', async () => {
            console.log('[Video Controls] Screen share button clicked');
            if (peerConnection) {
                try {
                    const screenStream = await navigator.mediaDevices.getDisplayMedia({ video: true });
                    const screenTrack = screenStream.getVideoTracks()[0];

                    const sender = peerConnection.getSenders().find(s => s.track.kind === 'video');
                    if (sender) {
                        await sender.replaceTrack(screenTrack);
                        console.log('[Video Controls] Replaced video track with screen track');
                    }

                    screenTrack.onended = async () => {
                        console.log('[Video Controls] Screen sharing ended, reverting to camera');
                        if (localStream) {
                            const cameraTrack = localStream.getVideoTracks()[0];
                            if (sender && cameraTrack) {
                                await sender.replaceTrack(cameraTrack);
                                console.log('[Video Controls] Reverted to camera video track');
                            }
                        }
                    };
                } catch (err) {
                    console.error('[Video Controls] Failed to start screen sharing:', err);
                }
            } else {
                console.warn('[Video Controls] No peer connection for screen sharing');
            }
        });

      btnEnd.addEventListener('click', async () => {
    console.log('[Video Controls] End interview button clicked');

    // ✅ STOP MEDIA & CONNECTION
    if (peerConnection) {
        peerConnection.close();
        peerConnection = null;
    }
    if (localStream) {
        localStream.getTracks().forEach(track => track.stop());
        localStream = null;
    }

    // ✅ CALL BACKEND TO DISABLE LINK
    try {
        await fetch("{{ route('interview.end', $interview->unique_link) }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        });
        // Notify all in room via socket.io (for instant force-end)
        socket.emit('force-end', { room: 'interview.' + uniqueLink });
    } catch (e) {
        console.error('Failed to update interview status', e);
    }
    // Clean up local media and connection immediately
    try {
        if (peerConnection) {
            peerConnection.close();
            peerConnection = null;
        }
        if (localStream) {
            localStream.getTracks().forEach(track => track.stop());
            localStream = null;
        }
    } catch (e) {}
    // Always redirect, even if already on end screen
    if (window.location.href !== 'https://www.bitmaxgroup.com/') {
        window.location.replace('https://www.bitmaxgroup.com/');
    }
});

    })();

    // Add this function to handle the interviewer starting the interview
    function startInterview() {
        fetch("{{ route('interview.start', $interview->unique_link) }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Optionally hide the modal or reload the page to update UI
                const startModal = document.getElementById('startModal');
                if (startModal) startModal.style.display = 'none';
                location.reload();
            } else {
                alert('Failed to start interview. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error starting interview:', error);
            alert('An error occurred. Please try again.');
        });
    }

    // Fullscreen logic
document.getElementById('btnFullscreen')?.addEventListener('click', function() {
    const videoSection = document.querySelector('.video-section');
    if (!videoSection) return;
    if (document.fullscreenElement) {
        document.exitFullscreen();
    } else {
        if (videoSection.requestFullscreen) {
            videoSection.requestFullscreen();
        } else if (videoSection.webkitRequestFullscreen) { /* Safari */
            videoSection.webkitRequestFullscreen();
        } else if (videoSection.msRequestFullscreen) { /* IE11 */
            videoSection.msRequestFullscreen();
        }
    }
});
</script>
</body>
</html>
