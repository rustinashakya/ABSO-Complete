<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin panel</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{asset('assets/plugins/jqvmap/jqvmap.min.css')}}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('assets/dist/css/adminlte.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('assets/plugins/daterangepicker/daterangepicker.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-bs4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/dist/css/custom.css')}}">
    @yield('header-styles')
    @yield('header-scripts')
  </head>
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <!-- Preloader -->
      <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{asset('assets/dist/img/AdminLTELogo.png')}}" alt="AdminLTELogo" height="60" width="60">
      </div>
      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="{{route('dashboard')}}" class="nav-link">Home</a>
          </li>
          <!-- <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Contact</a>
          </li> -->
        </ul>
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
          <!-- Navbar Search -->
          <li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
              <i class="fas fa-search"></i>
            </a>
            <div class="navbar-search-block">
              <form class="form-inline">
                <div class="input-group input-group-sm">
                  <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                  <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                    </button>
                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                    <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </li>
          <!-- Messages Dropdown Menu -->
          
          <!-- Notifications Dropdown Menu -->
          
        
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="fas fa-user-circle"></i> Administrator
            </a>
            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
              
              <a href="#" class="dropdown-item">
                <i class="fas fa-user-circle"></i> My Account
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">
                <form class="d-inline" action="{{route('logout')}}" method="post">
                  @csrf
                  <button class="logout_btn btn btn-success" type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
              </a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="fas fa-globe"></i> {{__('general.languge')}}
            </a>
            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
              
              <a href="#" class="dropdown-item language-option" data-language="en">
                {{__('general.language_en')}}
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item language-option" data-language="np">
                {{__('general.language_np')}}
              </a>
            </div>
          </li>

        </ul>
        
        
        
        
      </nav>
      <!-- /.navbar -->
      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{route('dashboard')}}" class="brand-link">
          <img src="{{asset('assets/qyec_logo.jpeg')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light">DCMS</span>
        </a>
        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img src="{{asset('assets/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
              <a href="#" class="d-block">Alexander Pierce</a>
            </div>
          </div> -->
          <!-- SidebarSearch Form -->
          <!-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
              <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
                </button>
              </div>
            </div>
          </div> -->
          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <!-- Add icons to the links using the .nav-icon class
              with font-awesome or any other icon font library -->
              
              <li class="nav-item">
                <a href="{{route('dashboard')}}" class="nav-link {{$nav=='dashboard'?' active':''}}">
                  <i class="fas fa-tachometer-alt nav-icon"></i>
                  <p>Dashboard</p>
                </a>
              </li>

              @include('admin.nav-items')
              @if($nav=='roles' || $nav=='worksector' || $nav=='sourcecomplaint' || $nav=='subjectcomplaint' || $nav=='caseresolve' || $nav=='remedy' || $nav=='sanction')
              <li class="nav-item menu-is-opening menu-open">
                @else
                <li class="nav-item">
                @endif
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                    Presets
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                   <a href="{{route('role.list')}}" class="nav-link {{$nav=='roles'?' active':''}}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Roles</p>
                  </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('worksector.list')}}" class="nav-link {{$nav=='worksector'?' active':''}}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>{{ __('worksector.worksectors') }}</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('sourcecomplaint.list')}}" class="nav-link {{$nav=='sourcecomplaint'?' active':''}}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>{{ __('sourcecomplaint.sourcecomplaints') }}</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('subjectcomplaint.list')}}" class="nav-link {{$nav=='subjectcomplaint'?' active':''}}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>{{ __('subjectcomplaint.subjectcomplaints') }}</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('caseresolve.list')}}" class="nav-link {{$nav=='caseresolve'?' active':''}}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>{{ __('caseresolve.caseresolves') }}</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('remedy.list')}}" class="nav-link {{$nav=='remedy'?' active':''}}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>{{ __('remedy.remedies') }}</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('sanction.list')}}" class="nav-link {{$nav=='sanction'?' active':''}}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>{{ __('sanction.sanctions') }}</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="{{route('dashboard')}}" class="nav-link {{$nav=='users'?' active':''}}">
                  <i class="fas fa-users nav-icon"></i>
                  <p>Users</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('legalassistance')}}" class="nav-link {{$nav=='legal'?' active':''}}">
                  <i class="fas fa-list nav-icon"></i>
                  <p>Greviences</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('report')}}" class="nav-link {{$nav=='reports'?' active':''}}">
                  <i class="far fa-file-alt nav-icon"></i>
                  <p>Reports</p>
                </a>
              </li>



    
              


              
            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
      </aside>
      <!-- Content Wrapper. Contains page content -->
      @yield('content')
      
      <!-- /.content-wrapper -->
      <footer class="main-footer">
        <strong>DCMS Copyright &copy; 2021-2022.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
          <b>Version</b> 1.0
        </div>
      </footer>
      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
      </aside>
      <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <!-- jQuery -->
    <script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{asset('assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
    $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- ChartJS -->
    <script src="{{asset('assets/plugins/chart.js/Chart.min.js')}}"></script>
    <!-- Sparkline -->
    <script src="{{asset('assets/plugins/sparklines/sparkline.js')}}"></script>
    <!-- JQVMap -->
    <script src="{{asset('assets/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
    <script src="{{asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{asset('assets/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
    <!-- daterangepicker -->
    <script src="{{asset('assets/plugins/moment/moment.min.js')}}"></script>
    <script src="{{asset('assets/plugins/daterangepicker/daterangepicker.js')}}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <!-- Summernote -->
    <script src="{{asset('assets/plugins/summernote/summernote-bs4.min.js')}}"></script>
    <!-- overlayScrollbars -->
    <script src="{{asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
    <!-- Select2 -->
    <script src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('assets/dist/js/adminlte.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{asset('assets/dist/js/demo.js')}}"></script>
    @yield('footer-scripts')
    <script type="text/javascript">
      $(document).ready(function(){
         $('.language-option').click(function(e){
            e.preventDefault();
            var target = $(this);
            $.ajax({
              method: "GET",
              url: "{{route('language')}}?lang="+ target.data('language')
              }
            ).done(function( msg ) {
                window.location.href = "{{$currentURL}}"
            });
         }) 
      })
    </script>
  </body>
</html>