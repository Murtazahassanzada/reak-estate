@php
    use App\Enums\PropertyStatus;
@endphp
@extends('layouts.user')

@section('title', __('user.panel.name'))

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/User.css') }}">
@endpush

@section('content')
<div class="container my-5">

  {{-- WELCOME CARD --}}
  <div class="card welcome-card mb-4">
    <div class="card-body d-flex align-items-center gap-4">
      <img src="{{ asset('assets/image/1.jpg') }}" class="user-avatar">
      <div>
        <h4>👋 {{ __('user.welcome') }}, {{ auth()->user()->name }}</h4>
        <p>{{ __('user.description') }}</p>
      </div>
    </div>
  </div>

  {{-- SEARCH CARD --}}
  <div class="card search-card mb-4 shadow-sm">
    <div class="card-header">
      <i class="bi bi-search"></i> {{ __('user.search.title') }}
    </div>
    <div class="card-body">
      <form method="GET" action="{{ route('user.panel') }}">
        <div class="row g-3 align-items-center">
          <div class="col-md-5">
            <div class="d-flex gap-2">
              <input type="text" name="location" class="form-control"
                     placeholder="{{ __('user.search.location') }}"
                     value="{{ request('location') }}">
              <button class="btn btn-primary px-4">🔍</button>
            </div>
          </div>

          <div class="col-md-3">
            <select name="type" class="form-select">
              <option value="">{{ __('user.search.type') }}</option>
              <option value="house" {{ request('type')=='house'?'selected':'' }}>
                {{ __('user.types.house') }}
              </option>
              <option value="apartment" {{ request('type')=='apartment'?'selected':'' }}>
                {{ __('user.types.apartment') }}
              </option>
              <option value="villa" {{ request('type')=='villa'?'selected':'' }}>
                {{ __('user.types.villa') }}
              </option>
            </select>
          </div>

          <div class="col-md-3">
            <select name="purpose" class="form-select">
              <option value="">{{ __('user.search.purpose') }}</option>
              <option value="sale" {{ request('purpose')=='sale'?'selected':'' }}>
                {{ __('user.purpose.sale') }}
              </option>
              <option value="rent" {{ request('purpose')=='rent'?'selected':'' }}>
                {{ __('user.purpose.rent') }}
              </option>
              <option value="mortgage" {{ request('purpose')=='mortgage'?'selected':'' }}>
                {{ __('user.purpose.mortgage') }}
              </option>
            </select>
          </div>

          <div class="col-md-1">
            <button class="btn btn-primary w-100">{{ __('user.search.go') }}</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  {{-- ADD PROPERTY BUTTON --}}
  <div class="d-flex justify-content-end mb-3">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userAddPropertyModal">
      ➕ {{ __('user.property.add') }}
    </button>
  </div>

  {{-- TABS --}}
  <div class="dashboard-tabs mb-4">
    <button class="tab-btn active" data-tab="all">🏠 {{ __('user.menu.properties') }}</button>
    <button class="tab-btn" data-tab="fav">❤️ {{ __('user.favorites.title') }}</button>
  </div>

  {{-- FAVORITES SECTION --}}
  @if(isset($favorites) && $favorites->count())
  <div class="mb-5 favorites-section">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4 class="fw-bold mb-0">❤️ {{ __('user.favorites.title') }}</h4>
      <span class="badge bg-danger">{{ $favorites->count() }} {{ __('user.favorites.saved') }}</span>
    </div>
    <div class="row g-4">
      @foreach($favorites as $fav)
      <div class="col-md-4">
        <div class="card property-card favorite-card h-100 border-0 shadow-sm overflow-hidden">
          <div class="favorite-badge">❤️ {{ __('user.favorites.favorite') }}</div>

          {{-- Image carousel --}}
          @if($fav->images && $fav->images->count())
          <div id="favoriteCarousel{{ $fav->id }}" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
            <div class="carousel-inner">
              @foreach($fav->images as $key => $img)
              <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                <img src="{{ asset('storage/properties/'.$img->image) }}" class="d-block w-100" style="height:220px; object-fit:cover;" loading="lazy">
              </div>
              @endforeach
            </div>
            @if($fav->images->count() > 1)
            <button class="carousel-control-prev" type="button" data-bs-target="#favoriteCarousel{{ $fav->id }}" data-bs-slide="prev">
              <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#favoriteCarousel{{ $fav->id }}" data-bs-slide="next">
              <span class="carousel-control-next-icon"></span>
            </button>
            @endif
          </div>
          @else
          <img src="{{ asset('assets/image/1.jpg') }}" class="card-img-top" style="height:220px; object-fit:cover;" loading="lazy">
          @endif

          <div class="card-body d-flex flex-column">
            <h5 class="fw-bold mb-2">{{ $fav->title }}</h5>
            <p class="text-muted small mb-2"><i class="bi bi-geo-alt"></i> {{ $fav->location }}</p>
            <div class="d-flex justify-content-between small text-muted mb-3">
              <span>🛏 {{ $fav->bedrooms }}</span>
              <span>🛁 {{ $fav->bathrooms }}</span>
              <span>📐 {{ $fav->area }} m²</span>
            </div>
            <h5 class="text-success fw-bold mb-3">{{ config('app.currency', '$') }}{{ number_format($fav->price) }}</h5>
            <div class="mt-auto d-flex gap-2">
              <form action="{{ route('property.save',$fav->id) }}" method="POST" class="w-50">
                @csrf
                <button class="btn btn-danger btn-sm w-100">💔 {{ __('user.favorites.remove') }}</button>
              </form>
              <a href="{{ route('property.view',$fav->id) }}" class="btn btn-outline-primary btn-sm w-50">👁 {{ __('user.property.view') }}</a>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
  @endif

  {{-- PROPERTIES SECTION --}}
  <div class="row g-4 properties-wrapper">
    @forelse($properties as $property)
    <div class="col-md-4">
      {{-- EDIT MODAL --}}
      <div class="modal fade" id="editUserProperty{{ $property->id }}">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
          <div class="modal-content shadow border-0">
            <div class="modal-header bg-primary text-white">
              <h5 class="modal-title">✏️ {{ __('user.property.edit') }}</h5>
              <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <form action="{{ route('user.property.update',$property->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="row">
                  <div class="col-md-8">
                    <label class="form-label">{{ __('user.property.title') }}</label>
                    <input type="text" name="title" value="{{ $property->title }}" class="form-control mb-3" required>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">{{ __('user.property.price') }} ({{ config('app.currency', '$') }})</label>
                    <input type="number" name="price" value="{{ $property->price }}" class="form-control mb-3" required>
                  </div>
                </div>
                <label class="form-label">{{ __('user.property.description') }}</label>
                <textarea name="description" class="form-control mb-3">{{ $property->description }}</textarea>
                <label class="form-label">{{ __('user.property.location') }}</label>
                <input type="text" name="location" value="{{ $property->location }}" class="form-control mb-3" required>
                <div class="row">
                  <div class="col-md-6">
                    <label class="form-label">{{ __('user.property.type') }}</label>
                    <select name="type" class="form-select mb-3" required>
                      <option value="">{{ __('user.property.type') }}</option>
                      <option value="house" {{ $property->type=='house'?'selected':'' }}>{{ __('user.types.house') }}</option>
                      <option value="apartment" {{ $property->type=='apartment'?'selected':'' }}>{{ __('user.types.apartment') }}</option>
                      <option value="villa" {{ $property->type=='villa'?'selected':'' }}>{{ __('user.types.villa') }}</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">{{ __('user.property.purpose') }}</label>
                    <select name="purpose" class="form-select mb-3" required>
                      <option value="">{{ __('user.property.purpose') }}</option>
                      <option value="sale" {{ $property->purpose=='sale'?'selected':'' }}>{{ __('user.purpose.sale') }}</option>
                      <option value="rent" {{ $property->purpose=='rent'?'selected':'' }}>{{ __('user.purpose.rent') }}</option>
                      <option value="mortgage" {{ $property->purpose=='mortgage'?'selected':'' }}>{{ __('user.purpose.mortgage') }}</option>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <label class="form-label">{{ __('user.property.bedrooms') }}</label>
                    <input type="number" name="bedrooms" value="{{ $property->bedrooms }}" class="form-control mb-3" required>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">{{ __('user.property.bathrooms') }}</label>
                    <input type="number" name="bathrooms" value="{{ $property->bathrooms }}" class="form-control mb-3" required>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">{{ __('user.property.area') }} (m²)</label>
                    <input type="number" name="area" value="{{ $property->area }}" class="form-control mb-3" required>
                  </div>
                </div>
                <label class="form-label">{{ __('user.property.update_images') }}</label>
                <input type="file" name="images[]" class="form-control mb-4" multiple>
                <button class="btn btn-primary w-100">💾 {{ __('user.property.save_changes') }}</button>
              </form>
            </div>
          </div>
        </div>
      </div>

      {{-- DELETE MODAL --}}
      <div class="modal fade" id="deleteUserProperty{{ $property->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header bg-danger text-white">
              <h5>{{ __('user.delete.title') }}</h5>
              <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
              <p>{{ __('user.delete.question') }}</p>
            </div>
            <div class="modal-footer justify-content-center">
              <button class="btn btn-secondary" data-bs-dismiss="modal">{{ __('user.delete.cancel') }}</button>
              <form action="{{ route('user.property.delete',$property->id) }}" method="POST">
                @csrf @method('DELETE')
                <button class="btn btn-danger">{{ __('user.delete.confirm') }}</button>
              </form>
            </div>
          </div>
        </div>
      </div>

      {{-- PROPERTY CARD --}}
      @if($property->images && $property->images->count())
      <div id="carousel{{ $property->id }}" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-inner">
          @foreach($property->images as $key => $img)
          <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
            <img src="{{ asset('storage/properties/'.$img->image) }}" class="d-block w-100" style="height:200px; object-fit:cover;" loading="lazy">
          </div>
          @endforeach
        </div>
        @if($property->images->count() > 1)
        <button class="carousel-control-prev" type="button" data-bs-target="#carousel{{ $property->id }}" data-bs-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carousel{{ $property->id }}" data-bs-slide="next">
          <span class="carousel-control-next-icon"></span>
        </button>
        @endif
      </div>
      @else
      <img src="{{ asset('assets/image/1.jpg') }}" style="height:200px; object-fit:cover;" loading="lazy">
      @endif

      <div class="card-body d-flex flex-column">
        <h5 class="card-title">{{ $property->title }}</h5>
        <p class="text-muted mb-1"><i class="bi bi-geo-alt"></i> {{ $property->location }}</p>
        <p class="mb-1">
          <span class="badge bg-light text-dark">{{ __('user.types.'.$property->type) }}</span>
          <span class="badge bg-info text-dark">{{ __('user.purpose.'.$property->purpose) }}</span>
        </p>
        <p class="text-muted small mb-2">
          🛏 {{ $property->bedrooms }} | 🛁 {{ $property->bathrooms }} | 📐 {{ $property->area }} m²
        </p>
        <p class="fw-bold text-success fs-5">{{ config('app.currency', '$') }}{{ number_format($property->price) }}</p>

        @php
        $statusMap = [
            'pending'  => ['text' => __('user.status.pending'), 'class' => 'bg-warning text-dark'],
            'approved' => ['text' => __('user.status.approved'), 'class' => 'bg-success'],
            'rejected' => ['text' => __('user.status.rejected'), 'class' => 'bg-danger'],
        ];
        $status = $statusMap[$property->approval_status] ?? ['text' => __('user.status.pending'), 'class' => 'bg-warning text-dark'];
        @endphp
        <span class="badge mb-2 {{ $status['class'] }}">{{ $status['text'] }}</span>

        <div class="mt-auto action-buttons-text">
          @if($property->user_id == auth()->id())
          <button class="btn btn-edit" data-bs-toggle="modal" data-bs-target="#editUserProperty{{ $property->id }}">✏️ {{ __('user.property.edit') }}</button>
          <button class="btn btn-delete" data-bs-toggle="modal" data-bs-target="#deleteUserProperty{{ $property->id }}">🗑 {{ __('user.property.delete') }}</button>
          @endif
          <button class="btn btn-compare" onclick="addToCompare({{ $property->id }})">📊 {{ __('user.compare.button') }}</button>
          <a href="{{ route('property.view', $property->id) }}" class="btn btn-view">👁 {{ __('user.property.view') }}</a>
        </div>
      </div>
    </div>
    @empty
    <div class="col-12 text-center text-muted">
      <p>{{ __('user.no_properties') }}</p>
    </div>
    @endforelse
    <div class="mt-4 d-flex justify-content-center">
      {{ $properties->appends(request()->query())->links() }}
    </div>
  </div>
