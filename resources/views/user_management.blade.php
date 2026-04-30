@extends('layouts.user')

@section('title', __('user_management.title'))


@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/User Management.css') }}">
@endpush


@section('content')

<!-- HEADER -->
<header class="admin-header">
<div class="d-flex align-items-center header-brand">

  <img alt="Logo"
       class="dashboard-logo"
       src="{{ asset('assets/image/lOGO.png') }}"/>

  <span class="brand-text">
    {{ __('user_management.reports') }}
  </span>

</div>

<a href="{{ route('admin.dashboard') }}" class="btn dashboard-back-btn btn-sm">
    <i class="bi bi-arrow-left"></i>
    {{ __('user_management.back_dashboard') }}
</a>
</header>

<section class="container mt-5">
  <div class="property-card">

    <div class="card-header-custom">
      <h5><i class="bi bi-people"></i> {{ __('user_management.users_list') }}</h5>
    </div>

    <div class="table-responsive">

      <!-- FILTER -->
      <form method="GET" action="{{ route('users.index') }}"
            class="mb-3 d-flex gap-2 flex-wrap">

        <input type="text"
               name="search"
               class="form-control w-25"
               placeholder="{{ __('user_management.search') }}"
               value="{{ request('search') }}">

        <select name="role" class="form-select w-25">
            <option value="">{{ __('user_management.all_roles') }}</option>
            <option value="Admin" {{ request('role') == 'Admin' ? 'selected' : '' }}>
                {{ __('user_management.admin') }}
            </option>
            <option value="User" {{ request('role') == 'User' ? 'selected' : '' }}>
                {{ __('user_management.user') }}
            </option>
        </select>

        <select name="status" class="form-select w-25">
            <option value="">{{ __('user_management.all_status') }}</option>
            <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>
                {{ __('user_management.active') }}
            </option>
            <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>
                {{ __('user_management.inactive') }}
            </option>
        </select>

        <button class="btn btn-primary">
          {{ __('user_management.filter') }}
        </button>

      </form>

      <!-- TABLE -->
      <table class="table align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>{{ __('user_management.user') }}</th>
            <th>{{ __('user_management.email') }}</th>
            <th>{{ __('user_management.role') }}</th>
            <th>{{ __('user_management.status') }}</th>
            <th class="text-center">{{ __('user_management.action') }}</th>
          </tr>
        </thead>

        <tbody>
        @forelse($users as $user)

        <tr>
            <td>{{ $loop->iteration }}</td>

            <td class="d-flex align-items-center gap-2">
                <img src="{{ asset('assets/image/2.jpg') }}" class="prop-img">
                <span>{{ $user->name }}</span>
            </td>

            <td>{{ $user->email }}</td>

            <td>
                <span class="badge bg-primary">
                  {{ $user->role ?? __('user_management.user') }}
                </span>
            </td>

            <td>
                <span class="badge {{ $user->status == 'Active' ? 'bg-success' : 'bg-secondary' }}">
                  {{ $user->status ?? __('user_management.active') }}
                </span>
            </td>

            <td class="text-center">

                <button class="btn btn-sm btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#editUserModal{{ $user->id }}">
                    {{ __('user_management.edit') }}
                </button>

                <button class="btn btn-sm btn-danger"
                        data-bs-toggle="modal"
                        data-bs-target="#deleteUserModal{{ $user->id }}">
                    {{ __('user_management.delete') }}
                </button>

            </td>
        </tr>

        @empty
        <tr>
          <td colspan="6" class="text-center text-muted">
            {{ __('user_management.empty') }}
          </td>
        </tr>
        @endforelse
        </tbody>
      </table>

      <div class="mt-3 d-flex justify-content-center">
        {{ $users->links() }}
      </div>

    </div>

  </div>
</section>

{{-- EDIT MODALS --}}
@foreach($users as $user)
<div class="modal fade" id="editUserModal{{ $user->id }}">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header bg-primary text-white">
        <h5>{{ __('user_management.edit_user') }}</h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="modal-body">

          <div class="mb-3">
            <label>{{ __('user_management.name') }}</label>
            <input type="text" name="name"
                   class="form-control"
                   value="{{ $user->name }}" required>
          </div>

          <div class="mb-3">
            <label>{{ __('user_management.email') }}</label>
            <input type="email" name="email"
                   class="form-control"
                   value="{{ $user->email }}" required>
          </div>

          <div class="mb-3">
            <label>{{ __('user_management.password_optional') }}</label>
            <input type="password" name="password"
                   class="form-control">
          </div>

        </div>

        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">
            {{ __('user_management.cancel') }}
          </button>
          <button type="submit" class="btn btn-primary">
            {{ __('user_management.save') }}
          </button>
        </div>

      </form>

    </div>
  </div>
</div>
@endforeach

{{-- DELETE MODALS --}}
@foreach($users as $user)
<div class="modal fade" id="deleteUserModal{{ $user->id }}">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header bg-danger text-white">
        <h5>{{ __('user_management.delete_user') }}</h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <form action="{{ route('users.destroy', $user->id) }}" method="POST">
        @csrf
        @method('DELETE')

        <div class="modal-body text-center">
          <p>
            {{ __('user_management.delete_confirm') }}
            <strong>{{ $user->name }}</strong> ?
          </p>
        </div>

        <div class="modal-footer justify-content-center">
          <button class="btn btn-secondary" data-bs-dismiss="modal">
            {{ __('user_management.cancel') }}
          </button>
          <button type="submit" class="btn btn-danger">
            {{ __('user_management.yes_delete') }}
          </button>
        </div>

      </form>

    </div>
  </div>
</div>
@endforeach

@push('scripts')
<script src="{{ asset('assets/js/User Management.js') }}"></script>
@endpush

@endsection
