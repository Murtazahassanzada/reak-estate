@extends('layouts.user')
@section('title','Property')
@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/Property.css') }}">
@endpush
<!--<select><option>the number</option></select>-->

<!-- HEADER -->
<header class="admin-header">
  <div>
    <img alt="Logo" class="dashboard-logo" src="../assets/image/lOGO.png"/>
    <!--<h4>REMS Admin</h4>
    <small>Property Management</small>-->
    <span class="brand-text">Property Management</span>
  </div>
  <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm">
    <i class="bi bi-arrow-left"></i> Back to Dashboard
  </a>
</header>

<!-- STATS -->
<section class="container stats-section">
  <div class="row g-4">
    <div class="col-md-4">
      <div class="stat-card blue">
        <i class="bi bi-buildings"></i>
        <h5>Total Properties</h5>
        <p>120</p>
      </div>
    </div>

    <div class="col-md-4">
      <div class="stat-card green">
        <i class="bi bi-check-circle"></i>
        <h5>Active</h5>
        <p>90</p>
      </div>
    </div>

    <div class="col-md-4">
      <div class="stat-card red">
        <i class="bi bi-x-circle"></i>
        <h5>Deleted</h5>
        <p>30</p>
      </div>
    </div>
  </div>
</section>

<!-- PROPERTY TABLE -->
<section class="container mt-5">
  <div class="property-card">

    <div class="card-header-custom">
      <h5><i class="bi bi-house-gear"></i> Property List</h5>
      <button class="btn btn-success"
        data-bs-toggle="modal"
        data-bs-target="#addPropertyModal">
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
    <img src="../assets/image/1.jpg" class="prop-img">
    <span>{{ $property->title }}</span>
  </td>

  <td>{{ $property->location }}</td>

  <td>${{ $property->price }}</td>

  <td>
    <span class="badge bg-success">
      {{ $property->status }}
    </span>
  </td>

  <td class="text-center">
    <button class="btn btn-sm btn-primary me-2"
      data-bs-toggle="modal"
      data-bs-target="#editModal{{ $property->id }}">
      Edit
    </button>

    <button class="btn btn-sm btn-danger"
      data-bs-toggle="modal"
      data-bs-target="#deleteModal{{ $property->id }}">
      Delete
    </button>
  </td>
</tr>
@endforeach
</tbody>


      </table>
    </div>

  </div>
</section>
<!-- Add Property Modal -->
<div class="modal fade" id="addPropertyModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">
          <i class="bi bi-plus-circle"></i> Add New Property
        </h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form action="{{ route('properties.store') }}" method="POST">
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

<div class="mt-3 text-end">
<button type="submit" class="btn btn-success">
       Save Property
</button>
</div>

</form>
    </div>
    </div>
</div>
</div>
<!--edit property model-->
@foreach($properties as $property)

<!-- Edit Modal -->
<div class="modal fade" id="editModal{{ $property->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5>Edit Property</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('properties.update',$property->id) }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="text"
                           name="title"
                           value="{{ $property->title }}"
                           class="form-control mb-2"
                           placeholder="Title"
                           required>

                    <textarea name="description"
                              class="form-control mb-2"
                              placeholder="Description">{{ $property->description }}</textarea>

                    <input type="text"
                           name="location"
                           value="{{ $property->location }}"
                           class="form-control mb-2"
                           placeholder="Location"
                           required>

                    <select name="status"
                            class="form-control mb-2"
                            required>
                        <option value="Active"
                            {{ $property->status == 'Active' ? 'selected' : '' }}>
                            Active
                        </option>
                        <option value="Inactive"
                            {{ $property->status == 'Inactive' ? 'selected' : '' }}>
                            Inactive
                        </option>
                    </select>

                    <input type="number"
                           name="price"
                           step="0.01"
                           value="{{ $property->price }}"
                           class="form-control mb-2"
                           placeholder="Price"
                           required>

                    <input type="number"
                           name="bedrooms"
                           value="{{ $property->bedrooms }}"
                           class="form-control mb-2"
                           placeholder="Bedrooms"
                           required>

                    <input type="number"
                           name="bathrooms"
                           value="{{ $property->bathrooms }}"
                           class="form-control mb-2"
                           placeholder="Bathrooms"
                           required>

                    <input type="number"
                           name="area"
                           value="{{ $property->area }}"
                           class="form-control mb-2"
                           placeholder="Area"
                           required>

                    <!-- Show Current Image -->
                    @if($property->image)
                        <div class="mb-2">
                            <img src="{{ asset('images/'.$property->image) }}"
                                 width="100">
                        </div>
                    @endif

                    <input type="file"
                           name="image"
                           class="form-control mb-3">

                    <button type="submit"
                            class="btn btn-primary w-100">
                        Save Changes
                    </button>

                </form>
            </div>

        </div>
    </div>
</div>

@endforeach

      <!--<div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary">Save Changes</button>
      </div>

    </div>
  </div>
</div>-->
<!-- Delete property -->

@foreach($properties as $property)

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
                    Are you sure you want to delete
                    <strong>{{ $property->title }}</strong> ?
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit" class="btn btn-danger">
                        Yes Delete
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@endforeach
@push('scripts')
<script src="{{ asset('assets/js/Property.js') }}"></script>
@endpush
<script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

@endsection
