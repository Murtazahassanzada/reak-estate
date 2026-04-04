@extends('layouts.app')
@section('title','About')
@section('content')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/About.css') }}">
@endpush



<!-- Hero Section -->
<section class="hero-section text-white text-center">
  <div class="container">
    <h1 class="fw-bold">About REAL ESTATE</h1>
    <p class="lead">A Smart Real Estate Management System</p>
  </div>
</section>

<!-- About Content -->
<section class="py-5">
  <div class="container">
    <div class="row align-items-center">

      <div class="col-md-6">
        <h2 class="fw-bold mb-3">Who We Are</h2>
        <p>
          REMS (Real Estate Management System) is a modern web-based platform
          designed to simplify property management processes.
          The system helps administrators manage properties efficiently,
          while users can explore, search, and compare real estate listings.
        </p>
        <p>
          This project is developed using modern web technologies
          with a focus on usability, security, and scalability.
        </p>
      </div>

      <div class="col-md-6 text-center">
        <i class="bi bi-buildings about-icon"></i>
      </div>

    </div>
  </div>
</section>

<!-- Features -->
<section class="bg-light py-5">
  <div class="container">
    <h2 class="text-center fw-bold mb-5">System Features</h2>

    <div class="row g-4">
      <div class="col-md-4">
        <div class="feature-card">
          <i class="bi bi-house-check"></i>
          <h5>Property Management</h5>
          <p>Add, edit, delete, and manage real estate properties easily.</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="feature-card">
          <i class="bi bi-search"></i>
          <h5>Advanced Search</h5>
          <p>Search properties using multiple filters and criteria.</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="feature-card">
          <i class="bi bi-bar-chart"></i>
          <h5>Comparison System</h5>
          <p>Compare properties side by side for better decision making.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Mission -->
<section class="py-5">
  <div class="container text-center">
    <h2 class="fw-bold mb-3">Our Mission</h2>
    <p class="mission-text">
      Our mission is to provide a reliable, secure, and user-friendly
      real estate management solution that improves efficiency and transparency
      in property management systems.
    </p>
  </div>
</section>

<!-- Footer -->
<!--<footer class="footer text-white text-center py-3">
  <p class="mb-0">© 2026 REMS | Real Estate Management System</p>
</footer>-->
<!---->
<!-- FOOTER -->

@push('scripts')
<script src="{{ asset('assets/js/About.js') }}"></script>
@endpush

<script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>


@endsection
