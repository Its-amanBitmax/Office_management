@extends('layouts.admin')

@section('title', 'WhatsApp Bot Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fab fa-whatsapp text-success me-2"></i>
                        WhatsApp Bot Management
                    </h1>
                    <p class="text-muted mb-0">Send messages to employees and groups efficiently</p>
                </div>
                <div class="d-flex align-items-center">
                    @if($connectionStatus['status'] === 'connected' && $connectionStatus['user'])
                        <span class="badge bg-success fs-6 px-3 py-2">
                            <i class="fas fa-circle text-white me-1"></i>
                            Connected
                        </span>
                    @else
                        <span class="badge bg-warning fs-6 px-3 py-2">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            Disconnected
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Connection Status Card -->
    <div class="row mb-4">
        <div class="col-12">
            @if($connectionStatus['status'] === 'connected' && $connectionStatus['user'])
                <div class="card border-success shadow-sm">
                    <div class="card-body py-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="fab fa-whatsapp text-success fs-1 me-3"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="card-title text-success mb-1">WhatsApp Connected Successfully</h6>
                                <p class="card-text mb-0">
                                    <strong>{{ $connectionStatus['user']['name'] }}</strong>
                                    <span class="text-muted">• +{{ $connectionStatus['user']['number'] }}</span>
                                    <span class="text-muted">• {{ $connectionStatus['user']['platform'] }}</span>
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                            
                                <button class="btn btn-danger btn-sm" onclick="deleteSession()">
                                    <i class="fas fa-trash me-1"></i>
                                    Delete Session
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="card border-warning shadow-sm">
                    <div class="card-body py-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-warning fs-1 me-3"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="card-title text-warning mb-1">WhatsApp Bot Not Connected</h6>
                                <p class="card-text mb-2">Please start the WhatsApp bot and scan the QR code to connect.</p>
                                @if($qrCode)
                                    <div class="qr-code-container text-center">
                                        <p class="mb-2"><strong>Scan this QR code with WhatsApp:</strong></p>
                                        <div id="qrcode" class="d-inline-block"></div>
                                        <p class="text-muted small mt-2">QR code will refresh automatically</p>
                                    </div>
                                @else
                                    <p class="text-muted small">QR code will appear here once the bot is started...</p>
                                @endif
                            </div>
                            <div class="flex-shrink-0">
                                <button class="btn btn-danger btn-sm me-2" onclick="deleteSession()">
                                    <i class="fas fa-trash me-1"></i>
                                    Delete Session
                                </button>
                                <button class="btn btn-warning btn-sm" onclick="showConnectionInstructions()">
                                    <i class="fas fa-info-circle me-1"></i>
                                    How to Connect
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Messaging Options -->
    <div class="row">
        <!-- Individual Message -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-primary">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user me-2"></i>
                        Individual Message
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.whatsapp.send') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="employee" class="form-label fw-semibold">
                                <i class="fas fa-users me-1"></i>Select Employee (Optional)
                            </label>
                            <select class="form-select" id="employee" name="employee_id" onchange="updatePhoneNumber()">
                                <option value="">Choose an employee...</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}" data-phone="{{ $employee->phone }}">
                                        {{ $employee->name }} ({{ $employee->phone }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="number" class="form-label fw-semibold">
                                <i class="fas fa-phone me-1"></i>Phone Number
                            </label>
                            <input type="text" class="form-control" id="number" name="number" required
                                   placeholder="Enter phone number (e.g., 9876543210)">
                            <div class="form-text">Auto-filled when employee selected, but you can edit it.</div>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label fw-semibold">
                                <i class="fas fa-comment me-1"></i>Message (Optional for media)
                            </label>
                            <textarea class="form-control" id="message" name="message" rows="3"
                                      placeholder="Type your message here..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="media_file" class="form-label fw-semibold">
                                <i class="fas fa-file-upload me-1"></i>Attach Media/File (Optional)
                            </label>
                            <input type="file" class="form-control" id="media_file" name="media_file">
                            <div class="form-text">
                                <small class="text-muted">
                                    Any file type and size supported
                                </small>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-paper-plane me-2"></i>
                            Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Bulk Message -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-success">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-users me-2"></i>
                        Bulk Message
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.whatsapp.send-bulk') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="employees" class="form-label fw-semibold">
                                <i class="fas fa-users-cog me-1"></i>Select Employees (Optional)
                            </label>
                            <select class="form-select" id="employees" name="employee_ids[]" multiple
                                    style="height: 80px;" size="4" onchange="updateBulkPhoneNumbers()">
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}" data-phone="{{ $employee->phone }}">
                                        {{ $employee->name }} ({{ $employee->phone }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Hold Ctrl (Cmd on Mac) to select multiple employees
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="phoneNumbers" class="form-label fw-semibold">
                                <i class="fas fa-phone me-1"></i>Phone Numbers
                            </label>
                            <textarea class="form-control" id="phoneNumbers" name="phone_numbers" rows="3" required
                                      placeholder="Enter phone numbers, one per line (e.g., 9876543210)"></textarea>
                            <div class="form-text">Auto-filled when employees selected, but you can edit or add more.</div>
                        </div>
                        <div class="mb-3">
                            <label for="bulkMessage" class="form-label fw-semibold">
                                <i class="fas fa-comments me-1"></i>Message (Optional for media)
                            </label>
                            <textarea class="form-control" id="bulkMessage" name="message" rows="3"
                                      placeholder="Type your bulk message here..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="bulk_media_file" class="form-label fw-semibold">
                                <i class="fas fa-file-upload me-1"></i>Attach Media/File (Optional)
                            </label>
                            <input type="file" class="form-control" id="bulk_media_file" name="media_file">
                            <div class="form-text">
                                <small class="text-muted">
                                    Any file type and size supported
                                </small>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-paper-plane me-2"></i>
                            Send to Numbers
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Group Message -->
        <div class="col-lg-4 col-md-12 mb-4">
            <div class="card h-100 shadow-sm border-info">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-users-cog me-2"></i>
                        Group Message
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.whatsapp.send-group') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="group" class="form-label fw-semibold">
                                <i class="fas fa-layer-group me-1"></i>Select WhatsApp Group
                            </label>
                            <select class="form-select" id="group" name="groupId" required>
                                <option value="">Choose a group...</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group['id'] }}">
                                        {{ $group['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="groupMessage" class="form-label fw-semibold">
                                <i class="fas fa-comment-dots me-1"></i>Message (Optional for media)
                            </label>
                            <textarea class="form-control" id="groupMessage" name="message" rows="3"
                                      placeholder="Type your group message here..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="group_media_file" class="form-label fw-semibold">
                                <i class="fas fa-file-upload me-1"></i>Attach Media/File (Optional)
                            </label>
                            <input type="file" class="form-control" id="group_media_file" name="media_file">
                            <div class="form-text">
                                <small class="text-muted">
                                    Any file type and size supported
                                </small>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-info w-100">
                            <i class="fas fa-paper-plane me-2"></i>
                            Send to Group
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Instructions Card -->
    <div class="row">
        <div class="col-12">
           <div class="card shadow-sm">
    <div class="card-header bg-light">
        <h5 class="card-title mb-0">
            <i class="fas fa-info-circle me-2 text-primary"></i>
            Setup Instructions
        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6 class="text-primary mb-3">
                    <i class="fas fa-play-circle me-2"></i>
                    Getting Started
                </h6>
                <ol class="mb-0">
                    <li>Open terminal/command prompt</li>
                    <li>Navigate to project directory: <code>cd whatsapp-bot</code></li>
                    <li>Start the bot: <code>node index.js</code></li>
                    <li>Scan the QR code with WhatsApp Web</li>
                </ol>
            </div>
            <div class="col-md-6">
                <h6 class="text-success mb-3">
                    <i class="fas fa-lightbulb me-2"></i>
                    Usage Tips
                </h6>
                <ul class="mb-0">
                    <li><strong>Individual:</strong> Select employee, message auto-fills phone number</li>
                    <li><strong>Bulk:</strong> Hold Ctrl/Cmd to select multiple employees</li>
                    <li><strong>Groups:</strong> Group IDs are auto-detected from connected WhatsApp</li>
                    <li><strong>Status:</strong> Green badge = Connected, Yellow = Disconnected</li>
                </ul>
            </div>
        </div>

        <!-- ✅ IMPORTANT NOTE -->
        <hr>
        <div class="alert alert-warning mb-0 mt-3">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Important Note:</strong>
            Larger files may take more time to upload and send on WhatsApp.
            For best performance, it is recommended to use
            <strong>smaller or compressed files</strong>.
            Very large media files (especially videos) may fail due to WhatsApp Web limitations.
        </div>
    </div>
</div>

        </div>
    </div>
</div>

<!-- Connection Instructions Modal -->
<div class="modal fade" id="connectionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fab fa-whatsapp me-2 text-success"></i>
                    WhatsApp Connection Guide
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Follow these steps to connect your WhatsApp bot:
                </div>
                <ol>
                    <li>Open your terminal/command prompt</li>
                    <li>Navigate to your project directory</li>
                    <li>Go to the whatsapp-bot folder: <code>cd whatsapp-bot</code></li>
                    <li>Start the bot: <code>node index.js</code></li>
                    <li>A QR code will appear in the terminal</li>
                    <li>Open WhatsApp on your phone</li>
                    <li>Go to Settings → Linked Devices → Link a Device</li>
                    <li>Scan the QR code shown in the terminal</li>
                    <li>Wait for connection confirmation</li>
                </ol>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Important:</strong> Keep the terminal running while using the bot.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
function renderQR(base64) {
    const container = document.getElementById('qrcode');
    container.innerHTML = '';

    if (!base64) return;

    const img = document.createElement('img');
    img.src = base64;
    img.style.width = '250px';
    img.style.height = '250px';

    container.appendChild(img);
}
let statusInterval;
let qrInterval;
let groupsInterval;

function updatePhoneNumber() {
    const select = document.getElementById('employee');
    const phoneInput = document.getElementById('number');
    const selectedOption = select.options[select.selectedIndex];

    if (selectedOption.value) {
        const phone = selectedOption.getAttribute('data-phone');
        // Auto-add country code (91 for India) if not already present
        let formattedPhone = phone || '';
        if (formattedPhone && !formattedPhone.startsWith('91') && !formattedPhone.startsWith('+91')) {
            formattedPhone = '91' + formattedPhone.replace(/^\+?91/, ''); // Remove any existing +91 or 91, then add 91
        }
        phoneInput.value = formattedPhone;
    } else {
        phoneInput.value = '';
    }
}

function updateBulkPhoneNumbers() {
    const select = document.getElementById('employees');
    const phoneTextarea = document.getElementById('phoneNumbers');
    const selectedOptions = Array.from(select.selectedOptions);

    if (selectedOptions.length > 0) {
        const phoneNumbers = selectedOptions.map(option => {
            const phone = option.getAttribute('data-phone');
            // Auto-add country code (91 for India) if not already present
            let formattedPhone = phone || '';
            if (formattedPhone && !formattedPhone.startsWith('91') && !formattedPhone.startsWith('+91')) {
                formattedPhone = '91' + formattedPhone.replace(/^\+?91/, ''); // Remove any existing +91 or 91, then add 91
            }
            return formattedPhone;
        }).filter(phone => phone); // Remove empty phones

        // Get existing phone numbers from textarea
        const existingPhones = phoneTextarea.value.split('\n').map(p => p.trim()).filter(p => p);

        // Combine existing and selected phones, remove duplicates
        const allPhones = [...new Set([...existingPhones, ...phoneNumbers])];

        phoneTextarea.value = allPhones.join('\n');
    }
}

function showConnectionInstructions() {
    const modal = new bootstrap.Modal(document.getElementById('connectionModal'));
    modal.show();
}

function startBot() {
    const button = event.target;
    const originalText = button.innerHTML;
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Starting...';

    fetch('{{ route("admin.whatsapp.start-bot") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-success alert-dismissible fade show shadow-sm';
            alertDiv.innerHTML = '<i class="fas fa-check-circle me-2"></i>' + data.message +
                '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
            document.querySelector('.container-fluid').insertBefore(alertDiv, document.querySelector('.row.mb-4'));

            // Auto-hide after 5 seconds
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alertDiv);
                bsAlert.close();
            }, 5000);
        } else {
            // Show error message
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-danger alert-dismissible fade show shadow-sm';
            alertDiv.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>' + data.message +
                '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
            document.querySelector('.container-fluid').insertBefore(alertDiv, document.querySelector('.row.mb-4'));

            // Auto-hide after 5 seconds
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alertDiv);
                bsAlert.close();
            }, 5000);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger alert-dismissible fade show shadow-sm';
        alertDiv.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>Failed to start bot. Please try again.' +
            '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
        document.querySelector('.container-fluid').insertBefore(alertDiv, document.querySelector('.row.mb-4'));

        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alertDiv);
            bsAlert.close();
        }, 5000);
    })
    .finally(() => {
        button.disabled = false;
        button.innerHTML = originalText;
    });
}

