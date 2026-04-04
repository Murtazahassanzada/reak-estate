@extends('layouts.admin')

@section('title','Admin')

@section('content')

<div class="row">
    <div class="col-md-3">
        <div class="card">
            <h3>{{ $totalProperties }}</h3>
            <p>کل املاک</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <h3>{{ $totalUsers }}</h3>
            <p>کل کاربران</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <h3>{{ $totalReports }}</h3>
            <p>کل گزارش‌ها</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <h3>{{ $totalContacts }}</h3>
            <p>کل پیام‌ها</p>
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
