@extends('admin.layout')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __(' Add Notice') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
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
                        <form method="POST" enctype="multipart/form-data" action="{{ route('notice.store') }}">
                            @csrf
                            @method('post')
                            <div class="row">
                                <div class="mb-3 form-group-translation col-md-4">
                                    <label for="TItle" class="form-label"><span>Title</span>*</label>
                                    <input id="title" type="text" name="title" value="{{ old('title') }}"
                                        placeholder="Title" class="form-control">

                                    @if($errors->has('title'))
                                    <span style="color:red;">{{$errors->first('title')}}</span>
                                    @endif

                                </div>
                                <div class="mb-3 form-group-translation col-md-4">
                                    <label for="Slug" class="form-label"><span>Slug</span>*</label>
                                    <input id="slug" type="text" name="slug" value="{{ old('slug') }}"
                                        placeholder="Slug" class="form-control">

                                    @if($errors->has('slug'))
                                    <span style="color:red;">{{$errors->first('slug')}}</span>
                                    @endif

                                </div>
                                <div class="mb-3 form-group-translation col-md-4">
                                    <label for="published date" class="form-label"><span>Published date</span>*</label>
                                    <input type="date"  name="published_date" value="{{ old('published_date') }}" class="form-control" >

                                    @if($errors->has('published_date'))
                                    <span style="color:red;">{{$errors->first('published_date')}}</span>
                                    @endif

                                </div>
                            </div>


                            <div class="row">
                                <div class="mb-3 form-group-translation col-md-12">
                                    <label for="Description" class="form-label"><span>Description</span>*</label>
                                    <textarea name="description" rows="3" placeholder="Description"
                                        class="form-control">{{ old('description') }}</textarea>

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
                                        class="form-control">{{ old('meta_description') }}</textarea>

                                    @if($errors->has('meta_description'))
                                    <span style="color:red;">{{$errors->first('meta_description')}}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 form-group-translation col-md-12">
                                    <label for="Meta Keyword" class="form-label"><span>Meta Keyword</span></label>
                                    <textarea name="meta_keyword" id="" cols="8" rows="3" placeholder="Keyword"
                                        class="form-control">{{ old('meta_keyword') }}</textarea>

                                    @if($errors->has('meta_keyword'))
                                    <span style="color:red;">{{$errors->first('meta_keyword')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">

                                <div class="mb-3 form-group-translation col-md-12">
                                    <label for="File" class="form-label"><span>File</span></label>

                                    <div class="mb-3 mt-3_ form-group-translation ">
                                        {{-- <label for="exampleFormControlFile1"><span>Mobile Image</span>:</label> --}}
                                        <p class="text-blue">Note: Please upload only image of size 900*795 or pdf file </p>
                                        <input type="file" class="form-control-file" id="exampleFormControlFile1"
                                            name="notice_image">

                                        @if($errors->has('notice_image'))
                                        <span style="color:red;">{{$errors->first('notice_image')}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mt-2 col-md-12 text-right">
                                    <button type="submit" class="btn btn-success save-button"
                                        value="save">{{ __('Save') }}</button>
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
