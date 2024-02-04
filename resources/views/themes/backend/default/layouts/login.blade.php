<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  data-menu-color="brand">
    <head>
        <meta charset="utf-8" />
        <title>{{ config('app.name', 'Laravel') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('themes/backend/default/assets/images/favicon.ico"') }}">

		<!-- Theme Config Js -->
		<script src="{{ asset('themes/backend/default/assets/js/head.js') }}"></script>

		<!-- Bootstrap css -->
		<link href="{{ asset('themes/backend/default/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" id="app-style" />

		<!-- App css -->
		<link href="{{ asset('themes/backend/default/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />

		<!-- Icons css -->
		<link href="{{ asset('themes/backend/default/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    </head>

    <body class="auth-fluid-pages pb-0">

        <div class="auth-fluid">
            <!--Auth fluid left content -->
            @yield('content')
            <!-- end auth-fluid-form-box-->

            <!-- Auth fluid right content -->
            <div class="auth-fluid-right text-center">
                <div class="auth-user-testimonial">
                    
                </div> <!-- end auth-user-testimonial-->
            </div>
            <!-- end Auth fluid right content -->
        </div>
        <!-- end auth-fluid-->

        <!-- Authentication js -->
        <script src="{{ asset('themes/backend/default/assets/js/pages/authentication.init.js') }}"></script>

    </body>
</html>