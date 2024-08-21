@extends('admin.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <div class="content-header px-3">
            <div class="container-fluid">
                <div class="row mb-2 mx-1">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __('Applicants') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                {{ __('Applicants') }}
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
                                </div>

                                <div class="collapse" id="collapseExample">
                                    <div class="card card-body">
                                        <div class="card-header p-1 mb-1">
                                            <h4>Filter Options</h4>
                                        </div>
                                        <div class="card-body p-0">
                                            <form action="{{ route('admin.applicant.index') }}" method="GET"
                                                id="filterForm">
                                                <!-- Search, Date range filter, and buttons in one row -->
                                                <div class="row align-items-center">
                                                    <div class="col-md-3 mb-3">
                                                        <div
                                                            class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                                            Name
                                                        </div>
                                                        <div class="d-flex align-items-center position-relative my-1">
                                                            <input type="text" data-kt-user-table-filter="name"
                                                                name="name" placeholder="Title"
                                                                class="form-control form-control-solid w-250px"
                                                                id="comapnyNameSearchInput" title="Title"
                                                                style="background-color: rgb(245, 245, 245);" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <div
                                                            class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                                            Email
                                                        </div>
                                                        <div class="d-flex align-items-center position-relative my-1">
                                                            <input type="text" data-kt-user-table-filter="email"
                                                                name="email" placeholder="Email"
                                                                class="form-control form-control-solid w-250px"
                                                                id="email" title="Email"
                                                                style="background-color: rgb(245, 245, 245);" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <div
                                                            class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                                            Phone
                                                        </div>
                                                        <div class="d-flex align-items-center position-relative my-1">
                                                            <input type="text" data-kt-user-table-filter="phone"
                                                                name="phone" placeholder="Phone"
                                                                class="form-control form-control-solid w-250px"
                                                                id="phone" title="Phone"
                                                                style="background-color: rgb(245, 245, 245);" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <div
                                                            class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                                            Position
                                                        </div>
                                                        <div class="d-flex align-items-center position-relative my-1">
                                                            <select class="form-control form-control-solid w-250px"
                                                                name="vacancy_id" id="vacancy_id">
                                                                <option value="">Select Position</option>
                                                                @foreach ($vacancies as $vacancy)
                                                                    <option value="{{ $vacancy->id }}">
                                                                        {{ $vacancy->title }}
                                                                        ({{ $vacancy->level->name ?? '' }})</option>
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
                                <div class="card">
                                    <div class="card-body">

                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="text-uppercase">{{ __('#') }}</th>
                                                    <th class="text-uppercase">{{ __('NAME') }}</th>
                                                    <th class="text-uppercase">{{ __('EMAIL') }}</th>
                                                    <th class="text-uppercase">{{ __('Type') }}</th>
                                                    <th class="text-uppercase">{{ __('POSITION') }}</th>
                                                    <th class="text-uppercase">{{ __('EXPERIENCE') }}</th>
                                                    <th class="text-uppercase">{{ __('ACTIONS') }}</th>
                                                </tr>

                                            </thead>

                                            <tbody>
                                                @forelse ($applicants as $key => $applicant)
                                                    <tr>
                                                        <td>{{ $applicants->firstItem() + $key }}</td>
                                                        <td>
                                                            <b>{{ ucwords($applicant->name) }}</b>
                                                        </td>
                                                        <td><a
                                                                href='mailto:{{ $applicant->email }}?subject=QYEC%20Management'>{{ $applicant->email }}</a><br>
                                                            </a>
                                                        </td>
                                                        <td>{{ ucwords($applicant->type) }}</td>
                                                        <td>{{ $applicant->vacancy->title ?? '' }}
                                                            @if ($applicant->vacancy->vacancy_level_id)
                                                                ({{ $applicant->vacancy->level->name ?? '' }})
                                                            @endif
                                                        </td>
                                                        <td>{{ $applicant->experience }}</td>
                                                        <td class="d-inline-flex">
                                                            @can('Vacancy edit')
                                                                <a href="{{ route('admin.applicant.show', $applicant->id) }}"
                                                                    class="btn btn-primary btn-sm mr-1 mb-3" type="submit">
                                                                    <i class="fas fa-eye" title='show'></i></a>
                                                            @endcan
                                                            @can('Vacancy delete')
                                                                <form method="POST"
                                                                    action="{{ route('admin.applicant.destroy', $applicant->id) }}">
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
                                                        <td colspan="7" class="text-center">
                                                            {{ __('No data available') }}</td>
                                                    </tr>
                                                @endforelse
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
                                                {{ $applicants->render('pagination::bootstrap-4') }}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
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
