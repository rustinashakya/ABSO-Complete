@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header px-3">
        <div class="container-fluid">
            <div class="row mb-2 mx-1">
                <div class="col-sm-6">
                    <h1 class="">{{ __('Add Roles') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a
                                href="{{route('admin.dashboard')}}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.roles.index')}}">{{ __('Roles') }}</a></li>
                        <li class="breadcrumb-item">{{ __('Add Roles') }}</li>
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
                                <form id="addRole" method="POST" action="{{route('admin.roles.store')}}">
                                    @csrf
                                    @method('post')
                                    <div class="row">
                                        <div class="mb-3 form-group-translation col-md-6">
                                            <label for="Role Name" class="form-label"><span>Role Name</span></label>
                                            <input id="role_name"
                                            type="text"
                                            name="name"
                                            value="{{ old('name') }}"
                                            placeholder="Enter role" class="form-control">
                                            @if($errors->has('name'))
                                            <span style="color:red;">{{$errors->first('name')}}</span>
                                            @endif
                                        </div>
                                        
                                        
                                    </div> 
                                    <div class="row">
                                        <div class="mb-3 form-group-translation col-md-12">
                                        <label>Permissions: </label> <br>
                                                @foreach($permissions as $permission)
                                                        <label class="flex flex-row items-center mt-2">
                                                            <input type="checkbox" class="form-checkbox " name="permissions[]" value="{{$permission->id}}"
                                                            ><span class="ml-2 mr-2 text-gray-800">{{ $permission->name }}</span>
                                                        </label>
                                                @endforeach
                                            </div>
                                    </div>    
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <button type="submit" class="btn btn-success save-button"
                                                value="save" onclick="disableButtonAndSubmitForm(this);">{{__('Save')}}</button>
                                            {{-- <button type="submit" class="btn btn-success save-button"
                                                value="save_close">{{__('general.buttons.save_close')}}</button> --}}
                                            <a href="{{route('admin.roles.index')}}"
                                                class="btn btn-secondary">{{__('Cancel')}}</a>
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
        $(this).attr('disabled', 'disabled')
        $('input[name="actions"').prop('value', $(this).prop('value'));
        $('#adminform').submit();
    });
})
</script> --}}
<script>
    function disableButtonAndSubmitForm(button) {
            // Disable the button
            button.disabled = true;
            // Submit the form
            document.getElementById("addRole").submit();
        }
</script>
@endsection