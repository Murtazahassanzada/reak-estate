@extends('layouts.app')
@section('title','Contact')
@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/Contact.css') }}">
@endpush



<!-- Contact Section -->
<section class="contact-section">
  <div class="container">
    <div class="row g-4">

      <!-- Contact Info -->
      <div class="col-lg-5">
        <div class="contact-info">
          <h2>Get in Touch</h2>
          <p>Feel free to contact us for any questions or property inquiries.</p>

          <div class="info-item">
            <i class="fas fa-map-marker-alt"></i>
            <span>Kabul, Afghanistan</span>
          </div>

          <div class="info-item">
            <i class="fas fa-phone"></i>
            <span>+93 700 000 000</span>
          </div>

          <div class="info-item">
            <i class="fas fa-envelope"></i>
            <span>info@realestate.com</span>
          </div>

          <div class="social-links">
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
          </div>
        </div>
      </div>

      <!-- Contact Form -->
      <div class="col-lg-7">
        <div class="contact-form">
          <h3>Send a Message</h3>

          <form id="contactForm">
            <div class="row">
              <div class="col-md-6 mb-3">
                <input type="text" class="form-control" placeholder="Your Name" required>
              </div>
              <div class="col-md-6 mb-3">
                <input type="email" class="form-control" placeholder="Your Email" required>
              </div>
            </div>

            <div class="mb-3">
              <input type="text" class="form-control" placeholder="Subject">
            </div>

            <div class="mb-3">
              <textarea class="form-control" rows="5" placeholder="Your Message" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100">Send Message</button>
          </form>

          <p id="successMsg" class="text-success mt-3 d-none">
            Message sent successfully ✔️
          </p>
        </div>
      </div>

    </div>
  </div>
</section>

@push('scripts')
<script src="{{ asset('assets/js/Contact.js') }}"></script>
@endpush


@endsection
