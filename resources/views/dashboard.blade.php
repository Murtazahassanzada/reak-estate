@extends('layouts.app')
@section('title','dashboard')
@section('content')

<!-- NAVBAR -->

<!-- HERO BANNER -->
<section class="hero-section">
<div class="hero-overlay">
<div class="hero-content">
<h1 class="hero-title">Find Your Property</h1>
<p class="hero-subtitle">Buy • Rent • Sell with REMS</p>

<form action="{{ route('dashboard') }}" method="GET">
<div class="hero-search">

<input name="location" value="{{ request('location') }}" placeholder="City or Location" type="text"/>

<select name="purpose">
<option value="">Purpose</option>
<option value="sale" {{ request('purpose')=='sale' ? 'selected' : '' }}>sale</option>
<option value="rent" {{ request('purpose')=='rent' ? 'selected' : '' }}>rent</option>
</select>

<select name="type">
<option value="">Type</option>
<option value="house" {{ request('type')=='house' ? 'selected' : '' }}>House</option>
<option value="apartment" {{ request('type')=='apartment' ? 'selected' : '' }}>Apartment</option>
<option value="villa" {{ request('type')=='villa' ? 'selected' : '' }}>Villa</option>
</select>

<button type="submit">Search</button>

</div>
</form>

</div>
</div>
</section>

<!-- SUMMARY -->
<section class="container my-4">
<div class="row g-3">

<div class="col-md-3">
<div class="summary-card">
<h6>Total Properties</h6>
<h2>{{ $totalProperties }}</h2>
</div>
</div>

<div class="col-md-3">
<div class="summary-card">
<h6>For Sale</h6>
<h2>{{ $forSale }}</h2>
</div>
</div>

<div class="col-md-3">
<div class="summary-card">
<h6>For Rent</h6>
<h2>{{ $forRent }}</h2>
</div>
</div>

<div class="col-md-3">
<div class="summary-card">
<h6>Customers</h6>
<h2>{{ $customers }}</h2>
</div>
</div>

</div>
</section>

<!-- PROPERTIES -->
<section class="container">
<h4 class="mb-3">Registered Properties</h4>
<div class="row g-4">

@foreach($properties as $property)

<div class="col-md-4">
<div class="property-card">

<!-- badge moved -->
<span class="badge badge-purpose">
{{ ucfirst($property->purpose ?? $property->status) }}
</span>

<!-- img fixed -->

@php
    $image = $property->images->first();
@endphp

<img alt=""
     src="{{ $image ? asset('storage/properties/'.$image->image) : asset('assets/image/1.jpg') }}">
<!--<img alt=""
src="{{-- {{ $property->images->first() ? asset('storage/properties/'.$property->images->first()->image) : asset('assets/image/1.jpg') }}"> --}}
-->
<div class="property-info">

<h5>{{ $property->title }}</h5>

<p class="price">
${{ number_format($property->price) }}
@if($property->purpose == 'rent')
 / month
@endif
</p>

<p class="location">{{ $property->location }}</p>

<div class="property-meta">
<span>🛏 {{ $property->bedrooms }}</span>
<span>🛁 {{ $property->bathrooms }}</span>
<span>📐 {{ $property->area }}m²</span>
</div>

</div>
</div>
</div>

@endforeach

</div>
</section>

<script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

@push('scripts')
<script src="{{ asset('assets/js/main.js') }}"></script>
@endpush

@endsection
