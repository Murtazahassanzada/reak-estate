@extends('layouts.user')
@section('title','Property')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/Property.css') }}">
@endpush

@section('content')

<header class="admin-header">
  <div>
    <img alt="Logo" class="dashboard-logo" src="../assets/image/lOGO.png"/>
    <span class="brand-text">Property Management</span>
  </div>
  <a href="{{ url('/admin') }}" class="btn btn-light btn-sm">
    Back to Dashboard
  </a>
</header>

<div class="card">

    <div class="card-header d-flex justify-content-between">
        <h5>Properties List</h5>

        <button class="btn btn-success"
                data-bs-toggle="modal"
                data-bs-target="#addPropertyModal">
            Add Property
        </button>
    </div>

    <div class="card-body">
  <!--<form method="GET" action="{{ route('properties.index') }}" class="mb-3 d-flex gap-2">

    <input type="text"
           name="search"
           class="form-control w-25"
           placeholder="Search title..."
           value="{{ request('search') }}">

    <select name="status" class="form-select w-25">
        <option value="">All Status</option>
        <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
        <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
    </select>

    <button class="btn btn-primary">Filter</button>
</form>-->
<form method="GET" action="{{ route('properties.index') }}" class="mb-3 d-flex gap-2">

<input type="text"
       name="search"
       class="form-control"
       placeholder="Search title..."
       value="{{ request('search') }}">

<select name="status" class="form-select">
<option value="">Status</option>
<option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
<option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
</select>

<select name="purpose" class="form-select">
<option value="">Purpose</option>
<option value="sale" {{ request('purpose') == 'sale' ? 'selected' : '' }}>Sale</option>
<option value="rent" {{ request('purpose') == 'rent' ? 'selected' : '' }}>Rent</option>
</select>

<select name="type" class="form-select">
<option value="">Type</option>
<option value="house" {{ request('type') == 'house' ? 'selected' : '' }}>House</option>
<option value="apartment" {{ request('type') == 'apartment' ? 'selected' : '' }}>Apartment</option>
<option value="villa" {{ request('type') == 'villa' ? 'selected' : '' }}>Villa</option>
</select>

<input type="text"
       name="location"
       class="form-control"
       placeholder="Location"
       value="{{ request('location') }}">

<button class="btn btn-primary">Filter</button>

</form>

<table class="table table-bordered">
<thead>
<tr>
<th>Title</th>
<th>Price</th>
<th>Action</th>
</tr>
</thead>

<tbody>
@foreach($properties as $property)
<tr>
<td>{{ $property->title }}</td>
<td>{{ $property->price }}</td>
<td>

<button class="btn btn-sm btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#editModal{{ $property->id }}">
    Edit
</button>

<button type="button"
        class="btn btn-sm btn-danger"
        data-bs-toggle="modal"
        data-bs-target="#deleteModal{{ $property->id }}">
    Delete
</button>

</td>
</tr>

<!-- ================= Delete Modal ================= -->
<div class="modal fade" id="deleteModal{{ $property->id }}" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5>Confirm Delete</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete "<strong>{{ $property->title }}</strong>"?
      </div>
      <div class="modal-footer">
        <form action="{{ route('properties.destroy', $property->id) }}" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">Yes, Delete</button>
        </form>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
<!-- ================= End Delete Modal ================= -->
<!-- ================= Edit Modal ================= -->
<!-- ================= Edit Modal ================= -->
<div class="modal fade" id="editModal{{ $property->id }}" tabindex="-1">
<div class="modal-dialog modal-lg">
<div class="modal-content">

<div class="modal-header bg-primary text-white">
<h5>Edit Property</h5>
<button type="button"
        class="btn-close btn-close-white"
        data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<!-- تصاویر موجود -->
<div class="mb-2">
@foreach($property->images as $img)
<div class="d-inline-block position-relative m-1">

<img src="{{ asset('storage/properties/'.$img->image) }}"
     width="80"
     class="rounded border">

<form method="POST"
      action="{{ route('property.image.delete',$img->id) }}"
      class="position-absolute top-0 end-0">

