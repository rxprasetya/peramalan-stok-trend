@extends('template.index')
@section('title', 'Datatable Forecastings')
@section('content')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Datatable Forecastings</h3>
                <p class="text-subtitle text-muted">A sortable, searchable, paginated table without dependencies thanks to
                    simple-datatables.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Datatable Forecastings</li>
                    </ol>
                </nav>
            </div>
        </div>
        <form action="{{ route('tmforecasting') }}" method="POST" enctype="multipart/form-data">
            <div class="row">
                @csrf
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="form-group">
                        <select class="choices form-select" name="chooseItem" id="chooseItem">
                            <option value="" selected disabled>-- Choose Item --</option>
                            @foreach ($item as $row)
                                <option value="{{ $row->id }}">[{{ $row->id }}] {{ $row->itemName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="form-group">
                        <select class="choices form-select" name="chooseYear" id="chooseYear" data-placeholder="asdasdasd">
                            <option value="" selected disabled>-- Choose Year --</option>
                            @foreach ($stock as $row)
                                <option value="{{ $row->year }}">{{ $row->year }}</option>
                            @endforeach
                        </select>
                        {{-- <div class="input-group">
                            <input type="text" class="form-control" name="chooseMonth" id="chooseMonth" style="padding: 10px 8px;">
                            <span class="input-group-text text-light">Month</span>
                        </div> --}}
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mb-2 mt-2" id="btn-forecast">Process</button>
        </form>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <table class="table table-striped" id="tableForecast">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Item</th>
                            <th>Date</th>
                            <th>Actual</th>
                            <th>Forecast</th>
                        </tr>
                        {{-- <tr>
                            <th>No</th>
                            <th>Item</th>
                            <th>Date</th>
                            <th>Actual</th>
                            <th>Forecast</th>
                            <th>Error</th>
                            <th>Abs Error</th>
                            <th>AE / AT</th>
                        </tr> --}}
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
