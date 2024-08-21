@extends('admin.layout')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __(' Edit Notice') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            {{ __('Edit Notice') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
            @if (session('message'))
            <div class="alert alert-success  alert-dismissible fade show">{{ session('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <section class="content row">
                <div class="container-fluid">
                    <div class="card card-body">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('notice.update',$notice->id) }}">
                            @csrf
                            @method('post')


                            <div class="row">
                                <div class="mb-3 form-group-translation col-md-4">
                                    <label for="Title" class="form-label"><span>Title</span>*</label>
                                    <input id="title" type="text" name="title" value="{{ $notice->title }}"
                                        placeholder="Title" class="form-control">

                                    @if($errors->has('title'))
                                    <span style="color:red;">{{$errors->first('title')}}</span>
                                    @endif

                                </div>
                                <div class="mb-3 form-group-translation col-md-4">
                                    <label for="Slug" class="form-label"><span>Slug</span>*</label>
                                    <input id="slug" type="text" name="slug" value="{{ $notice->slug }}"
                                        placeholder="Slug" class="form-control">

                                    @if($errors->has('slug'))
                                    <span style="color:red;">{{$errors->first('slug')}}</span>
                                    @endif

                                </div>
                                <div class="mb-3 form-group-translation col-md-4">
                                    <label for="published date" class="form-label"><span>Published date</span>*</label>
                                    <input type="date"  name="published_date" value="{{ $notice->publish_date }}" class="form-control" >

                                    @if($errors->has('published_date'))
                                    <span style="color:red;">{{$errors->first('published_date')}}</span>
                                    @endif

                                </div>
                            </div>



                            <div class="row">
                                <div class="mb-3 form-group-translation col-md-12">
                                    <label for="Description" class="form-label"><span>Description</span>*</label>
                                    <textarea name="description" rows="3" placeholder="Description"
                                        class="form-control">{{ $notice->description }}</textarea>

                                    @if($errors->has('description'))
                                    <span style="color:red;">{{$errors->first('description')}}</span>
                                    @endif

                                </div>

                            </div>





                            <div class="row">
                                <div class="mb-3 form-group-translation col-md-12">
                                    <label for="Meta Description" class="form-label"><span>Meta
                                            Description</span></label>
                                    <textarea name="meta_description" id="" cols="8" rows="3"
                                        placeholder="Meta Description"
                                        class="form-control">{{ $notice->meta_description }}</textarea>

                                    @if($errors->has('meta_description'))
                                    <span style="color:red;">{{$errors->first('meta_description')}}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 form-group-translation col-md-12">
                                    <label for="Meta Keyword" class="form-label"><span>Meta Keyword</span></label>
                                    <textarea name="meta_keyword" id="" cols="8" rows="3" placeholder="Keyword"
                                        class="form-control">{{ $notice->meta_keyword }}</textarea>

                                    @if($errors->has('meta_keyword'))
                                    <span style="color:red;">{{$errors->first('meta_keyword')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">

                                <div class="mb-3 form-group-translation col-md-12">
                                    <label for="Name of office" class="form-label"><span>File</span></label>

                                    <div class="mb-3 mt-2 form-group-translation">
                                        <p class="text-blue">Note: Please upload only image of size 900*795 or pdf file. </p>
                                        @php
                                            $extension = $notice->file_image;
                                            $ext = File::extension($extension);
                                        @endphp

                                        <input type="file" class="form-control-file" id="exampleFormControlFile1"  value="{{ old('file',$notice->file_image) }}" name="file">
                                        @if($notice->file_image)
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
                                            <iframe src="{{asset('storage/uploads/pdf_image/'.$notice->file_image)}}" width="40%" height="300">
                                                    This browser does not support PDFs. Please download the PDF to view it: <a href="{{asset('storage/uploads/pdf_image/'.$notice->file_image)}}">Download PDF</a>
                                            </iframe>
                                        @endif
                                        @if($errors->has('file'))
                                        <span style="color:red;">{{$errors->first('file')}}</span>
                                        @endif
                                        @else
                                        <div class="mb-3 form-group-translation col-md-8">
                                            <p>No Images and PDF added   </p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mt-2 col-md-12 text-right">
                                    <button type="submit" class="btn btn-success save-button"
                                        value="save">{{ __('Update') }}</button>
                                </div>
                            </div>
                        </form>
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
