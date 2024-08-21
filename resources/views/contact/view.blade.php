@extends('admin.layout')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{__(' Contact Us')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="mr-2">
                                <a title="Go Back" href="{{route('admin.contact.index')}}" class="btn btn-secondary btn-sm previous round"
                                style=""> <i class="fas fa-arrow-left" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.dashboard')}}">{{__('Home')}}</a>
                        </li>
                        <li class="breadcrumb-item">
                            {{__('Contact Us')}}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
               @if( session('message'))
                    <div class="alert alert-success  alert-dismissible fade show">{{session('message')}}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
               @endif
               <section class="content">
               <div class="container-fluid ">
                <div class="row mb-3">
<div class="col-md-12 text-right">
    <a href='mailto:{{ $contact->email }}?subject=QYEC'> <button class="btn btn-primary btn-sm">Reply Email</button> </a>

</div>
                </div>
                            <div class="card card-body">
                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-4">
                                        <label for="Name of office" class="form-label"><span><b>Name</b></span></label>
                                        <p>{{ $contact->name }}</p>
                                       
                                    </div>
                                    <div class="mb-3 form-group-translation col-md-4">
                                        <label for="Name of office" class="form-label"><span><b>Email</b></span></label>
                                      <p>{{ $contact->email }}</p>
                                
                                    </div>
                                    <div class="mb-3 form-group-translation col-md-4">
                                        <label for="Name of office" class="form-label"><span><b>Phone</b></span></label>
                                      <p>{{ $contact->phone_no }}</p>
                                
                                    </div>
                                </div> 
                                
                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-4">
                                        <label for="Name of office" class="form-label"><span><b>Address</b></span></label>
                                        <p>{{ $contact->address }}</p>
                                      
                                    </div>
                                    <div class="mb-3 form-group-translation col-md-4">
                                        <label for="Name of office" class="form-label"><span><b>Subject</b></span></label>
                                        <p>{{ $contact->subject }}</p>
                                      
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-12">
                                        <label for="Name of office" class="form-label"><span><b>Message</b></span></label>
                                        <p>{{ $contact->message }}</p>
                                      
                                    </div>
                                </div>
                            </div>
                </div>
            </section>
        </div>
        <!-- /.container-fluid -->
    </section>
</div>
@endsection