function deleteSession() {
    if (!confirm('Are you sure you want to disconnect WhatsApp and delete the session? This will log out the current user and delete all session data. You will need to scan the QR code again to reconnect.')) {
        return;
    }

    const button = event.target;
    const originalText = button.innerHTML;
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Deleting...';

    fetch('{{ route("admin.whatsapp.delete-session") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-success alert-dismissible fade show shadow-sm';
            alertDiv.innerHTML = '<i class="fas fa-check-circle me-2"></i>' + data.message +
                '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
            document.querySelector('.container-fluid').insertBefore(alertDiv, document.querySelector('.row.mb-4'));

            // Auto-hide after 5 seconds
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alertDiv);
                bsAlert.close();
            }, 5000);

            // Refresh the page after a short delay to update the status
            setTimeout(() => {
                location.reload();
            }, 2000);
        } else {
            // Show error message
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-danger alert-dismissible fade show shadow-sm';
            alertDiv.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>' + data.message +
                '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
            document.querySelector('.container-fluid').insertBefore(alertDiv, document.querySelector('.row.mb-4'));

            // Auto-hide after 5 seconds
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alertDiv);
                bsAlert.close();
            }, 5000);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger alert-dismissible fade show shadow-sm';
        alertDiv.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>Failed to delete session. Please try again.' +
            '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
        document.querySelector('.container-fluid').insertBefore(alertDiv, document.querySelector('.row.mb-4'));

        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alertDiv);
            bsAlert.close();
        }, 5000);
    })
    .finally(() => {
        button.disabled = false;
        button.innerHTML = originalText;
    });
}

