@extends('layouts.user')
@php
    $isAdmin = auth()->user()->role === 'admin';
@endphp
@section('title', __('property.title'))

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/Property.css') }}">
<style>
  .filter-form .form-control,
  .filter-form .form-select {
    min-width: 120px;
  }
  .modal-lg {
    max-width: 800px;
  }
  .property-img {
    width: 80px;
    height: 60px;
    object-fit: cover;
    border-radius: 4px;
    border: 1px solid #ddd;
  }
</style>
@endpush

@section('content')

<!-- HEADER -->
<header class="admin-header d-flex justify-content-between align-items-center mb-4">
  <div class="d-flex align-items-center gap-2">
    <img alt="Logo" class="dashboard-logo" src="{{ asset('assets/image/lOGO.png') }}"/>
    <span class="brand-text">{{ __('property.management') }}</span>
  </div>

  <a href="{{ url('/admin') }}" class="btn btn-light btn-sm">
    <i class="bi bi-arrow-left"></i>
    {{ __('property.back_dashboard') }}
  </a>
</header>

<!-- CARD -->
<div class="card shadow-sm">

  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">{{ __('property.list') }}</h5>

    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPropertyModal">
      {{ __('property.add') }}
    </button>
  </div>

  <div class="card-body">

    <!-- FILTER -->
    <form method="GET" action="{{ route('properties.index') }}"
          class="mb-3 d-flex gap-2 flex-wrap filter-form">

      <input type="text" name="search" class="form-control"
             placeholder="{{ __('property.search') }}"
             value="{{ request('search') }}">

      <select name="status" class="form-select">
        <option value="">{{ __('property.status') }}</option>
        <option value="Active" {{ request('status')=='Active'?'selected':'' }}>
          {{ __('property.status_Active') }}
        </option>
        <option value="Inactive" {{ request('status')=='Inactive'?'selected':'' }}>
          {{ __('property.status_Inactive') }}
        </option>
      </select>

  <select name="purpose" class="form-select">
    <option value="">{{ __('property.purpose') }}</option>

    <option value="sale" {{ request('purpose')=='sale'?'selected':'' }}>
        {{ __('property.sale') }}
    </option>

    <option value="rent" {{ request('purpose')=='rent'?'selected':'' }}>
        {{ __('property.rent') }}
    </option>

    <option value="mortgage" {{ request('purpose')=='mortgage'?'selected':'' }}>
        {{ __('property.mortgage') }}
    </option>
</select>

      <select name="type" class="form-select">
        <option value="">{{ __('property.type') }}</option>
        <option value="house" {{ request('type')=='house'?'selected':'' }}>
          {{ __('property.house') }}
        </option>
        <option value="apartment" {{ request('type')=='apartment'?'selected':'' }}>
          {{ __('property.apartment') }}
        </option>
        <option value="villa" {{ request('type')=='villa'?'selected':'' }}>
          {{ __('property.villa') }}
        </option>
      </select>

      <input type="text" name="location" class="form-control"
             placeholder="{{ __('property.location') }}"
             value="{{ request('location') }}">

      <button class="btn btn-primary">
        {{ __('property.filter') }}
      </button>
    </form>

    <!-- TABLE -->
    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle">

        <thead class="table-light">
          <tr>
            <th>{{ __('property.title_col') }}</th>
            <th>{{ __('property.price') }}</th>
            <th>{{ __('property.type') }}</th>
            <th>{{ __('property.purpose') }}</th>
            <th>{{ __('property.status') }}</th>
            <th>{{ __('property.action') }}</th>
          </tr>
        </thead>
<tbody>
@forelse($properties as $property)

<tr>

<td class="d-flex align-items-center gap-2">

    @php
        $img = $property->images->first();
    @endphp

    <img
        src="{{ $img ? asset('storage/properties/'.$img->image) : asset('assets/image/download.jfif') }}"
        class="property-img">

    <span>{{ $property->title }}</span>

</td>
  <td class="text-success fw-bold">
    ${{ number_format($property->price,2) }}
  </td>

  <td>{{ ucfirst($property->type) }}</td>
<td>{{ __('property.'.$property->purpose) }}</td>

  <td>
    <span class="badge {{ $property->status=='Active' ? 'bg-success' : 'bg-secondary' }}">
      {{ __('property.status_'.$property->status) }}
    </span>
  </td>

 <td class="d-flex gap-1 flex-wrap justify-content-center">

  <!-- APPROVE -->
  <form action="{{ route('properties.approve', $property->id) }}" method="POST">
    @csrf
    <button class="btn btn-success btn-sm">
      ✅ Approve
    </button>
  </form>

  <!-- REJECT -->
  <form action="{{ route('properties.reject', $property->id) }}" method="POST">
    @csrf
    <input type="hidden" name="reason" value="Not acceptable">
    <button class="btn btn-danger btn-sm">
      ❌ Reject
    </button>
  </form>

</td>
</tr>

<!-- DELETE MODAL -->
<div class="modal fade" id="deleteModal{{ $property->id }}">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header bg-danger text-white">
        <h5>{{ __('property.confirm_delete') }}</h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        {!! __('property.delete_msg', ['name'=>$property->title]) !!}
      </div>

      <div class="modal-footer">
        <form action="{{ route('properties.destroy', $property->id) }}" method="POST">
          @csrf
          @method('DELETE')
          <button class="btn btn-danger">
            {{ __('property.yes_delete') }}
          </button>
        </form>

        <button class="btn btn-secondary" data-bs-dismiss="modal">
          {{ __('property.cancel') }}
        </button>
      </div>

    </div>
  </div>
</div>

