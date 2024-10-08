@extends('admin.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <div class="content-header px-3">
            <div class="container-fluid">
                <div class="row mb-2 mx-1">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __('Project Types') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            {{-- <a title="Go Back" href="{{route('admin.project.types.index')}}"
                        class="btn btn-secondary btn-sm previous round"> <i class="fas fa-arrow-left" aria-hidden="true"></i></a>&nbsp;&nbsp; --}}
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                {{ __('Project Types') }}
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
                                @can('Vacancy create')
                                    <div class="row mb-3">
                                        <div class="col-md-12 text-right">
                                            <a href="{{ route('admin.project.types.create') }}" class="btn btn-primary"> +
                                                Add</a>
                                        </div>
                                    </div>
                                @endcan
                                <!-- /.card -->
                                <div class="card">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase">#</th>
                                                <th class="">TITLE</th>
                                                <th class="">DESCRIPTION</th>
                                                <th class="">ACTION</th>
                                            </tr>

                                        </thead>
                                        <tbody>
                                        @forelse ($projectTypes as $key => $project_type)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>

                                                <td>{{ $project_type->name }}</td>

                                                <td>{!! $project_type->description !!}</td>

                                                <td style="white-space: nowrap;">

                                                    <a href="{{ route('admin.project.types.edit', $project_type->id) }}"
                                                        button class="btn btn-primary btn-sm" type="submit"
                                                        title='Edit'></button>
                                                        <i class="fas fa-edit"></i></a>
                                                    <form method="POST"
                                                        action="{{ route('admin.project.types.destroy', $project_type->id) }}"
                                                        style="display:inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <button type="submit" button
                                                            class="btn btn-danger btn-sm show_confirm" data-toggle="tooltip"
                                                            title='Delete'><i class="fas fa-trash"></i></button>
                                                    </form>
                                                </td>

                                            </tr>
                                        @empty
                                            <tr><td colspan="7" class="text-center">{{ __('No data available') }}</td></tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                    <!-- </div>
                                    </div> -->
                                    <!-- </div> -->
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
