@extends('admin.layout')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-wrapper">
    <div class="content-header px-3">
        <div class="container-fluid">
            <div class="row mb-2 mx-1">
                <div class="col-sm-6">
                    <h1 class="m-0">{{__('Users')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.dashboard')}}">{{__('Home')}}</a>
                        </li>
                        <li class="breadcrumb-item">
                            {{__('Users')}}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->
    <section class="content px-3">
        <div class="container-fluid">
            <div class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            @can('Role create')
                            <div class="row mb-3">
                                <div class="col-md-12 text-right">
                                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary"> +
                                        Add</a>
                                </div>
                            </div>
                            @endcan
                            <!-- /.card -->
                            <div class="card">
                                @if(count($users) > 0)
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>

                                            <th class="text-uppercase">{{__('#')}}</th>
                                            <th class="text-uppercase">{{__('USERNAME')}}</th>
                                            <th class="text-uppercase">{{__('ROLE')}}</th>
                                            <th class="text-uppercase">{{__('ACTIONS')}}</th>
                                        </tr>

                                    </thead>

                                    <tbody>
                                        @can('User access')
                                        @forelse($users as $key => $user)
                                        <tr>
                                            <td>{{ $key + 1}}</td>
                                            <td>
                                                <b>{{ ucwords( $user->name ) }}</b>
                                            </td>
                                            <td>
                                                @foreach($user->roles as $role)
                                                <span class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none text-black bg-black-500 bg-gray rounded-pill">{{ $role->name }}</span>
                                                @endforeach
                                            </td>
                                            <td class="d-flex">
                                                @can('User edit')
                                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary btn-sm mr-1" type="submit">
                                                    <i class="fas fa-edit" title='Edit'></i></a>
                                                @endcan
                                                @can('User delete')
                                                <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}">
                                                    @csrf
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button type="submit" button class="btn btn-danger btn-sm show_confirm" data-toggle="tooltip" title='Delete'><i class="fas fa-trash"></i></button>
                                                </form>
                                                @endcan

                                            </td>
                                            <!-- <td class="d-inline-flex">
                                                  
                                                   @can('User edit')

                                                   
                                                   <a href="{{route('admin.users.edit', $user->id)}}"
                                                       class="btn btn-primary btn-sm mr-1" title="Edit">
                                                       <i class="fas fa-edit"></i></a>
                                                   @endcan

                                                   @can('User delete')
                                                       <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                                           @csrf
                                                           @method('delete')
                                                           <button class="btn btn-danger btn-sm show_confirm"><i class="fa fa-trash"></i></button>
                                                       </form>
                                                   @endcan
                                               </td> -->
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center">{{ __('No data available') }}</td>
                                        </tr>
                                        @endforelse
                                        @endcan
                                    </tbody>
                                </table>
                                <div class="row mt-4">
                                    <div class="col-md-4">
                                        {{-- <ul class="pagination">
                                        <li class="page-item active"><a class="page-link">Showing to
                                               of {{ $permissions->total() }} records.</a></li>
                                        </ul> --}}
                                    </div>
                                    <div class="col-md-8 g-pg">
                                        {{ $users->render('pagination::bootstrap-4') }}
                                    </div>
                                </div>
                                @else
                                <div>{{__('No data avaliable')}}</div>
                                @endif
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                </div>
            </div>


        </div>
        <!-- /.container-fluid -->
    </section>
</div>
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script type="text/javascript">
    $('.show_confirm').click(function(event) {
        var form = $(this).closest("form");
        var name = $(this).data("name");
        event.preventDefault();
        swal({
                title: `Are you sure you want to delete this record?`,
                text: "If you delete this, it will be gone forever.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
    });
</script>
@endsection
@section('header-styles')
<!-- <link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
<style type="text/css">
div.dt-buttons{ position: relative;float: left;}
</style> -->
@endsection

@section('footer-scripts')
<!-- <script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script> -->
@endsection