@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="">{{ __('Permission') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a
                                href="{{route('admin.dashboard')}}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{route('admin.permissions.index')}}">{{ __('Permission') }}</a></li>
                        {{-- <li class="breadcrumb-item active">
                            {{ isset($industry)?  __('industry.edit') : __('industry.new') }}</li> --}}
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
                    <div class="card card-body">
                        <form method="POST" action="{{ route('admin.permissions.update',$permission->id)}}">
                            @csrf
                            @method('put')
                        <div class="row">
                            <div class="mb-3 form-group-translation col-md-6">
                                <label for="Permission Name" class="form-label text-uppercase"><span>Permission Name</span></label>
                                <input id="role_name"
                                type="text"
                                name="name"
                                value="{{ old('name',$permission->name) }}"
                                placeholder="Enter permission" class="form-control">
                                @if($errors->has('name'))
                                <span style="color:red;">{{$errors->first('name')}}</span>
                                @endif
                            </div>
                            
                            
                        </div>   
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn btn-success save-button"
                                    value="update">{{__('Update')}}</button>
                                {{-- <button type="submit" class="btn btn-success save-button"
                                    value="save_close">{{__('general.buttons.save_close')}}</button> --}}
                                <a href="{{route('admin.permissions.index')}}"
                                    class="btn btn-secondary">{{__('Cancel')}}</a>
                            </div>    
                        </div> 
                        </form>
                    </div>
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