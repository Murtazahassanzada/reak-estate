<nav class="navbar navbar-expand-lg dashboard-navbar">
  <div class="container">

    <!-- LOGO -->
    <a class="navbar-brand d-flex align-items-center" href="{{ url('/dashboard') }}">
      <img src="{{ asset('assets/image/LOGO.png') }}" class="dashboard-logo" alt="Logo">
      <span class="brand-text ms-2">REAL ESTATE</span>
    </a>

    <!-- MOBILE BUTTON -->
    <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#mainMenu"
            aria-controls="mainMenu"
            aria-expanded="false"
            aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- MENU -->
    <div class="collapse navbar-collapse" id="mainMenu">

      <!-- ✅ وسط واقعی -->
      <ul class="navbar-nav mx-auto gap-4">

        <li class="nav-item">
          <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}"
             href="{{ url('/dashboard') }}">
            <i class="fa-solid fa-gauge-high"></i> Dashboard
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link {{ request()->is('about') ? 'active' : '' }}"
             href="{{ url('/about') }}">
            <i class="fa-solid fa-circle-info"></i> About
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link {{ request()->is('contact') ? 'active' : '' }}"
             href="{{ url('/contact') }}">
            <i class="fa-solid fa-phone"></i> Contact
          </a>
        </li>

      </ul>

      <!-- RIGHT SIDE -->
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link login-link" href="{{ url('/login') }}">
            <i class="fa-solid fa-right-to-bracket"></i> Login
          </a>
        </li>
      </ul>

    </div>
  </div>
</nav>
