@extends('admin.layout')

@section('content')
    <!-- Separate CSS file or <style> block in <head> -->
    <style>
        .bg-text-white a {
            color: black;
        }

        .bg-text-white a:hover {
            font-weight: 800;
        }

        .hidden-form {
            display: none;
        }
    </style>

    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <div class="content-header px-3">
            <div class="container-fluid">
                <div class="row mb-2 mx-1">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __('Contact Us') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ __('Contact Us') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-2 m-3">
            <div class="col-md-12 d-flex align-items-center justify-content-end px-3">
                <button class="d-flex btn btn-success btn-sm me-2" type="button" id="search"><i class="fa fa-filter fa-1x m-2" aria-hidden="true"></i></button>
                @if (count($contact) > 0)
                    <a class="btn btn-info ml-2" href="{{ route('admin.contact.export') }}">Export</a>
                @endif
            </div>
            <div class="hidden-form px-3" id="searchForm">
                <div class="hidden-form-container">
                    <form action="{{ route('admin.contact.index') }}" method="get"
                        class="border border-dark-subtle p-3 mt-2 mb-3 bg-white">
                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="date_from" class="form-label">Date From</label>
                                <input type="date" id="date_from" name="date_from" class="form-control custom-input">
                            </div>
                            <div class="col-6">
                                <label for="date_to" class="form-label">Date To</label>
                                <input type="date" id="date_to" name="date_to" class="form-control custom-input">
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="d-flex btn btn-success">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <section class="content px-3">
            <div class="container-fluid">
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                @can('Vacancy create')
                                    <div class="row mb-3">
                                    </div>
                                @endcan
                                <!-- /.card -->
                                <div class="card">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase">#</th>
                                                <th class="text-uppercase">{{ __('User Info') }}</th>
                                                <th class="text-uppercase">{{ __('Message') }}</th>
                                                <th class="text-uppercase">{{ __('Created at') }}</th>
                                                <th class="text-uppercase">{{ __('Actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($contact as $key => $contacts)
                                                <tr>
                                                    <td>{{ $contact->firstItem() + $key }}</td>
                                                    <td class="bg-text-white">
                                                        {{ ucwords($contacts->name) }}<br>
                                                        <a
                                                            href='mailto:{{ $contacts->email }}?subject=Hope%20Fertility%20And%20Diagnostic'>{{ $contacts->email }}</a><br>
                                                        <a
                                                            href='tel:{{ $contacts->phone_no }}'>{{ $contacts->phone_no }}</a>
                                                    </td>
                                                    <td>{{ $contacts->message }}</td>
                                                    <td>{{ date('Y-m-d', strtotime($contacts->created_at)) }}</td>
                                                    <td class="d-flex">
                                                        <a href="{{ route('admin.contact.view', $contacts->id) }}"
                                                            class="btn btn-primary mr-1">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <form action="{{ route('admin.contact.delete', $contacts->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <button class="btn btn-danger show_confirm" type="submit">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
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
                                    @if ($contact->hasPages())
                                        <div class="pagination-wrapper">
                                            {{ $contact->links() }}
                                        </div>
                                    @endif
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
        document.getElementById('search').addEventListener('click', function() {
            var searchForm = document.getElementById('searchForm');
            if (searchForm.style.display === 'none' || searchForm.style.display === '') {
                searchForm.style.display = 'block';
            } else {
                searchForm.style.display = 'none';
            }
        });
    </script>
    <script>
        $('.show_confirm').click(function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                    title: `{{ __('Are you sure you want to delete this record?') }}`,
                    text: "{{ __('If you delete this, it will be gone forever.') }}",
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