@csrf
@method('DELETE')

<button type="submit"
        class="btn btn-danger btn-sm p-0"
        style="width:20px;height:20px;line-height:18px;">
x
</button>

</form>
</div>
@endforeach
</div>

<form action="{{ route('properties.update',$property->id) }}"
      method="POST"
      enctype="multipart/form-data">
@csrf
@method('PUT')

<input type="text" name="title"
       value="{{ $property->title }}"
       class="form-control mb-2"
       placeholder="Title" required>

<textarea name="description"
          class="form-control mb-2"
          placeholder="Description">{{ $property->description }}</textarea>

<input type="text" name="location"
       value="{{ $property->location }}"
       class="form-control mb-2"
       placeholder="Location" required>

<select name="status"
        class="form-control mb-2" required>
<option value="Active" {{ $property->status == 'Active' ? 'selected' : '' }}>Active</option>
<option value="Inactive" {{ $property->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
</select>

<select name="purpose" class="form-control mb-2">
<option value="sale" {{ $property->purpose == 'sale' ? 'selected' : '' }}>sale</option>
<option value="rent" {{ $property->purpose == 'rent' ? 'selected' : '' }}>rent</option>
</select>

<select name="type" class="form-control mb-2">
<option value="house" {{ $property->type == 'house' ? 'selected' : '' }}>House</option>
<option value="apartment" {{ $property->type == 'apartment' ? 'selected' : '' }}>Apartment</option>
<option value="villa" {{ $property->type == 'villa' ? 'selected' : '' }}>Villa</option>
</select>

<input type="number" name="price"
       step="0.01"
       value="{{ $property->price }}"
       class="form-control mb-2" required>

<input type="number" name="bedrooms"
       value="{{ $property->bedrooms }}"
       class="form-control mb-2" required>

<input type="number" name="bathrooms"
       value="{{ $property->bathrooms }}"
       class="form-control mb-2" required>

<input type="number" name="area"
       value="{{ $property->area }}"
       class="form-control mb-2" required>

<input type="file"
name="images[]"
class="form-control mb-3"
multiple>

<button type="submit"
        class="btn btn-primary w-100">
Save Changes
</button>

</form>

</div>

</div>
</div>
</div>
<!-- ================= End Edit Modal ================= -->
<!-- ================= End Edit Modal ================= -->

@endforeach
</tbody>
</table>

</div>
</div>

<!-- ================= Add Modal ================= -->
<div class="modal fade" id="addPropertyModal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">
<h5>Add Property</h5>
<button type="button"
class="btn-close"
data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
<form action="{{ route('properties.store') }}"
method="POST"
enctype="multipart/form-data">
@csrf

<input type="text" name="title"
class="form-control mb-2"
placeholder="Title" required>

<textarea name="description"
class="form-control mb-2"
placeholder="Description"></textarea>

<input type="text" name="location"
class="form-control mb-2"
placeholder="Location">

<input type="text" name="status"
class="form-control mb-2"
placeholder="Status">

<!-- ✅ NEW -->
<select name="purpose" class="form-control mb-2">
<option value="">Purpose</option>
<option value="sale">sale</option>
<option value="rent">rent</option>
</select>

<select name="type" class="form-control mb-2">
<option value="">Type</option>
<option value="house">House</option>
<option value="apartment">Apartment</option>
<option value="villa">Villa</option>
</select>
<!-- ✅ END -->

<input type="number" name="price"
step="0.01"
class="form-control mb-2"
placeholder="Price" required>

<input type="number" name="bedrooms"
class="form-control mb-2"
placeholder="Bedrooms" required>

<input type="number" name="bathrooms"
class="form-control mb-2"
placeholder="Bathrooms" required>

<input type="number" name="area"
class="form-control mb-2"
placeholder="Area" required>

<input type="file"
name="images[]"
class="form-control mb-3"
multiple>

<button type="submit"
class="btn btn-success w-100">
Save Property
</button>
</form>
</div>

</div>
</div>
</div>
<!-- ================= End Add Modal ================= -->

@endsection
