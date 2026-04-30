@php
    $isAdminPage = request()->is('admin/*');
@endphp

<nav class="navbar navbar-expand-lg dashboard-navbar">
  <div class="container position-relative">

    <!-- LOGO -->
    <a class="navbar-brand logo-box" href="{{ url('/') }}">
      <img src="{{ asset('assets/image/LOGO.png') }}" class="dashboard-logo">

      <span class="brand-text">
        @auth
            @if(strtolower(trim(auth()->user()->role)) === 'user')
                {{ __('user.panel.name') }}
            @else
                {{ __('site.brand.name') }}
            @endif
        @else
           {{ __('site.brand.name') ?? 'Real Estate' }}
        @endauth
      </span>
    </a>

    <!-- MOBILE -->
    @if(!$isAdminPage)
    <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#mainMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    @endif

    <div class="collapse navbar-collapse" id="mainMenu">

      <!-- ================= CENTER ================= -->
      @if(!$isAdminPage)
      <ul class="navbar-nav mx-auto gap-4 center-menu">

        {{-- ================= GUEST ================= --}}
        @guest
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
        @endguest

        {{-- ================= AUTH ================= --}}
        @auth
            @php
                $role = strtolower(trim(auth()->user()->role));
            @endphp

            {{-- ADMIN --}}
            @if($role === 'admin')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                       href="{{ route('admin.dashboard') }}">
                        <i class="fa-solid fa-gauge-high"></i>
                        {{ __('admin.sidebar.dashboard') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('properties.*') ? 'active' : '' }}"
                       href="{{ route('properties.index') }}">
                        <i class="fa-solid fa-building"></i>
                        {{ __('admin.sidebar.properties') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}"
                       href="{{ route('users.index') }}">
                        <i class="fa-solid fa-users"></i>
                        {{ __('admin.sidebar.users') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.report') ? 'active' : '' }}"
                       href="{{ route('admin.report') }}">
                        <i class="fa-solid fa-chart-line"></i>
                        {{ __('admin.sidebar.reports') }}
                    </a>
                </li>

            {{-- USER --}}
            @else
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.properties') ? 'active' : '' }}"
                       href="{{ route('user.panel') }}">
                        <i class="fa-solid fa-house"></i>
                        {{ __('user.menu.properties') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                       href="{{ route('dashboard') }}">
                        <i class="fa-solid fa-gauge-high"></i>
                        {{ __('user.menu.dashboard') }}
                    </a>
                </li>
            @endif
        @endauth

      </ul>
      @endif

      <!-- ================= RIGHT ================= -->
      <ul class="navbar-nav ms-auto align-items-center">

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

        {{-- AUTH ONLY --}}
        @auth
        <li class="nav-item">
            <button type="button"
                    class="nav-link border-0 bg-transparent"
                    data-bs-toggle="modal"
                    data-bs-target="#logoutModal">
                <i class="fa-solid fa-right-from-bracket"></i>
             {{ __('site.actions.logout') }}
            </button>
        </li>
        @endauth

        {{-- GUEST LOGIN (فقط خارج admin) --}}
        @if(!$isAdminPage && auth()->guest())
        <li class="nav-item">
          <a class="nav-link login-link" href="{{ url('/login') }}">
            <i class="fa-solid fa-right-to-bracket"></i>
            {{ __('site.auth.login') }}
          </a>
        </li>
        @endif

        <!-- LANG -->
        <li class="nav-item">
          <a class="nav-link {{ app()->getLocale() == 'fa' ? 'active' : '' }}"
             href="{{ route('lang','fa') }}">FA</a>
        </li>

        <li class="nav-item">
          <a class="nav-link {{ app()->getLocale() == 'en' ? 'active' : '' }}"
             href="{{ route('lang','en') }}">EN</a>
        </li>

      </ul>

    </div>
  </div>
</nav>