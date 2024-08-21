{{-- <x-app-layout>
    <div>
         <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
             <div class="container mx-auto px-6 py-2">
                 <div class="text-right">
                   @can('Permission create')
                     <a href="{{route('admin.permissions.create')}}" class="bg-blue-500 text-white font-bold px-5 py-1 rounded focus:outline-none shadow hover:bg-blue-500 transition-colors ">New Permission</a>
@endcan
</div>

<div class="bg-white shadow-md rounded my-6">
    <table class="text-left w-full border-collapse">
        <thead>
            <tr>
                <th class="py-4 px-6 bg-grey-lightest font-bold text-sm text-grey-dark border-b border-grey-light">Permission Name</th>

                <th class="py-4 px-6 bg-grey-lightest font-bold text-sm text-grey-dark border-b border-grey-light text-right">Actions</th>
            </tr>
        </thead>
        <tbody>

            @can('Permission access')
            @foreach($permissions as $permission)
            <tr class="hover:bg-grey-lighter">
                <td class="py-4 px-6 border-b border-grey-light">{{ $permission->name }}</td>
                <td class="py-4 px-6 border-b border-grey-light text-right">
                    @can('Permission edit')
                    <a href="{{route('admin.permissions.edit',$permission->id)}}" class="text-grey-lighter font-bold py-1 px-3 rounded text-xs bg-green hover:bg-green-dark text-blue-400">Edit</a>
                    @endcan

                    @can('Permission delete')
                    <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST" class="inline">
                        @csrf
                        @method('delete')
                        <button class="text-grey-lighter font-bold py-1 px-3 rounded text-xs bg-blue hover:bg-blue-dark text-red-400">Delete</button>
                    </form>
                    @endcan
                </td>
            </tr>
            @endforeach
            @endcan

        </tbody>
    </table>
</div>

</div>
</main>
</div>
</div>
</x-app-layout> --}}

@extends('admin.layout')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-wrapper">
    <div class="content-header px-3">
        <div class="container-fluid">
            <div class="row mb-2 mx-1">
                <div class="col-sm-6">
                    <h1 class="m-0">{{__('Permissions')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.dashboard')}}">{{__('Home')}}</a>
                        </li>
                        <li class="breadcrumb-item">
                            {{__('Permissions')}}
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
                            <!-- /.card -->
                            <div class="card">
                                <!-- <div class="card-body"> -->
                                @can('Permission create')
                                {{-- <div class="row mb-3">
                                    <div class="col-md-12 text-right">
                                        <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary"> +
                                Add</a>
                                <!-- </div> -->
                                </div> --}}
                                @endcan

                                @if(count($permissions) > 0)
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>

                                            <th class="text-uppercase">{{__('#')}}</th>
                                            <th class="text-uppercase">{{__('PERMISSION NAME')}}</th>
                                            {{-- <th class="text-uppercase">{{__('ACTIONS')}}</th> --}}
                                        </tr>

                                    </thead>

                                    <tbody>
                                        @can('Permission access')
                                        @forelse($permissions as $key => $permission)
                                        <tr>
                                            <td>{{ $key + 1}}</td>
                                            <td>
                                                <b>{{ ucwords( $permission->name ) }}</b>
                                            </td>
                                            {{-- <td class="d-flex"> --}}
                                            {{-- <a href="{{route('details', Crypt::encryptString($case->id))}}"
                                            class="btn btn-primary btn-xs" title="View details">
                                            <i class="fas fa-eye"></i></a> --}}
                                            {{-- @can('Permission edit')
                                                        <a href="{{route('admin.permissions.edit', $permission->id)}}"
                                            class="btn btn-primary btn-sm mr-2" title="Edit">
                                            <i class="fas fa-edit"></i></a>
                                            @endcan

                                            @can('Permission delete')
                                            <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                            </form>
                                            @endcan
                                            </td> --}}
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center">{{ __('No data available') }}</td>
                                        </tr>
                                        @endforelse
                                        @endcan
                                    </tbody>
                                </table>
                                <div class="row mt-4 mx-3">
                                    <div class="justify-content-center">
                                        <ul class="pagination pagination-sm">
                                            {{ $permissions->render('pagination::bootstrap-4') }}
                                        </ul>
                                    </div>
                                </div>
                                @else
                                <div>{{__('No data avaliable')}}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>
</div>
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