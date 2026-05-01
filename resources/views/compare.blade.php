@extends('layouts.user')

@section('title', __('compare.title'))

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/Compare.css') }}">
@endpush

@section('content')

<!-- NAVBAR -->
<!-- PAGE HEADER -->
<section class="compare-page-header
{{ app()->getLocale() == 'fa' ? 'rtl' : '' }}">

    <div class="container">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

            <!-- LEFT SIDE -->
            <div class="d-flex align-items-center gap-3">

                <!-- ICON -->
                <div class="compare-header-icon">

                    <i class="bi bi-bar-chart-line-fill"></i>

                </div>

                <!-- TITLE -->
                <div>

                    <h2 class="compare-page-title mb-1">

                        {{ __('compare.compare_title') }}

                    </h2>

                    <p class="compare-page-subtitle mb-0">

                        {{ __('compare.header') }}

                    </p>

                </div>

            </div>

            <!-- RIGHT SIDE -->
            <a href="{{ route('user.properties') }}"
               class="compare-back-btn">

                <i class="bi bi-arrow-left-short"></i>

                {{ __('compare.back') }}

            </a>

        </div>

    </div>

</section>

<div class="container my-5">

  <!-- TITLE -->
  <h4 class="mb-4 text-center compare-title">
    <i class="bi bi-bar-chart"></i>
    {{ __('compare.compare_title') }}
  </h4>

  <div class="row g-4" id="compareContainer">

    @if($properties->count() < 2)

      <div class="col-12 text-center text-danger">
        <p class="fw-semibold">
          {{ __('compare.need_two') }}
        </p>
      </div>

    @else

      @foreach($properties as $property)

      <div class="col-lg-6">

        <div class="card compare-card h-100 border-0 shadow-lg overflow-hidden">

          <div class="card-body text-center d-flex flex-column">

            <!-- IMAGE SLIDER -->
            @if($property->images && $property->images->count())

            <div id="compareCarousel{{ $property->id }}"
                 class="carousel slide mb-3"
                 data-bs-ride="carousel"
                 data-bs-interval="3000">

              <!-- IMAGES -->
              <div class="carousel-inner rounded overflow-hidden">

                @foreach($property->images as $key => $image)

                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">

                  <img
                    src="{{ asset('storage/properties/'.$image->image) }}"
                    class="d-block w-100 compare-img"
                    loading="lazy">

                </div>

                @endforeach

              </div>

              <!-- CONTROLS -->
              @if($property->images->count() > 1)

              <button class="carousel-control-prev"
                      type="button"
                      data-bs-target="#compareCarousel{{ $property->id }}"
                      data-bs-slide="prev">

                <span class="carousel-control-prev-icon"></span>

              </button>

              <button class="carousel-control-next"
                      type="button"
                      data-bs-target="#compareCarousel{{ $property->id }}"
                      data-bs-slide="next">

                <span class="carousel-control-next-icon"></span>

              </button>

              @endif

            </div>

            @else

            <!-- FALLBACK IMAGE -->
            <img
              src="{{ asset('assets/image/download.jfif') }}"
              class="img-fluid mb-3 compare-img"
              loading="lazy">

            @endif

            <!-- TITLE -->
            <h5 class="card-title fw-bold mb-3">
              {{ $property->title }}
            </h5>

            <!-- DETAILS -->
            <div class="compare-details text-start mt-2">

              <!-- TYPE -->
              <div class="compare-item">
                <strong>
                  <i class="bi bi-house-door"></i>
                  {{ __('compare.type') }}:
                </strong>

                <span>
                  {{ __('user.types.' . $property->type) }}
                </span>
              </div>

              <!-- LOCATION -->
              <div class="compare-item">

                <strong>
                  <i class="bi bi-geo-alt"></i>
                  {{ __('compare.location') }}:
                </strong>

                <span>
                  {{ $property->location }}
                </span>

              </div>

              <!-- PRICE -->
              <div class="compare-item text-success fw-bold">

                <strong>
                  <i class="bi bi-cash-stack"></i>
                  {{ __('compare.price') }}:
                </strong>

                <span>
                  {{ number_format($property->price, 2) }} $
                </span>

              </div>

              <!-- BEDROOMS -->
              <div class="compare-item">

                <strong>
                  <i class="bi bi-door-open"></i>
                  {{ __('user.bedrooms') ?? 'Bedrooms' }}:
                </strong>

                <span>
                  {{ $property->bedrooms }}
                </span>

              </div>

              <!-- BATHROOMS -->
              <div class="compare-item">

                <strong>
                  <i class="bi bi-droplet"></i>
                  {{ __('user.bathrooms') ?? 'Bathrooms' }}:
                </strong>

                <span>
                  {{ $property->bathrooms }}
                </span>

              </div>

              <!-- AREA -->
              <div class="compare-item">

                <strong>
                  <i class="bi bi-bounding-box"></i>
                  {{ __('compare.area') ?? 'Area' }}:
                </strong>

                <span>
                  {{ $property->area }} m²
                </span>

              </div>

            </div>

            <!-- VIEW BUTTON -->
            <a href="{{ route('property.view', $property->id) }}"
               class="btn btn-primary mt-4 w-100 rounded-pill">

              <i class="bi bi-eye"></i>
              {{ __('site.actions.view') }}

            </a>

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