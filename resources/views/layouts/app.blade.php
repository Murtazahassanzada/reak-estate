<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"
      dir="{{ app()->getLocale() == 'fa' ? 'rtl' : 'ltr' }}">

<head>
<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>@yield('title', __('site.meta.title'))</title>

{{-- BOOTSTRAP --}}
@if(app()->getLocale() == 'fa')
<link href="{{ asset('assets/bootstrap/css/bootstrap.rtl.min.css') }}" rel="stylesheet">
@else
<link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
@endif

{{-- ICONS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">

{{-- MAIN STYLE --}}
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

<style>
body {
    background:#f8f9fa;
}

body[dir="rtl"] {
    text-align:right;
}

main {
    min-height:70vh;
}

.navbar-toggler {
    border:none;
}

.navbar-toggler-icon {
    filter:invert(1);
}
</style>

@stack('styles')
</head>

<body>

{{-- ================= NAVBAR ================= --}}
@include('partials.header-master')

{{-- ================= MAIN ================= --}}
<main class="py-2">
    @yield('content')
</main>

{{-- ================= FOOTER ================= --}}
@include('partials.footer')

{{-- ================= SCRIPTS ================= --}}
<script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>

@stack('scripts')

{{-- ================= REALTIME (ECHO) ================= --}}
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<script>
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
 key: "{{ config('broadcasting.connections.reverb.key') }}",
    wsHost: window.location.hostname,
    wsPort: 8080,
    forceTLS: false,
    disableStats: true,
});

let userId = {!! auth()->check() ? auth()->id() : 'null' !!};

if(userId){

    Echo.private(`user.${userId}`)
    .listen('.notification.created', (e) => {

        console.log('NOTIFICATION:', e);

        // ================= BADGE =================
        let badge = document.getElementById('notif-count');

        if (badge) {
            badge.innerText = e.unreadCount;

            if (e.unreadCount > 0) {
                badge.style.display = 'inline-block';
            } else {
                badge.style.display = 'none';
            }
        }

        // ================= DROPDOWN =================
        let list = document.getElementById('notifList');

        if (list) {
            list.innerHTML =
            `<div class="border-bottom p-2">
                <strong>${e.notification.title}</strong><br>
                <small>${e.notification.body}</small>
            </div>` + list.innerHTML;
        }

        // ================= SOUND =================
        let sound = document.getElementById('notifSound');
        if (sound) sound.play();

        // ================= TOAST =================
        let toastBox = document.getElementById('toastBox');

        if (toastBox) {
            toastBox.innerHTML =
            `<div style="
                background:#198754;
                color:#fff;
                padding:12px 16px;
                margin-bottom:10px;
                border-radius:8px;
                min-width:250px;
                box-shadow:0 5px 15px rgba(0,0,0,0.2);
            ">
                🔔 ${e.notification.title}
            </div>` + toastBox.innerHTML;
        }

    });
}
</script>

{{-- ================= AUDIO ================= --}}
<audio id="notifSound" src="{{ asset('assets/sounds/notification.mp3') }}"></audio>

{{-- ================= TOAST BOX ================= --}}
<div id="toastBox" style="
position:fixed;
top:20px;
right:20px;
z-index:9999;
"></div>
<div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">

    <div class="modal-content">

      <div class="modal-header">
       <h5 class="modal-title">
    {{ app()->getLocale() == 'fa'
        ? 'تأیید خروج'
        : __('site.auth.logout_confirm') }}
</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center">
        <p>
            {{ app()->getLocale() == 'fa'
                ? 'آیا مطمئن هستید که می‌خواهید از سیستم خارج شوید؟'
                : 'Are you sure you want to logout?' }}
        </p>
      </div>

      <div class="modal-footer justify-content-center">

         <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
        {{ app()->getLocale() == 'fa'
            ? 'انصراف'
            : __('site.actions.cancel') }}
    </button>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger">
            {{ in_array(app()->getLocale(), ['fa','ar'])
                ? 'بله، خروج'
                : __('site.actions.logout') }}
        </button>
        </form>

      </div>

    </div>

  </div>
</div>
</body>
</html>