<!-- EDIT MODAL -->
<div class="modal fade" id="editModal{{ $property->id }}">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header bg-primary text-white">
        <h5>{{ __('property.edit') }}</h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <!-- IMAGES -->
        <div class="mb-2 d-flex flex-wrap gap-2">
          @foreach($property->images as $img)
            <div class="position-relative">
              <img src="{{ asset('storage/properties/'.$img->image) }}" class="property-img">

              <form method="POST"
                    action="{{ route('property.image.delete',$img->id) }}"
                    class="position-absolute top-0 end-0">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="btn btn-danger btn-sm p-0"
                        style="width:20px;height:20px;">x</button>
              </form>
            </div>
          @endforeach
        </div>

        <!-- FORM -->
        <form action="{{ route('properties.update',$property->id) }}"
              method="POST"
              enctype="multipart/form-data">

          @csrf
          @method('PUT')

          <input type="text" name="title"
                 value="{{ $property->title }}"
                 class="form-control mb-2"
                 placeholder="{{ __('property.title_col') }}" required>

          <textarea name="description"
                    class="form-control mb-2"
                    placeholder="{{ __('property.description') }}">{{ $property->description }}</textarea>

          <input type="text" name="location"
                 value="{{ $property->location }}"
                 class="form-control mb-2"
                 placeholder="{{ __('property.location') }}" required>

          <select name="status" class="form-control mb-2">
            <option value="Active" {{ $property->status=='Active'?'selected':'' }}>
              {{ __('property.status_Active') }}
            </option>
            <option value="Inactive" {{ $property->status=='Inactive'?'selected':'' }}>
              {{ __('property.status_Inactive') }}
            </option>
          </select>

        <select name="purpose" class="form-control mb-2">

    <option value="sale" {{ $property->purpose=='sale'?'selected':'' }}>
        {{ __('property.sale') }}
    </option>

    <option value="rent" {{ $property->purpose=='rent'?'selected':'' }}>
        {{ __('property.rent') }}
    </option>

    <option value="mortgage" {{ $property->purpose=='mortgage'?'selected':'' }}>
        {{ __('property.mortgage') }}
    </option>

</select>

          <select name="type" class="form-control mb-2">
            <option value="house" {{ $property->type=='house'?'selected':'' }}>
              {{ __('property.house') }}
            </option>
            <option value="apartment" {{ $property->type=='apartment'?'selected':'' }}>
              {{ __('property.apartment') }}
            </option>
            <option value="villa" {{ $property->type=='villa'?'selected':'' }}>
              {{ __('property.villa') }}
            </option>
          </select>

          <input type="number" name="price"
                 value="{{ $property->price }}"
                 class="form-control mb-2"
                 placeholder="{{ __('property.price') }}" required>

          <input type="number" name="bedrooms"
                 value="{{ $property->bedrooms }}"
                 class="form-control mb-2"
                 placeholder="{{ __('property.bedrooms') }}" required>

          <input type="number" name="bathrooms"
                 value="{{ $property->bathrooms }}"
                 class="form-control mb-2"
                 placeholder="{{ __('property.bathrooms') }}" required>

          <input type="number" name="area"
                 value="{{ $property->area }}"
                 class="form-control mb-2"
                 placeholder="{{ __('property.area') }}" required>

          <input type="file" name="images[]" class="form-control mb-3" multiple>

          <button class="btn btn-primary w-100">
            {{ __('property.edit') }}
          </button>

        </form>

      </div>
    </div>
  </div>
</div>

@empty
<tr>
  <td colspan="6" class="text-center text-muted">
    {{ __('property.empty') }}
  </td>
</tr>
@endforelse
</tbody>

</table>
</div>

</div>
</div>

<!-- ADD MODAL (بیرون از حلقه) -->
<div class="modal fade" id="addPropertyModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header bg-success text-white">
        <h5>{{ __('property.add') }}</h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <form action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <input type="text" name="title" class="form-control mb-2"
                 placeholder="{{ __('property.title_col') }}" required>

          <textarea name="description" class="form-control mb-2"
                    placeholder="{{ __('property.description') }}"></textarea>

          <input type="text" name="location" class="form-control mb-2"
                 placeholder="{{ __('property.location') }}">

          <select name="status" class="form-control mb-2">
            <option value="Active">{{ __('property.status_Active') }}</option>
            <option value="Inactive">{{ __('property.status_Inactive') }}</option>
          </select>

       <select name="purpose" class="form-control mb-2">
    <option value="sale">{{ __('property.sale') }}</option>
    <option value="rent">{{ __('property.rent') }}</option>
    <option value="mortgage">{{ __('property.mortgage') }}</option>
</select>
          <select name="type" class="form-control mb-2">
            <option value="house">{{ __('property.house') }}</option>
            <option value="apartment">{{ __('property.apartment') }}</option>
            <option value="villa">{{ __('property.villa') }}</option>
          </select>

          <input type="number" name="price" class="form-control mb-2"
                 placeholder="{{ __('property.price') }}" required>

          <input type="number" name="bedrooms" class="form-control mb-2"
                 placeholder="{{ __('property.bedrooms') }}" required>

          <input type="number" name="bathrooms" class="form-control mb-2"
                 placeholder="{{ __('property.bathrooms') }}" required>

          <input type="number" name="area" class="form-control mb-2"
                 placeholder="{{ __('property.area') }}" required>

          <input type="file" name="images[]" class="form-control mb-3" multiple>

          <button class="btn btn-success w-100">
            {{ __('property.add') }}
          </button>

        </form>
      </div>

    </div>
  </div>
</div>

@endsection
