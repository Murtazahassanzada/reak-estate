@extends('layouts.user')
@section('title','View')
@section('content')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/View.css') }}">
@endpush

<!-- Navbar -->
<nav class="navbar navbar-dark custom-nav px-4">

  <span class="brand-text">
    <img alt="Logo" class="dashboard-logo" src="{{ asset('assets/image/lOGO.png') }}"/>
    Property Details
  </span>

  <a href="{{ url('/user') }}" class="btn btn-light btn-sm">
    <i class="bi bi-arrow-left"></i> Back to dashboard
  </a>
</nav>

<div class="container my-5">

  <div class="card view-card shadow">
    <div class="row g-0">

      <!-- Image -->
      <div class="col-md-6">
        <img
        id="propertyImage"
        src="{{ $property->images->first()
                ? asset('storage/properties/'.$property->images->first()->image)
                : asset('assets/image/download.jfif') }}"
        class="img-fluid rounded-start property-img"
        alt="Property">
      </div>

      <!-- Details -->
      <div class="col-md-6">
        <div class="card-body">
          <h4 id="propertyName" class="card-title">
            {{ $property->title }}
          </h4>

          <p class="mb-2">
            <i class="bi bi-house"></i>
            <strong>Type:</strong>
            <span id="propertyType">
              {{ $property->type }}
            </span>
          </p>

          <p class="mb-2">
            <i class="bi bi-geo-alt"></i>
            <strong>Location:</strong>
            <span id="propertyLocation">
              {{ $property->location }}
            </span>
          </p>

          <p class="mb-3">
            <i class="bi bi-cash"></i>
            <strong>Price:</strong>
            $
            <span id="propertyPrice">
              {{ number_format($property->price) }}
            </span>
          </p>

          <div class="alert alert-info">
            {{ $property->description ?? 'This is a read-only view. Users cannot edit properties.' }}
          </div>

        </div>
      </div>

    </div>
  </div>

</div>

<script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

@endsection
