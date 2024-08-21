@extends('admin.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <div class="content-header px-3">
            <div class="container-fluid">
                <div class="row mb-2 mx-1">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __('Clients') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                {{ __('Clients') }}
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
                                    <button class="btn btn-primary btn-rounded btn-md mr-3 collapse-button" type="button"
                                        data-toggle="collapse" data-target="#collapseExample" aria-expanded="false"
                                        aria-controls="collapseExample">
                                        <i class="fa fa-filter" aria-hidden="true" title="Advanced Search"></i>
                                    </button>
                                    @can('Team create')
                                        <a href="{{ route('admin.client.create') }}" class="btn btn-primary">+ Add</a>
                                    @endcan
                                </div>

                                <div class="collapse" id="collapseExample">
                                    <div class="card card-body">
                                        <div class="card-header p-1 mb-1">
                                            <h4>Filter Options</h4>
                                        </div>
                                        <div class="card-body p-0">
                                            <form action="{{ route('admin.client.index') }}" method="GET" id="filterForm">
                                                <!-- Search, Date range filter, and buttons in one row -->
                                                <div class="row align-items-center">
                                                    <div class="col-md-12 mb-3">
                                                        <div
                                                            class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                                            Name
                                                        </div>
                                                        <div class="d-flex align-items-center position-relative my-1">
                                                            <input type="text" data-kt-user-table-filter="name"
                                                                name="name" placeholder="Name"
                                                                class="form-control form-control-solid w-250px"
                                                                id="comapnyNameSearchInput" title="Name"
                                                                style="background-color: rgb(245, 245, 245);" />
                                                        </div>
                                                    </div>
                                                    {{-- <div class="col-md-4 mb-3">
                                                        <div
                                                            class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                                            Slug
                                                        </div>
                                                        <div class="d-flex align-items-center position-relative my-1">
                                                            <input type="text" data-kt-user-table-filter="email"
                                                                name="slug" placeholder="Slug"
                                                                class="form-control form-control-solid w-250px"
                                                                id="emailSearchInput" title="Email"
                                                                style="background-color: rgb(245, 245, 245);" />
                                                        </div>
                                                    </div> 
                                                    <div class="col-md-6 mb-3">
                                                        <div
                                                            class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                                            Designation
                                                        </div>
                                                        <div class="d-flex align-items-center position-relative my-1">
                                                            <input type="text" data-kt-user-table-filter="Designation"
                                                                name="designation" placeholder="Designation"
                                                                class="form-control form-control-solid w-250px"
                                                                id="emailSearchInput" title="Designation"
                                                                style="background-color: rgb(245, 245, 245);" />
                                                        </div>
                                                    </div>--}}
                                                </div>
                                                <!-- Buttons -->
                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <div class="d-flex justify-content-end">
                                                            <button type="button" class="btn btn-secondary mr-2"
                                                                onclick="resetForm()">Reset</button>
                                                            <button type="submit" class="btn btn-primary"
                                                                id="apply_filter">Apply Filters</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase">{{ __('#') }}</th>
                                                <th class="text-uppercase">{{ __('Name') }}</th>
                                                <th class="text-uppercase">{{ __('Organization Logo') }}</th>
                                                <th class="text-uppercase">{{ __('Actions') }}</th>
                                            </tr>

                                        </thead>

                                        <tbody>
                                            @forelse ($clients as $key => $client)
                                                <tr>
                                                    <td>{{ $clients->firstItem() + $key }}</td>
                                                    <td>
                                                        {{ ucwords($client->name) }}
                                                    </td>
                                                    <td>
                                                        @if ($client->organisation_logo)
                                                            <a href="{{ asset('storage/uploads/clients/organisation_logo/' . $client->organisation_logo) }}"
                                                                data-toggle="lightbox" data-gallery="multiimages"
                                                                data-title="" class=" img-responsive">
                                                                <picture>
                                                                    <source media="(min-width:3840px)"
                                                                        srcset="{{ asset('storage/uploads/clients/organisation_logo/thumbnail/admin_' . $client->organisation_logo) }}" />

                                                                    <img src="{{ asset('storage/uploads/clients/organisation_logo/thumbnail/admin_' . $client->organisation_logo) }}"
                                                                        alt="main Image" />
                                                                </picture>
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td class="d-flex">
                                                        @can('Team edit')
                                                            <a href="{{ route('admin.client.edit', $client->id) }}"
                                                                class="btn btn-primary btn-sm mr-1" type="submit">
                                                                <i class="fas fa-edit" title='Edit'></i></a>
                                                        @endcan
                                                        @can('Team delete')
                                                            <form method="POST"
                                                                action="{{ route('admin.client.destroy', $client->id) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <input name="_method" type="hidden" value="DELETE">
                                                                <button type="submit" button
                                                                    class="btn btn-danger btn-sm show_confirm"
                                                                    data-toggle="tooltip" title='Delete'><i
                                                                        class="fas fa-trash"></i></button>
                                                            </form>
                                                        @endcan

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
                                        <div class="col-md-8 g-pg">
                                            {{ $clients->render('pagination::bootstrap-4') }}
                                        </div>
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
