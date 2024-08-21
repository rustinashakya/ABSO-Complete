@extends('admin.layout')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Testimonials') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        {{-- <a title="Go Back" href="{{route('gallery')}}"
                            class="btn btn-secondary btn-sm previous round" style=""> <i class="fas fa-arrow-left"
                                aria-hidden="true"></i></a>&nbsp;&nbsp; --}}
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            {{ __('Testimonials') }}
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
                                    <a href="{{ route('testimonial.add') }}" class="btn btn-primary" style=""> +
                                        Add</a>
                                </div>

                            </div>

                            <div class="box box-primary">
                                <div class="box-body table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase">#</th>
                                                <th class="">Thumbnail</th>
                                                <th class="">Link</th>
                                            </tr>

                                        </thead>
                                        <tbody>
                                            @foreach ($testimonials as $key => $testimonial)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>

                                                <td>@if (isset($testimonial->thumbnail))
                                                    <div class="col-md-12">
                                                        <div class="image-trap">
                                                            <a href="{{ asset('storage/uploads/testimonial_thumbnail/' . $testimonial->thumbnail) }}"
                                                                data-toggle="lightbox" data-gallery="multiimages"
                                                                data-title="" class=" img-responsive">
                                                                {{-- <img class="img-thumbnail image_list"
                                                                    src="{{ asset('storage/uploads/testimonial_thumbnail/' . $testimonial->thumbnail}}"
                                                                    onerror="this.onerror=null;this.src='storage/uploads/no-img.jpg';"
                                                                    alt="image"> --}}
                                                                <picture>
                                                                    {{--
                                                                    <source media="(min-width:1200)"
                                                                        srcset="{{ asset('/storage/uploads/testimonial_thumbnail/thumbnail/small_' . $testimonial->thumbnail) }}" />
                                                                    --}}
                                                                    <source media="(min-width:768px)"
                                                                        srcset="{{ asset('/storage/uploads/testimonial_thumbnail/thumbnail/modal_' . $testimonial->thumbnail) }}" />
                                                                    <img src="{{ asset('/storage/uploads/testimonial_thumbnail/thumbnail/vsmall_' . $testimonial->thumbnail) }}"
                                                                        alt="Image">
                                                                </picture>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    @endif
                                                <td>{{ $testimonial->link }}</td>
                                                </td>
                                                <td class="inline">

                                                    <a href="{{ route('testimonial.edit', $testimonial->id) }}" button
                                                        class="btn btn-primary btn-sm" type="submit" title='Edit'></button>
                                                        <i class="fas fa-edit"></i></a>
                                                    <form method="POST"
                                                        action="{{ route('testimonial.delete', $testimonial->id) }}"
                                                        style="display:inline">
                                                        @csrf
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <button type="submit" button
                                                            class="btn btn-danger btn-sm show_confirm"
                                                            data-toggle="tooltip" title='Delete'><i
                                                                class="fas fa-trash"></i></button>
                                                    </form>
                                                    {{-- <a href="{{ route('testimonial.delete', $testimonial->id) }}"
                                                        button class="btn btn-danger btn-sm" type="submit"></button>
                                                        <i class="fa fa-trash"></i></a> --}}
                                                </td>

                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
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
    $('.show_confirm').click(function (event) {
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