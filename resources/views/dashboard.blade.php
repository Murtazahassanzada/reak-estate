@extends('layouts.app')
@section('title', __('dashboard.title'))

@section('content')

<!-- =========================
     HERO SLIDER (ENTERPRISE)
========================= -->
<div id="heroSlider" class="carousel slide hero-section" data-bs-ride="carousel">

  <!-- INDICATORS -->
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#heroSlider" data-bs-slide-to="0" class="active"></button>
    <button type="button" data-bs-target="#heroSlider" data-bs-slide-to="1"></button>
    <button type="button" data-bs-target="#heroSlider" data-bs-slide-to="2"></button>
  </div>

  <div class="carousel-inner">

    <!-- SLIDE 1 -->
    <div class="carousel-item active hero-slide"
         style="background-image:url('/assets/image/banner.jpg');">

      <div class="hero-overlay">
        <div class="hero-content text-center">

          <h1 class="hero-title">
            {{ __('site.slider.slide1_title') }}
          </h1>

          <p class="hero-subtitle">
            {{ __('site.slider.slide1_subtitle') }}
          </p>

          <!-- SEARCH BOX -->
          <form action="{{ route('dashboard') }}" method="GET">
           <div class="hero-search shadow-lg search-box">

              <input name="location"
                     value="{{ request('location') }}"
                     placeholder="{{ __('site.filters.location') }}"
                     type="text" />

    <select name="purpose">
    <option value="">{{ __('site.filters.purpose') }}</option>

    <option value="sale" {{ request('purpose')=='sale' ? 'selected' : '' }}>
        {{ __('site.enums.purpose.sale') }}
    </option>

    <option value="rent" {{ request('purpose')=='rent' ? 'selected' : '' }}>
        {{ __('site.enums.purpose.rent') }}
    </option>

    <option value="mortgage" {{ request('purpose')=='mortgage' ? 'selected' : '' }}>
       {{ __('site.enums.purpose.mortgage') }}
    </option>
</select>

<select name="type">
    <option value="">{{ __('site.filters.type') }}</option>

    <option value="house" {{ request('type')=='house' ? 'selected' : '' }}>
        {{ __('site.enums.type.house') }}
    </option>

    <option value="apartment" {{ request('type')=='apartment' ? 'selected' : '' }}>
        {{ __('site.enums.type.apartment') }}
    </option>

    <option value="villa" {{ request('type')=='villa' ? 'selected' : '' }}>
  {{ __('site.enums.type.villa') }}
    </option>
</select>

              <button type="submit" class="hero-btn">
                🔍 {{ __('site.actions.search') }}
              </button>

            </div>
          </form>

        </div>
      </div>
    </div>

    <!-- SLIDE 2 -->
    <div class="carousel-item hero-slide"
         style="background-image:url('/assets/image/banner2.jpg');">
      <div class="hero-overlay">
        <div class="hero-content text-center">
          <h1 class="hero-title">{{ __('site.slider.slide2_title') }}</h1>
          <p class="hero-subtitle">{{ __('site.slider.slide2_subtitle') }}</p>
        </div>
      </div>
    </div>

    <!-- SLIDE 3 -->
    <div class="carousel-item hero-slide"
         style="background-image:url('/assets/image/banner3.jpg');">
      <div class="hero-overlay">
        <div class="hero-content text-center">
          <h1 class="hero-title">{{ __('site.slider.slide3_title') }}</h1>
          <p class="hero-subtitle">{{ __('site.slider.slide3_subtitle') }}</p>
        </div>
      </div>
    </div>

  </div>

  <!-- CONTROLS -->
  <button class="carousel-control-prev" type="button" data-bs-target="#heroSlider" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>

  <button class="carousel-control-next" type="button" data-bs-target="#heroSlider" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>

</div>

<!-- =========================
     SUMMARY SECTION
========================= -->
<section class="container my-5">
  <div class="row g-4 text-center">

@foreach([
  ['title'=>__('dashboard.stats.total_properties'),'value'=>$totalProperties ?? 0,'color'=>'primary'],
  ['title'=>__('dashboard.stats.for_sale'),'value'=>$forSale ?? 0,'color'=>'success'],
  ['title'=>__('dashboard.stats.for_rent'),'value'=>$forRent ?? 0,'color'=>'warning'],
  ['title'=>__('dashboard.stats.customers'),'value'=>$customers ?? 0,'color'=>'dark']
] as $item)

      <div class="col-md-3">
        <div class="card border-0 shadow-lg p-4 rounded-4">
          <h6 class="text-muted">{{ $item['title'] }}</h6>
          <h2 class="fw-bold text-{{ $item['color'] }}">
            {{ $item['value'] }}
          </h2>
        </div>
      </div>

    @endforeach

  </div>
</section>

<!-- =========================
     PROPERTIES SECTION (CLICKABLE CARD FIX)
========================= -->
<section class="container">

  <h4 class="mb-4 fw-bold">{{ __('dashboard.properties.title') }}</h4>

  <div class="row g-4">

    @forelse($properties as $property)

      <div class="col-md-4">

        <a href="{{ route('property.view',$property->id) }}"
           class="property-link text-decoration-none text-dark">

          <div class="card border-0 shadow-lg rounded-4 overflow-hidden property-card-clickable">

            @php
              $image = $property->images->first();
            @endphp

            <img src="{{ $image ? asset('storage/properties/'.$image->image) : asset('assets/image/1.jpg') }}"
                 class="w-100"
                 style="height:220px;object-fit:cover;">

            <div class="p-3">

              <span class="badge bg-primary mb-2">
                {{ __('site.enums.purpose.' . $property->purpose) }}
              </span>

              <h5 class="fw-bold">{{ $property->title }}</h5>

              <p class="text-success fw-bold mb-1">
                ${{ number_format($property->price) }}
                @if($property->purpose=='rent')
                  / {{ __('dashboard.properties.per_month') }}
                @endif
              </p>

              <p class="text-muted small mb-2">
                📍 {{ $property->location }}
              </p>

              <div class="d-flex justify-content-between small text-muted">
                <span>🛏 {{ $property->bedrooms }}</span>
                <span>🛁 {{ $property->bathrooms }}</span>
               <span>
📐 {{ $property->area }} {{ __('site.properties.area_unit') }}
</span>
              </div>

              <div class="btn btn-outline-primary w-100 mt-3">
              {{ __('site.actions.view') }}
              </div>

            </div>

          </div>

        </a>

      </div>

    @empty

      <div class="col-12 text-center py-5">
     <h5>{{ __('dashboard.properties.empty') }}</h5>
      </div>

    @endforelse

  </div>

</section>

<!-- =========================
     SCRIPTS
========================= -->
<script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

@push('scripts')
<script src="{{ asset('assets/js/main.js') }}"></script>
@endpush

@endsection
