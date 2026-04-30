@extends('layouts.app')

@section('content')

<div class="container my-5">

    <h3 class="mb-4">📥 Inbox</h3>

    <!-- Tabs -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#messages">
                📩 Messages
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#notifications">
                🔔 Notifications
            </button>
        </li>
    </ul>

    <div class="tab-content">

        <!-- ================= MESSAGES ================= -->
        <div class="tab-pane fade show active" id="messages">

            @forelse($messages ?? [] as $msg)
                <div class="card mb-3 shadow-sm p-3">

                    <strong>From:</strong> {{ $msg->sender->name ?? '-' }} <br>
                    <strong>Property:</strong> {{ $msg->property->title ?? '-' }} <br>

                    <p class="mt-2">{{ $msg->message }}</p>

                </div>
            @empty
                <p class="text-muted">No messages yet</p>
            @endforelse

        </div>

        <!-- ================= NOTIFICATIONS ================= -->
        <div class="tab-pane fade" id="notifications" id="notif-box">

            @forelse($notifications ?? [] as $noti)
                <div class="card mb-3 p-3 shadow-sm notification-item {{ $noti->is_read ? '' : 'border-primary' }}">

                    <strong>{{ $noti->title }}</strong>

                    <p class="mb-2">{{ $noti->body }}</p>

                    @if(!$noti->is_read)
                        <button
                            class="btn btn-sm btn-outline-primary mark-read-btn"
                            data-id="{{ $noti->id }}">
                            Mark as read
                        </button>
                    @endif

                </div>
            @empty
                <p class="text-muted">No notifications</p>
            @endforelse

        </div>

    </div>

</div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ================= MARK SINGLE =================
    document.querySelectorAll('.mark-read-btn').forEach(btn => {

        btn.addEventListener('click', function () {

            let id = this.dataset.id;
            let card = this.closest('.card');

            fetch(`/notification/${id}/read-ajax`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {

                if (data.success) {

                    card.classList.remove('border-primary');
                    this.remove();

                    updateBadge(data.unread);
                }

            });

        });

    });

    // ================= AUTO REFRESH =================
    function loadNotifications() {

        fetch('/notifications/fetch')
        .then(res => res.json())
        .then(data => {
            updateBadge(data.unread);
        });

    }

    setInterval(loadNotifications, 8000);

    // ================= BADGE =================
    function updateBadge(count) {

        let badge = document.getElementById('notif-count');

        if (!badge) return;

        badge.innerText = count;

        if (count > 0) {
            badge.style.display = 'inline-block';
        } else {
            badge.style.display = 'none';
        }
    }

});
</script>
@endpush
@endsection
