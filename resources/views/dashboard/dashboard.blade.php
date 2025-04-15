@extends('template.index')
@section('title', 'Dashboard')
@section('content')
    <div class="page-heading">
        <h3>Dashboard, {{ auth()->user()->name }}</h3>
    </div>
    <section class="row">
        <div class="col-12 col-lg-9">
            <div class="row">
                <div class="col-4 col-lg-4 col-md-6 col-sm-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon bg-info mb-2">
                                        <i class="iconly-boldProfile"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Users</h6>
                                    <h6 class="font-extrabold mb-0">{{ $sumUser }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-lg-4 col-md-6 col-sm-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon bg-info mb-2">
                                        <i class="iconly-boldBookmark"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Items</h6>
                                    <h6 class="font-extrabold mb-0">{{ $item }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-lg-4 col-md-6 col-sm-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon {{ $opnameDate ? 'bg-success' : 'bg-warning' }} mb-2">
                                        <i class="iconly-boldInfo-Circle"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Latest Opname</h6>
                                    <h6 class="font-extrabold mb-0">
                                        {!! $opnameDate ? date('F Y', strtotime($opnameDate)) : '&nbsp;' !!}
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Total Sales Per Month ({{ $year }})</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-zxc"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <div class="card">
                <div class="card-body py-4 px-4">
                    <div class="d-flex align-items-center">
                        <div class="avatar p-1 me-2" id="avatar">
                            <span class="avatar-content font-bold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </span>
                        </div>
                        <div class="ms-3 name">
                            <h5 class="font-extrabold">{{ str()->before(auth()->user()->name, ' ') }}</h5>
                            <h6 class="text-muted mb-0">{{ auth()->user()->role }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
