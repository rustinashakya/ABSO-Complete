@extends('admin.layout')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-wrapper">
    <div class="content-header px-3">
        <div class="container-fluid">
            <div class="row mb-2 mx-1">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('View Campaign') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <a title="Go Back" href="{{ route('admin.campaign.index') }}" class="btn btn-secondary btn-sm previous round"> <i class="fas fa-arrow-left" aria-hidden="true"></i></a> &nbsp;&nbsp;
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.campaign.index') }}">{{ __('Campaigns') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            {{ __('View Campaign') }}
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
                            <div class="card card-body">
                                <form>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="title">Title <span class="text-danger">*</span></label>
                                            <input type="text" id="title" name="title" value="{{ $campaign->title }}" readonly class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="url">Url <span class="text-danger">*</span></label>
                                            <input type="url" id="url" name="url" value="{{ $campaign->url }}" readonly class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="status">Status <span class="text-danger">*</span></label>
                                            <select id="status" name="status" disabled class="form-control">
                                                <option value="1" {{ $campaign->status ? 'selected' : '' }}>Yes</option>
                                                <option value="0" {{ !$campaign->status ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>


                                <div class="row mt-4">
                                    @foreach($campaign->images as $image)
                                    <div class="col-md-3 mb-3">
                                        <p>{{ $loop->iteration }} .</p>
                                        <img src="{{ asset('storage/uploads/campaign/main_image/thumbnail/admin_' . $image->main_image) }}" alt="Image" class="img-fluid" data-toggle="modal" data-target="#imageModal{{ $loop->iteration }}">
                                    </div>

                                    <!-- Modal -->
                                    <div class="modal fade" id="imageModal{{ $loop->iteration }}" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel{{ $loop->iteration }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="imageModalLabel{{ $loop->iteration }}">{{ $image }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <img src="{{ asset('storage/uploads/campaign/main_image/' . $image) }}" alt="Image" class="img-fluid">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- </div> -->
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
@section('header-styles')
@endsection

@section('footer-scripts')
@endsection