// AJAX functions for auto-refresh
function updateConnectionStatus() {
    fetch('{{ route("admin.whatsapp.status") }}')
        .then(response => response.json())
        .then(data => {
            const statusBadge = document.querySelector('.d-flex.align-items-center .badge');
            const connectionCard = document.querySelector('.card.border-success, .card.border-warning');

            if (data.status === 'connected' && data.user) {
                // Update to connected state
                statusBadge.className = 'badge bg-success fs-6 px-3 py-2';
                statusBadge.innerHTML = '<i class="fas fa-circle text-white me-1"></i>Connected';

                connectionCard.className = 'card border-success shadow-sm';
                connectionCard.innerHTML = `
                    <div class="card-body py-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="fab fa-whatsapp text-success fs-1 me-3"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="card-title text-success mb-1">WhatsApp Connected Successfully</h6>
                                <p class="card-text mb-0">
                                    <strong>${data.user.name}</strong>
                                    <span class="text-muted">• +${data.user.number}</span>
                                    <span class="text-muted">• ${data.user.platform}</span>
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                <button class="btn btn-danger btn-sm" onclick="deleteSession()">
                                    <i class="fas fa-trash me-1"></i>
                                    Delete Session
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            } else {
                // Update to disconnected state
                statusBadge.className = 'badge bg-warning fs-6 px-3 py-2';
                statusBadge.innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i>Disconnected';

                connectionCard.className = 'card border-warning shadow-sm';
                connectionCard.innerHTML = `
                    <div class="card-body py-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-warning fs-1 me-3"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="card-title text-warning mb-1">WhatsApp Bot Not Connected</h6>
                                <p class="card-text mb-2">Please start the WhatsApp bot and scan the QR code to connect.</p>
                                <div class="qr-code-container text-center">
                                    <p class="mb-2"><strong>Scan this QR code with WhatsApp:</strong></p>
                                    <div id="qrcode" class="d-inline-block"></div>
                                    <p class="text-muted small mt-2">QR code will refresh automatically</p>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <button class="btn btn-danger btn-sm me-2" onclick="deleteSession()">
                                    <i class="fas fa-trash me-1"></i>
                                    Delete Session
                                </button>
                                <button class="btn btn-warning btn-sm" onclick="showConnectionInstructions()">
                                    <i class="fas fa-info-circle me-1"></i>
                                    How to Connect
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            }
        })
        .catch(error => console.error('Error updating status:', error));
}

