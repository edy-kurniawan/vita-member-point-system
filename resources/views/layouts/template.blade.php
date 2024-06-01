<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>VITA MEMBER POINT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ url('assets/images/favicon.ico') }}">
    <link href="{{ url('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Bootstrap Css -->
    <link href="{{ url('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ url('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ url('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <!-- DataTables -->
    <link href="{{ url('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ url('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />  
    
    @yield('css')
</head>

<body data-sidebar="dark" data-layout-mode="light">

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->
    <!-- Begin page -->
    <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="#" class="logo logo-dark">
                            <span class="logo-sm">
                                <h4 class="text-white mt-4">VITA</h4>
                            </span>
                            <span class="logo-lg">
                                <h4 class="text-white mt-4">VITA MEMBER POINT</h4>
                            </span>
                        </a>

                        <a href="#" class="logo logo-light">
                            <span class="logo-sm">
                                <h4 class="text-white mt-4">VITA</h4>
                            </span>
                            <span class="logo-lg">
                                <h4 class="text-white mt-4">VITA MEMBER POINT</h4>
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect"
                        id="vertical-menu-btn">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>

                </div>

                <div class="d-flex">

                    <div class="dropdown d-inline-block d-lg-none ms-2">
                        <button type="button" class="btn header-item noti-icon waves-effect"
                            id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                            aria-labelledby="page-header-search-dropdown">

                            <form class="p-3">
                                <div class="form-group m-0">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search ..."
                                            aria-label="Recipient's username">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit"><i
                                                    class="mdi mdi-magnify"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="dropdown d-none d-lg-inline-block ms-1">
                        <button type="button" class="btn header-item noti-icon waves-effect"
                            data-bs-toggle="fullscreen">
                            <i class="bx bx-fullscreen"></i>
                        </button>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user" src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&rounded=true&color=7F9CF5&background=EBF4FF"
                                alt="Header Avatar">
                            <span class="d-none d-xl-inline-block ms-1" key="t-henry">{{ Auth::user()->name }}</span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a class="dropdown-item" href="/user/profile"><i class="bx bx-user font-size-16 align-middle me-1"></i>
                                <span key="t-profile">Profile</span></a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="/logout"><i
                                    class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span
                                    key="t-logout">Logout</span></a>
                        </div>
                    </div>

                    {{-- <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                            <i class="bx bx-cog bx-spin"></i>
                        </button>
                    </div> --}}

                </div>
            </div>
        </header>

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">
            <div data-simplebar class="h-100">
                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title" key="t-menu">Menu</li>

                        <li>
                            <a href="#" class="waves-effect">
                                <i class="fas fa-tachometer-alt"></i>
                                <span>Dashboards</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('point.create') }}" class="waves-effect">
                                <i class="bx bx-transfer"></i>
                                <span>Penukaran Point</span>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="waves-effect">
                                <i class="fas fa-coins"></i>
                                <span>Pengumpulan Point</span>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="waves-effect">
                                <i class="fas fa-chart-line"></i>
                                <span>Laporan</span>
                            </a>
                        </li>

                        <li class="menu-title" key="t-menu">Master Data</li>
                        <li>
                            <a href="{{ route('member.index') }}" class="waves-effect">
                                <i class="fas fa-users"></i>
                                <span>Member</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('reward.index') }}" class="waves-effect">
                                <i class="fas fa-trophy"></i>
                                <span>Reward</span>
                            </a>
                        </li>

                        @if (Auth::user()->role == 'admin')

                        <li class="menu-title" key="t-menu">Setting</li>
                        <li>
                            <a href="{{ route('kasir.index') }}" class="waves-effect">
                                <i class="fas fa-users-cog"></i>
                                <span>Kasir</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('log.index') }}" class="waves-effect">
                                <i class="fas fa-book"></i>
                                <span>Logs</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('setting.index') }}" class="waves-effect">
                                <i class="fas fa-cog"></i>
                                <span>Setting</span>
                            </a>
                        </li>

                        @endif
                    </ul>
                </div>
                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                @yield('content')
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © VITA FASHION STORE.
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    <div class="right-bar">
        <div data-simplebar class="h-100">
            <div class="rightbar-title d-flex align-items-center px-3 py-4">

                <h5 class="m-0 me-2">Settings</h5>

                <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                    <i class="mdi mdi-close noti-icon"></i>
                </a>
            </div>

            <!-- Settings -->
            <hr class="mt-0" />
            <h6 class="text-center mb-0">Choose Layouts</h6>

            <div class="p-4">
                <div class="mb-2">
                    <img src="{{ url('assets/images/layouts/layout-1.jpg') }}" class="img-thumbnail" alt="layout images">
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="checkbox" id="light-mode-switch" checked>
                    <label class="form-check-label" for="light-mode-switch">Light Mode</label>
                </div>

                <div class="mb-2">
                    <img src="{{ url('assets/images/layouts/layout-2.jpg') }}" class="img-thumbnail" alt="layout images">
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="checkbox" id="dark-mode-switch">
                    <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
                </div>
            </div>

        </div> <!-- end slimscroll-menu-->
    </div>
    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    <script src="{{ url('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ url('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ url('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ url('assets/libs/node-waves/waves.min.js') }}"></script>

    <!-- Required datatable js -->
    <script src="{{ url('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Responsive examples -->
    <script src="{{ url('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ url('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    <!-- Bootstrap Toasts Js -->
    <script src="{{ url('assets/js/pages/bootstrap-toastr.init.js') }}"></script>
    <script src="{{ url('assets/js/apps.js') }}"></script>

    @yield('js')
</body>


</html>