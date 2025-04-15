@extends('template.index')
@section('title', 'Form Item')
@section('content')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>{{ Request::routeIs('citem') ? 'Create Data Item' : (Request::routeIs('eitem') ? 'Update Data Item' : 'Import Data Item') }}
                </h3>
                <p class="text-subtitle text-muted">A sortable, searchable, paginated table without dependencies thanks to
                    simple-datatables.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('item') }}">Datatable Items</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ Request::routeIs('citem') ? 'Create Data Item' : (Request::routeIs('eitem') ? 'Update Data Item' : 'Import Data Item') }}
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
                    @if (Request::routeIs('imitem'))
                        <form class="form form-vertical" data-parsley-validate action="{{ route('puitem') }}" method="POST"
                            enctype="multipart/form-data">
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
                            action="{{ Request::routeIs('citem') ? route('iitem') : route('uitem', $item->id) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group has-icon-left @error('id') is-invalid @enderror">
                                            <label class="form-label" for="id">ID</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control" placeholder="Item ID"
                                                    name="id" id="id"
                                                    value="{{ Request::routeIs('citem') ? '' : $item->id }}"
                                                    data-parsley-required="true">
                                                @error('id')
                                                    <div class="parsley-error filled">
                                                        <span class="parsley-required">{{ $message }}</span>
                                                    </div>
                                                @enderror
                                                <div class="form-control-icon">
                                                    <i class="bi bi-qr-code"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group has-icon-left @error('itemName') is-invalid @enderror">
                                            <label class="form-label" for="itemName">Name</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control" placeholder="Item Name"
                                                    name="itemName" id="itemName"
                                                    value="{{ Request::routeIs('citem') ? '' : $item->itemName }}"
                                                    data-parsley-required="true">
                                                @error('itemName')
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
                                        <div class="form-group has-icon-left @error('unit') is-invalid @enderror">
                                            <label class="form-label" for="unit">Unit</label>
                                            <div class="position-relative">
                                                <select class="form-control" name="unit" id="unit"
                                                    data-parsley-required="true">
                                                    <option value="" hidden>-- Choose Unit --</option>
                                                    <option value="Kg"
                                                        {{ (Request::routeIs('citem') ? '' : $item->unit == 'Kg') ? 'selected' : '' }}>
                                                        Kg</option>
                                                    <option value="L"
                                                        {{ (Request::routeIs('citem') ? '' : $item->unit == 'L') ? 'selected' : '' }}>
                                                        L</option>
                                                    <option value="Pcs"
                                                        {{ (Request::routeIs('citem') ? '' : $item->unit == 'Pcs') ? 'selected' : '' }}>
                                                        Pcs</option>
                                                </select>
                                                @error('unit')
                                                    <div class="parsley-error filled">
                                                        <span class="parsley-required">{{ $message }}</span>
                                                    </div>
                                                @enderror
                                                <div class="form-control-icon">
                                                    <i class="bi bi-1-circle"></i>
                                                </div>
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
