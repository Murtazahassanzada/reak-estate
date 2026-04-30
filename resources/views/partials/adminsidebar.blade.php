<div class="admin-sidebar">

    <!-- ================= LOGO ================= -->
    <div class="sidebar-header text-center">

        <img src="{{ asset('assets/image/LOGO.png') }}" class="sidebar-logo">

        <h6 class="mt-2 mb-0"{{ __('admin.meta.title') }}</h6>
        <small class="text-muted"{{ __('admin.meta.subtitle') }}</small>>

    </div>

    <!-- ================= MENU ================= -->
    <ul class="sidebar-menu">

        <li>
            <a href="{{ route('admin.dashboard') }}"
               class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge-high"></i>
              <span>{{ __('admin.sidebar.dashboard') }}</span>
            </a>
        </li>

        <li>
            <a href="{{ route('properties.index') }}"
               class="{{ request()->routeIs('properties.*') ? 'active' : '' }}">
                <i class="fa-solid fa-building"></i>
               <span>{{ __('admin.sidebar.properties') }}</span>
            </a>
        </li>

        <li>
            <a href="{{ route('users.index') }}"
               class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i>
             <span>{{ __('admin.sidebar.users') }}</span>

            </a>
        </li>

        <li>
            <a href="{{ route('admin.report') }}"
               class="{{ request()->routeIs('admin.report') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-line"></i>
               <span>{{ __('admin.sidebar.reports') }}</span>
            </a>
        </li>

    </ul>

</div>