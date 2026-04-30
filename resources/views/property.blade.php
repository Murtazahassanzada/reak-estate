@extends('layouts.user')
@section('title','Property')
@section('content')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/Property.css') }}">
@endpush

<!-- HEADER -->
<header class="admin-header">
  <div class="d-flex align-items-center">
    <img alt="Logo" class="dashboard-logo" src="{{ asset('assets/image/lOGO.png') }}"/>
    <span class="brand-text ms-2">Property Management</span>
  </div>
<a href="{{ url('/admin/dashboard') }}" class="btn dashboard-back-btn btn-sm">
    <i class="bi bi-arrow-left"></i>
    {{ __('property.back_dashboard') }}
</a>
</header>

<!-- STATS -->
<section class="container stats-section">
  <div class="row g-4">
    <div class="col-md-4">
      <div class="stat-card blue">
        <i class="bi bi-buildings"></i>
        <div>
          <h5>Total Properties</h5>
          <p>120</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="stat-card green">
        <i class="bi bi-check-circle"></i>
        <div>
          <h5>Active</h5>
          <p>90</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="stat-card red">
        <i class="bi bi-x-circle"></i>
        <div>
          <h5>Deleted</h5>
          <p>30</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- PROPERTY TABLE -->
<section class="container mt-5">
  <div class="property-card">

    <div class="card-header-custom">
      <h5><i class="bi bi-house-gear"></i> Property List</h5>
      <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPropertyModal">
        <i class="bi bi-plus-circle"></i> Add Property
      </button>
    </div>

    <div class="table-responsive">
      <table class="table align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>Property</th>
            <th>Type</th>
            <th>Price</th>
            <th>Status</th>
            <th class="text-center">Action</th>
          </tr>
        </thead>

        <tbody>
          @foreach($properties as $property)
          <tr>
            <td>{{ $property->id }}</td>
            <td class="d-flex align-items-center gap-2">
             @php
            $img = $property->images->first();
            @endphp

           <img
            src="{{ $img ? asset('storage/properties/'.$img->image) : asset('assets/image/1.jpg') }}"
            class="prop-img">
              <span>{{ $property->title }}</span>
            </td>
            <td>{{ $property->location }}</td>
            <td>${{ $property->price }}</td>
            <td>
              <span class="badge bg-success">{{ $property->status }}</span>
            </td>
            <td class="text-center">
              <button class="action-btn edit me-2" data-bs-toggle="modal" data-bs-target="#editModal{{ $property->id }}">
                Edit
              </button>
              <button class="action-btn delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $property->id }}">
                Delete
              </button>
              <button onclick="addToCompare({{ $property->id }})" class="btn btn-primary">
              Compare
             </button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

  </div>
</section>

<!-- ADD PROPERTY MODAL -->
<div class="modal fade" id="addPropertyModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header bg-success text-white">
        <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Add New Property</h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
    <form action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<input type="text" name="title" class="form-control mb-2" placeholder="Title">
<textarea name="description" class="form-control mb-2" placeholder="Description"></textarea>
<input type="text" name="location" class="form-control mb-2" placeholder="Location">

<select name="status" class="form-control mb-2">
    <option value="Active">Active</option>
    <option value="Inactive">Inactive</option>
</select>

<input type="number" name="price" class="form-control mb-2" placeholder="Price" required>
<input type="number" name="bedrooms" class="form-control mb-2" placeholder="Bedrooms" required>
<input type="number" name="bathrooms" class="form-control mb-2" placeholder="Bathrooms" required>
<input type="number" name="area" class="form-control mb-2" placeholder="Area" required>

<label>Property Images</label>
<input type="file" name="images[]" class="form-control mb-3" multiple>

<div class="mt-3 text-end">
    <button type="submit" class="btn btn-success">Save Property</button>
</div>
</form>
      </div>
    </div>
  </div>
</div>

<!-- EDIT & DELETE MODALS -->
@foreach($properties as $property)
  <!-- EDIT -->
  <div class="modal fade" id="editModal{{ $property->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5>Edit Property</h5>
          <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('properties.update',$property->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="text" name="title" value="{{ $property->title }}" class="form-control mb-2" placeholder="Title" required>
            <textarea name="description" class="form-control mb-2" placeholder="Description">{{ $property->description }}</textarea>
            <input type="text" name="location" value="{{ $property->location }}" class="form-control mb-2" placeholder="Location" required>
            <select name="status" class="form-control mb-2" required>
              <option value="Active" {{ $property->status=='Active'?'selected':'' }}>Active</option>
              <option value="Inactive" {{ $property->status=='Inactive'?'selected':'' }}>Inactive</option>
            </select>
            <input type="number" name="price" step="0.01" value="{{ $property->price }}" class="form-control mb-2" placeholder="Price" required>
            <input type="number" name="bedrooms" value="{{ $property->bedrooms }}" class="form-control mb-2" placeholder="Bedrooms" required>
            <input type="number" name="bathrooms" value="{{ $property->bathrooms }}" class="form-control mb-2" placeholder="Bathrooms" required>
            <input type="number" name="area" value="{{ $property->area }}" class="form-control mb-2" placeholder="Area" required>
        <div class="mb-2 d-flex flex-wrap gap-2">
         @foreach($property->images as $img)
        <img src="{{ asset('storage/properties/'.$img->image) }}" width="80">
          @endforeach
         </div>

  <input type="file" name="images[]" class="form-control mb-3" multiple>
            <button type="submit" class="btn btn-primary w-100">Save Changes</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- DELETE -->
  <div class="modal fade" id="deleteModal{{ $property->id }}" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{ route('properties.destroy', $property->id) }}" method="POST">
          @csrf
          @method('DELETE')
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title">Delete Property</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            Are you sure you want to delete <strong>{{ $property->title }}</strong>?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger">Yes Delete</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endforeach

@push('scripts')
<script src="{{ asset('assets/js/Property.js') }}"></script>
<script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
@endpush
<script>
let selected = [];

function addToCompare(id) {

    if (selected.includes(id)) {
        alert("This property is already selected");
        return;
    }

    if (selected.length >= 2) {
        alert("Only 2 properties allowed");
        return;
    }

    selected.push(id);

    if (selected.length === 2) {
        window.location.href = `/compare-properties?ids=${selected.join(',')}`;
    }
}
</script>
@endsection
