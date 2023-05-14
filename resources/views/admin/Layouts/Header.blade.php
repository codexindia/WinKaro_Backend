<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ url('AdminAssets/assets/') }}" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Winkaro - @yield('title')</title>


    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ url('AdminAssets/assets/img/favicon/favicon.ico') }}" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ url('AdminAssets/assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ url('AdminAssets/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ url('AdminAssets/assets/vendor/css/core.css') }}"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ url('AdminAssets/assets/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ url('AdminAssets/assets/css/demo.css') }}" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="{{ url('AdminAssets/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <link rel="stylesheet" href="{{ url('AdminAssets/assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Helpers -->
    <script src="{{ url('AdminAssets/assets/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ url('AdminAssets/assets/js/config.js') }}"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="{{ route('dashboard') }}" class="app-brand-link">
                        <img style="max-width:50px;border-radius:50%;"
                            src="{{ asset('AdminAssets/assets/img/logo.png') }}" alt="">
                        <span class="app-brand-text demo menu-text fw-bolder ms-2">WinKaro</span>
                    </a>

                    <a href="javascript:void(0);"
                        class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <!-- Dashboard -->
                    <li class="menu-item {{ request()->is('Admin/Dashboard*') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="Analytics">Dashboard</div>
                        </a>
                    </li>

                    <li class="menu-item {{ request()->is('Admin/Users*') ? 'active' : '' }}">
                        <a href="{{ route('users.list') }}" class="menu-link">
                            <i class="menu-icon uil uil-users-alt"></i>
                            <div data-i18n="Analytics">Users List</div>
                        </a>
                    </li>

                    <li
                        class="menu-item {{ request()->is(['Admin/Tasks', 'Admin/Tasks/New', 'Admin/Tasks/Edit*']) ? 'active' : '' }}">
                        <a href="{{ route('task.index') }}" class="menu-link">
                            <i class="menu-icon uil uil-signal-alt"></i>
                            <div data-i18n="Analytics">Tasks Manage</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->is('Admin/Tasks/Submissions*') ? 'active' : '' }}">
                        <a href="{{ route('task.submission_list') }}" class="menu-link">
                            <i class="menu-icon uil uil-envelope-check"></i>
                            <div data-i18n="Analytics">Tasks Submissions</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->is('Admin/Offers*') ? 'active' : '' }}">
                        <a href="{{ route('offers.index') }}" class="menu-link">
                            <i class="menu-icon uil uil-tag-alt"></i>
                            <div data-i18n="Analytics">Offers Tab</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->is('Admin/Withdrawls*') ? 'active' : '' }}">
                        <a href="{{ route('withdraw.index') }}" class="menu-link">
                            <i class="menu-icon uil uil-money-withdraw"></i>
                            <div data-i18n="Analytics">Withdraw Requests</div>
                        </a>
                    </li>

                    <li class="menu-item {{ request()->is('Admin/Banners*') ? 'active' : '' }}">
                        <a href="{{ route('banners.index') }}" class="menu-link">
                            <i class="menu-icon uil uil-image"></i>
                            <div data-i18n="Analytics">Banners</div>
                        </a>
                    </li>

                    <li class="menu-item {{ request()->is('Admin/Notifications*') ? 'active' : '' }}">
                        <a href="{{ route('notification.index') }}" class="menu-link">
                            <i class="menu-icon uil uil-bell"></i>
                            <div data-i18n="Analytics">Notificaions</div>
                        </a>
                    </li>
                    {{-- setting menu --}}
                    <li class="menu-item {{ request()->is('Admin/Settings*') ? 'active' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon uil uil-cog"></i>
                            <div data-i18n="Account Settings">Settings</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item {{ request()->is('Admin/Settings/App_update') ? 'active' : '' }}">
                                <a href="{{ route('settings.appupdate') }}" class="menu-link">
                                    <div data-i18n="Account">App Update</div>
                                </a>
                            </li>
                            
                        </ul>
                    </li>
                    {{-- end of setting menu --}}
                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <!-- Search -->
                        <div class="navbar-nav align-items-center">
                            {{-- <div class="nav-item d-flex align-items-center">
                                <i class="bx bx-search fs-4 lh-0"></i>
                                <input type="text" class="form-control border-0 shadow-none"
                                    placeholder="Search..." aria-label="Search..." />
                            </div> --}}
                        </div>
                        <!-- /Search -->

                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- Place this tag where you want the button to render. -->


                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="{{ url('AdminAssets/assets/img/avatars/1.png') }}" alt
                                            class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="{{ url('AdminAssets/assets/img/avatars/1.png') }}"
                                                            alt class="w-px-40 h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span
                                                        class="fw-semibold d-block">{{ Auth::guard('admin')->user()->name }}</span>
                                                    <small class="text-muted">Admin</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="bx bx-power-off me-2"></i>
                                            <span class="align-middle">Log Out</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>
