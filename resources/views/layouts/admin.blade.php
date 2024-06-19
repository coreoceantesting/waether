<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('fav.png') }}">

        <!-- Scripts -->
        <script src="{{ asset('admin/js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('admin/css/app.css') }}" rel="stylesheet">

          <link rel="stylesheet" type="text/css" href="{{URL::to('admin/icon/themify-icons/themify-icons.css')}}">
          <link rel="stylesheet" type="text/css" href="{{URL::to('admin/icon/font-awesome/css/font-awesome.min.css')}}">

        <!-- Select2 start -->
        <link rel="stylesheet" href="{{asset('admin/plugins/select2/css/select2.min.css')}}">
        <link rel="stylesheet" href="{{asset('admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
        <!-- Select2 end-->

        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('admin/plugins/fontawesome-free/css/all.min.css')}}">
        <link rel="stylesheet" href="{{asset('admin/dist/css/adminlte.min.css')}}">
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

        <!-- fullCalendar -->
        <link rel="stylesheet" href="{{asset('admin/plugins/fullcalendar/main.css')}}">


        <style type="text/css">
            body{
                font-family: 'Poppins', sans-serif;
            }

            label{
                font-weight:normal!important;
            }

        </style>
        @yield('css')
    </head>
    <body class="sidebar-mini" style="height: auto;">
        <div class="wrapper" id="app">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fa fa-bars"></i></a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="#" class="nav-link"></a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="#" class="nav-link"></a>
                    </li>
                </ul>
                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">

                    <li class="nav-item d-none d-sm-inline-block">

                        <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                            <p>
                                <i class="nav-icon fa fa-power-off"></i>
                                Logout
                            </p>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </nav>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-light-primary elevation-4">
                <!-- Brand Logo -->
                <a href="{{ url('admin/dashboard') }}" class="brand-link">
                
                     <center>
                        <img src="https://www.pcctmc.com/assets/img/tmc_logo1.png" height="30px" height="50px;" alt="AdminLTE Logo" class="" style="">
                        Weather Forecast

                    </center>
                    <span class="brand-text font-weight-30px;" style=""></span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <img src="https://static-00.iconduck.com/assets.00/user-icon-2048x2048-ihoxz4vq.png" class="img-circle elevation-2" alt="User Image">
                        </div>
                        <div class="info">
                            <a href="{{ url('admin/dashboard') }}" class="d-block">{{ auth()->user()->name }}</a>
                        </div>
                    </div>

                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item">
                                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->is('admin/dashboard*') ? 'active' : '' }} {{ request()->is('admin/hightide/import*') ? 'active' : '' }}">
                                    <i class="nav-icon fa fa-tv"></i>
                                    <p>
                                        High Tide
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('admin/device/list') }}" class="nav-link {{ request()->is('admin/device*') ? 'active' : '' }}">
                                    <i class="nav-icon fa fa-map-marker"></i>
                                    <p>
                                        Device
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('admin/pollution/location/list') }}" class="nav-link {{ request()->is('admin/pollution*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-air-freshener"></i>
                                    <p>
                                        Pollution Update
                                    </p>
                                </a>
                            </li>

                            {{-- <li class="nav-item">
                                <a href="{{ url('admin/contact/list') }}" class="nav-link {{ request()->is('admin/contact/list') ? 'active' : '' }}">
                                    <i class="nav-icon fa fa-address-book"></i>
                                    <p>
                                        Contact Us
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('/admin/contact/send-message') }}" class="nav-link {{ request()->is('admin/contact/send-message') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-air-freshener"></i>
                                    <p>
                                        Send Message
                                    </p>
                                </a>
                            </li> --}}

                            <li class="nav-item">
                                <a href="{{ url('admin/setting') }}" class="nav-link {{ request()->is('admin/setting*') ? 'active' : '' }}">
                                    <i class="nav-icon fa fa-gear"></i>
                                    <p>
                                        Setting
                                    </p>
                                </a>
                            </li>


                            {{-- <li class="nav-item has-treeview ">
                                <a href="{{ route('import.index') }}" class="nav-link {{ request()->is('import*') ? 'active' : '' }}">
                                    <i class="nav-icon fa fa-users "></i>
                                    <p>
                                        Import Data
                                       
                                    </p>
                                </a>
                            </li> --}}
                            
                         





                </div>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style="min-height: 399px;">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-dark">@yield('name')</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                                    <li class="breadcrumb-item active">@yield('title')</li>
                                </ol>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <div class="content">
                    <div class="container-fluid">
                        @include('admin.partials.alert')
                        @yield('content')
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <!-- Main Footer -->
            <footer class="main-footer">
                <!-- To the right -->
                <div class="float-right d-none d-sm-inline">
                    
                </div>
                <!-- Default to the left -->
                <strong>Copyright 
                   &copy; 2020-{{date("Y")}}
                 <a href="javascript::void(0)">Weather Forecast</a>.</strong> All rights reserved.
            </footer>
            <div id="sidebar-overlay"></div>
        </div>
        <!-- ./wrapper -->

        <script src="{{asset('admin/plugins/jquery/jquery.min.js')}}" ></script>
        {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script> --}}

        <!-- jQuery UI 1.11.4 -->
        <script src="{{asset('admin/plugins/jquery-ui/jquery-ui.min.js')}}" defer></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script src="{{asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}" defer></script>
        <!-- fullCalendar 2.2.5 -->
        <script src="{{asset('admin/plugins/moment/moment.min.js')}}" defer ></script>
        <script src="{{asset('admin/plugins/fullcalendar/main.js')}}" defer></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js" f></script>

        @yield('js')
        <!-- Page specific script -->

    </body>

</html>
