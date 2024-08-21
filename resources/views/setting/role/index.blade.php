@extends('admin.layout')

@section('content')
<div class="content-wrapper">
    <div class="content-header px-3">
        <div class="container-fluid">
            <div class="row mb-2 mx-1">
                <div class="col-sm-6">
                    <h1 class="m-0">{{__('Roles')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">{{__('Home')}}</a>
                        </li>
                        <li class="breadcrumb-item">
                            {{__('Roles')}}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content px-3">
        <div class="container-fluid">
            <div class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            @can('Role create')
                            <div class="row mb-3">
                                <div class="col-md-12 text-right">
                                    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">+
                                        Add</a>
                                </div>
                            </div>
                            @endcan

                            <div class="card">
                                @if(count($roles) > 0)
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase">{{__('#')}}</th>
                                            <th class="text-uppercase">{{__('ROLE NAME')}}</th>
                                            <th class="text-uppercase">{{__('PERMISSIONS')}}</th>
                                            <th class="text-uppercase">{{__('ACTIONS')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($roles as $key => $role)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td><b>{{ ucwords($role->name) }}</b></td>
                                            <td>
                                                @foreach($role->permissions as $permission)
                                                <span class="badge badge-info">{{ $permission->name }}</span>
                                                @endforeach
                                            </td>
                                            <td style="white-space: nowrap;">
                                                @can('Role edit')
                                                <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-primary btn-sm" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @endcan

                                                @can('Role delete')
                                                <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" style="display:inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger btn-sm show_confirm" title="Delete">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                                @endcan
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="row mt-4">
                                    <div class="col-md-4">
                                        <ul class="pagination">
                                            {{-- Show pagination information --}}
                                        </ul>
                                    </div>
                                    <div class="col-md-8">
                                        {{ $roles->render('pagination::bootstrap-4') }}
                                    </div>
                                </div>
                                @else
                                <div>{{__('No data available')}}</div>
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

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script type="text/javascript">
    $('.show_confirm').click(function(event) {
        var form = $(this).closest("form");
        event.preventDefault();
        swal({
            title: `Are you sure you want to delete this record?`,
            text: "If you delete this, it will be gone forever.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                form.submit();
            }
        });
    });
</script>
@endsection

@section('header-styles')
{{-- Uncomment and add styles if needed --}}
{{-- <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}"> --}}
{{-- <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}"> --}}
{{-- <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}"> --}}
{{-- <style type="text/css">
    div.dt-buttons{ position: relative;float: left;}
</style> --}}
@endsection

@section('footer-scripts')
{{-- Uncomment and add scripts if needed --}}
{{-- <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script> --}}
@endsection
