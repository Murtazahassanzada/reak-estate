@extends('layouts.admin')

@section('title', __('admin.dashboard.title'))

@section('content')

<div class="row text-center">
    <div class="col-md-3 mb-3">
        <div class="card stat-card p-4 d-flex justify-content-center align-items-center">
            <h3 class="mb-2">{{ $totalProperties }}</h3>
            <p class="mb-0">{{ __('admin.dashboard.properties') }}</p>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card p-4 d-flex justify-content-center align-items-center">
            <h3 class="mb-2">{{ $totalUsers }}</h3>
            <p class="mb-0">{{ __('admin.dashboard.users') }}</p>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card p-4 d-flex justify-content-center align-items-center">
            <h3 class="mb-2">{{ $totalReports }}</h3>
            <p class="mb-0">{{ __('admin.dashboard.reports') }}</p>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card p-4 d-flex justify-content-center align-items-center">
            <h3 class="mb-2">{{ $totalContacts }}</h3>
            {{-- اینجا قبلاً Contacts بود --}}
            <p class="mb-0">{{ __('admin.dashboard.messages') }}</p>
        </div>
    </div>
</div>

<div class="card mt-5 shadow-sm">
  <div class="card-header bg-success text-white fw-bold">
    {{ __('admin.table.title') }}
  </div>
  <div class="card-body">
    <table class="table table-hover align-middle">
      <thead>
        <tr>
          <th>#</th>
          <th>{{ __('admin.table.name') }}</th>
          <th>{{ __('admin.table.type') }}</th>
          <th>{{ __('admin.table.price') }}</th>
          <th>{{ __('admin.table.actions') }}</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>Duplex House</td>
          <td>Residential</td>
          <td>$120,000</td>
          <td>
            <button class="btn btn-sm btn-primary">
              {{ __('admin.actions.edit') }}
            </button>
            <button class="btn btn-sm btn-danger">
              {{ __('admin.actions.delete') }}
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

@endsection
