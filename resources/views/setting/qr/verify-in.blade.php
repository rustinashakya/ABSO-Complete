@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="">{{ __('Arrival QR Scanner') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a
                                href="{{route('admin.dashboard')}}">{{ __('Home') }}</a></li>
                                <li class="breadcrumb-item">
                                    Arrival QR Scanner
                                </li>
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
                        <form method="POST" action="{{route('scan.qr.code.store')}}">
                            @csrf
                            @method('post')
                        <div class="row">
                            <div class="mb-3 form-group-translation col-md-6">
                                <label for="Code" class="form-label"><span>Code</span></label>
                                <input id="role_name"
                                type="text"
                                name="qr_code"
                                value="{{ old('qr_code') }}"
                                placeholder="Enter QR code" class="form-control">
                                @if($errors->has('qr_code'))
                                <span style="color:red;">{{$errors->first('qr_code')}}</span>
                                @endif
                            </div>
                        </div>   
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn btn-primary save-button"
                                    value="save">{{__('Verify')}}</button>
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
@endsection