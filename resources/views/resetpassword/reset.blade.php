<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Reset Password</title>
    <link rel="icon" href="{{ asset('assets/frontend/img/Favicon.png') }}" type="image/png">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/custom.css') }}">
    <!-- toastr -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <style>
        .content-wrapper{
            margin-left: auto !important;
            margin-right: auto !important;
        }
    </style>

</head>
<body>
<div class="content-wrapper">
  <div class="row">
          <!-- @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
          @endif -->

          @if( session('message'))
            <div class="alert alert-danger  alert-dismissible fade show">{{session('message')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
          @endif

          @if( session('pwd_changed'))
          <div class="alert alert-success  alert-dismissible fade show">{{session('pwd_changed')}}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
        @endif
    </div>
    <div class="row mt-3 mt-lg-4 mb-4">
        <div class="col-12">
            <h3 class="text-theme-primary text-center">{{__('Change Password')}}</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 offset-md-4">
        <div class="card card-body">
            <form method="POST" action="{{url('resetpassword/'.$user_uuid)}}">
              @csrf
                <!-- <h5 class="font-weight-bold">PERSONAL INFORMATION</h5> -->
                
                <div class="form-group">
                    <label class="text-uppercase">{{__('New Password')}}</label>

                    <div class="input-group">
                        <input type="password" name="new_password" class="form-control new-password" id="password"
                        placeholder="Password">
                        <span class="input-group-append">
                        <button class="btn btn-default js-password" type="button">
                            <i class="fa fa-eye-slash"></i>
                        </button>
                        </span>
                    </div>
                                   
                    @if($errors->has('new_password'))
                    <div style="color:red;">{{$errors->first('new_password')}}</div>
                    @endif
                    <div class="d-block d-md-none mb-0">
                    </div>
                </div>
                <div class="form-group">
                    <label class="text-uppercase">{{__('Confirm Password')}}</label>

                    <div class="input-group">
                        <input type="password" name="confirm_password" class="form-control confirm-password" id="password"
                        placeholder="Password">
                        <span class="input-group-append">
                        <button class="btn btn-default js-c-password" type="button">
                            <i class="fa fa-eye-slash"></i>
                        </button>
                        </span>
                    </div>
                    @if($errors->has('confirm_password'))
                    <div style="color:red;">{{$errors->first('confirm_password')}}</div>
                    @endif
                </div>

                <div class="mt-4 mt-xl-5 text-center">
                    <button class="btn btn-primary" title="{{__('Save')}}" type="submit">
                        {{__('Save')}}
                    </button>
                </div>
            </form>
             </div>
        </div>

    </div>

</div>
</body>
</html>






<script>
    $(function(){
        $('.js-o-password').on('click',function(){
        var _this = $(this)
        if(_this.hasClass('active')) {
          _this.closest('div').find('.old-password').prop('type','password')
          _this.empty().append('<i class="fa fa-eye-slash"></i>')
          _this.removeClass('active')
        }
        else {
          _this.closest('div').find('.old-password').prop('type','text')
          _this.empty().append('<i class="fa fa-eye"></i>')
          _this.addClass('active')
        }
      })
      $('.js-password').on('click',function(){
        var _this = $(this)
        if(_this.hasClass('active')) {
          _this.closest('div').find('.new-password').prop('type','password')
          _this.empty().append('<i class="fa fa-eye-slash"></i>')
          _this.removeClass('active')
        }
        else {
          _this.closest('div').find('.new-password').prop('type','text')
          _this.empty().append('<i class="fa fa-eye"></i>')
          _this.addClass('active')
        }
      })
      $('.js-c-password').on('click',function(){
        var _this = $(this)
        if(_this.hasClass('active')) {
          _this.closest('div').find('.confirm-password').prop('type','password')
          _this.empty().append('<i class="fa fa-eye-slash"></i>')
          _this.removeClass('active')
        }
        else {
          _this.closest('div').find('.confirm-password').prop('type','text')
          _this.empty().append('<i class="fa fa-eye"></i>')
          _this.addClass('active')
        }
      })
    })
  </script>