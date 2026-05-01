@extends('layouts.user')

@section('title', __('view.title'))

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/View.css') }}">
@endpush

@section('content')
<!-- هدر ساده فقط با دکمه بازگشت -->
<div class="simple-header d-flex align-items-center justify-content-start">
    <a href="{{ route('dashboard', app()->getLocale()) }}" class="back-button" aria-label="{{ __('view.back') }}">
        <i class="bi bi-arrow-{{ app()->getLocale() == 'fa' ? 'right' : 'left' }}"></i>
        <span>{{ __('view.back') }}</span>
    </a>
</div>

<div class="container my-5">
    <div class="property-card">
        <div class="row g-0">
            <!-- سمت چپ: گالری تصاویر با بهبود دسترسی -->
            <div class="col-md-6">
                @if($property->images && $property->images->count())
                    <div id="propCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($property->images as $key => $img)
                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                    <img src="{{ asset('storage/properties/'.$img->image) }}"
                                         class="property-img"
                                         alt="{{ __('view.image_alt') }}"
                                         loading="lazy">
                                </div>
                            @endforeach
                        </div>
                        @if($property->images->count() > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#propCarousel" data-bs-slide="prev" aria-label="Previous">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#propCarousel" data-bs-slide="next" aria-label="Next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            </button>
                        @endif
                    </div>
                @else
                    <img src="{{ asset('assets/image/download.jfif') }}" class="property-img" alt="{{ __('view.image_alt') }}">
                @endif
            </div>

            <!-- سمت راست: اطلاعات -->
            <div class="col-md-6">
                <div class="details-section">
                    <h1 class="property-title">{{ $property->localized_title ?? $property->title }}</h1>
                    <span class="type-badge">{{ __('view.types.'.$property->type) }}</span>

                    <div class="info-line">
                        <i class="bi bi-geo-alt-fill"></i>
                        <span><strong>{{ __('view.location') }}:</strong>
                            {{ app()->getLocale() == 'fa' ? ($property->location_fa ?? $property->location) : ($property->location_en ?? $property->location) }}
                        </span>
                    </div>

                    <div class="price-box">
                        <i class="bi bi-cash-stack fs-4"></i>
                        <strong>{{ config('app.currency', '$') }}{{ number_format($property->price, 2) }}</strong>
                    </div>

                    <div class="feature-grid">
                        <div class="feature-tile">
                            <div class="feature-icon">🛏️</div>
                            <div class="feature-value">{{ $property->bedrooms }}</div>
                            <div class="feature-label">{{ __('view.beds') }}</div>
                        </div>
                        <div class="feature-tile">
                            <div class="feature-icon">🛁</div>
                            <div class="feature-value">{{ $property->bathrooms }}</div>
                            <div class="feature-label">{{ __('view.baths') }}</div>
                        </div>
                        <div class="feature-tile">
                            <div class="feature-icon">📐</div>
                            <div class="feature-value">{{ $property->area }}</div>
                            <div class="feature-label">{{ __('view.area') }}</div>
                        </div>
                    </div>

                    <div class="description-card">
                        {{ app()->getLocale() == 'fa' ? ($property->description_fa ?? $property->description) : ($property->description_en ?? $property->description) }}
                    </div>

                    <div class="action-group">
                        @php
                            $isSaved = auth()->check() && auth()->user()->favorites()->where('property_id', $property->id)->exists();
                        @endphp
                        <form action="{{ route('property.save', ['locale' => app()->getLocale(), 'id' => $property->id]) }}" method="POST">
                            @csrf
                            <button class="btn-save {{ $isSaved ? 'saved' : '' }}" type="submit">
                                @if($isSaved)
                                    💔 {{ __('view.remove_saved') }}
                                @else
                                    ❤️ {{ __('view.save_property') }}
                                @endif
                            </button>
                        </form>

                        @auth
                            <form action="{{ route('property.contact', ['locale' => app()->getLocale(), 'id' => $property->id]) }}" method="POST">
                                @csrf
                                <textarea name="message" class="form-control" rows="2" placeholder="{{ __('view.write_message') }}" required></textarea>
                                <button class="btn-contact" type="submit">📞 {{ __('view.contact_agent') }}</button>
                            </form>
                        @endauth
                        @guest
                            <a href="{{ route('login', app()->getLocale()) }}" class="btn-contact d-block text-center text-decoration-none">
                                🔐 {{ __('view.login_contact') }}
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection