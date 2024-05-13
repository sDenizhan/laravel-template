<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-menu-color="brand">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('themes/backend/default/assets/images/favicon.ico')}}">

        @stack('styles')

		<script src="{{ asset('themes/backend/default/assets/js/head.js')}}"></script>

		<!-- Bootstrap css -->
		<link href="{{asset('themes/backend/default/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" id="app-style" />

		<!-- App css -->
		<link href="{{asset('themes/backend/default/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />

		<!-- Icons css -->
		<link href="{{ asset('themes/backend/default/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    </head>

    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- ========== Menu ========== -->
            <div class="app-menu">

                <!-- Brand Logo -->
                <div class="logo-box">
                    <!-- Brand Logo Light -->
                    <a href="{{ route('admin.dashboard') }}" class="logo-light">
                        <img src="{{ asset('themes/backend/default/assets/images/logo-light-2.png')}}" alt="logo" class="logo-lg">
                        <img src="{{ asset('themes/backend/default/assets/images/logo-sm.png')}}" alt="small logo" class="logo-sm">
                    </a>

                    <!-- Brand Logo Dark -->
                    <a href="{{ route('admin.dashboard') }}"  class="logo-dark">
                        <img src="{{ asset('themes/backend/default/assets/images/logo-dark.png') }}" alt="dark logo" class="logo-lg">
                        <img src="{{ asset('themes/backend/default/assets/images/logo-sm.png')}}" alt="small logo" class="logo-sm">
                    </a>
                </div>

                <!-- menu-left -->
                <div class="scrollbar">

                    <!-- User box -->
                    <div class="user-box text-center">
                        <img src="assets/images/users/user-1.jpg" alt="user-img" title="Mat Helme" class="rounded-circle avatar-md">
                        <div class="dropdown">
                            <a href="javascript: void(0);" class="dropdown-toggle h5 mb-1 d-block" data-bs-toggle="dropdown">Geneva Kennedy</a>
                            <div class="dropdown-menu user-pro-dropdown">

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="fe-user me-1"></i>
                                    <span>My Account</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="fe-settings me-1"></i>
                                    <span>Settings</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="fe-lock me-1"></i>
                                    <span>Lock Screen</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="fe-log-out me-1"></i>
                                    <span>Logout</span>
                                </a>

                            </div>
                        </div>
                        <p class="text-muted mb-0">Admin Head</p>
                    </div>

                    <!--- Menu -->
                    <ul class="menu">

                        <li class="menu-title">Navigation</li>

                        <li class="menu-item">
                            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                                <span class="menu-icon"><i data-feather="home"></i></span>
                                <span class="menu-text">{{  __('Dashboard') }}</span>
                            </a>
                        </li>

                        <li class="menu-title">Inquires</li>



                        @role('Super Admin')

                            <li class="menu-title">{{ __('Settings') }}</li>

                            @can('view-treatments')
                                <li class="menu-item">
                                    <a href="#menuTreatments" data-bs-toggle="collapse" class="menu-link">
                                        <span class="menu-icon"><i data-feather="briefcase"></i></span>
                                        <span class="menu-text"> {{ __('Treatments')  }}</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="collapse" id="menuTreatments">
                                        <ul class="sub-menu">
                                            <li class="menu-item">
                                                <a href="{{ route('admin.treatments.index') }}" class="menu-link">
                                                    <span class="menu-text">{{ __('Treatments') }}</span>
                                                </a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="{{ route('admin.treatments.create') }}" class="menu-link">
                                                    <span class="menu-text">{{ __('Add Treatment') }}</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            @endcan

                            @can('view-statuses')
                                <li class="menu-item">
                                    <a href="#menuStatuses" data-bs-toggle="collapse" class="menu-link">
                                        <span class="menu-icon"><i data-feather="briefcase"></i></span>
                                        <span class="menu-text"> {{ __('Statuses')  }}</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="collapse" id="menuStatuses">
                                        <ul class="sub-menu">
                                            <li class="menu-item">
                                                <a href="{{ route('admin.status.index') }}" class="menu-link">
                                                    <span class="menu-text">{{ __('Statuses') }}</span>
                                                </a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="{{ route('admin.status.create') }}" class="menu-link">
                                                    <span class="menu-text">{{ __('Add Status') }}</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            @endcan

                            <li class="menu-item">
                                <a href="#menuUsers" data-bs-toggle="collapse" class="menu-link">
                                    <span class="menu-icon"><i data-feather="users"></i></span>
                                    <span class="menu-text"> {{ __('Users')  }}</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="menuUsers">
                                    <ul class="sub-menu">
                                        <li class="menu-item">
                                            <a href="{{ route('admin.users.index') }}" class="menu-link">
                                                <span class="menu-text">{{ __('Users') }}</span>
                                            </a>
                                        </li>
                                        <li class="menu-item">
                                            <a href="{{ route('admin.users.create') }}" class="menu-link">
                                                <span class="menu-text">{{ __('Add User') }}</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="menu-item">
                                <a href="#menuRoles" data-bs-toggle="collapse" class="menu-link">
                                    <span class="menu-icon"><i data-feather="users"></i></span>
                                    <span class="menu-text"> {{ __('Roles')  }}</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="menuRoles">
                                    <ul class="sub-menu">
                                        <li class="menu-item">
                                            <a href="{{ route('admin.roles.index') }}" class="menu-link">
                                                <span class="menu-text">{{ __('Roles') }}</span>
                                            </a>
                                        </li>
                                        <li class="menu-item">
                                            <a href="{{ route('admin.roles.create') }}" class="menu-link">
                                                <span class="menu-text">{{ __('Add Role') }}</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="menu-item">
                                <a href="#menuPerms" data-bs-toggle="collapse" class="menu-link">
                                    <span class="menu-icon"><i data-feather="users"></i></span>
                                    <span class="menu-text"> {{ __('Permissions')  }}</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="menuPerms">
                                    <ul class="sub-menu">
                                        <li class="menu-item">
                                            <a href="{{ route('admin.permissions.index') }}" class="menu-link">
                                                <span class="menu-text">{{ __('Permissions') }}</span>
                                            </a>
                                        </li>
                                        <li class="menu-item">
                                            <a href="{{ route('admin.permissions.create') }}" class="menu-link">
                                                <span class="menu-text">{{ __('Add Permission') }}</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                        @endrole

                    </ul>
                    <!--- End Menu -->
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- ========== Left menu End ========== -->


            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">

                <!-- ========== Topbar Start ========== -->
                <div class="navbar-custom">
                    <div class="topbar">
                        <div class="topbar-menu d-flex align-items-center gap-1">

                            <!-- Topbar Brand Logo -->
                            <div class="logo-box">
                                <!-- Brand Logo Light -->
                                <a href="index.html" class="logo-light">
                                    <img src="assets/images/logo-light.png" alt="logo" class="logo-lg">
                                    <img src="assets/images/logo-sm.png" alt="small logo" class="logo-sm">
                                </a>

                                <!-- Brand Logo Dark -->
                                <a href="index.html" class="logo-dark">
                                    <img src="assets/images/logo-dark.png" alt="dark logo" class="logo-lg">
                                    <img src="assets/images/logo-sm.png" alt="small logo" class="logo-sm">
                                </a>
                            </div>

                            <!-- Sidebar Menu Toggle Button -->
                            <button class="button-toggle-menu">
                                <i class="mdi mdi-menu"></i>
                            </button>

                            <!-- Dropdown Menu -->
                            <div class="dropdown d-none d-xl-block">
                                <a class="nav-link dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    Create New
                                    <i class="mdi mdi-chevron-down ms-1"></i>
                                </a>
                                <div class="dropdown-menu">
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="fe-briefcase me-1"></i>
                                        <span>New Projects</span>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="fe-user me-1"></i>
                                        <span>Create Users</span>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="fe-bar-chart-line- me-1"></i>
                                        <span>Revenue Report</span>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="fe-settings me-1"></i>
                                        <span>Settings</span>
                                    </a>

                                    <div class="dropdown-divider"></div>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="fe-headphones me-1"></i>
                                        <span>Help & Support</span>
                                    </a>

                                </div>
                            </div>
                        </div>

                        <ul class="topbar-menu d-flex align-items-center">

                            <!-- Search Dropdown (for Mobile/Tablet) -->
                            <li class="dropdown d-lg-none">
                                <a class="nav-link dropdown-toggle waves-effect waves-light arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <i class="ri-search-line font-22"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-animated dropdown-lg p-0">
                                    <form class="p-3">
                                        <input type="search" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                    </form>
                                </div>
                            </li>

                            <!-- Light/Dark Mode Toggle Button -->
                            <li class="d-none d-sm-inline-block">
                                <div class="nav-link waves-effect waves-light" id="light-dark-mode">
                                    <i class="ri-moon-line font-22"></i>
                                </div>
                            </li>

                            <!-- User Dropdown -->
                            <li class="dropdown">
                                <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <img src="{{ asset('themes/backend/default/assets/images/users/user-1.jpg') }}" alt="user-image" class="rounded-circle">
                                    <span class="ms-1 d-none d-md-inline-block">
                                        {{ Auth::user()->name }} <i class="mdi mdi-chevron-down"></i>
                                    </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                                    <!-- item-->
                                    <div class="dropdown-header noti-title">
                                        <h6 class="text-overflow m-0">Welcome !</h6>
                                    </div>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <i class="fe-user"></i>
                                        <span>My Account</span>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <i class="fe-settings"></i>
                                        <span>Settings</span>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <i class="fe-lock"></i>
                                        <span>Lock Screen</span>
                                    </a>

                                    <div class="dropdown-divider"></div>

                                    <a class="dropdown-item notify-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fe-log-out"></i>
                                        <span>{{ __('Logout') }}</span>
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- ========== Topbar End ========== -->

                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">

                        @yield('pre-content')

                        @yield('content')

                    </div> <!-- container -->

                </div> <!-- content -->

                <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <div><script>document.write(new Date().getFullYear())</script> © Süleyman DENİZHAN </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-none d-md-flex gap-4 align-item-center justify-content-md-end footer-links">
                                    <a href="javascript: void(0);">About</a>
                                    <a href="javascript: void(0);">Support</a>
                                    <a href="javascript: void(0);">Contact Us</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->

            </div>

        </div>
        <!-- END wrapper -->

        <!-- Vendor js -->
        <script src="{{ asset('themes/backend/default/assets/js/vendor.min.js')}}"></script>

        <!-- App js -->
        <script src="{{ asset('themes/backend/default/assets/js/app.min.js')}}"></script>

        <script src="{{ asset('themes/backend/default/assets/js/pages/material-symbols.init.js')}}"></script>

        @stack('scripts')

    </body>
</html>
