@extends('template.index')
@section('title', 'Form Opname')
@section('content')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>{{ Request::routeIs('copname') ? 'Create Data Opname' : (Request::routeIs('eopname') ? 'Update Data Opname' : 'Import Data Opname') }}
                </h3>
                <p class="text-subtitle text-muted">A sortable, searchable, paginated table without dependencies thanks to
                    simple-datatables.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('opname') }}">Datatable Opnames</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ Request::routeIs('copname') ? 'Create Data Opname' : (Request::routeIs('eopname') ? 'Update Data Opname' : 'Import Data Opname') }}
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
                    @if (Request::routeIs('imopname'))
                        <form class="form form-vertical" data-parsley-validate action="{{ route('puopname') }}"
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
                            action="{{ Request::routeIs('copname') ? route('iopname') : route('uopname', $opname->id) }}"
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
                                                    <option value="" hidden>-- Choose Item --</option>
                                                    @foreach ($item as $row)
                                                        <option data-unit="{{ $row->unit }}" value="{{ $row->id }}"
                                                            {{ (Request::routeIs('copname') ? '' : $row->id == $opname->itemID) ? 'selected' : '' }}>
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
                                        <div class="form-group has-icon-left @error('opnameDate') is-invalid @enderror">
                                            <label class="form-label" for="opnameDate">Date</label>
                                            <div class="position-relative">
                                                <input type="date" class="form-control" name="opnameDate" id="opnameDate"
                                                    value="{{ Request::routeIs('copname') ? $date : $opname->opnameDate }}"
                                                    data-parsley-required="true">
                                                @error('opnameDate')
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
                                        <div class="form-group has-icon-left @error('systemStock') is-invalid @enderror">
                                            <label class="form-label" for="systemStock">System Stock</label>
                                            <div class="position-relative input-group">
                                                <input type="number" class="form-control" name="systemStock"
                                                    id="systemStock"
                                                    value="{{ Request::routeIs('copname') ? null : $opname->systemStock }}"
                                                    data-parsley-required="true" readonly>
                                                <span class="input-group-text text-light unitText">-</span>
                                                <div class="form-control-icon">
                                                    <i class="bi bi-box-seam"></i>
                                                </div>
                                            </div>
                                            @error('systemStock')
                                                <div class="parsley-error filled">
                                                    <span class="parsley-required">{{ $message }}</span>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group has-icon-left @error('physicalStock') is-invalid @enderror">
                                            <label class="form-label" for="physicalStock">Physical Stock</label>
                                            <div class="position-relative input-group">
                                                <input type="number" class="form-control" name="physicalStock"
                                                    id="physicalStock"
                                                    value="{{ Request::routeIs('copname') ? null : $opname->physicalStock }}"
                                                    data-parsley-required="true">
                                                <span class="input-group-text text-light unitText">-</span>
                                                <div class="form-control-icon">
                                                    <i class="bi bi-box-seam"></i>
                                                </div>
                                            </div>
                                            @error('physicalStock')
                                                <div class="parsley-error filled">
                                                    <span class="parsley-required">{{ $message }}</span>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group has-icon-left @error('difference') is-invalid @enderror">
                                            <label class="form-label" for="difference">Difference</label>
                                            <div class="position-relative input-group">
                                                <input type="number" class="form-control" name="difference"
                                                    id="difference"
                                                    value="{{ Request::routeIs('copname') ? null : $opname->difference }}"
                                                    data-parsley-required="true" readonly>
                                                <span class="input-group-text text-light unitText">-</span>
                                                <div class="form-control-icon">
                                                    <i class="bi bi-plus-slash-minus"></i>
                                                </div>
                                            </div>
                                            @error('difference')
                                                <div class="parsley-error filled">
                                                    <span class="parsley-required">{{ $message }}</span>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group has-icon-left @error('remarks') is-invalid @enderror">
                                            <label class="form-label" for="remarks">Remarks</label>
                                            <div class="position-relative">
                                                <textarea class="form-control" id="remarks" name="remarks" rows="3">{{ Request::routeIs('copname') ? '' : $opname->remarks }}</textarea>
                                                <div class="form-control-icon">
                                                    <i class="bi bi-journal-text"></i>
                                                </div>
                                                @error('remarks')
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
