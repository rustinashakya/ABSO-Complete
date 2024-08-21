@extends('admin.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <div class="content-header px-3">
            <div class="container-fluid">
                <div class="row mb-2 mx-1">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __('Fun Facts') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                {{ __('Fun Facts') }}
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
                                <div class="d-flex justify-content-end mb-3">

                                    <a href="{{ route('admin.fun.create') }}" class="btn btn-primary">+ Add</a>
                                </div>


                                <div class="card">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase">{{ __('#') }}</th>
                                                <th class="text-uppercase">{{ __('title') }}</th>
                                                <th class="text-uppercase">{{ __('Actions') }}</th>
                                            </tr>

                                        </thead>

                                        <tbody>
                                            @forelse ($funs as $key => $fun)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ ucwords($fun->title) }}</td>
                                                    <td class="d-flex">
                                                        <a href="{{ route('admin.fun.edit', $fun->id) }}"
                                                            class="btn btn-primary btn-sm mr-1" type="submit">
                                                            <i class="fas fa-edit" title='Edit'></i></a>

                                                        <form method="POST"
                                                            action="{{ route('admin.fun.destroy', $fun->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input name="_method" type="hidden" value="DELETE">
                                                            <button type="submit" button
                                                                class="btn btn-danger btn-sm show_confirm"
                                                                data-toggle="tooltip" title='Delete'><i
                                                                    class="fas fa-trash"></i></button>
                                                        </form>

                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">{{ __('No data available') }}
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>

                                    <div class="row mt-4">
                                        <div class="col-md-4">
                                            {{-- <ul class="pagination">
                                                <li class="page-item active"><a class="page-link">Showing to
                                                        of {{ $clients->total() }} records.</a></li>
                                            </ul> --}}
                                        </div>
                                        {{-- <div class="col-md-8 g-pg">
                                            {{ $clients->render('pagination::bootstrap-4') }}
                                        </div> --}}
                                    </div>
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

        function resetForm() {
            document.getElementById("filterForm").reset();
        }
    </script>
@endsection
@section('header-styles')
@endsection

@section('footer-scripts')
@endsection
