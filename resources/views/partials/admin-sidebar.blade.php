<aside class="col-md-2 sidebar">
  <ul class="nav flex-column">

    <li class="nav-item">
      <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}"
         href="{{ url('/dashboard') }}">
        <i class="fa-solid fa-gauge-high"></i> Dashboard
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link {{ request()->is('admin/properties*') ? 'active' : '' }}"
        href="{{ route('properties.index') }}">
        <i class="fa-solid fa-building"></i> Property Management
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}"
        href="{{ route('users.index') }}">
        <i class="fa-solid fa-users"></i> Users
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link {{ request()->is('admin/report*') ? 'active' : '' }}"
         href="{{ url('/admin/report') }}">
        <i class="fa-solid fa-chart-line"></i> Reports
      </a>
    </li>
<li class="nav-item">
  <a href="#" class="nav-link text-danger" id="logoutBtn">
    <i class="fa-solid fa-right-from-bracket"></i>
    Logout
  </a>
</li>

<form method="POST" action="{{ route('admin.logout') }}">
  @csrf
  <div class="modal fade" id="logoutModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title">Confirm Logout</h5>
          <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          Are you sure you want to logout?
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Logout</button>
        </div>

      </div>
    </div>
  </div>
</form>



</aside>
