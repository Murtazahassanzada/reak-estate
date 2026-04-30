@extends('layouts.admin')

@section('title', __('admin.dashboard.title'))

@section('content')

<div class="row g-4">

    <div class="col-xl-3 col-md-6">
        <div class="stat-card card-blue">
            <div class="stat-icon">
                <i class="fa-solid fa-building"></i>
            </div>
            <div>
                <h2>{{ $totalProperties }}</h2>
                <p>{{ __('admin.dashboard.properties') }}</p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card card-green">
            <div class="stat-icon">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <h2>{{ $totalUsers }}</h2>
                <p>{{ __('admin.dashboard.users') }}</p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card card-orange">
            <div class="stat-icon">
                <i class="fa-solid fa-chart-line"></i>
            </div>
            <div>
                <h2>{{ $totalReports }}</h2>
                <p>{{ __('admin.dashboard.reports') }}</p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card card-red">
            <div class="stat-icon">
                <i class="fa-solid fa-envelope"></i>
            </div>
            <div>
                <h2>{{ $totalContacts }}</h2>
                <p>{{ __('admin.dashboard.messages') }}</p>
            </div>
        </div>
    </div>

</div>


<!-- ================= TABLE ================= -->
<div class="card mt-5 modern-table">

    <div class="card-header">
        <h5 class="m-0">
            {{ __('admin.table.title') }}
        </h5>
    </div>

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table modern align-middle">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('admin.table.name') }}</th>
                        <th>{{ __('admin.table.type') }}</th>
                        <th>{{ __('admin.table.price') }}</th>
                        <th class="text-center">{{ __('admin.table.actions') }}</th>
                    </tr>
                </thead>

                <tbody>

                    {{-- STATIC SAMPLE --}}
                    <tr>

                        <td>1</td>

                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar"></div>
                                Duplex House
                            </div>
                        </td>

                        <td>
                            <span class="badge bg-light text-dark">
                                Residential
                            </span>
                        </td>

                        <td class="fw-bold text-success">
                            {{ number_format(120000, 2) }} $
                        </td>

                        <td class="text-center">

                            <button class="btn btn-sm btn-primary">
                                {{ __('admin.actions.edit') }}
                            </button>

                            <button class="btn btn-sm btn-danger">
                                {{ __('admin.actions.delete') }}
                            </button>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection