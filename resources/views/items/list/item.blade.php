@extends('template.index')
@section('title', 'Datatable Items')
@section('content')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Datatable Items</h3>
                <p class="text-subtitle text-muted">A sortable, searchable, paginated table without dependencies thanks to
                    simple-datatables.</p>
                <a class="btn btn-primary mb-2" href="{{ route('citem') }}">Create</a>
                <a class="btn btn-light mb-2 ms-1" href="{{ route('imitem') }}">Import</a>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Datatable Items</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            {{-- <div class="card-header">
                <h5 class="card-title">
                    Datatable Items
                </h5>
            </div> --}}
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Unit</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($item as $item => $row)
                            <tr>
                                <td>{{ $row->id }}</td>
                                <td>{{ $row->itemName }}</td>
                                <td>{{ $row->unit }}</td>
                                <td>
                                    <a class="btn btn-success" href="{{ route('eitem', $row->id) }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a class="btn btn-danger" href="{{ route('ditem', $row->id) }}" id="delete">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
