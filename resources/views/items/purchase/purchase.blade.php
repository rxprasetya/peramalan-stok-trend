@extends('template.index')
@section('title', 'Datatable Purchases')
@section('content')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Datatable Purchases</h3>
                <p class="text-subtitle text-muted">A sortable, searchable, paginated table without dependencies thanks to
                    simple-datatables.</p>
                <a class="btn btn-primary mb-2" href="{{ route('cpurchase') }}">Create</a>
                <a class="btn btn-light mb-2 ms-1" href="{{ route('impurchase') }}">Import</a>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Datatable Purchases</li>
                    </ol>
                </nav>
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
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- $dataController as $index -> $rename -->
                        @foreach ($purchase as $item => $row)
                            <tr>
                                <td>{{ $item + 1 }}</td>
                                <td>{{ $row->item->itemName }}</td>
                                <td>{{ date('F Y', strtotime($row->purchaseDate)) }}</td>
                                <td>{{ $row->qtyPurchased }}</td>
                                <td>{{ $row->cost }}</td>
                                <td>{{ $row->totalCost }}</td>
                                <td>
                                    @if ($item == count($purchase) - 1)
                                        <div class="d-flex gap-1">
                                            <a class="btn btn-success" href="{{ route('epurchase', $row->id) }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <a class="btn btn-danger" href="{{ route('dpurchase', $row->id) }}"
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