function updateQrCode() {
    fetch('{{ route("admin.whatsapp.qr-code") }}')
        .then(response => response.json())
        .then(data => {
            if (data.qr) {
                renderQR(data.qr);
            }
        })
        .catch(error => console.error('Error updating QR code:', error));
}

function updateGroups() {
    fetch('{{ route("admin.whatsapp.groups-data") }}')
        .then(response => response.json())
        .then(data => {
            const groupSelect = document.getElementById('group');
            if (groupSelect && Array.isArray(data)) {
                // Store the currently selected value
                const selectedValue = groupSelect.value;

                // Clear existing options except the first one
                while (groupSelect.options.length > 1) {
                    groupSelect.remove(1);
                }

                // Add new groups
                data.forEach(group => {
                    const option = document.createElement('option');
                    option.value = group.id;
                    option.textContent = group.name;
                    groupSelect.appendChild(option);
                });

                // Restore the selected value if it still exists in the options
                if (selectedValue && groupSelect.querySelector(`option[value="${selectedValue}"]`)) {
                    groupSelect.value = selectedValue;
                }
            }
        })
        .catch(error => console.error('Error updating groups:', error));
}

function startAutoRefresh() {
    // Update status every 1 second
    statusInterval = setInterval(updateConnectionStatus, 1000);

    // Update QR code every 1 second
    qrInterval = setInterval(updateQrCode, 5000);

    // Update groups every 1 second
    groupsInterval = setInterval(updateGroups, 1000);
}

function stopAutoRefresh() {
    if (statusInterval) clearInterval(statusInterval);
    if (qrInterval) clearInterval(qrInterval);
    if (groupsInterval) clearInterval(groupsInterval);
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Generate initial QR code if available
    @if($qrCode)
    const qrCodeData = '{{ $qrCode }}';
    if (qrCodeData && document.getElementById('qrcode')) {
        renderQR(qrCodeData);
    }
    @endif

    // Start auto-refresh
    startAutoRefresh();

    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
});

// Stop auto-refresh when page is unloaded
window.addEventListener('beforeunload', function() {
    stopAutoRefresh();
});
</script>
@endsection
