@extends('template.index')
@section('title', 'Form Stock')
@section('content')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>{{ Request::routeIs('cstock') ? 'Create Data Stock' : (Request::routeIs('cstock') ? 'Update Data Stock' : 'Import Data Stock') }}
                </h3>
                <p class="text-subtitle text-muted">A sortable, searchable, paginated table without dependencies thanks to
                    simple-datatables.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('stock') }}">Datatable Stocks</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ Request::routeIs('cstock') ? 'Create Data Stock' : (Request::routeIs('cstock') ? 'Update Data Stock' : 'Import Data Stock') }}
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
                    @if (Request::routeIs('imstock'))
                        <form class="form form-vertical" data-parsley-validate action="{{ route('pustock') }}"
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
                            action="{{ Request::routeIs('cstock') ? route('istock') : route('ustock', $stock->id) }}"
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
                                                            {{ (Request::routeIs('cstock') ? '' : $row->id == $stock->itemID) ? 'selected' : '' }}>
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
                                        <div class="form-group has-icon-left @error('stockDate') is-invalid @enderror">
                                            <label class="form-label" for="stockDate">Date</label>
                                            <div class="position-relative">
                                                <input type="date" class="form-control" name="stockDate" id="stockDate"
                                                    value="{{ Request::routeIs('cstock') ? $date : $stock->stockDate }}"
                                                    data-parsley-required="true">
                                                @error('stockDate')
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
                                        <div class="form-group has-icon-left @error('stockOpening') is-invalid @enderror">
                                            <label class="form-label" for="stockOpening">Opening Stock</label>
                                            <div class="position-relative input-group">
                                                <input type="number" class="form-control" name="stockOpening"
                                                    id="stockOpening"
                                                    value="{{ Request::routeIs('cstock') ? null : $stock->stockOpening }}"
                                                    data-parsley-required="true" readonly>
                                                <span class="input-group-text text-light unitText">-</span>
                                                <div class="form-control-icon">
                                                    <i class="bi bi-box-seam"></i>
                                                </div>
                                            </div>
                                            @error('stockOpening')
                                                <div class="parsley-error filled">
                                                    <span class="parsley-required">{{ $message }}</span>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group has-icon-left @error('stockClosing') is-invalid @enderror">
                                            <label class="form-label" for="stockClosing">Closing Stock</label>
                                            <div class="position-relative input-group">
                                                <input type="number" class="form-control" name="stockClosing"
                                                    id="stockClosing"
                                                    value="{{ Request::routeIs('cstock') ? null : $stock->stockClosing }}"
                                                    data-parsley-required="true" readonly>
                                                <span class="input-group-text text-light unitText">-</span>
                                                <div class="form-control-icon">
                                                    <i class="bi bi-box-seam"></i>
                                                </div>
                                            </div>
                                            @error('stockClosing')
                                                <div class="parsley-error filled">
                                                    <span class="parsley-required">{{ $message }}</span>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group has-icon-left @error('qtySold') is-invalid @enderror">
                                            <label class="form-label" for="qtySold">Qty Sold</label>
                                            <div class="position-relative input-group">
                                                <input type="number" class="form-control" name="qtySold" id="qtySold"
                                                    value="{{ Request::routeIs('cstock') ? null : $stock->qtySold }}"
                                                    data-parsley-required="true" readonly>
                                                <span class="input-group-text text-light unitText">-</span>
                                                <div class="form-control-icon">
                                                    <i class="bi bi-arrow-up-circle"></i>
                                                </div>
                                            </div>
                                            @error('qtySold')
                                                <div class="parsley-error filled">
                                                    <span class="parsley-required">{{ $message }}</span>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group has-icon-left @error('qtyPurchased') is-invalid @enderror">
                                            <label class="form-label" for="qtyPurchased">Qty Purchased</label>
                                            <div class="position-relative input-group">
                                                <input type="number" class="form-control" name="qtyPurchased"
                                                    id="qtyPurchased"
                                                    value="{{ Request::routeIs('cstock') ? null : $stock->qtyPurchased }}"
                                                    data-parsley-required="true" readonly>
                                                <span class="input-group-text text-light unitText">-</span>
                                                <div class="form-control-icon">
                                                    <i class="bi bi-arrow-down-circle"></i>
                                                </div>
                                            </div>
                                            @error('qtyPurchased')
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
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
