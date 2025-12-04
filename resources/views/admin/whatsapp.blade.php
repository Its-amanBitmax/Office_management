@extends('layouts.admin')

@section('title', 'WhatsApp Bot Management')

@section('content')
<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">
                WhatsApp Bot Management
            </h1>
            <p class="text-muted mb-0">Send messages to employees and groups instantly</p>
        </div>
        <span id="statusBadge" class="badge bg-warning fs-5 px-4 py-2">
            Checking...
        </span>
    </div>

    <!-- Connection Card -->
    <div class="card shadow-sm mb-4" id="connectionCard">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-1 text-center">
                    <i id="statusIcon" class="fas fa-exclamation-triangle text-warning fs-1"></i>
                </div>
                <div class="col-md-7">
                    <h5 id="statusTitle" class="mb-1 text-warning">WhatsApp Bot Not Connected</h5>
                    <p id="statusText" class="mb-0 text-muted">
                        Please scan the QR code below to connect your WhatsApp account.
                    </p>
                </div>
                <div class="col-md-4 text-md-end">
                    <button onclick="deleteSession()" class="btn btn-danger btn-sm">
                        New QR
                    </button>
                </div>
            </div>

            <!-- QR Code -->
            <div id="qrSection" class="text-center mt-4" style="display:none;">
                <div class="d-inline-block p-5 bg-white rounded-4 shadow-lg">
                    <div id="qrcode">
                        <div class="text-muted">
                            <i class="fas fa-spinner fa-spin fa-4x mb-4"></i>
                            <p class="fs-5">Loading QR Code...</p>
                        </div>
                    </div>
                    <p class="mt-4 text-success fw-bold fs-5">
                        Open WhatsApp → Settings → Linked Devices → Link a Device
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Messaging Cards -->
    <div class="row g-4">
        <!-- Individual Message -->
        <div class="col-lg-4">
            <div class="card h-100 shadow border-0">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h5 class="mb-0">Individual Message</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ url('admin/whatsapp/send') }}" method="POST" enctype="multipart/form-data" class="sendForm">
                        @csrf
                        <div class="mb-3">
                            <select class="form-select" id="employee" onchange="updatePhoneNumber()">
                                <option value="">Manual Number</option>
                                @foreach($employees as $e)
                                    <option value="{{ $e->id }}" data-phone="{{ $e->phone }}">
                                        {{ $e->name }} ({{ $e->phone }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="number" name="number" required placeholder="917065170513" value="">
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" name="message" rows="3" placeholder="Your message (optional if media)"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Attach Media (Image/Video/PDF/Document)</label>
                            <input type="file" class="form-control" name="media_file">
                            <input type="text" class="form-control mt-2" name="caption" placeholder="Caption for media (optional)">
                            <small class="text-muted">Any file supported • Max 200MB</small>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Bulk Message -->
        <div class="col-lg-4">
            <div class="card h-100 shadow border-0">
                <div class="card-header bg-success text-white text-center py-3">
                    <h5 class="mb-0">Bulk Message</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ url('admin/whatsapp/send-bulk') }}" method="POST" enctype="multipart/form-data" class="sendForm">
                        @csrf
                        <div class="mb-3">
                            <textarea class="form-control" name="phone_numbers" rows="6" required placeholder="917065170513&#10;919876543210&#10;One number per line"></textarea>
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" name="message" rows="3" placeholder="Message for all"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Attach Media (Optional)</label>
                            <input type="file" class="form-control" name="media_file">
                            <input type="text" class="form-control mt-2" name="caption" placeholder="Caption for bulk media">
                        </div>
                        <button type="submit" class="btn btn-success w-100 py-3 fw-bold">
                            Send to All
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Group Message -->
        <div class="col-lg-4">
            <div class="card h-100 shadow border-0">
                <div class="card-header bg-info text-white text-center py-3">
                    <h5 class="mb-0">Group Message</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ url('admin/whatsapp/send-group') }}" method="POST" enctype="multipart/form-data" class="sendForm">
                        @csrf
                        <div class="mb-3">
                            <select class="form-select" id="group" name="groupId" required>
                                <option value="">Loading groups...</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" name="message" rows="3" placeholder="Message for group"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Attach Media (Optional)</label>
                            <input type="file" class="form-control" name="media_file">
                            <input type="text" class="form-control mt-2" name="caption" placeholder="Caption for group media">
                        </div>
                        <button type="submit" class="btn btn-info w-100 py-3 fw-bold text-white">
                            Send to Group
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Tips -->
    <div class="card mt-5 shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">Quick Tips</h5>
        </div>
        <div class="card-body text-center">
            <div class="row">
                <div class="col-md-4"><p><strong>Individual:</strong> Select employee → number auto fill</p></div>
                <div class="col-md-4"><p><strong>Bulk:</strong> Paste numbers (one per line)</p></div>
                <div class="col-md-4"><p><strong>Groups:</strong> Auto detected after connection</p></div>
            </div>
        </div>
    </div>
