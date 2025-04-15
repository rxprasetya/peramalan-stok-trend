@extends('template.index')
@section('title', 'Datatable Opnames')
@section('content')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Datatable Opnames</h3>
                <p class="text-subtitle text-muted">A sortable, searchable, paginated table without dependencies thanks to
                    simple-datatables.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Datatable Opnames</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8">
                <a class="btn btn-primary mb-2" href="{{ route('copname') }}">Create</a>
                <a class="btn btn-light mb-2" href="{{ route('imopname') }}">Import</a>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <a class="btn btn-success mb-2 ms-2 float-end" href="{{ route('exopname') }}">Export</a>
                <a class="btn btn-outline-primary mb-2 float-end" href="{{ route('topname') }}">Template</a>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Item</th>
                            <th>Date</th>
                            <th>System Stock</th>
                            <th>Physical Stock</th>
                            <th>Difference</th>
                            <th>Remarks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($opname as $item => $row)
                            <tr>
                                <td>{{ $item + 1 }}</td>
                                <td>{{ $row->item->itemName }}</td>
                                <td>{{ date('F Y', strtotime($row->opnameDate)) }}</td>
                                <td>{{ $row->systemStock }}</td>
                                <td>{{ $row->physicalStock }}</td>
                                <td>{{ $row->difference }}</td>
                                <td>{{ $row->remarks }}</td>
                                <td>
                                    @if ($item == count($opname) - 1)
                                        <div class="d-flex gap-1">
                                            <a class="btn btn-success" href="{{ route('eopname', $row->id) }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <a class="btn btn-danger" href="{{ route('dopname', $row->id) }}"
                                                id="delete">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
