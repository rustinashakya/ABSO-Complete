@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header px-3">
        <div class="container-fluid">
            <div class="row mb-2 mx-1">
                <div class="col-sm-6">
                    <h1 class="">{{ __('User') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="mr-2">
                            <a title="Go Back" href="{{route('admin.users.index')}}" class="btn btn-secondary btn-sm previous round"> <i class="fas fa-arrow-left" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.users.index')}}">{{ __('Users') }}</a></li>
                        <li class="breadcrumb-item">{{ __('Edit Users') }}</li>
                        {{-- <li class="breadcrumb-item active">
                            {{ isset($industry)?  __('industry.edit') : __('industry.new') }}</li> --}}
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content px-3">
        <div class="container-fluid">

            <section class="content">
                <div class="container-fluid">
                    <div class="card card-body">
                        <form method="POST" action="{{ route('admin.users.update',$user->id)}}">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="mb-3 form-group-translation col-md-6">
                                    <label for="User Name" class="form-label"><span>Username <span class="text-danger">*</span></span></label>
                                    <input id="name" type="text" name="name" value="{{ old('name',$user->name) }}" placeholder="Enter User Name" class="form-control">
                                    @if($errors->has('name'))
                                    <span style="color:red;">{{$errors->first('name')}}</span>
                                    @endif
                                </div>
                                <div class="mb-3 form-group-translation col-md-6">
                                    <label for="Email" class="form-label"><span>Email <span class="text-danger">*</span></span></label>
                                    <input id="email" type="text" name="email" value="{{ old('email',$user->email) }}" placeholder="Enter Email" class="form-control">
                                    @if($errors->has('email'))
                                    <span style="color:red;">{{$errors->first('email')}}</span>
                                    @endif
                                </div>

                            </div>
                            <div class="row">
                                <div class="mb-3 form-group-translation col-md-6">
                                    <label for="Password" class="form-label"><span>Password <span class="text-danger">*</span></span></label>
                                    <input id="password" type="password" name="password" value="{{ old('password') }}" placeholder="Enter Password" class="form-control">
                                    @if($errors->has('password'))
                                    <span style="color:red;">{{$errors->first('password')}}</span>
                                    @endif
                                </div>
                                <div class="mb-3 form-group-translation col-md-6">
                                    <label for="Confirm Password" class="form-label"><span>Confirm Password <span class="text-danger">*</span></span></label>
                                    <input id="password_confirmation" type="password" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="Enter Password" class="form-control">
                                    @if($errors->has('password_confirmation'))
                                    <span style="color:red;">{{$errors->first('password_confirmation')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 form-group-translation col-md-12">
                                <label class="mr-4">Select the Role: <span class="text-danger">*</span></label> <br>
                                    @foreach($roles as $role)
                                    <label class="flex flex-row items-center mt-2">
                                        <input type="checkbox" class="form-checkbox " name="roles[]" value="{{$role->id}}" @if(count($user->roles->where('id',$role->id)))
                                        checked
                                        @endif
                                        ><span class="ml-1 mr-3 text-black-800">{{ $role->name }}</span>
                                    </label>
                                    @endforeach
                                </div>

                            </div>
                            <div class="row">
                                
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-success save-button" value="save">{{__('Update')}}</button>
                                    {{-- <button type="submit" class="btn btn-success save-button"
                                    value="save_close">{{__('general.buttons.save_close')}}</button> --}}
                                    <a href="{{route('admin.users.index')}}" class="btn btn-secondary">{{__('Cancel')}}</a>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </section>
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection

@section('footer-scripts')
{{-- <script type="text/javascript">
$(document).ready(function() {
    $('.save-button').click(function(e) {
        e.preventDefault();
        $('input[name="actions"').prop('value', $(this).prop('value'));
        $('#adminform').submit();
    });
})
</script> --}}
@endsection