</div>

{{-- COMPARE MODAL --}}
<div class="modal fade" id="compareModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title"><i class="bi bi-bar-chart"></i> {{ __('user.compare.title') }}</h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <div id="compareListContainer" class="mb-3"></div>
        <button id="compareNowBtn" class="btn btn-success w-100" disabled>{{ __('user.compare.button') }}</button>
      </div>
    </div>
  </div>
</div>

{{-- LOGOUT MODAL --}}
<form method="POST" action="{{ route('logout') }}">
  @csrf
  <div class="modal fade" id="userLogoutModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title"><i class="fa-solid fa-right-from-bracket"></i> {{ __('user.logout.title') }}</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body text-center">
          <p class="mb-0">{{ __('user.logout.question') }}</p>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('user.logout.cancel') }}</button>
          <button type="submit" class="btn btn-danger">{{ __('user.logout.submit') }}</button>
        </div>
      </div>
    </div>
  </div>
</form>

{{-- ADD PROPERTY MODAL --}}
<div class="modal fade" id="userAddPropertyModal">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content shadow border-0">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">➕ {{ __('user.property.add_new') }}</h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('user.property.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-8">
              <label class="form-label">{{ __('user.property.title') }}</label>
              <input type="text" name="title" class="form-control mb-3" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">{{ __('user.property.price') }} ({{ config('app.currency', '$') }})</label>
              <input type="number" name="price" class="form-control mb-3" required>
            </div>
          </div>
          <label class="form-label">{{ __('user.property.description') }}</label>
          <textarea name="description" class="form-control mb-3" rows="3"></textarea>
          <label class="form-label">{{ __('user.property.location') }}</label>
          <input type="text" name="location" class="form-control mb-3" required>
          <div class="row">
            <div class="col-md-6">
              <label class="form-label">{{ __('user.property.type') }}</label>
              <select name="type" class="form-select mb-3" required>
                <option value="" disabled selected hidden>{{ __('user.property.type') }}</option>
                <option value="house">{{ __('user.types.house') }}</option>
                <option value="apartment">{{ __('user.types.apartment') }}</option>
                <option value="villa">{{ __('user.types.villa') }}</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">{{ __('user.property.purpose') }}</label>
              <select name="purpose" class="form-select mb-3" required>
                <option value="" disabled selected hidden>{{ __('user.property.purpose') }}</option>
                <option value="sale">{{ __('user.purpose.sale') }}</option>
                <option value="rent">{{ __('user.purpose.rent') }}</option>
                <option value="mortgage">{{ __('user.purpose.mortgage') }}</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label class="form-label">{{ __('user.property.bedrooms') }}</label>
              <input type="number" name="bedrooms" class="form-control mb-3" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">{{ __('user.property.bathrooms') }}</label>
              <input type="number" name="bathrooms" class="form-control mb-3" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">{{ __('user.property.area') }} (m²)</label>
              <input type="number" name="area" class="form-control mb-3" required>
            </div>
          </div>
          <label class="form-label">{{ __('user.property.images') }}</label>
          <input type="file" name="images[]" class="form-control mb-4" multiple>
          <button class="btn btn-success w-100">🚀 {{ __('user.property.publish') }}</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/User.js') }}"></script>
@endpush