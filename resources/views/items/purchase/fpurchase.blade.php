@extends('template.index')
@section('title', 'Form Purchase')
@section('content')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>{{ Request::routeIs('cpurchase') ? 'Create Data Purchase' : (Request::routeIs('epurchase') ? 'Update Data Purchase' : 'Import Data Purchase') }}
                </h3>
                <p class="text-subtitle text-muted">A sortable, searchable, paginated table without dependencies thanks
                    to
                    simple-datatables.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('purchase') }}">Datatable Purchases</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ Request::routeIs('cpurchase') ? 'Create Data Purchase' : (Request::routeIs('epurchase') ? 'Update Data Purchase' : 'Import Data Purchase') }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    @if (Request::routeIs('impurchase'))
                        <form class="form form-vertical" data-parsley-validate action="{{ route('pupurchase') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="mb-3">
                                        <label for="file" class="form-label">Choose File</label>
                                        <input class="form-control" type="file" name="file" id="file"
                                            data-parsley-required="true">
                                        @error('file')
                                            <div class="parsley-error filled">
                                                <span class="parsley-required">{{ $message }}</span>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                    <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                </div>
                            </div>
                        </form>
                    @else
                        <form class="form form-vertical" data-parsley-validate
                            action="{{ Request::routeIs('cpurchase') ? route('ipurchase') : route('upurchase', $purchase->id) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group has-icon-left @error('itemID') is-invalid @enderror">
                                            <label class="form-label" for="itemID">Item</label>
                                            <div class="position-relative">
                                                <select class="form-control" name="itemID" id="itemID"
                                                    data-parsley-required="true">
                                                    <option value=""
                                                        {{ Request::routeIs('cstock') ? 'selected' : '' }} hidden>-- Choose
                                                        Item --</option>
                                                    @foreach ($item as $row)
                                                        <option data-unit="{{ $row->unit }}" value="{{ $row->id }}"
                                                            {{ (Request::routeIs('cpurchase') ? '' : $row->id == $purchase->itemID) ? 'selected' : '' }}>
                                                            {{ $row->itemName }}</option>
                                                    @endforeach
                                                </select>
                                                @error('itemID')
                                                    <div class="parsley-error filled">
                                                        <span class="parsley-required">{{ $message }}</span>
                                                    </div>
                                                @enderror
                                                <div class="form-control-icon">
                                                    <i class="bi bi-box"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group has-icon-left @error('purchaseDate') is-invalid @enderror">
                                            <label class="form-label" for="purchaseDate">Date</label>
                                            <div class="position-relative">
                                                <input type="date" class="form-control" name="purchaseDate"
                                                    id="purchaseDate"
                                                    value="{{ Request::routeIs('cpurchase') ? $date : $purchase->purchaseDate }}"
                                                    data-parsley-required="true">
                                                @error('purchaseDate')
                                                    <div class="parsley-error filled">
                                                        <span class="parsley-required">{{ $message }}</span>
                                                    </div>
                                                @enderror
                                                <div class="form-control-icon">
                                                    <i class="bi bi-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group has-icon-left @error('qtyPurchased') is-invalid @enderror">
                                            <label class="form-label" for="qtyPurchased">Qty</label>
                                            <div class="position-relative input-group">
                                                <input type="number" class="form-control" name="qtyPurchased"
                                                    id="qtyPurchased"
                                                    value="{{ Request::routeIs('cpurchase') ? null : $purchase->qtyPurchased }}"
                                                    data-parsley-required="true">
                                                <span class="input-group-text text-light unitText">-</span>
                                                @error('qtyPurchased')
                                                    <div class="parsley-error filled">
                                                        <span class="parsley-required">{{ $message }}</span>
                                                    </div>
                                                @enderror
                                                <div class="form-control-icon">
                                                    <i class="bi bi-box-seam"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group has-icon-left @error('cost') is-invalid @enderror">
                                            <label class="form-label" for="cost">Cost per Unit</label>
                                            <div class="position-relative input-group">
                                                <span class="input-group-text text-light">Rp</span>
                                                <input type="number" class="form-control" name="cost" id="cost"
                                                    value="{{ Request::routeIs('cpurchase') ? null : $purchase->cost }}"
                                                    data-parsley-required="true">
                                                @error('cost')
                                                    <div class="parsley-error filled">
                                                        <span class="parsley-required">{{ $message }}</span>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group has-icon-left @error('totalCost') is-invalid @enderror">
                                            <label class="form-label" for="totalCost">Total Cost</label>
                                            <div class="position-relative input-group">
                                                <span class="input-group-text text-light">Rp</span>
                                                <input type="number" class="form-control" name="totalCost"
                                                    id="totalCost"
                                                    value="{{ Request::routeIs('cpurchase') ? '' : $purchase->totalCost }}"
                                                    data-parsley-required="true" readonly>
                                                @error('totalCost')
                                                    <div class="parsley-error filled">
                                                        <span class="parsley-required">{{ $message }}</span>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
