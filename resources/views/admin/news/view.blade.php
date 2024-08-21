@extends('admin.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __(' News Detail') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <a title="Go Back" href="{{ route('admin.news.index') }}"
                                class="btn btn-secondary btn-sm previous round" style=""> <i class="fas fa-arrow-left"
                                    aria-hidden="true"></i></a> &nbsp;&nbsp;
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.news.index') }}">{{ __('News') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                {{ __('News Detail') }}
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
                            <div class="row mb-3">
                                <div class="col-md-12 text-left">
                                    <!-- <a href="{{ route('admin.news.index') }}" class="btn btn-secondary btn-sm previous round"
                                        style=""> <i class="fas fa-arrow-left" aria-hidden="true"></i> Go Back</a> -->
                                </div>
                            </div>
                            <div class="row">

                                <div class="mb-3 form-group-translation col-md-4">
                                    <label for="Name" class="form-label"><b>Title</b></label>
                                    <div class="">
                                        {{ $new_s->title }}
                                    </div>

                                </div>


                               
                                <div class="mb-3 form-group-translation col-md-4">
                                    <label for="Name" class="form-label"><b>Html Title</b></label>
                                    <div class="ml-2">
                                        {{ $new_s->html_title }}
                                    </div>

                                </div>

                                <div class="mb-3 form-group-translation col-md-4">
                                    <label for="Meta Description" class="form-label"><span><b>Meta
                                            Description</b></span></label>
    
                                    <div class="">
                                        {{ $new_s->meta_description }}
                                    </div>
                                </div>
                                <div class="mb-3 form-group-translation col-md-4">
                                    <label for="published" class="form-label"><span><b>Published Date</b></span></label>
                                    <div class="">
                                        {{ $new_s->published_date }}
                                    </div>
                                </div>

                            </div>
                            <div class="row">

                                <div class="mb-3 form-group-translation col-md-4">
                                    <label for="Meta Keyword" class="form-label"><span><b>Meta Keyword</b></span></label>

                                    <div class="">
                                        {{ $new_s->meta_keyword }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 form-group-translation col-md-12">
                                    <label for="Description" class="form-label"><span><b>Description</b></span></label>
                                    <div class="">
                                       <!-- {!! $new_s->description !!} -->
                                       @php
                                       
                                       if (strpos($new_s->description, '<oembed') !== false) {
    
                                                preg_match('/<oembed[^>]*?url="(.*?)"><\/oembed>/', $new_s->description, $matches);

    
                                        if (isset($matches[1])) {
                                            $oembed_url = $matches[1];
                                        
                                            $new_s->description = str_replace('<oembed url="' . $oembed_url . '"></oembed>', '<iframe width="700" height="315" src="' . $oembed_url . '" frameborder="0" allowfullscreen></iframe>', $new_s->description);
                                            }
                                        }
                                        echo $new_s->description;
                                       @endphp
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                @if ($new_s->main_image)
                                    <div class="mb-3 form-group-translation col-md-12">
                                        <label for="Name of office" class="form-label"><span><b>Image File</b></span></label>

                                        <div class="ml-2">
                                            @php
                                                $extension = $new_s->file_image;
                                                $ext = File::extension($extension);
                                            @endphp
                                            @if ($ext != 'pdf')
                                                <div class="col-md-6">
                                                    <div class="image-trap">
                                                        <a href="{{ asset('storage/uploads/news/main_image/' . $new_s->main_image) }}"
                                                            data-toggle="lightbox" data-gallery="multiimages" data-title=""
                                                            class=" img-responsive">
                                                            <picture>
                                                                <source media="(min-width:3840px)" srcset="{{ asset('/storage/uploads/news/main_image/thumbnail/admin_' . $new_s->main_image) }}" />

                                                                <img src="{{ asset('/storage/uploads/news/main_image/thumbnail/admin_' . $new_s->main_image) }}" alt="Image" >
                                                            </picture>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif
                                            @if ($ext == 'pdf')
                                                <iframe
                                                    src="{{ asset('storage/uploads/pdf_image/' . $new_s->file_image) }}"
                                                    width="40%" height="300">
                                                    This browser does not support PDFs. Please download the PDF to view it:
                                                    <a
                                                        href="{{ asset('storage/uploads/pdf_image/' . $new_s->file_image) }}">Download
                                                        PDF</a>
                                                </iframe>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="row">
                                @if ($new_s->youtube_link)
                                    <div class="mb-3 form-group-translation col-md-8">
                                        <br>
                                        <label for="Youtube" class="form-label"><b>Youtube Link</b></label>
                                        
                                            <div style="cursor: pointer;">
                                                <iframe id="myVideo" width="283" height="225"
                                                    src="{{ $new_s->youtube_link }}" title="YouTube video player"
                                                    frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                    allowfullscreen></iframe>
                                            </div>

                                        
                                        <div>
                                @endif
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
