@extends('layouts.user')

@section('title', __('report.title'))

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/Report.css') }}">
@endpush

@section('content')

<!-- HEADER -->
<header class="admin-header">

  <div class="d-flex align-items-center gap-2">
    <img class="dashboard-logo" src="{{ asset('assets/image/lOGO.png') }}">
    <span class="brand-text">{{ __('report.reports') }}</span>
  </div>

<a href="{{ route('admin.dashboard') }}" class="btn dashboard-back-btn btn-sm">
    <i class="bi bi-arrow-left"></i>
    {{ __('report.back_dashboard') }}
</a>

</header>

<section class="container mt-5">

  <!-- STATS -->
  <div class="row g-4">

    <div class="col-md-4">
      <div class="stat-card blue">
        <i class="bi bi-bar-chart"></i>
        <h2>{{ $totalProperties }}</h2>
        <p>{{ __('report.properties') }}</p>
      </div>
    </div>

    <div class="col-md-4">
      <div class="stat-card green">
        <i class="bi bi-check-circle"></i>
        <h2>{{ $activeProperties }}</h2>
        <p>{{ __('report.active') }}</p>
      </div>
    </div>

    <div class="col-md-4">
      <div class="stat-card red">
        <i class="bi bi-x-circle"></i>
        <h2>{{ $deletedProperties }}</h2>
        <p>{{ __('report.deleted') }}</p>
      </div>
    </div>

  </div>

  <!-- REPORT TABLE -->
  <div class="property-card mt-5">

    <div class="card-header-custom">
      <h5>
        <i class="bi bi-file-earmark-text"></i>
        {{ __('report.monthly_report') }}
      </h5>
    </div>

    <div class="table-responsive">
      <table class="table align-middle table-hover">

        <thead class="table-light">
          <tr>
            <th>{{ __('report.month') }}</th>
            <th>{{ __('report.added') }}</th>
            <th>{{ __('report.deleted') }}</th>
            <th>{{ __('report.active') }}</th>
          </tr>
        </thead>

        <tbody>

          @forelse($monthlyReport as $report)
          <tr>
            <td>
              {{ \Carbon\Carbon::create()->month($report->month)->locale(app()->getLocale())->translatedFormat('F') }}
            </td>

            <td class="text-success fw-bold">
              +{{ $report->added }}
            </td>

         <td class="text-danger fw-bold">
    {{ $report->deleted ?? 0 }}
</td>

           <td class="text-primary fw-bold">
          {{ $report->active }}
          </td>
          </tr>
          @empty
          <tr>
            <td colspan="4" class="text-center text-muted py-4">
              <i class="bi bi-inbox"></i>
              {{ __('report.empty') }}
            </td>
          </tr>
          @endforelse

        </tbody>

      </table>
    </div>

  </div>

</section>

@push('scripts')
<script src="{{ asset('assets/js/Report.js') }}"></script>
@endpush

@endsection
