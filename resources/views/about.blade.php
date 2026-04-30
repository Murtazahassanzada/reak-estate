@extends('layouts.app')
@section('title', __('about.meta.title'))

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/About.css') }}">
@endpush

@section('content')

<!-- HERO -->
<section class="hero-section position-relative text-white text-center d-flex align-items-center">
    <div class="hero-overlay"></div>
  <div class="container">
    <h1 class="fw-bold display-5">{{ __('about.hero.title') }}</h1>
    <p class="lead">{{ __('about.hero.subtitle') }}</p>
  </div>
</section>

<!-- ABOUT -->
<section class="py-5">
  <div class="container">
    <div class="row align-items-center g-4">

      <div class="col-lg-6">
        <h2 class="fw-bold mb-3">{{ __('about.about_section.title') }}</h2>
        <p>
          {{ __('about.about_section.p1') }}
        </p>
        <p>
          {{ __('about.about_section.p2') }}
        </p>
        <p>
          {{ __('about.about_section.p3') }}
        </p>
      </div>

      <div class="col-lg-6 text-center">
        <div class="about-icon-wrapper">
          <i class="bi bi-buildings about-icon"></i>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- FEATURES -->
<section class="bg-light py-5">
  <div class="container">
    <h2 class="text-center fw-bold mb-5">{{ __('about.features.title') }}</h2>

    <div class="row g-4">

      <div class="col-lg-4 col-md-6">
        <div class="feature-card h-100">
          <i class="bi bi-house-check"></i>
          <h5>{{ __('about.features.property.title') }}</h5>
          <p>{{ __('about.features.property.desc') }}</p>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="feature-card h-100">
          <i class="bi bi-search"></i>
          <h5>{{ __('about.features.search.title') }}</h5>
          <p>{{ __('about.features.search.desc') }}</p>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="feature-card h-100">
          <i class="bi bi-bar-chart"></i>
          <h5>{{ __('about.features.compare.title') }}</h5>
          <p>{{ __('about.features.compare.desc') }}</p>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- MISSION -->
<section class="py-5">
  <div class="container text-center">
    <h2 class="fw-bold mb-3">{{ __('about.mission.title') }}</h2>
    <p class="mission-text">
      {{ __('about.mission.text') }}
    </p>
  </div>
</section>

@endsection

@push('scripts')
<script src="{{ asset('assets/js/About.js') }}"></script>
@endpush