</div>

<script>
// Config
const BOT_URL = 'https://bot.bitmaxgroup.com';
const API_KEY = 'SECRET123';
let isConnected = false;
let lastQR = null;

// API Helper
function api(path, opts = {}) {
    return fetch(`${BOT_URL}${path}?t=${Date.now()}`, {
        ...opts,
        cache: 'no-store',
        headers: {
            'x-api-key': API_KEY,
            'Content-Type': 'application/json',
            ...(opts.headers || {})
        }
    });
}

// Render QR
function renderQR(qr) {
    if (!qr || qr === lastQR) return;
    lastQR = qr;
    document.getElementById('qrcode').innerHTML = 
        `<img src="${qr}" class="img-fluid rounded shadow" style="max-width:300px; border: 8px solid #25d366;">`;
}

// Update Everything
async function refreshAll() {
    try {
        const res = await api('/status');
        const data = await res.json();

        const badge = document.getElementById('statusBadge');
        const icon = document.getElementById('statusIcon');
        const title = document.getElementById('statusTitle');
        const text = document.getElementById('statusText');
        const qrSec = document.getElementById('qrSection');

        if (data.status === 'connected' && data.user) {
            isConnected = true;
            const u = data.user;
            const name = u.name || u.pushname || 'User';
            const num = u.number || u.wid?.user || 'Unknown';

            badge.className = 'badge bg-success fs-5 px-4 py-2';
            badge.innerHTML = 'Connected';

            icon.className = 'fab fa-whatsapp text-success fs-1';
            title.className = 'text-success';
            title.innerText = 'Connected Successfully';
            text.innerHTML = `<strong>${name}</strong> • +${num}`;
            qrSec.style.display = 'none';

            // Load Groups
            const g = await api('/groups');
            const groups = await g.json();
            const select = document.getElementById('group');
            select.innerHTML = '<option value="">Select Group</option>';
            groups.forEach(g => {
                select.innerHTML += `<option value="${g.id}">${g.name}</option>`;
            });

        } else {
            isConnected = false;
            badge.className = 'badge bg-warning fs-5 px-4 py-2';
            badge.innerHTML = 'Not Connected';

            icon.className = 'fas fa-qrcode text-warning fs-1';
            title.className = 'text-warning';
            title.innerText = 'Scan QR Code to Connect';
            text.innerHTML = 'Open WhatsApp → Linked Devices → Link a Device';
            qrSec.style.display = 'block';

            const qrRes = await api('/qr');
            const qrData = await qrRes.json();
            if (qrData.qr) renderQR(qrData.qr);
        }
    } catch (e) { console.error(e); }
}

// Delete Session
async function deleteSession() {
    if (!confirm('New QR generate karna hai?')) return;
    await api('/delete-session', {method: 'POST'});
    alert('New QR ready!');
    setTimeout(() => location.reload(), 1500);
}

// Auto fill number
function updatePhoneNumber() {
    const sel = document.getElementById('employee');
    const phone = sel.selectedOptions[0]?.dataset.phone || '';
    if (phone) {
        document.getElementById('number').value = phone.startsWith('91') ? phone : '91' + phone;
    }
}

// Auto format numbers before submit
document.querySelectorAll('.sendForm').forEach(form => {
    form.addEventListener('submit', function() {
        // Individual number
        const numInput = this.querySelector('input[name="number"]');
        if (numInput) {
            let val = numInput.value.replace(/\D/g, '');
            if (val && !val.startsWith('91')) val = '91' + val;
            numInput.value = val;
        }

        // Bulk numbers
        const bulkInput = this.querySelector('textarea[name="phone_numbers"]');
        if (bulkInput) {
            const lines = bulkInput.value.split('\n').map(l => {
                let n = l.replace(/\D/g, '');
                if (n && !n.startsWith('91')) n = '91' + n;
                return n;
            });
            bulkInput.value = lines.join('\n');
        }
    });
});

// Start
document.addEventListener('DOMContentLoaded', () => {
    refreshAll();
    setInterval(refreshAll, 60000);
});
</script>

@endsection