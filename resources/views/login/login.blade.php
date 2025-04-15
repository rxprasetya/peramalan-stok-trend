<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="shortcut icon" href="{{ asset('assets/compiled/png/letter-s.png') }}" type="image/x-icon">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}">
    
    <!-- Default -->
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/auth.css') }}">
</head>

<body data-error-message="{{ session('error') }}">
    <script src="assets/static/js/initTheme.js"></script>
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="logo"></div>
                    <h1 class="auth-title">
                        <a href="{{ route('login') }}">Stock.in</a>
                    </h1>
                    <p class="auth-subtitle mb-5">Log in with your data that you entered during registration.</p>
                    <form action="{{ route('alogin') }}" method="POST" enctype="multipart/form-data"
                        data-parsley-validate>
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" class="form-control form-control-xl" placeholder="Username"
                                name="name" id="name" data-parsley-required="true">
                            @error('name')
                                <div class="parsley-error filled">
                                    <span class="parsley-required text-danger">{{ $message }}</span>
                                </div>
                            @enderror
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl" placeholder="Password"
                                name="password" id="password" data-parsley-required="true">
                            @error('password')
                                <div class="parsley-error filled">
                                    <span class="parsley-required text-danger">{{ $message }}</span>
                                </div>
                            @enderror
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        {{-- <div class="form-check form-check-lg d-flex align-items-end">
                            <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label text-gray-600" for="flexCheckDefault">
                                Keep me logged in
                            </label>
                        </div> --}}
                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5" id="btn-login">Log in</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-7 my-auto">
                <div class="d-flex justify-content-center">
                    <img class="img-fluid" width="80%" src="{{ asset('assets/compiled/png/login.png') }}" alt="login.png">
                </div>
            </div>
        </div>
    </div>

    <!-- ValidationParsley -->
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/parsley.js') }}"></script>

    <!-- SweetAlert2 -->
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/my/js/sweetalert2.js') }}"></script>
</body>

</html>
