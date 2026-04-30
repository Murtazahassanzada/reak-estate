{{-- ================= GUEST MENU ================= --}}

{{-- CENTER MENU --}}
<li class="nav-item">
    <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}"
       href="{{ url('/dashboard') }}">
        <i class="fa-solid fa-gauge-high"></i>
        {{ __('site.nav.dashboard') }}
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->is('about') ? 'active' : '' }}"
       href="{{ url('/about') }}">
        <i class="fa-solid fa-circle-info"></i>
        {{ __('site.nav.about') }}
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->is('contact') ? 'active' : '' }}"
       href="{{ url('/contact') }}">
        <i class="fa-solid fa-phone"></i>
        {{ __('site.nav.contact') }}
    </a>
</li>
{{-- 🔔 Notification --}}
<li class="nav-item me-3 position-relative">
  <a href="{{ auth()->check() ? route('inbox') : route('login') }}"
     class="nav-link position-relative">

    <i class="fa-solid fa-bell"></i>

    @auth
    <span id="notif-count"
          class="badge bg-danger position-absolute top-0 start-100 translate-middle"
          style="{{ ($unreadNotifications ?? 0) == 0 ? 'display:none' : '' }}">
        {{ $unreadNotifications ?? 0 }}
    </span>
    @endauth

  </a>
</li>

{{-- LOGIN (Guest only) --}}
@guest
<li class="nav-item">
  <a class="nav-link login-link" href="{{ url('/login') }}">
    <i class="fa-solid fa-right-to-bracket"></i>
    {{ __('site.auth.login') }}
  </a>
</li>
@endguest

{{-- LOGOUT --}}
@auth
<li class="nav-item">
<button type="button"
        class="nav-link border-0 bg-transparent"
        data-bs-toggle="modal"
        data-bs-target="#logoutModal">
    <i class="fa-solid fa-right-from-bracket"></i>
    Logout
</button>
</li>
@endauth

{{-- LANGUAGE --}}
<li class="nav-item">
  <a class="nav-link {{ app()->getLocale() == 'fa' ? 'active' : '' }}"
     href="{{ route('lang','fa') }}">FA</a>
</li>

<li class="nav-item">
  <a class="nav-link {{ app()->getLocale() == 'en' ? 'active' : '' }}"
     href="{{ route('lang','en') }}">EN</a>
</li>