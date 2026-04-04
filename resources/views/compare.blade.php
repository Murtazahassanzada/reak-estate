@extends('layouts.user')
@section('title','Compare')
@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/Compare.css') }}">
@endpush

<!-- Navbar -->
<nav class="navbar navbar-dark custom-nav px-4">
  <span class="brand-text">
    <img alt="Logo" class="dashboard-logo" src="{{ asset('assets/image/lOGO.png') }}"/>
    Property Comparison
  </span>

  <a href="{{ route('user.properties') }}" class="btn btn-light btn-sm">
    <i class="bi bi-arrow-left"></i> dashboard
  </a>
</nav>

<div class="container my-5">

  <h4 class="mb-4 text-center">
    <i class="bi bi-bar-chart"></i> Compare Selected Properties
  </h4>

  <div class="row g-4" id="compareContainer">

    @if($properties->count() < 2)
      <div class="col-12 text-center text-danger">
        <p>Please select two properties to compare.</p>
      </div>
    @else

      @foreach($properties as $property)
      <div class="col-md-6">
        <div class="card compare-card h-100">
          <div class="card-body text-center">

        <img
        src="{{ $property->images->first() ? asset('storage/properties/'.$property->images->first()->image) : asset('assets/image/download.jfif') }}"
        class="img-fluid mb-3"
        style="max-height:180px;object-fit:cover;">
            <h5 class="card-title">{{ $property->title }}</h5>

            <p><strong>Type:</strong> {{ ucfirst($property->status) }}</p>

            <p><strong>Location:</strong> {{ $property->location }}</p>

            <p><strong>Price:</strong> ${{ number_format($property->price) }}</p>

          </div>
        </div>
      </div>
      @endforeach

    @endif

  </div>

</div>


<script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

@endsection
