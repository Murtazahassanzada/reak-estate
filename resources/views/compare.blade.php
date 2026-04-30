@extends('layouts.user')

@section('title', __('compare.title'))

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/Compare.css') }}">
@endpush

@section('content')

<!-- NAVBAR -->
<nav class="navbar navbar-dark custom-nav px-4 
{{ app()->getLocale() == 'fa' ? 'rtl' : '' }}">

  <div class="container d-flex justify-content-between align-items-center">

    <!-- LOGO + TITLE -->
    <div class="d-flex align-items-center logo-box">

      <img
        alt="Logo"
        src="{{ asset('assets/image/lOGO.png') }}"
        class="dashboard-logo">

      <span class="brand-text">
        {{ __('compare.header') }}
      </span>

    </div>

    <!-- BACK BUTTON -->
    <a href="{{ route('user.properties') }}" class="back-btn">
      <i class="bi bi-arrow-left"></i>
      {{ __('compare.back') }}
    </a>

  </div>

</nav>

<div class="container my-5">

  <!-- TITLE -->
  <h4 class="mb-4 text-center compare-title">
    <i class="bi bi-bar-chart"></i>
    {{ __('compare.compare_title') }}
  </h4>

  <div class="row g-4" id="compareContainer">

    @if($properties->count() < 2)

      <div class="col-12 text-center text-danger">
        <p class="fw-semibold">{{ __('compare.need_two') }}</p>
      </div>

    @else

      @foreach($properties as $property)

      <div class="col-md-6">
        <div class="card compare-card h-100 shadow-sm">

          <div class="card-body text-center d-flex flex-column">

            <!-- IMAGE -->
            <img
              src="{{ $property->images->first()
                ? asset('storage/properties/'.$property->images->first()->image)
                : asset('assets/image/download.jfif') }}"
              class="img-fluid mb-3 compare-img">

            <!-- TITLE -->
            <h5 class="card-title">
              {{ $property->title }}
            </h5>

            <!-- DETAILS -->
            <div class="compare-details text-start mt-3">

              <p>
                <strong>{{ __('compare.type') }}:</strong>
                {{ __('user.types.' . $property->type) }}
              </p>

              <p>
                <strong>{{ __('compare.location') }}:</strong>
                {{ $property->location }}
              </p>

              <p class="text-success fw-bold">
                <strong>{{ __('compare.price') }}:</strong>
                {{ number_format($property->price, 2) }} $
              </p>

            </div>

          </div>

        </div>
      </div>

      @endforeach

    @endif

  </div>

</div>

<!-- JS TRANSLATIONS -->
<script>
window.trans = {
    need_two: "{{ __('compare.need_two') }}",
    type: "{{ __('compare.type') }}",
    price: "{{ __('compare.price') }}",
    error: "{{ __('compare.error') }}"
};
</script>

@endsection