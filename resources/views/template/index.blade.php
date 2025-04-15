<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Icon -->
    <link rel="shortcut icon" href="{{ asset('assets/compiled/png/letter-s.png') }}" type="image/x-icon">

    <!-- Choices -->
    <link rel="stylesheet" href="{{ asset('assets/extensions/choices.js/public/assets/styles/choices.css') }}">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}">

    <!-- Datatables -->
    <link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/table-datatable.css') }}">

    <!-- Default -->
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/iconly.css') }}">
</head>

<body data-success-message="{{ session('success') }}">
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
    <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo">
                            <a href="{{ route('dashboard') }}">Stock.In</a>
                        </div>
                        <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                aria-hidden="true" role="img" class="iconify iconify--system-uicons" width="20"
                                height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                                <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                                        opacity=".3"></path>
                                    <g transform="translate(-210 -1)">
                                        <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                        <circle cx="220.5" cy="11.5" r="4"></circle>
                                        <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2">
                                        </path>
                                    </g>
                                </g>
                            </svg>
                            <div class="form-check form-switch fs-6">
                                <input class="form-check-input  me-0" type="checkbox" id="toggle-dark"
                                    style="cursor: pointer">
                                <label class="form-check-label"></label>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                aria-hidden="true" role="img" class="iconify iconify--mdi" width="20"
                                height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                                </path>
                            </svg>
                        </div>
                        <div class="sidebar-toggler  x">
                            <a href="#" class="sidebar-hide d-xl-none d-block">
                                <i class="bi bi-x bi-middle"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu</li>
                        <li class="sidebar-item {{ Request::routeIs('dashboard') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}" class="sidebar-link">
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        @if (auth()->user()->role == 'Admin')
                            <li class="sidebar-item {{ Request::routeIs('user', 'cuser', 'euser') ? 'active' : '' }}">
                                <a href="{{ route('user') }}" class="sidebar-link">
                                    <i class="bi bi-person-fill"></i>
                                    <span>Users</span>
                                </a>
                            </li>
                        @endif
                        <li
                            class="sidebar-item has-sub {{ Request::routeIs('item', 'citem', 'eitem', 'purchase', 'cpurchase', 'epurchase', 'sale', 'csale', 'esale', 'stock', 'cstock', 'estock', 'opname', 'copname', 'eopname', 'forecasting', 'cforecasting', 'eforecasting') ? 'active' : '' }}">
                            <a href="" class="sidebar-link">
                                <i class="bi bi-box-fill"></i>
                                <span>Items</span>
                            </a>
                            <ul class="submenu">
                                <li
                                    class="submenu-item {{ Request::routeIs('item', 'citem', 'eitem') ? 'active' : '' }}">
                                    <a href="{{ route('item') }}" class="submenu-link">List</a>
                                </li>
                                <li
                                    class="submenu-item {{ Request::routeIs('purchase', 'cpurchase', 'epurchase') ? 'active' : '' }}">
                                    <a href="{{ route('purchase') }}" class="submenu-link">Purchase</a>
                                </li>
                                <li
                                    class="submenu-item {{ Request::routeIs('sale', 'csale', 'esale') ? 'active' : '' }}">
                                    <a href="{{ route('sale') }}" class="submenu-link">Sale</a>
                                </li>
                                <li
                                    class="submenu-item {{ Request::routeIs('stock', 'cstock', 'estock') ? 'active' : '' }}">
                                    <a href="{{ route('stock') }}" class="submenu-link">Stock</a>
                                </li>
                                <li
                                    class="submenu-item {{ Request::routeIs('opname', 'copname', 'eopname') ? 'active' : '' }}">
                                    <a href="{{ route('opname') }}" class="submenu-link">Stock Opname</a>
                                </li>
                                <li
                                    class="submenu-item {{ Request::routeIs('forecasting', 'cforecasting', 'eforecasting') ? 'active' : '' }}">
                                    <a href="{{ route('forecasting') }}" class="submenu-link">Stock Forecasting</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item ">
                            <a href="{{ route('logout') }}" class="sidebar-link" id="btn-logout">
                                <i class="iconly-boldLogout"></i>
                                <span>Log Out</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            <div class="page-content">
                @yield('content')
            </div>
            @if (Request::routeIs('dashboard'))
            @else
                <footer>
                    <div class="footer clearfix mb-0 text-muted">
                        <div class="float-start">
                            <p>2024 &copy; Stock.In</p>
                        </div>
                        <div class="float-end">
                            <p>#<a href="{{ route('dashboard') }}">Stock.In</a> aja!</p>
                        </div>
                    </div>
                </footer>
            @endif
        </div>
    </div>

    <!-- Default -->
    <script src="{{ asset('assets/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>

    <!-- Datatables -->
    <script src="{{ asset('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/simple-datatables.js') }}"></script>

    <!-- ValidationParsley -->
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/parsley.js') }}"></script>

    <!-- Choices -->
    <script src="{{ asset('assets/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/form-element-select.js') }}"></script>

    <!-- Need: Apexcharts -->
    <script src="{{ asset('assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/my/js/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/dashboard.js') }}"></script>

    <!-- myRealtime -->
    <script src="{{ asset('assets/my/js/real-time.js') }}"></script>

    <!-- SweetAlert2 -->
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/my/js/sweetalert2.js') }}"></script>

</body>

</html>
