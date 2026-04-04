@extends('layouts.user')
@section('title','User')
@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/User.css') }}">
@endpush

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark custom-nav px-4">
  <img alt="Logo" class="dashboard-logo" src="{{ asset('assets/image/lOGO.png') }}"/>
  <a class="navbar-brand fw-bold" href="{{ route('user.panel') }}">
    <span class="brand-text"> User Panel </span>
  </a>

  <ul class="navbar-nav mx-auto gap-4">
    <li class="nav-item">
      <a class="nav-link active" href="{{ route('user.properties') }}">
        <i class="fa-solid fa-users"></i> User Panel
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ url('/dashboard') }}">
        <i class="fa-solid fa-gauge-high"></i> Dashboard
      </a>
    </li>
  </ul>

  <ul class="navbar-nav ms-auto">
        <li class="nav-item">
<form method="POST" action="{{ route('logout') }}">
@csrf
<button class="nav-link text-warning border-0 bg-transparent">
<i class="fa-solid fa-right-from-bracket"></i> Logout
</button>
</form>
</li>
  </ul>
</nav>

<div class="container my-5">

  <!-- Welcome Card -->
  <div class="card welcome-card mb-4">
    <div class="card-body d-flex align-items-center gap-4">
      <img src="{{ asset('assets/image/3.jpg') }}" class="user-avatar" alt="User">
      <div>
        <h4 class="mb-1">
          <i class="bi bi-person-circle"></i> Welcome, User
        </h4>
        <p class="mb-0 text-muted">
          You can view, search and compare properties.
        </p>
      </div>
    </div>
  </div>

  <!-- Search Section -->
  <div class="card search-card mb-4">
    <div class="card-header bg-gradient text-white">
      <i class="bi bi-search"></i> Advanced Property Search
    </div>
    <div class="card-body">
      <form method="GET" action="{{ route('property.search') }}">
        <div class="row g-3">
          <div class="col-md-4">
            <input
              type="text"
              name="location"
              id="searchLocation"
              class="form-control"
              placeholder="Location"
              value="{{ request('location') }}">
          </div>

          <div class="col-md-4">
            <select name="type" id="searchType" class="form-select">
              <option value="">Property Type</option>
              <option value="house" {{ request('type')=='house'?'selected':'' }}>House</option>
              <option value="apartment" {{ request('type')=='apartment'?'selected':'' }}>Apartment</option>
            </select>
          </div>

          <div class="col-md-4">
            <button class="btn btn-success w-100">
              <i class="bi bi-search"></i> Search
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Property Cards -->
  <div class="row g-4">

    @forelse($properties as $property)
    <div class="col-md-4">
      <div class="card property-card"
           data-location="{{ strtolower($property->location) }}"
           data-type="{{ strtolower($property->status) }}">

        <img alt=""
src="{{ $property->images->first() ? asset('storage/properties/'.$property->images->first()->image) : asset('assets/image/1.jpg') }}">


        <div class="card-body">
          <h5 class="card-title">{{ $property->title }}</h5>
          <p>${{ number_format($property->price) }}</p>

          <!-- Compare -->
          <button
            class="btn btn-outline-primary w-100"
            onclick="addToCompare({{ $property->id }})">
            <i class="bi bi-bar-chart"></i> Compare
          </button>

          <!-- View -->
          <a
            href="{{ route('property.view', $property->id) }}"
            class="btn btn-outline-success w-100 mt-2">
            <i class="bi bi-eye"></i> View
          </a>
        </div>
      </div>
    </div>
    @empty
    <div class="col-12 text-center text-muted">
      <p>No properties found.</p>
    </div>
    @endforelse

  </div>
</div>

@push('scripts')
<script src="{{ asset('assets/js/User.js') }}"></script>
@endpush
<script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

@endsection
