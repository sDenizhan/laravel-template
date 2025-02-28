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

        <div id="wrapper">
            <div class="app-menu">

                <!-- Brand Logo -->
                <div class="logo-box" style="background: #fff !important;">
                    <!-- Brand Logo Light -->
                    <a href="{{ route('admin.dashboard') }}" class="logo-light">
                        <img src="{{ asset('assets/logo.png')}}" alt="logo" class="logo-lg" style="min-height: 55px !important;">
                        <img src="{{ asset('assets/logo.png')}}" alt="small logo" class="logo-sm" style="min-height: 55px !important;">
                    </a>

                    <!-- Brand Logo Dark -->
                    <a href="{{ route('admin.dashboard') }}"  class="logo-dark">
                        <img src="{{ asset('assets/logo.png') }}" alt="dark logo" class="logo-lg">
                        <img src="{{ asset('assets/logo.png')}}" alt="small logo" class="logo-sm">
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

                        @hasanyrole('Super Admin|Admin|Coordinator|Anaesthetist|Doctor')

                            <li class="menu-title">Inquires</li>

                            <li class="menu-item">
                                <a href="#menuInquires" data-bs-toggle="collapse" class="menu-link">
                                    <span class="menu-icon"><i data-feather="briefcase"></i></span>
                                    <span class="menu-text"> {{ __('Inquires')  }}</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="menuInquires">
                                    <ul class="sub-menu">

                                        @can('view-inactive-inquiries')
                                        <li class="menu-item">
                                            <a href="{{ route('admin.inquiries.waiting') }}" class="menu-link">
                                                <span class="menu-text">{{ __('Waiting') }}</span>
                                            </a>
                                        </li>
                                        @endcan

                                        @can('view-active-inquiries')
                                        <li class="menu-item">
                                            <a href="{{ route('admin.inquiries.approved') }}" class="menu-link">
                                                <span class="menu-text">{{ __('Approved') }}</span>
                                            </a>
                                        </li>
                                        @endcan

                                        @can('view-anaesthetist-inquiries')
                                            <li class="menu-item">
                                                <a href="{{ route('admin.inquiries.anaesthetist') }}" class="menu-link">
                                                    <span class="menu-text">{{ __('Awaiting Anesthesia') }}</span>
                                                </a>
                                            </li>
                                        @endcan

                                        @can('doctor-can-view-inquiry')
                                            <li class="menu-item">
                                                <a href="{{ route('admin.inquiries.doctors') }}" class="menu-link">
                                                    <span class="menu-text">{{ __('Awaiting Doctors') }}</span>
                                                </a>
                                            </li>
                                        @endcan

                                        @can('view-completed-inquiries')
                                            <li class="menu-item">
                                                <a href="{{ route('admin.inquiries.completed') }}" class="menu-link">
                                                    <span class="menu-text">{{ __('Completed') }}</span>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </div>
                            </li>

                            <li class="menu-title">{{ __('Reports') }}</li>

                            <li class="menu-item">
                                <a href="#menuReports" data-bs-toggle="collapse" class="menu-link">
                                    <span class="menu-icon"><i data-feather="briefcase"></i></span>
                                    <span class="menu-text"> {{ __('Reports')  }}</span>
                                    <span class="menu-arrow"></span>
                                </a>

                                <div class="collapse" id="menuReports">
                                    <ul class="sub-menu">
                                        <li class="menu-item">
                                            <a href="{{ route('admin.reports.applications') }}" class="menu-link">
                                                <span class="menu-text">{{ __('Applications') }}</span>
                                            </a>
                                        </li>
                                        <li class="menu-item">
                                            <a href="{{ route('admin.reports.coordinators') }}" class="menu-link">
                                                <span class="menu-text">{{ __('Coordinators') }}</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endrole

                        @hasanyrole('Super Admin|Admin')

                            <li class="menu-title">{{ __('Settings') }}</li>

                            @can('view-hospital')
                                <li class="menu-item">
                                    <a href="#menuHospitals" data-bs-toggle="collapse" class="menu-link">
                                        <span class="menu-icon"><i data-feather="briefcase"></i></span>
                                        <span class="menu-text"> {{ __('Hospitals')  }}</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="collapse" id="menuHospitals">
                                        <ul class="sub-menu">
                                            <li class="menu-item">
                                                <a href="{{ route('admin.hospitals.index') }}" class="menu-link">
                                                    <span class="menu-text">{{ __('Hospitals') }}</span>
                                                </a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="{{ route('admin.hospitals.create') }}" class="menu-link">
                                                    <span class="menu-text">{{ __('Add Hospital') }}</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            @endcan


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

                            @can('view-medical-forms')
                                <li class="menu-item">
                                    <a href="#menuMedicalForms" data-bs-toggle="collapse" class="menu-link">
                                        <span class="menu-icon"><i data-feather="briefcase"></i></span>
                                        <span class="menu-text"> {{ __('Medical Forms')  }}</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="collapse" id="menuMedicalForms">
                                        <ul class="sub-menu">
                                            <li class="menu-item">
                                                <a href="{{ route('admin.medical-forms.index') }}" class="menu-link">
                                                    <span class="menu-text">{{ __('Medical Forms') }}</span>
                                                </a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="{{ route('admin.medical-forms.create') }}" class="menu-link">
                                                    <span class="menu-text">{{ __('Add Medical Form') }}</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            @endcan

                            <li class="menu-item">
                                <a href="#menuMedicalMessages" data-bs-toggle="collapse" class="menu-link">
                                    <span class="menu-icon"><i data-feather="briefcase"></i></span>
                                    <span class="menu-text"> {{ __('Medical Messages')  }}</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="menuMedicalMessages">
                                    <ul class="sub-menu">
                                        <li class="menu-item">
                                            <a href="{{ route('admin.message-template.index') }}" class="menu-link">
                                                <span class="menu-text">{{ __('Message Templates') }}</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

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
                                <a href="{{ url('/') }}" class="logo-light">
                                    <img src="assets/images/logo-light.png" alt="logo" class="logo-lg">
                                    <img src="assets/images/logo-sm.png" alt="small logo" class="logo-sm">
                                </a>

                                <a href="{{ url('/') }}" class="logo-dark">
                                    <img src="assets/images/logo-dark.png" alt="dark logo" class="logo-lg">
                                    <img src="assets/images/logo-sm.png" alt="small logo" class="logo-sm">
                                </a>
                            </div>

                            <button class="button-toggle-menu">
                                <i class="mdi mdi-menu"></i>
                            </button>
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


                            <!-- Notofication dropdown -->
                            <li class="dropdown notification-list">
                                <a class="nav-link dropdown-toggle waves-effect waves-light arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <i class="fe-bell font-22"></i>
                                    <span class="badge bg-danger rounded-circle noti-icon-badge">9</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg py-0">
                                    <div class="p-2 border-top-0 border-start-0 border-end-0 border-dashed border">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h6 class="m-0 font-16 fw-semibold"> Notification</h6>
                                            </div>
                                            <div class="col-auto">
                                                <a href="javascript: void(0);" class="text-dark text-decoration-underline">
                                                    <small>Clear All</small>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="px-1" style="max-height: 300px;" data-simplebar>

                                        <h5 class="text-muted font-13 fw-normal mt-2">Today</h5>
                                        <!-- item-->

                                        <a href="javascript:void(0);" class="dropdown-item p-0 notify-item card unread-noti shadow-none mb-1">
                                            <div class="card-body">
                                                <span class="float-end noti-close-btn text-muted"><i class="mdi mdi-close"></i></span>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <div class="notify-icon bg-primary">
                                                            <i class="mdi mdi-comment-account-outline"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 text-truncate ms-2">
                                                        <h5 class="noti-item-title fw-semibold font-14">Datacorp <small class="fw-normal text-muted ms-1">1 min ago</small></h5>
                                                        <small class="noti-item-subtitle text-muted">Caleb Flakelar commented on Admin</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>

                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item p-0 notify-item card read-noti shadow-none mb-1">
                                            <div class="card-body">
                                                <span class="float-end noti-close-btn text-muted"><i class="mdi mdi-close"></i></span>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <div class="notify-icon bg-info">
                                                            <i class="mdi mdi-account-plus"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 text-truncate ms-2">
                                                        <h5 class="noti-item-title fw-semibold font-14">Admin <small class="fw-normal text-muted ms-1">1 hours ago</small></h5>
                                                        <small class="noti-item-subtitle text-muted">New user registered</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>

                                        <h5 class="text-muted font-13 fw-normal mt-0">Yesterday</h5>

                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item p-0 notify-item card read-noti shadow-none mb-1">
                                            <div class="card-body">
                                                <span class="float-end noti-close-btn text-muted"><i class="mdi mdi-close"></i></span>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <div class="notify-icon">
                                                            <img src="assets/images/users/avatar-2.jpg" class="img-fluid rounded-circle" alt="" />
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 text-truncate ms-2">
                                                        <h5 class="noti-item-title fw-semibold font-14">Cristina Pride <small class="fw-normal text-muted ms-1">1 day ago</small></h5>
                                                        <small class="noti-item-subtitle text-muted">Hi, How are you? What about our next meeting</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>

                                        <h5 class="text-muted font-13 fw-normal mt-0">30 Dec 2021</h5>

                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item p-0 notify-item card read-noti shadow-none mb-1">
                                            <div class="card-body">
                                                <span class="float-end noti-close-btn text-muted"><i class="mdi mdi-close"></i></span>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <div class="notify-icon bg-primary">
                                                            <i class="mdi mdi-comment-account-outline"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 text-truncate ms-2">
                                                        <h5 class="noti-item-title fw-semibold font-14">Datacorp</h5>
                                                        <small class="noti-item-subtitle text-muted">Caleb Flakelar commented on Admin</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>

                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item p-0 notify-item card read-noti shadow-none mb-1">
                                            <div class="card-body">
                                                <span class="float-end noti-close-btn text-muted"><i class="mdi mdi-close"></i></span>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <div class="notify-icon">
                                                            <img src="assets/images/users/avatar-4.jpg" class="img-fluid rounded-circle" alt="" />
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 text-truncate ms-2">
                                                        <h5 class="noti-item-title fw-semibold font-14">Karen Robinson</h5>
                                                        <small class="noti-item-subtitle text-muted">Wow ! this admin looks good and awesome design</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>

                                        <div class="text-center">
                                            <i class="mdi mdi-dots-circle mdi-spin text-muted h3 mt-0"></i>
                                        </div>
                                    </div>

                                    <!-- All-->
                                    <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item border-top border-light py-2">
                                        View All
                                    </a>

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
                                <div><script>document.write(new Date().getFullYear())</script> © BookingSurgery by Global Health Services </div>
                            </div>
                            <div class="col-md-6">

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
