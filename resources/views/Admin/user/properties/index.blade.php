@extends('layouts.user')

@section('title', 'My Properties')

@section('content')

<div class="card shadow-sm">

  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">My Properties</h5>

    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPropertyModal">
      + Add Property
    </button>
  </div>

  <div class="card-body">

    <div class="table-responsive">
      <table class="table align-middle">

        <thead>
          <tr>
            <th>Title</th>
            <th>Price</th>
            <th>Status</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>

        <tbody>
        @forelse($properties as $property)
        <tr>

          <td class="d-flex align-items-center gap-2">
            @php $img = $property->images->first(); @endphp

            <img
              src="{{ $img ? asset('storage/properties/'.$img->image) : asset('assets/image/download.jfif') }}"
              class="property-img">

            <span>{{ $property->title }}</span>
          </td>

          <td class="text-success fw-bold">
            ${{ number_format($property->price) }}
          </td>

          <td>
            @if($property->approval_status == 'pending')
              <span class="badge bg-warning">Pending</span>
            @elseif($property->approval_status == 'approved')
              <span class="badge bg-success">Approved</span>
            @else
              <span class="badge bg-danger">Rejected</span>
            @endif
          </td>

          <td class="text-center">

            <button class="btn btn-sm btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#editModal{{ $property->id }}">
              Edit
            </button>

            <form action="{{ route('user.properties.destroy', $property->id) }}"
                  method="POST"
                  class="d-inline">
              @csrf
              @method('DELETE')

              <button class="btn btn-sm btn-danger">
                Delete
              </button>
            </form>

          </td>

        </tr>

        <!-- EDIT MODAL -->
        <div class="modal fade" id="editModal{{ $property->id }}">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">

              <div class="modal-header bg-primary text-white">
                <h5>Edit Property</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
              </div>

              <div class="modal-body">

                <form action="{{ route('user.properties.update',$property->id) }}"
                      method="POST">

                  @csrf
                  @method('PUT')

                  <input type="text" name="title"
                         value="{{ $property->title }}"
                         class="form-control mb-2">

                  <input type="number" name="price"
                         value="{{ $property->price }}"
                         class="form-control mb-2">

                  <button class="btn btn-primary w-100">
                    Update (Pending Approval)
                  </button>

                </form>

              </div>
            </div>
          </div>
        </div>

        @empty
        <tr>
          <td colspan="4" class="text-center text-muted">
            No properties found
          </td>
        </tr>
        @endforelse
        </tbody>

      </table>
    </div>

  </div>
</div>

<!-- ADD MODAL -->
<div class="modal fade" id="addPropertyModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header bg-success text-white">
        <h5>Add Property</h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <form action="{{ route('user.properties.store') }}" method="POST">
          @csrf

          <input type="text" name="title" class="form-control mb-2" placeholder="Title">

          <input type="number" name="price" class="form-control mb-2" placeholder="Price">

          <button class="btn btn-success w-100">
            Submit (Pending)
          </button>

        </form>

      </div>

    </div>
  </div>
</div>

@endsection
