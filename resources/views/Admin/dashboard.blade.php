@extends('layouts.admin')

@section('title','Admin')

@section('content')

<div class="row text-center">
    <div class="col-md-3 mb-3">
        <div class="card p-4 d-flex justify-content-center align-items-center">
            <h3 class="mb-2">{{ $totalProperties }}</h3>
            <p class="mb-0">Properties</p>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card p-4 d-flex justify-content-center align-items-center">
            <h3 class="mb-2">{{ $totalUsers }}</h3>
            <p class="mb-0">Users</p>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card p-4 d-flex justify-content-center align-items-center">
            <h3 class="mb-2">{{ $totalReports }}</h3>
            <p class="mb-0">Reports</p>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card p-4 d-flex justify-content-center align-items-center">
            <h3 class="mb-2">{{ $totalContacts }}</h3>
            <p class="mb-0">Contacts</p>
        </div>
    </div>
</div>

<div class="card mt-5">
  <div class="card-header bg-success text-white">
    Property List
  </div>
  <div class="card-body">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>Property Name</th>
          <th>Type</th>
          <th>Price</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>Duplex House</td>
          <td>Residential</td>
          <td>$120,000</td>
          <td>
            <button class="btn btn-sm btn-primary">Edit</button>
            <button class="btn btn-sm btn-danger">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

@endsection
