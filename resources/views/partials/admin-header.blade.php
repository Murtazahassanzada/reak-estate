<nav class="navbar navbar-dark bg-success px-4 d-flex align-items-center">

    <!-- LEFT -->
    <div class="d-flex align-items-center flex-shrink-0">

        <img
            src="{{ asset('assets/image/LOGO.png') }}"
            class="dashboard-logo {{ app()->getLocale() == 'fa' ? 'ms-2' : 'me-2' }}"
        >

        <span class="text-white fw-bold">
            {{ __('admin.header.brand') }}
        </span>

    </div>

    <!-- CENTER (FIXED CENTER) -->
    <ul class="navbar-nav flex-row gap-3 position-absolute start-50 translate-middle-x">

        @auth
            @if(auth()->user()->role === 'admin')

                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                       href="{{ route('admin.dashboard') }}">
                        <i class="fa-solid fa-gauge-high"></i>
                        {{ __('admin.sidebar.dashboard') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('properties.*') ? 'active' : '' }}"
                       href="{{ route('properties.index') }}">
                        <i class="fa-solid fa-building"></i>
                        {{ __('admin.sidebar.properties') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('users.*') ? 'active' : '' }}"
                       href="{{ route('users.index') }}">
                        <i class="fa-solid fa-users"></i>
                        {{ __('admin.sidebar.users') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('admin.report') ? 'active' : '' }}"
                       href="{{ route('admin.report') }}">
                        <i class="fa-solid fa-chart-line"></i>
                        {{ __('admin.sidebar.reports') }}
                    </a>
                </li>

            @endif
        @endauth

    </ul>

    <!-- RIGHT -->
    <div class="d-flex align-items-center flex-shrink-0 ms-auto">

        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf

            <button class="btn btn-link text-white text-decoration-none d-flex align-items-center gap-2 p-0 logout-btn">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>{{ __('admin.sidebar.logout') }}</span>
            </button>

        </form>

    </div>

</nav>