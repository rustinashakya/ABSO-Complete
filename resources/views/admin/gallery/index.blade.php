@extends('admin.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <div class="content-header px-3">
            <div class="container-fluid">
                <div class="row mb-2 mx-1">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __('Galleries') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            {{-- <a title="Go Back" href="{{route('gallery')}}" class="btn btn-secondary btn-sm previous round"> <i class="fas fa-arrow-left" aria-hidden="true"></i></a>&nbsp;&nbsp; --}}
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                {{ __('Galleries') }}
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
                                <!-- <div class="card"> -->
                                <!-- <div class="card-body"> -->
                                <div class="row mb-3">
                                    <div class="col-md-12 text-right">
                                        <a href="{{ route('admin.gallery.add') }}" class="btn btn-primary"> +
                                            Add</a>
                                    </div>
                                </div>

                                <div class="card table-responsive">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase">#</th>
                                                <th class="">CAPTION</th>
                                                <th class="">TYPE</th>
                                                <th class="">FILE</th>
                                                <th class="">ACTION</th>
                                            </tr>

                                        </thead>
                                        <tbody>
                                            @forelse ($galleries as $key => $gallery)
                                                <tr>
                                                    <td>{{ $galleries->firstItem() + $key }}</td>
                                                    <td>{{ $gallery->caption }}</td>
                                                    <td>{{ $gallery->type }}</td>
                                                    <td>
                                                        @if ($gallery->type == 'image')
                                                        <a href="{{ asset('storage/uploads/gallery/main_image/' . $gallery->main_image) }}"
                                                            data-toggle="lightbox" data-gallery="multiimages" data-title=""
                                                            class=" img-responsive">
                                                            <picture>
                                                                <source media="(min-width:3840px)" srcset="{{ asset('storage/uploads/gallery/main_image/thumbnail/admin_' . $gallery->main_image) }}" />

                                                                <img src="{{ asset('storage/uploads/gallery/main_image/thumbnail/admin_' . $gallery->main_image) }}"
                                                                alt="main Image" />
                                                            </picture>
                                                        </a>
                                                            
                                                        @elseif($gallery->type == 'youtube_link')
                                                            <a href="{{ $gallery->youtube_link }}"
                                                                target="_blank">{{ $gallery->youtube_link }}</a>
                                                        @elseif($gallery->type == 'document')
                                                            <a
                                                                href="{{ asset('storage/uploads/gallery/document/' . $gallery->document) }}">{{ $gallery->document }}</a>
                                                        @endif
                                                    </td>
                                                    <td class="d-flex">
                                                        <a href="{{ route('admin.gallery.edit', $gallery->id) }}"
                                                            class="btn btn-primary btn-sm mx-1" title="Edit"><i
                                                                class="far fa-edit"></i></a>

                                                        <form method="POST"
                                                            action="{{ route('admin.gallery.destroy', $gallery->id) }}">
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
                                                    <td colspan="6" class="text-center">{{ __('No data available') }}
                                                    </td>
                                                </tr>
                                            @endforelse

                                        </tbody>
                                    </table>
                                    @if ($galleries->hasPages())
                                        <div class="pagination-wrapper">
                                            {{ $galleries->links() }}
                                        </div>
                                    @endif

                                    <!-- </div> -->
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
