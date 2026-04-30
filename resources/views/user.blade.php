@php
    use App\Enums\PropertyStatus;
@endphp
@extends('layouts.user')

@section('title', __('user.panel.name'))

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/User.css') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
@endpush

@section('content')

<div class="container my-5">

  <!-- WELCOME CARD - LUXURY VERSION -->
  <div class="welcome-card mb-5">
    <div class="welcome-overlay"></div>
    <div class="welcome-content">
      <div class="row align-items-center">
        <div class="col-md-8">
          <div class="d-flex align-items-center gap-4">
            <div class="avatar-wrapper">
              <img src="{{ asset('assets/image/1.jpg') }}" class="user-avatar">
              <span class="avatar-status"></span>
            </div>
            <div class="welcome-text">
              <h1 class="display-6 fw-bold mb-2">👋 {{ __('user.welcome') }}, {{ auth()->user()->name }}</h1>
              <p class="lead mb-0">Manage your properties, search smarter, and compare easily.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4 text-md-end mt-4 mt-md-0">
          <div class="stats-badge">
            <span class="stat-number">{{ $properties->total() }}</span>
            <span class="stat-label">Properties</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- SEARCH CARD - PREMIUM -->
  <div class="search-card mb-4">
    <div class="search-header">
      <i class="bi bi-search"></i> {{ __('user.search.title') }}
      <span class="search-badge">Find your dream property</span>
    </div>
    <div class="search-body">
      <form method="GET" action="{{ route('user.panel') }}">
        <div class="search-grid">
          <div class="search-field">
            <label class="search-label">📍 Location</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
              <input type="text" name="location" class="form-control" placeholder="City, neighborhood, or address" value="{{ request('location') }}">
            </div>
          </div>
          
          <div class="search-field">
            <label class="search-label">🏠 Property Type</label>
            <select name="type" class="form-select">
              <option value="">{{ __('user.search.type') }}</option>
              <option value="house" {{ request('type')=='house'?'selected':'' }}>{{ __('user.types.house') }}</option>
              <option value="apartment" {{ request('type')=='apartment'?'selected':'' }}>{{ __('user.types.apartment') }}</option>
              <option value="villa" {{ request('type')=='villa'?'selected':'' }}>{{ __('user.types.villa') }}</option>
            </select>
          </div>
          
          <div class="search-field">
            <label class="search-label">🎯 Purpose</label>
            <select name="purpose" class="form-select">
              <option value="">All purposes</option>
              <option value="sale" {{ request('purpose')=='sale'?'selected':'' }}>For Sale</option>
              <option value="rent" {{ request('purpose')=='rent'?'selected':'' }}>For Rent</option>
              <option value="mortgage" {{ request('purpose')=='mortgage'?'selected':'' }}>Mortgage</option>
            </select>
          </div>
          
          <div class="search-action">
            <button type="submit" class="search-btn">
              <i class="bi bi-search"></i> Search
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- ACTION BAR -->
  <div class="action-bar mb-4">
    <div class="tabs-wrapper">
      <button class="tab-btn active" data-tab="all">
        <i class="bi bi-grid-3x3-gap-fill"></i> My Properties
      </button>
      <button class="tab-btn" data-tab="fav">
        <i class="bi bi-heart-fill"></i> Favorites
      </button>
    </div>
    <button class="add-property-btn" data-bs-toggle="modal" data-bs-target="#userAddPropertyModal">
      <i class="bi bi-plus-circle"></i> Add Property
    </button>
  </div>

  <!-- PROPERTIES GRID -->
  <div class="properties-grid" id="propertiesContainer">
    
    <!-- FAVORITES SECTION -->
    @if(isset($favorites) && $favorites->count())
    <div id="favoritesSection" class="favorites-section" style="display: none;">
      <div class="section-header">
        <h3><i class="bi bi-heart-fill text-danger"></i> Saved Properties</h3>
        <span class="section-count">{{ $favorites->count() }} properties</span>
      </div>
      <div class="row g-4">
        @foreach($favorites as $fav)
        <div class="col-lg-4 col-md-6">
          <div class="property-card premium-card">
            <div class="card-badge favorite-badge">
              <i class="bi bi-heart-fill"></i> Favorite
            </div>
            @if($fav->images && $fav->images->count())
              <div class="card-image">
                <img src="{{ asset('storage/properties/'.$fav->images->first()->image) }}" alt="{{ $fav->title }}">
                <div class="image-overlay"></div>
              </div>
            @else
              <div class="card-image">
                <img src="{{ asset('assets/image/1.jpg') }}" alt="Property">
                <div class="image-overlay"></div>
              </div>
            @endif
            <div class="card-content">
              <h4>{{ Str::limit($fav->title, 40) }}</h4>
              <div class="property-location">
                <i class="bi bi-geo-alt-fill"></i> {{ $fav->location }}
              </div>
              <div class="property-price">${{ number_format($fav->price) }}</div>
              <div class="property-features">
                <span><i class="bi bi-door-closed"></i> {{ $fav->bedrooms }} beds</span>
                <span><i class="bi bi-droplet"></i> {{ $fav->bathrooms }} baths</span>
                <span><i class="bi bi-aspect-ratio"></i> {{ $fav->area }} m²</span>
              </div>
              <div class="card-actions">
                <form action="{{ route('property.save',$fav->id) }}" method="POST" class="favorite-form">
                  @csrf
                  <button class="action-btn remove-btn"><i class="bi bi-heart-break"></i> Remove</button>
                </form>
                <a href="{{ route('property.view',$fav->id) }}" class="action-btn view-btn"><i class="bi bi-eye"></i> View</a>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    @else
    <div id="favoritesSection" class="favorites-section" style="display: none;">
      <div class="empty-state">
        <i class="bi bi-heart"></i>
        <h4>No favorites yet</h4>
        <p>Start saving properties you love by clicking the heart icon</p>
      </div>
    </div>
    @endif

    <!-- ALL PROPERTIES SECTION -->
    <div id="allPropertiesSection">
      @if($properties->count() > 0)
      <div class="section-header">
        <h3><i class="bi bi-house-door-fill"></i> My Properties</h3>
        <span class="section-count">{{ $properties->total() }} properties</span>
      </div>
      <div class="row g-4">
        @foreach($properties as $property)
        <div class="col-lg-4 col-md-6">
          <div class="property-card premium-card">
            
            <!-- EDIT MODAL -->
            <div class="modal fade" id="editUserProperty{{ $property->id }}">
              <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil-square"></i> Edit Property</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <form action="{{ route('user.property.update',$property->id) }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      @method('PUT')
                      <div class="row">
                        <div class="col-md-8">
                          <label>Property Title</label>
                          <input type="text" name="title" value="{{ $property->title }}" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                          <label>Price ($)</label>
                          <input type="number" name="price" value="{{ $property->price }}" class="form-control" required>
                        </div>
                      </div>
                      <label>Description</label>
                      <textarea name="description" class="form-control" rows="3">{{ $property->description }}</textarea>
                      <label>Location</label>
                      <input type="text" name="location" value="{{ $property->location }}" class="form-control" required>
                      <div class="row">
                        <div class="col-md-6">
                          <label>Property Type</label>
                          <select name="type" class="form-select" required>
                            <option value="house" {{ $property->type=='house'?'selected':'' }}>House</option>
                            <option value="apartment" {{ $property->type=='apartment'?'selected':'' }}>Apartment</option>
                            <option value="villa" {{ $property->type=='villa'?'selected':'' }}>Villa</option>
                          </select>
                        </div>
                        <div class="col-md-6">
                          <label>Purpose</label>
                          <select name="purpose" class="form-select" required>
                            <option value="sale" {{ $property->purpose=='sale'?'selected':'' }}>For Sale</option>
                            <option value="rent" {{ $property->purpose=='rent'?'selected':'' }}>For Rent</option>
                            <option value="mortgage" {{ $property->purpose=='mortgage'?'selected':'' }}>Mortgage</option>
                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <label>Bedrooms</label>
                          <input type="number" name="bedrooms" value="{{ $property->bedrooms }}" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                          <label>Bathrooms</label>
                          <input type="number" name="bathrooms" value="{{ $property->bathrooms }}" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                          <label>Area (m²)</label>
                          <input type="number" name="area" value="{{ $property->area }}" class="form-control" required>
                        </div>
                      </div>
                      <label>Update Images</label>
                      <input type="file" name="images[]" class="form-control" multiple>
                      <button type="submit" class="btn btn-save mt-3">Save Changes</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <!-- DELETE MODAL -->
            <div class="modal fade" id="deleteUserProperty{{ $property->id }}">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-trash"></i> Delete Property</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body text-center">
                    <i class="bi bi-exclamation-triangle" style="font-size: 48px; color: #f59e0b;"></i>
                    <p class="mt-3">Are you sure you want to delete "{{ $property->title }}"?</p>
                    <p class="text-muted small">This action cannot be undone.</p>
                  </div>
                  <div class="modal-footer justify-content-center">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('user.property.delete',$property->id) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-danger">Yes, Delete</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <!-- STATUS BADGE -->
            @php
            $statusMap = [
                'pending' => ['text' => 'Under Review', 'class' => 'status-pending'],
                'approved' => ['text' => 'Live', 'class' => 'status-approved'],
                'rejected' => ['text' => 'Rejected', 'class' => 'status-rejected'],
            ];
            $status = $statusMap[$property->approval_status] ?? ['text' => 'Pending', 'class' => 'status-pending'];
            @endphp
            <div class="status-badge {{ $status['class'] }}">{{ $status['text'] }}</div>

            <!-- CAROUSEL -->
            @if($property->images && $property->images->count())
            <div id="carousel{{ $property->id }}" class="carousel slide">
              <div class="carousel-inner">
                @foreach($property->images as $key => $img)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                  <img src="{{ asset('storage/properties/'.$img->image) }}" alt="{{ $property->title }}">
                </div>
                @endforeach
              </div>
              @if($property->images->count() > 1)
              <button class="carousel-control-prev" data-bs-target="#carousel{{ $property->id }}" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
              </button>
              <button class="carousel-control-next" data-bs-target="#carousel{{ $property->id }}" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
              </button>
              @endif
            </div>
            @else
            <div class="card-image">
              <img src="{{ asset('assets/image/1.jpg') }}" alt="Property">
            </div>
            @endif

            <div class="card-content">
              <h4>{{ Str::limit($property->title, 40) }}</h4>
              <div class="property-location">
                <i class="bi bi-geo-alt-fill"></i> {{ $property->location }}
              </div>
              <div class="property-price">${{ number_format($property->price) }}</div>
              <div class="property-features">
                <span><i class="bi bi-door-closed"></i> {{ $property->bedrooms }}</span>
                <span><i class="bi bi-droplet"></i> {{ $property->bathrooms }}</span>
                <span><i class="bi bi-aspect-ratio"></i> {{ $property->area }}m²</span>
              </div>
              <div class="card-actions">
                @if($property->user_id == auth()->id())
                <button class="action-btn edit-btn" data-bs-toggle="modal" data-bs-target="#editUserProperty{{ $property->id }}">
                  <i class="bi bi-pencil"></i> Edit
                </button>
                <button class="action-btn delete-btn" data-bs-toggle="modal" data-bs-target="#deleteUserProperty{{ $property->id }}">
                  <i class="bi bi-trash"></i> Delete
                </button>
                @endif
                <button class="action-btn compare-btn" onclick="addToCompare({{ $property->id }})">
                  <i class="bi bi-bar-chart"></i> Compare
                </button>
                <a href="{{ route('property.view', $property->id) }}" class="action-btn view-btn">
                  <i class="bi bi-eye"></i> View
                </a>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
      <div class="pagination-wrapper mt-5">
        {{ $properties->appends(request()->query())->links() }}
      </div>
      @else
      <div class="empty-state">
        <i class="bi bi-building"></i>
        <h4>No properties yet</h4>
        <p>Get started by adding your first property</p>
        <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#userAddPropertyModal">
          <i class="bi bi-plus-circle"></i> Add Property
        </button>
      </div>
      @endif
    </div>
  </div>
</div>

<!-- COMPARE MODAL -->
<div class="modal fade" id="compareModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="bi bi-bar-chart"></i> Compare Properties</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <div id="compareListContainer" class="mb-3"></div>
        <button id="compareNowBtn" class="compare-now-btn" disabled>Compare Now</button>
      </div>
    </div>
  </div>
</div>

<!-- LOGOUT MODAL -->
<form method="POST" action="{{ route('logout') }}">
  @csrf
  <div class="modal fade" id="userLogoutModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="bi bi-box-arrow-right"></i> Logout</h5>
          <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body text-center">
          <i class="bi bi-question-circle" style="font-size: 48px;"></i>
          <p class="mt-3">Are you sure you want to logout?</p>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Logout</button>
        </div>
      </div>
    </div>
  </div>
</form>

<!-- ADD PROPERTY MODAL -->
<div class="modal fade" id="userAddPropertyModal">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Add New Property</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('user.property.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-8">
              <label>Property Title</label>
              <input type="text" name="title" class="form-control" placeholder="Modern 3-bedroom apartment in city center" required>
            </div>
            <div class="col-md-4">
              <label>Price ($)</label>
              <input type="number" name="price" class="form-control" placeholder="85000" required>
            </div>
          </div>
          <label>Description</label>
          <textarea name="description" class="form-control" rows="3" placeholder="Describe features, location, nearby places..."></textarea>
          <label>Location</label>
          <input type="text" name="location" class="form-control" placeholder="Kabul, Karte Seh" required>
          <div class="row">
            <div class="col-md-6">
              <label>Property Type</label>
              <select name="type" class="form-select" required>
                <option value="" disabled selected>Select property type</option>
                <option value="house">House</option>
                <option value="apartment">Apartment</option>
                <option value="villa">Villa</option>
              </select>
            </div>
            <div class="col-md-6">
              <label>Purpose</label>
              <select name="purpose" class="form-select" required>
                <option value="" disabled selected>Select purpose</option>
                <option value="sale">For Sale</option>
                <option value="rent">For Rent</option>
                <option value="mortgage">Mortgage</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Bedrooms</label>
              <input type="number" name="bedrooms" class="form-control" placeholder="3" required>
            </div>
            <div class="col-md-4">
              <label>Bathrooms</label>
              <input type="number" name="bathrooms" class="form-control" placeholder="2" required>
            </div>
            <div class="col-md-4">
              <label>Area (m²)</label>
              <input type="number" name="area" class="form-control" placeholder="120" required>
            </div>
          </div>
          <label>Property Images</label>
          <input type="file" name="images[]" class="form-control" multiple>
          <button type="submit" class="btn btn-publish mt-3">Publish Property</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('assets/js/User.js') }}"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const tabBtns = document.querySelectorAll('.tab-btn');
    const favoritesSection = document.getElementById('favoritesSection');
    const allPropertiesSection = document.getElementById('allPropertiesSection');
    
    if (!favoritesSection || !allPropertiesSection) return;
    
    function showAllProperties() {
        favoritesSection.style.display = 'none';
        allPropertiesSection.style.display = 'block';
    }
    
    function showFavoritesOnly() {
        favoritesSection.style.display = 'block';
        allPropertiesSection.style.display = 'none';
    }
    
    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            tabBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            if (this.dataset.tab === 'all') {
                showAllProperties();
            } else if (this.dataset.tab === 'fav') {
                showFavoritesOnly();
            }
        });
    });
    
    const activeTab = document.querySelector('.tab-btn.active');
    if (activeTab && activeTab.dataset.tab === 'fav') {
        showFavoritesOnly();
    } else {
        showAllProperties();
    }
});
</script>
@endpush