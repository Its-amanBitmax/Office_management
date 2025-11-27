@extends('layouts.admin')

@section('title', 'All Notifications')

@section('page-title', 'All Notifications')
@section('page-description', 'Your recent notifications')

@section('content')
<div class="container">
    @if($notifications->count())
    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-sm btn-primary" onclick="markAllAsRead()">
            <i class="fas fa-check-double"></i> Mark All as Read
        </button>
    </div>
@endif

    <div class="row">
        <div class="col-12">
            

            @if($notifications->count())
                <div class="list-group">

                    @foreach($notifications as $notification)
                        <div class="list-group-item d-flex justify-content-between align-items-start"
                             style="{{ $notification->is_read ? '' : 'background:#f8f9fa;' }}"
                             id="notification-{{ $notification->id }}">

                            <div class="me-3">
                                <strong>{{ $notification->title }}</strong>
                                <div style="font-size:0.95em;">
                                    {{ $notification->message }}
                                </div>
                            </div>

                            <div class="text-end">
                                <div style="font-size:0.85em; color:#888;">
                                    {{ $notification->created_at->diffForHumans() }}
                                </div>

                                <button class="btn btn-sm btn-danger mt-1"
                                    onclick="deleteNotification({{ $notification->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

                        </div>
                    @endforeach

                </div>

                <div class="mt-3">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    No notifications found.
                </div>
            @endif

        </div>
    </div>
</div>
<script>
window.deleteNotification = function(id) {

    if (!confirm('Are you sure you want to delete this notification?')) {
        return;
    }

    fetch(`/admin/notifications/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById(`notification-${id}`).remove();
        } else {
            alert('Unable to delete notification');
        }
    })
    .catch(err => console.error(err));
};
</script>
<script>
function markAllAsRead() {
    if (!confirm('Mark all notifications as read?')) {
        return;
    }

    fetch("{{ route('admin.notifications.markAllRead') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {

            // ✅ UI update without refresh
            document.querySelectorAll('.list-group-item').forEach(el => {
                el.style.background = 'transparent';
            });

            // ✅ Header count reset
            const countEl = document.getElementById('admin-notification-count');
            if (countEl) countEl.style.display = 'none';

        }
    });
}
</script>
<script src="https://cdn.tailwindcss.com"></script>

@endsection
