@extends('layouts.user')
@section('title','Report')
@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/Report.css') }}">
@endpush

<!-- HEADER -->
<header class="admin-header">
  <div>
    <img alt="Logo" class="dashboard-logo" src="../assets/image/lOGO.png"/>
    <!--<h4>REMS Admin</h4>
    <small>System Reports</small>-->
    <span class="brand-text">System Reports</span>
  </div>
  <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm">

    <i class="bi bi-arrow-left"></i> Back to Dashboard
  </a>
</header>

<section class="container mt-5">

  <div class="row g-4">

    <div class="col-md-4">
      <div class="stat-card blue">
        <i class="bi bi-bar-chart"></i>
       <h2>{{ $totalProperties }}</h2>
        <p>Properties</p>
      </div>
    </div>

    <div class="col-md-4">
      <div class="stat-card green">
        <i class="bi bi-check-circle"></i>
       <h2>{{ $activeProperties }}</h2>
        <p>Active</p>
      </div>
    </div>

    <div class="col-md-4">
      <div class="stat-card red">
        <i class="bi bi-x-circle"></i>
       <h2>{{ $deletedProperties }}</h2>
        <p>Deleted</p>
      </div>
    </div>

  </div>

  <!-- Table Report -->
  <div class="property-card mt-5">
    <div class="card-header-custom">
      <h5><i class="bi bi-file-earmark-text"></i> Monthly Report</h5>
    </div>

    <table class="table align-middle">
      <thead>
        <tr>
          <th>Month</th>
          <th>Added</th>
          <th>Deleted</th>
          <th>Active</th>
        </tr>
      </thead>
     <tbody>
@foreach($monthlyReport as $report)
<tr>
    <td>{{ \Carbon\Carbon::create()->month($report->month)->format('F') }}</td>
    <td>{{ $report->added }}</td>
    <td>-</td>
    <td>{{ $activeProperties }}</td>
</tr>
@endforeach
</tbody>
    </table>
  </div>

</section>


@push('scripts')
<script src="{{ asset('assets/js/Report.js') }}"></script>
@endpush
<script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

@endsection
