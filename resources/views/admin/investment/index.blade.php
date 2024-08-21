@extends('admin.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <div class="content-header px-3">
            <div class="container-fluid">
                <div class="row mb-2 mx-1">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __('Investments') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            {{-- <a title="Go Back" href="{{route('admin.investment.index')}}"
                        class="btn btn-secondary btn-sm previous round"> <i class="fas fa-arrow-left" aria-hidden="true"></i></a>&nbsp;&nbsp; --}}
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                {{ __('Investments') }}
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
                                    @can('Investment create')
                                        <a href="{{ route('admin.investment.create') }}" class="btn btn-primary">+ Add</a>
                                    @endcan
                                </div>

                                <div class="collapse" id="collapseExample">
                                    <div class="card card-body">
                                        <div class="card-header p-1 mb-1">
                                            <h4>Filter Options</h4>
                                        </div>
                                        <div class="card-body p-0">
                                            <form action="{{ route('admin.investment.index') }}" method="GET"
                                                id="filterForm">
                                                <!-- Search, Date range filter, and buttons in one row -->
                                                <div class="row align-items-center">
                                                    <div class="col-md-4 mb-3">
                                                        <div
                                                            class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                                            Title
                                                        </div>
                                                        <div class="d-flex align-items-center position-relative my-1">
                                                            <input type="text" data-kt-user-table-filter="name"
                                                                name="title" placeholder="Title"
                                                                class="form-control form-control-solid w-250px"
                                                                id="comapnyNameSearchInput" title="company Name"
                                                                style="background-color: rgb(245, 245, 245);" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
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
                                                    <div class="col-md-4 mb-3">
                                                        <div
                                                            class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                                            Stage
                                                        </div>
                                                        <div class="d-flex align-items-center position-relative my-1">
                                                            <select name="stage" id="stage" class="form-control">
                                                                <option value="">Select Stage</option>
                                                                <option value="completed">Completed</option>
                                                                <option value="ongoing">Ongoing</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <div
                                                            class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                                            Project Type
                                                        </div>
                                                        <div class="d-flex align-items-center position-relative my-1">
                                                            <select name="project_type_id" id="project_type_id"
                                                                class="form-control">
                                                                <option value="">Select Project Type</option>
                                                                @foreach ($projectTypes as $projectType)
                                                                    <option value="{{ $projectType->id }}">
                                                                        {{ $projectType->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <div
                                                            class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                                            Sector
                                                        </div>
                                                        <div class="d-flex align-items-center position-relative my-1">
                                                            <select name="page_id" id="page_id" class="form-control">
                                                                <option value="">Select sector</option>
                                                                @foreach ($sectors as $sector)
                                                                    <option value="{{ $sector->id }}">{{ $sector->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
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
                                <!-- /.card -->
                                <div class="card">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase">#</th>
                                                <th class="">TITLE</th>
                                                <th class="">CAPITAL</th>
                                                <th class="">START YEAR</th>
                                                <th class="">PAYBACK PERIOD</th>
                                                <th class="">ACTION</th>
                                            </tr>

                                        </thead>
                                        <tbody>
                                            @forelse ($investments as $investment)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>

                                                    <td>{{ $investment->title }}</td>

                                                    <td>{{ $investment->capital }}</td>
                                                    <td>{{ $investment->start_year }}</td>
                                                    <td>{{ $investment->payback_period }}</td>

                                                    <td style="white-space: nowrap;">
                                                        <a href="{{ route('admin.investment.language.index', $investment->id) }}"
                                                            class="btn btn-primary btn-sm mr-1" type="submit"><i
                                                                class="fas fa-language" title='Translation'></i></a>
                                                        <a href="{{ route('admin.investment.edit', $investment->id) }}"
                                                            button class="btn btn-primary btn-sm" type="submit"
                                                            title='Edit'></button>
                                                            <i class="fas fa-edit"></i></a>
                                                        <form method="POST"
                                                            action="{{ route('admin.investment.delete', $investment->id) }}"
                                                            style="display:inline">
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
                                                    <td colspan="6" class="text-center">{{ __('No data available') }}
                                                    </td>
                                                </tr>
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

        function resetForm() {
            document.getElementById("filterForm").reset();
        }
    </script>
@endsection
