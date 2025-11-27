@extends('layouts.employee')

@section('title', 'Notifications')

@section('content')


<div class="card">
     <button onclick="markAllEmployeeRead()"
            class="flex items-center gap-2 px-4 py-2 text-sm
                   font-semibold text-white bg-blue-600
                   rounded-md hover:bg-blue-700 transition">
            <i class="fas fa-check-double"></i>
            Mark All as Read
        </button>
    <div class="card-body">

        @forelse($notifications as $notification)
            <div class="p-3 mb-2 border rounded {{ $notification->is_read ? '' : 'bg-light' }}">
                <strong>{{ $notification->title }}</strong>
                <p class="mb-1">{{ $notification->message }}</p>
                <small class="text-muted">
                    {{ $notification->created_at->diffForHumans() }}
                </small>
            </div>
        @empty
            <p class="text-center text-muted mb-0">
                No notifications found
            </p>
        @endforelse

    </div>
</div>

<script>
function markAllEmployeeRead() {
    if (!confirm('Mark all notifications as read?')) return;

    fetch("{{ route('employee.notifications.readAll') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document
                .querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document
                .querySelectorAll('[id^="notification-"]')
                .forEach(el => el.classList.remove('bg-gray-50'));
        }
    });
}
</script>
<script src="https://cdn.tailwindcss.com"></script>
@endsection
