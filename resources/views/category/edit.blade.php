@extends('admin.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __(' Edit Category') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                {{ __('Category') }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid">


                <section class="content">
                    <div class="container-fluid">
                        <div class="card card-body">
                            <form method="POST" enctype="multipart/form-data" action="{{route('category.update',$category->id)}}">
                                @csrf
                                @method('post')
                                {{-- <div class="row">
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="Category" class="form-label"><span>Parent Category</span>*</label>
                                        <select name="category_parent_id" class="form-control" id="category_parent_id">
                                            @php
                                                $category_id = old('category_parent_id', isset($category->category_parent_id) ? $category->category_parent_id : '');
                                            @endphp

                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    @if ($category_id == $category->id) {{ 'selected' }} @endif>
                                                    {{ $category->name }}</option>
                                            @endforeach
                                        </select>

                                        @if($errors->has('category_parent_id'))
                                            <span style="color:red;">{{$errors->first('category_parent_id')}}</span>
                                        @endif
                                    </div>

                                </div> --}}

                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="Category" class="form-label"><span>Category Name</span>*</label>
                                        <input id="name" type="text" name="name" value="{{ old('name',$category->name) }}" placeholder="Category Name"
                                            class="form-control">

                                            @if($errors->has('name'))
                                                <span style="color:red;">{{$errors->first('name')}}</span>
                                            @endif
                                    </div>

                                    {{-- <div class="mb-3 form-group-translation col-md-6">
                                        <label for="Category" class="form-label"><span>श्रेणी नाम</span>*</label>
                                        <input id="nepali_name" type="text" name="nepali_name" value="{{ old('nepali_name',$category->nepali_name) }}" placeholder="श्रेणी नाम"
                                            class="form-control">

                                            @if($errors->has('nepali_name'))
                                                <span style="color:red;">{{$errors->first('nepali_name')}}</span>
                                            @endif
                                    </div> --}}
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="Category" class="form-label"><span>Is Menu</span></label>
                                        <select name="is_menu" class="form-control" id="category_id">
                                            <option value="1" @if ($category->is_menu == '1') selected = "selected" @endif> Yes</option>
                                            <option value="0" @if ($category->is_menu == '0') selected = "selected" @endif > No</option>
                                        </select>

                                        @if($errors->has('template'))
                                            <span style="color:red;">{{$errors->first('template')}}</span>
                                        @endif
                                    </div>
                                </div>


                                <div class="row">
                                    {{-- <div class="mb-3 form-group-translation col-md-6">
                                        <label for="Category" class="form-label"><span>Is Menu</span></label>
                                        <select name="is_menu" class="form-control" id="category_id">
                                            <option value="1" @if ($category->is_menu == '1') selected = "selected" @endif> Yes</option>
                                            <option value="0" @if ($category->is_menu == '0') selected = "selected" @endif > No</option>
                                        </select>

                                        @if($errors->has('template'))
                                            <span style="color:red;">{{$errors->first('template')}}</span>
                                        @endif
                                    </div> --}}
                                </div>

                                <div class="row">
                                        <div class="mb-3 form-group-translation col-md-12">
                                            <label for="exampleFormControlFile1"><span>Category Image</span></label>
                                            <input type="hidden" name="category_image1" value="{{ $category->category_image }}">
                                            <input type="file" class="form-control-file" id="exampleFormControlFile1"  value="{{ old('category_image',$category->category_image) }}" name="category_image">
                                            @if($category->category_image)
                                            <div class="col-md-4" >
                                                <div class="image-trap" >
                                                    <a href="{{asset('storage/uploads/category_image/'.$category->category_image)}}" data-toggle="lightbox" data-gallery="multiimages" data-title="" class=" img-responsive">
                                                        <picture>
                                                            <source media="(min-width:3840px)" srcset="{{ asset('/storage/uploads/category_image/' . $category->category_image) }}" />

                                                            <source media="(min-width:2560px)" srcset="{{ asset('/storage/uploads/category_image/thumbnail/large_' . $category->category_image) }}" />

                                                             <source media="(min-width:1920px)" srcset="{{ asset('/storage/uploads/category_image/thumbnail/medium_' . $category->category_image) }}" />
                                                             <source media="(min-width:1366px)" srcset="{{ asset('/storage/uploads/category_image/thumbnail/small_' . $category->category_image) }}" />

                                                            <img src="{{ asset('/storage/uploads/category_image/thumbnail/vsmall_' . $category->category_image) }}" alt="Image" >
                                                        </picture>
                                                        {{-- <img class="img-thumbnail image_list" style="height: 100px"  src="{{asset('storage/uploads/category_image/thumbnail/'.$category->category_image)}}" alt="image"> --}}
                                                    </a>
                                                </div>
                                            </div>
                                            @endif
                                            @if($errors->has('category_image'))
                                            <span style="color:red;">{{$errors->first('category_image')}}</span>
                                            @endif
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
