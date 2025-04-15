@extends('template.index')
@section('title', 'Form User')
@section('content')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>{{ Request::routeIs('cuser') ? 'Create Data User' : 'Update Data User' }}</h3>
                <p class="text-subtitle text-muted">A sortable, searchable, paginated table without dependencies thanks to
                    simple-datatables.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('user') }}">Datatable Users</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ Request::routeIs('cuser') ? 'Create Data User' : 'Update Data User' }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            {{-- <div class="card-header">
                <h4 class="card-title">Tambah Data User</h4>
            </div> --}}
            <div class="card-content">
                <div class="card-body">
                    <form class="form form-vertical" data-parsley-validate
                        action="{{ Request::routeIs('cuser') ? route('iuser') : route('uuser', $user->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group has-icon-left @error('name') is-invalid @enderror">
                                        <label class="form-label" for="name">Name</label>
                                        <div class="position-relative">
                                            <input type="text" class="form-control" placeholder="Username" name="name"
                                                id="name" value="{{ Request::routeIs('cuser') ? '' : $user->name }}"
                                                data-parsley-required="true">
                                            @error('name')
                                                <div class="parsley-error filled">
                                                    <span class="parsley-required">{{ $message }}</span>
                                                </div>
                                            @enderror
                                            <div class="form-control-icon">
                                                <i class="bi bi-person"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group has-icon-left @error('password') is-invalid @enderror">
                                        <label class="form-label" for="password">Password</label>
                                        <div class="position-relative">
                                            <input type="password" class="form-control" placeholder="Password"
                                                name="password" id="password"
                                                value="{{ Request::routeIs('cuser') ? '' : $user->password }}"
                                                data-parsley-required="true">
                                            @error('password')
                                                <div class="parsley-error filled">
                                                    <span class="parsley-required">{{ $message }}</span>
                                                </div>
                                            @enderror
                                            <div class="form-control-icon">
                                                <i class="bi bi-lock"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group has-icon-left @error('role') is-invalid @enderror">
                                        <label class="form-label" for="role">Role</label>
                                        <div class="position-relative">
                                            <select class="form-control" name="role" id="role"
                                                data-parsley-required="true">
                                                <option value="" hidden>-- Choose Role --</option>
                                                <option value="Admin"
                                                    {{ (Request::routeIs('cuser') ? '' : $user->role == 'Admin') ? 'selected' : '' }}>
                                                    Admin</option>
                                                <option value="Employee"
                                                    {{ (Request::routeIs('cuser') ? '' : $user->role == 'Employee') ? 'selected' : '' }}>
                                                    Employee</option>
                                            </select>
                                            @error('role')
                                                <div class="parsley-error filled">
                                                    <span class="parsley-required">{{ $message }}</span>
                                                </div>
                                            @enderror
                                            <div class="form-control-icon">
                                                <i class="bi bi-person-gear"></i>
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
                </div>
            </div>
        </div>
    </section>
@endsection
