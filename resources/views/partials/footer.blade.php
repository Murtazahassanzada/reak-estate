<footer class="dashboard-footer mt-5">
  <div class="container">
    <div class="row gy-4">

      <div class="col-md-4">
        <h5 class="footer-title">{{ __('site.brand.name') }}</h5>
        <p class="footer-text">
          {{ __('site.footer.description') }}
        </p>
      </div>

      <div class="col-md-4">
        <h6 class="footer-title">{{ __('site.footer.quick_links') }}</h6>
        <ul class="footer-links list-unstyled">
          <li><a href="{{ route('dashboard') }}">{{ __('site.nav.dashboard') }}</a></li>
          <li><a href="{{ route('user.properties') }}">{{ __('site.nav.properties') }}</a></li>
        
          <li><a href="{{ route('login') }}">{{ __('site.auth.login') }}</a></li>
        </ul>
      </div>

      <div class="col-md-4">
        <h6 class="footer-title">{{ __('site.footer.contact_title') }}</h6>
        <p class="footer-text mb-1">📍 {{ __('site.contact.address') }}</p>
        <p class="footer-text mb-1">📧 {{ __('site.contact.email') }}</p>
        <p class="footer-text">📞 {{ __('site.contact.phone') }}</p>
      </div>

    </div>

    <hr class="footer-divider"/>

    <div class="text-center footer-bottom">
      © {{ date('Y') }} {{ __('site.brand.name') }} — {{ __('site.footer.rights') }}
    </div>
  </div>
</footer>
