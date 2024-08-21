@extends('admin.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __('Notices') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                {{ __('Notices') }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- /.card -->
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-12 text-right">
                                        <a href="{{ route('notice.add') }}" class="btn btn-primary" style=""> +
                                            Add</a>

                                        <div class="col-md-4 text-left">
                                            {{-- <label for="">Search</label>
                                            <form role="search" action="{{ route('admin.page.search.category') }}">
                                                <select type="input" class="form-control" name="category" onchange="this.form.submit()">
                                                    <option value="">Select Category</option>
                                                    @foreach ($category as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </form> --}}
                                        </div>

                                    </div>

                                </div>
                                <div class="box box-primary">
                                    <div class="box-body table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="text-uppercase">#</th>
                                                    <th class="">Title</th>
                                                    <th class="">Slug</th>
                                                    <th class="">Published Date</th>
                                                    <th class="">Actions</th>
                                                </tr>

                                            </thead>

                                            <tbody>
                                                @foreach ($notices as $key => $notice)
                                                <tr>
                                                    <td>{{ $notices->firstItem() + $key }}</td>
                                                    <td>{{ $notice->title }}</td>
                                                    <td>{{ $notice->slug }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($notice->publish_date)->diffForHumans() }}</td>
                                                    <td class="d-inline-flex">
                                                        <a href="{{ route('notice.edit', $notice->id) }}"
                                                            class="btn btn-primary btn-sm" title="Edit"><i
                                                                class="fas fa-edit"></i></a>
                                                        <a href="{{ route('notice.view', $notice->id) }}"
                                                            class="btn btn-primary btn-sm mx-1" title="View"><i
                                                                class="fas fa-eye"></i></a>
                                                        <form method="POST"
                                                            action="{{ route('notice.delete', $notice->id) }}">
                                                            @csrf
                                                            <input name="_method" type="hidden" value="DELETE">
                                                            <button type="submit" button
                                                                class="btn btn-danger btn-sm show_confirm"
                                                                data-toggle="tooltip" title='Delete'><i
                                                                    class="fas fa-trash"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                        @if ($notices->hasPages())
                                            <div class="pagination-wrapper">
                                                {{ $notices->links() }}
                                            </div>
                                        @endif
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
