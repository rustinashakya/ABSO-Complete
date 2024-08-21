@extends('admin.layout')
@section('content')
<style>
    
      h1 {
        color: #88B04B;
        font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
        font-weight: 900;
        font-size: 40px;
        margin-bottom: 10px;
      }
  </style>
     {{-- <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet"> --}}
<!-- Content Header (Page header) -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{__(' Ticket Verification')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.dashboard')}}">{{__('Home')}}</a>
                        </li>
                        <li class="breadcrumb-item">
                            {{__('Ticket Verification')}}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
               <section class="content">
               <div class="container-fluid offset-md-2">
                
                      
                    </div>
                            <div class="card card-body">
                                <h1 style="font-size:24px;color:green">Ticket Verified Successfully<i class="checkmark">✓</i></h1> 
                                {{-- <h4 style="font-size:24px;color:red">Invalid Ticket<i class="fas fa-close" style="font-size:16px;color:red"></i></h1>  --}}
                                    <div class="col-md-4">
                                      <div class="row mb-3_ mt-3">
                                          <label for="inputEmail3" class="col-sm-3 col-form-label" style="font-size:20px">Name</label>
                                          <div class="col-sm-9">
                                            :&nbsp;<label for="inputEmail3" class="col-sm-5_ col-form-label" style="font-size:20px">{{ $customer->name ?? 'No data'}}</label>
                                          </div>
                                          <label for="inputEmail3" class="col-sm-3 col-form-label" style="font-size:20px">Date
                                                  </label>
                                          <div class="col-sm-9">
                                              :&nbsp;<label for="inputEmail3"
                                                  class="col-sm-5_ col-form-label" style="font-size:20px">{{ $customer->date ?? 'No data' }}</label>
                                          </div>
                                      </div>
                                      <div class="row mb-3">
                                          <label for="inputEmail3" class="col-sm-3 col-form-label" style="font-size:20px">Email
                                                  </label>
                                          <div class="col-sm-9">
                                              :&nbsp;<label for="inputEmail3" class="col-sm-5_ col-form-label" style="font-size:20px">{{ $customer->email ?? 'No data'}}</label>
                                          </div>
                                          <label for="inputEmail3" class="col-sm-3 col-form-label" style="font-size:20px">Phone
                                                  </label>
                                          <div class="col-sm-9">
                                              :&nbsp;<label for="inputEmail3" class="col-sm-5_ col-form-label" style="font-size:20px">{{ $customer->phone ?? 'No data'}}</label>
                                          </div>
                                      </div>
                                  </div>
                                  </div>
                    
                                <div class="row">
                                    @if ($departure == 'departure')
                                        <div class="mt-2 col-md-8 text-right">
                                            <a href="{{route('scan.qr-code','check=departure')}}"
                                                button class="btn btn-success save-button" type="submit">Done</button>
                                            </a>
                                        </div> 
                                    @else
                                        <div class="mt-2 col-md-8 text-right">
                                            <a href="{{route('scan.qr-code')}}"
                                                button class="btn btn-success save-button" type="submit">Done</button>
                                            </a>
                                        </div>     
                                    @endif   
                            </div>
                            </div>
                </div>
            </section>
        </div>
        <!-- /.container-fluid -->
    </section>
</div>
@endsection
