@extends('admin.layout')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{__('Newsletter List')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.dashboard')}}">{{__('Home')}}</a>
                        </li>
                        <li class="breadcrumb-item">
                            {{__('Newsletter List')}}
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
               
               <div class="row mb-3">
                    <div class="col-md-12 float-right">
                        <a href="{{route('export.newsletters')}}"
                        button class="btn btn-primary float-right" type="submit">Download Excel File</button>
                        <i class="fas fa-edit"></i></a>
                    </div>
          
                </div>
                <div class="row">
                    <div class="col-12">
                        <!-- /.card -->
                        <div class="card">
                            <div class="card-body">                               
                            </div>
                            <div class="box">
                                <div class="box-body table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase">#</th>
                                                <th class="">Email</th>
                                                <th class="">Actions</th>
                                            </tr>
                                        </thead>
 
                                        <tbody>
                                            @foreach ($letter as $index => $news)
                                                <tr>
                                                    <td>{{ ($index+1) + ($letter->currentPage() - 1) * $letter->perPage() }}</td>
                                                    <td>
                                                        <b>{{ $news->email }}</b>
                                                    </td>
                                                    <td class="inline">
                                                        <a href="{{ route('newsletter.delete', $news->id) }}" button class="btn btn-danger btn-sm" type="submit"></button>
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="justify-content-center">
                                    <ul class="pagination pagination-sm">
                                        {{ $letter->links() }}
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        
        
        <!-- /.container-fluid -->
    </section>
</div>
@endsection
