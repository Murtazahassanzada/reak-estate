@extends('layouts.user')
@section('title','User Management')
@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/User Management.css') }}">
@endpush

<!-- HEADER -->
<header class="admin-header">
  <div>
    <img alt="Logo" class="dashboard-logo" src="../assets/image/lOGO.png"/>
    <!--<h4>REMS Admin</h4>
    <small>User Management</small>-->
    <span class="brand-text">User Reports</span>
  </div>
  <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm">
    <i class="bi bi-arrow-left"></i> Back to Dashboard
  </a>
</header>

<section class="container mt-5">
  <div class="property-card">

    <div class="card-header-custom">
      <h5><i class="bi bi-people"></i> Users List</h5>
    </div>

    <div class="table-responsive">
        <form method="GET" action="{{ route('users.index') }}"
      class="mb-3 d-flex gap-2 flex-wrap">

    <input type="text"
           name="search"
           class="form-control w-25"
           placeholder="Search name or email..."
           value="{{ request('search') }}">

    <select name="role" class="form-select w-25">
        <option value="">All Roles</option>
        <option value="Admin" {{ request('role') == 'Admin' ? 'selected' : '' }}>
            Admin
        </option>
        <option value="User" {{ request('role') == 'User' ? 'selected' : '' }}>
            User
        </option>
    </select>

    <select name="status" class="form-select w-25">
        <option value="">All Status</option>
        <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>
            Active
        </option>
        <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>
            Inactive
        </option>
    </select>

    <button class="btn btn-primary">Filter</button>

</form>
      <table class="table align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>User</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th class="text-center">Action</th>
          </tr>
        </thead>

     <tbody>
@foreach($users as $user)
<tr>
    <td>{{ $loop->iteration }}</td>

    <td class="d-flex align-items-center gap-2">
        <img src="{{ asset('assets/image/2.jpg') }}" class="prop-img">
        <span>{{ $user->name }}</span>
    </td>

    <td>{{ $user->email }}</td>

    <td>
        <span class="badge bg-primary">User</span>
    </td>

    <td>
        <span class="badge bg-success">Active</span>
    </td>

    <td class="text-center">

        <!-- Edit Button -->
        <button class="btn btn-sm btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#editUserModal{{ $user->id }}">
            Edit
        </button>

        <!-- Delete Button -->
        <button class="btn btn-sm btn-danger"
                data-bs-toggle="modal"
                data-bs-target="#deleteUserModal{{ $user->id }}">
            Delete
        </button>

    </td>
</tr>
@endforeach
</tbody>

      </table>
      <div class="mt-3 d-flex justify-content-center">
    {{ $users->links() }}
</div>
    </div>

  </div>
</section>
@foreach($users as $user)

<div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Edit User</h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="modal-body">

          <div class="mb-3">
            <label>User Name</label>
            <input type="text" name="name"
                   class="form-control"
                   value="{{ $user->name }}" required>
          </div>

          <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email"
                   class="form-control"
                   value="{{ $user->email }}" required>
          </div>

          <div class="mb-3">
            <label>New Password (optional)</label>
            <input type="password" name="password"
                   class="form-control">
          </div>

        </div>

        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>

      </form>

    </div>
  </div>
</div>

@endforeach
@foreach($users as $user)

<div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Delete User</h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <form action="{{ route('users.destroy', $user->id) }}" method="POST">
        @csrf
        @method('DELETE')

        <div class="modal-body text-center">
          <p>Are you sure you want to delete <strong>{{ $user->name }}</strong> ?</p>
        </div>

        <div class="modal-footer justify-content-center">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Yes Delete</button>
        </div>

      </form>

    </div>
  </div>
</div>

@endforeach
<!--Model-->


@push('scripts')
<script src="{{ asset('assets/js/User Management.js') }}"></script>
@endpush


@endsection
