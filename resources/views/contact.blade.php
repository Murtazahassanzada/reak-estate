@extends('layouts.app')

@section('title', __('contact.meta.title'))

@push('styles')

@if(app()->getLocale() == 'fa')
<link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.rtl.min.css') }}">
@else
<link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
@endif

<link rel="stylesheet" href="{{ asset('assets/css/Contact.css') }}">

<style>
body[dir="rtl"] { text-align: right; }
</style>

@endpush


@section('content')

<section class="contact-section">
  <div class="container">
    <div class="row g-4 align-items-stretch">

      <!-- INFO -->
      <div class="col-lg-5">
        <div class="contact-info h-100">

          <h2 class="fw-bold">{{ __('contact.info.title') }}</h2>
          <p>{{ __('contact.info.subtitle') }}</p>

          <div class="info-item">
            <i class="fas fa-map-marker-alt"></i>
            <span>{{ __('contact.info.address') }}</span>
          </div>

          <div class="info-item">
            <i class="fas fa-phone"></i>
            <span>{{ __('contact.info.phone') }}</span>
          </div>

          <div class="info-item">
            <i class="fas fa-envelope"></i>
            <span>{{ __('contact.info.email') }}</span>
          </div>

        </div>
      </div>

      <!-- FORM -->
      <div class="col-lg-7">
        <div class="contact-form h-100">

          <h3 class="fw-bold">{{ __('contact.form.title') }}</h3>

          {{-- SUCCESS --}}
        @if(session('success'))
<div class="alert alert-success text-center shadow-sm">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger text-center shadow-sm">
    {{ session('error') }}
</div>
@endif

          {{-- ERROR --}}
          @if ($errors->any())
          <div class="alert alert-danger">
            {{ __('contact.form.error') }}
          </div>
          @endif

     <form id="contactForm" method="POST" action="{{ route('contact.submit') }}">
@csrf

<div class="row">

  <div class="col-md-6">
    <div class="form-group">
      <input type="text" name="name" placeholder=" "
             value="{{ old('name') }}"
             class="form-control @error('name') is-invalid @enderror" required>
      <label>{{ __('contact.form.name') }}</label>
      @error('name')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <input type="email" name="email" placeholder=" "
             value="{{ old('email') }}"
             class="form-control @error('email') is-invalid @enderror" required>
      <label>{{ __('contact.form.email') }}</label>
      @error('email')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
  </div>

</div>

<div class="form-group mt-3">
  <input type="text" name="subject" placeholder=" "
         value="{{ old('subject') }}"
         class="form-control">
  <label>{{ __('contact.form.subject') }}</label>
</div>

<div class="form-group mt-3">
  <textarea name="message" rows="5" placeholder=" "
            class="form-control @error('message') is-invalid @enderror" required>{{ old('message') }}</textarea>
  <label>{{ __('contact.form.message') }}</label>
  @error('message')
  <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>

<button type="submit"
        class="contact-btn w-100 mt-3"
        data-loading="{{ __('contact.form.sending') }}">
    <span class="btn-text">
        {{ __('contact.form.button') }}
    </span>
</button>

</form>

        </div>
      </div>

    </div>
  </div>
</section>

@endsection


@push('scripts')
<script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/contact.js') }}"></script>
@endpush
