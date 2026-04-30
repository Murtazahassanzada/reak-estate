@extends('layouts.user')
@section('title', __('view.title'))

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/View.css') }}">
@endpush

@section('content')

<!-- ================= NAVBAR ================= -->
<nav class="navbar custom-nav px-4">

  <span class="d-flex align-items-center brand-text {{ app()->getLocale()=='fa'?'flex-row-reverse':'' }}">
    <img
      alt="{{ __('view.logo_alt') }}"
      class="dashboard-logo {{ app()->getLocale()=='fa'?'ms-2':'me-2' }}"
      src="{{ asset('assets/image/LOGO.png') }}"
    />
    {{ __('view.header') }}
  </span>

  <a href="{{ url('/dashboard') }}" class="btn btn-light btn-sm">
    <i class="bi bi-arrow-left"></i>
    {{ __('view.back') }}
  </a>

</nav>

<!-- ================= MAIN CONTENT ================= -->
<div class="container my-5">

  <div class="card view-card shadow-lg border-0 overflow-hidden">

    <div class="row g-0">

      <!-- ================= IMAGE SECTION ================= -->
      <div class="col-md-6">

        @if($property->images && $property->images->count())

          <div id="propertyCarousel{{ $property->id }}" class="carousel slide" data-bs-ride="carousel">

            <div class="carousel-inner">

              @foreach($property->images as $key => $img)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                  <img
                    src="{{ asset('storage/properties/'.$img->image) }}"
                    class="d-block w-100 property-img"
                    alt="{{ __('view.image_alt') }}">
                </div>
              @endforeach

            </div>

            @if($property->images->count() > 1)
              <button class="carousel-control-prev" type="button"
                      data-bs-target="#propertyCarousel{{ $property->id }}"
                      data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
              </button>

              <button class="carousel-control-next" type="button"
                      data-bs-target="#propertyCarousel{{ $property->id }}"
                      data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
              </button>
            @endif

          </div>

        @else

          <img
            src="{{ asset('assets/image/download.jfif') }}"
            class="img-fluid property-img"
            alt="{{ __('view.image_alt') }}">

        @endif

      </div>

      <!-- ================= DETAILS SECTION ================= -->
      <div class="col-md-6">

        <div class="card-body p-4">

          <!-- TITLE -->
          <h2 class="fw-bold mb-2">
            {{ $property->title }}
          </h2>

          <!-- BADGE -->
          <span class="badge bg-primary mb-3">
            {{ __('view.types.'.$property->type) }}
          </span>

          <!-- BASIC INFO -->
          <p class="mb-2">
            <i class="bi bi-geo-alt text-danger"></i>
            <strong>{{ __('view.location') }}:</strong>
            {{ $property->location }}
          </p>

          <p class="mb-2">
            <i class="bi bi-house text-primary"></i>
            <strong>{{ __('view.type') }}:</strong>
            {{ __('view.types.'.$property->type) }}
          </p>

          <p class="mb-3 price-tag">
            <i class="bi bi-cash text-success"></i>
            <strong>{{ __('view.price') }}:</strong>
            ${{ number_format($property->price, 2) }}
          </p>

          <!-- ================= STATS GRID ================= -->
          <div class="row text-center mb-3">

            <div class="col-4 feature-box">
              🛏 <br>
              <strong>{{ $property->bedrooms }}</strong>
              <div class="small text-muted">Beds</div>
            </div>

            <div class="col-4 feature-box">
              🛁 <br>
              <strong>{{ $property->bathrooms }}</strong>
              <div class="small text-muted">Baths</div>
            </div>

            <div class="col-4 feature-box">
              📐 <br>
              <strong>{{ $property->area }}</strong>
              <div class="small text-muted">Area</div>
            </div>

          </div>

          <!-- ================= DESCRIPTION ================= -->
          <div class="description-box p-3 rounded bg-light border">
            {{ $property->description ?? __('view.default_desc') }}
          </div>

          <!-- ================= ACTIONS ================= -->
   <div class="mt-4 d-grid gap-2">

    <!-- SAVE PROPERTY -->
@php
    $isSaved = auth()->check() && auth()->user()
        ->favorites()
        ->where('property_id',$property->id)
        ->exists();
@endphp

<form action="{{ route('property.save',$property->id) }}" method="POST">
    @csrf

    <button class="btn {{ $isSaved ? 'btn-danger' : 'btn-outline-secondary' }}">
        @if($isSaved)
            💔 Remove from Saved
        @else
            ❤️ Save Property
        @endif
    </button>

</form>

    <!-- CONTACT AGENT -->
    @auth
        <form action="{{ route('property.contact',$property->id) }}" method="POST">
            @csrf

            <textarea name="message"
                      class="form-control"
                      placeholder="Write your message..."
                      required></textarea>

            <button class="btn btn-primary mt-2">
                📞 Contact Agent
            </button>
        </form>
    @endauth

    @guest
        <a href="{{ route('login') }}" class="btn btn-primary">
            🔐 Login to Contact
        </a>
    @endguest

</div>

        </div>

      </div>

    </div>
  </div>

</div>

@endsection
