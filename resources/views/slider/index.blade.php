@extends('admin.layout')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-wrapper">
    <div class="content-header px-3">
        <div class="container-fluid">
            <div class="row mb-2 mx-1">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Home Page Banner') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            {{ __('Home Page Banner') }}
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
                            <div class="row mb-3">
                                <div class="col-md-12 text-right">
                                    <a href="{{ route('admin.slider.add') }}" class="btn btn-primary">+ Add</a>
                                </div>
                            </div>

                            <div class="card">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase">#</th>
                                            <th>CAPTION TITLE</th>
                                            <th>CAPTION DESCRIPTION</th>
                                            {{-- <th>SLIDER TYPE</th>
                                            <th>MAIN IMAGE</th> --}}
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($sliders as $slider)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td><b>{{ $slider->name }}</b></td>
                                            <td><b>{!! $slider->caption_description !!}</b></td>
                                            {{-- <td>
                                                @if($slider->main_image)
                                                <b>Image</b>
                                                @else
                                                <b>Youtube</b>
                                                @endif
                                            </td>
                                            <td>
                                                @if($slider->main_image)
                                                <a href="{{asset('storage/uploads/slider/main_image/'.$slider->main_image)}}" data-toggle="lightbox" data-gallery="multiimages" data-title="" class="img-responsive">
                                                    <picture>
                                                        <img src="{{ asset('/storage/uploads/slider/main_image/thumbnail/admin_' . $slider->main_image) }}" alt="Image">
                                                    </picture>
                                                </a>
                                                @endif
                                            </td> --}}
                                            <td style="white-space: nowrap;">
                                                <a href="{{ route('admin.slider.edit', $slider->id) }}" class="btn btn-primary btn-sm" title="Edit">
                                                    <i class="fas fa-edit" title='Edit'></i>
                                                </a>
                                                <form method="POST" action="{{ route('admin.slider.destroy', $slider->id) }}" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button type="submit" class="btn btn-danger btn-sm show_confirm" data-toggle="tooltip" title='Delete'>
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center">{{ __('No data available') }}</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

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
@endsection