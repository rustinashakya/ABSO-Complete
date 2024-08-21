{{-- @extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <div class="card-header">
        <h4>Change Password</h4>
    </div>
    <div class="card-body">
        <div class="box box-default">

            <!-- form start -->
                <form class="form-horizontal" id="changePassword" method="post" action="">
                  <div class="box-body mt15">
                    <div class="form-group">
                      <label for="password" class="col-sm-2 control-label">Current Password</label>

                      <div class="col-sm-6">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Current Password">
                      </div>
                    <label for="password" class="col-sm-4 control-label"></label>
                    </div>
                    <div class="form-group">
                      <label for="new_password" class="col-sm-2 control-label">New Password</label>

                      <div class="col-sm-6">
                        <input type="password" class="form-control" name="new_password" id="new_password" placeholder="New Password">
                      </div>
                      <label for="password" class="col-sm-4 control-label"></label>
                    </div>
                    <div class="form-group">
                      <label for="re_password" class="col-sm-2 control-label">Confirm Password</label>

                      <div class="col-sm-6">
                        <input type="password" class="form-control" name="re_password" id="re_password" placeholder="Confirm Password">
                      </div>
                      <label for="password" class="col-sm-4 control-label"></label>
                    </div>
                  </div>
                  <!-- /.box-body -->

                  <div class="row">
                    <div class="col"></div>
                    <div class="col-md-6 text-right">
                        <button type="submit" class="btn btn-primary save-button"
                            value="save">Save</button>
                    </div>
                </div>
                  <!-- /.box-footer -->
                </form>
              </div>
    </div>
</div>
@endsection

@section('header-styles')

@endsection

@section('footer-scripts')

@endsection --}}

@extends('admin.layout')
@section('content')
<div class="content-wrapper">
  <div class="col-md-4 offset-md-4">
          @if ($errors->any())
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
          @endif

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
            <form method="POST" action="{{route('update.password')}}">
              @csrf
                <!-- <h5 class="font-weight-bold">PERSONAL INFORMATION</h5> -->
                <div class="form-group">
                    <label class="text-uppercase">{{__('Old Password')}}</label>

                    <div class="input-group">
                        <input type="password" name="old_password" class="form-control old-password" id="password"
                        placeholder="Password">
                        <span class="input-group-append">
                        <button class="btn btn-default js-o-password" type="button">
                            <i class="fa fa-eye-slash"></i>
                        </button>
                        </span>
                    </div>
                </div>
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
                    <div class="d-block d-md-none mb-0"></div>
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
@endsection

@section('footer-scripts')

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
@endsection

