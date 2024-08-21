@extends('admin.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <div class="content-header px-3">
            <div class="container-fluid">
                <div class="row mb-2 mx-1">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __('Sectors') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                {{ __('Sectors') }}
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
                                <div class="d-flex justify-content-end mb-3">
                                    <button class="btn btn-primary btn-rounded btn-md mr-3 collapse-button" type="button"
                                        data-toggle="collapse" data-target="#collapseExample" aria-expanded="false"
                                        aria-controls="collapseExample">
                                        <i class="fa fa-filter" aria-hidden="true"></i>
                                    </button>
                                    @can('Page create')
                                        <a href="{{ route('admin.sectors.create') }}" class="btn btn-primary">+ Add</a>
                                    @endcan
                                </div>

                                <div class="collapse" id="collapseExample">
                                    <div class="card card-body">
                                        <div class="card-header p-1 mb-1">
                                            <h4>Filter Options</h4>
                                        </div>
                                        <div class="card-body p-0">
                                            <form action="{{ route('admin.sectors.index') }}" method="GET"
                                                id="filterForm">
                                                <!-- Search, Date range filter, and buttons in one row -->
                                                <div class="row align-items-center">
                                                    <div class="col-md-6 mb-3">
                                                        <div
                                                            class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                                            Title
                                                        </div>
                                                        <div class="d-flex align-items-center position-relative my-1">
                                                            <input type="text" data-kt-user-table-filter="name"
                                                                name="name" placeholder="Title"
                                                                class="form-control form-control-solid w-250px"
                                                                id="comapnyNameSearchInput" title="company Name"
                                                                style="background-color: rgb(245, 245, 245);" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
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

                                <div class="card table-responsive">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase">#</th>
                                                <th class="">TITLE</th>
                                                <th class="">Media File</th>
                                                <th class="">ACTIONS</th>
                                            </tr>

                                        </thead>

                                        <tbody>
                                            @forelse ($sectors as $key => $sector)
                                                <tr>
                                                    <td>{{ $sectors->firstItem() + $key }}</td>
                                                    <td>
                                                        <b>{{ @$sector->name }}</b>
                                                    </td>
                                                    <td>

                                                        @if (isset($sector->main_image))
                                                            <div class="col-md-12">
                                                                <div class="image-trap">
                                                                    <a href="{{ asset('storage/uploads/sectors/main_image/' . $sector->main_image) }}"
                                                                        data-toggle="lightbox" data-gallery="multiimages"
                                                                        data-title="" class=" img-responsive">
                                                                        {{-- <img class="img-thumbnail image_list"
                                                                src="{{ asset('storage/uploads/service_image/' . $service->service_image) }}"
                                                                onerror="this.onerror=null;this.src='storage/uploads/no-img.jpg';"
                                                                alt="image"> --}}
                                                                        <picture>
                                                                            {{--
                                                                <source media="(min-width:1200)"
                                                                    srcset="{{ asset('/storage/uploads/service_image/thumbnail/small_' . $service->service_image) }}" />
                                                                --}}
                                                                            {{-- <source media="(min-width:768px)" --}}
                                                                            {{-- srcset="{{ asset('/storage/uploads/sector/thumbnail/modal_' . $service->service_image) }}" /> --}}
                                                                            <img src="{{ asset('/storage/uploads/sectors/main_image/thumbnail/admin_' . $sector->main_image) }}"
                                                                                alt="Image">
                                                                        </picture>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @elseif($sector->youtube_link)
                                                            <a href="{{ $sector->youtube_link }}"
                                                                target="_blank">{{ $sector->youtube_link }}</a>
                                                        @endif
                                                    </td>

                                                    <td class="d-flex">
                                                        <a href="{{ route('admin.sectors.edit', $sector->id) }}"
                                                            class="btn btn-primary btn-sm mr-1" type="submit"><i
                                                                class="fas fa-edit" title='Edit'></i></a>
                                                        <form method="POST"
                                                            action="{{ route('admin.sectors.delete', $sector->id) }}">
                                                            @csrf
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
                                </div>


                                <div class="justify-content-center">
                                    <ul class="pagination pagination-sm">
                                        {!! $sectors->links() !!}
                                    </ul>
                                </div>
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
