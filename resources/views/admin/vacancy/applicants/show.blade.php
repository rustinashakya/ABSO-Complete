@extends('admin.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __('Applicantion of ' . $applicant->name) }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                {{ __('Applicant') }}
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
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <span>Name : <b>{{ $applicant->name }}</b></span>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <span>Email : <a
                                                                href='mailto:{{ $applicant->email }}?subject=QYEC%20Management'>{{ $applicant->email }}</a><br>
                                                            </a></span>
                                            </div>
                                            {{-- <div class="col-md-12 mb-3">
                                                <span>Phone : <b>{{ $applicant->phone }}</b></span>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <span>Addrss : <b>{{ $applicant->address }}</b></span>
                                            </div> --}}
                                            <div class="col-md-12 mb-3">
                                                <span>Position : <b>{{ $applicant->vacancy->title ?? '' }}
                                                        ({{ $applicant->vacancy->level->name ?? '' }})</b></span>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <span>Experience : <b>{{ $applicant->experience }}</b></span>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <span>CV File : <b><a
                                                            href="{{ asset('storage/uploads/applicant/cv_file/' . $applicant->cv_file) }}"
                                                            target="_blank">{{ __('Click here to view') }}</a></a></b></span>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <span>Cover Letter : <b>{{ $applicant->cover_letter }}</b></span>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <span>Training : <b>{{ $applicant->training_description }}</b></span>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <span>Salary Expectation :
                                                    <b>{{ $applicant->salary_expectation }}</b></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <form action="{{ route('admin.applicant.comment.store') }}" method="POST"
                                            id="commentForm">
                                            @csrf
                                            <div class="border p-5">
                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <input type="hidden" name="applicant_id"
                                                            value="{{ $applicant->id }}">
                                                        <label class="form-label"
                                                            for="status">{{ __('Status') }}</label>
                                                        <select class="form-control" name="status"
                                                            class="form-control @error('status')
                                                    is-invalid
                                                @enderror">
                                                            <option value="">Select status</option>
                                                            <option value="accepted"
                                                                {{ old('status') == 'accepted' ? 'selected' : '' }}>
                                                                Accepted
                                                            </option>
                                                            <option value="pending"
                                                                {{ old('status') == 'pending' ? 'selected' : '' }}>Pending
                                                            </option>
                                                            <option value="shortlisted"
                                                                {{ old('status') == 'shortlisted' ? 'selected' : '' }}>
                                                                Shortlisted
                                                            </option>
                                                            <option value="rejected"
                                                                {{ old('status') == 'rejected' ? 'selected' : '' }}>
                                                                Rejected
                                                            </option>
                                                        </select>
                                                        @error('status')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label class="form-label"
                                                            for="status">{{ __('Comment') }}</label>
                                                        <textarea name="comment"
                                                            class="form-control @error('comment')
                                                    is-invalid
                                                @enderror"
                                                            rows="3" cols="8">{{ old('comment') }}</textarea>
                                                    </div>
                                                    <button type="submit"
                                                        class="btn btn-primary">{{ __('Submit') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                                <div class="row mt-3">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase">{{ __('SN.') }}</th>
                                                <th class="text-uppercase">{{ __('Date') }}</th>
                                                <th class="text-uppercase">{{ __('Comment') }}</th>
                                                <th class="text-uppercase">{{ __('Comment By') }}</th>
                                                <th class="text-uppercase">{{ __('Status') }}</th>
                                                <th class="text-uppercase">{{ __('Actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($comments as $comment)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $comment->comment_date }}</td>
                                                    <td>{{ $comment->comment }}</td>
                                                    <td>{{ $comment->commentBy->name ?? '' }}</td>
                                                    <td>{{ ucwords($comment->status) }}</td>
                                                    <td>
                                                        <form
                                                            action="{{ route('admin.applicant.comment.destroy', $comment->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm show_confirm"><i
                                                                    class="fa fa-trash" title="Delete"></i></button>
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
@section('header-styles')
@endsection

@section('footer-scripts')
@endsection
