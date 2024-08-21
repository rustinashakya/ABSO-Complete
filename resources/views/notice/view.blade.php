@extends('admin.layout')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __(' Notice Details') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="mr-2">
                            <a title="Go Back" href="{{route('notice.index')}}" class="btn btn-secondary btn-sm previous round"
                            style=""> <i class="fas fa-arrow-left" aria-hidden="true"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            {{ __('Notices') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
            <section class="content row">
                <div class="container-fluid">
                    <div class="card card-body">
                        {{-- <div class="row mb-3">
                            <div class="col-md-12 text-left">

                            </div>
                        </div> --}}



                        <div class="row">
                            <div class="mb-3 form-group-translation col-md-6">
                                <label for="Name" class="form-label"><b>Title</b></label>
                                <div class="ml-2">
                                    {{ $notice->title }}
                                </div>

                            </div>
                            <div class="mb-3 form-group-translation col-md-6">
                                <label for="published" class="form-label"><span><b>Published Date</b></span></label>
                                <div class="ml-2">
                                    {{ $notice->publish_date }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 form-group-translation col-md-8">
                                <label for="Description" class="form-label"><span><b>Description</b></span></label>
                                <div class="ml-2">
                                    {{ $notice->description }}
                                </div>
                            </div>

                        </div>




                        <div class="row">
                            <div class="mb-3 form-group-translation col-md-8">
                                <label for="Meta Description" class="form-label"><span><b>Meta
                                    Description</b></span></label>

                                <div class="ml-2">
                                    {{ $notice->meta_description }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 form-group-translation col-md-8">
                                <label for="Meta Keyword" class="form-label"><span><b>Meta Keyword</b></span></label>

                                <div class="ml-2">
                                    {{ $notice->meta_keyword }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @if($notice->file_image)
                            <div class="mb-3 form-group-translation col-md-8">
                                <label for="Name of office" class="form-label"><span><b>File</b></span></label>

                                <div class="ml-2">
                                    @php
                                        $extension = $notice->file_image;
                                        $ext = File::extension($extension);
                                    @endphp
                                    @if($ext != 'pdf')

                                    <div class="col-md-12" >
                                        <div class="image-trap" >
                                            <a href="{{asset('storage/uploads/pdf_image/'.$notice->file_image)}}" data-toggle="lightbox" data-gallery="multiimages" data-title="" class=" img-responsive">
                                                <picture>
                                                    <source media="(min-width:3840px)" srcset="{{ asset('/storage/uploads/pdf_image/' . $notice->file_image) }}" />

                                                    <source media="(min-width:2560px)" srcset="{{ asset('/storage/uploads/pdf_image/thumbnail/large_' . $notice->file_image) }}" />

                                                     <source media="(min-width:1920px)" srcset="{{ asset('/storage/uploads/pdf_image/thumbnail/medium_' . $notice->file_image) }}" />
                                                     <source media="(min-width:1366px)" srcset="{{ asset('/storage/uploads/pdf_image/thumbnail/small_' . $notice->file_image) }}" />

                                                    <img src="{{ asset('/storage/uploads/pdf_image/thumbnail/vsmall_' . $notice->file_image) }}" alt="Image" >
                                                </picture>
                                                {{-- <img class="img-thumbnail image_list" style="height: auto;"  src="{{asset('storage/uploads/pdf_image/thumbnail/'.$notice->file_image)}}" alt="image"> --}}
                                            </a>
                                        </div>
                                    </div>
                                    @endif
                                    @if($ext == 'pdf')
                                        <iframe src="{{asset('storage/uploads/pdf_image/  '.$notice->file_image)}}" width="40%" height="300">
                                                This browser does not support PDFs. Please download the PDF to view it: <a href="{{asset('storage/uploads/pdf_image/'.$notice->file_image)}}">Download PDF</a>
                                        </iframe>
                                        @endif
                                </div>
                            </div>
                            @else
                            <div class="mb-3 form-group-translation col-md-8">
                                <label for="Name of office" class="form-label"><span><b>File</b></span></label>
                                <p>No Images and PDF    </p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- /.container-fluid -->
    </section>
</div>
@endsection

@section('scripts')
<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .then(editor => {
            console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });

</script>
@endsection
