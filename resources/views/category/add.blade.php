@extends('admin.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __(' Add Category') }}</h1>
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

                @if (session('message'))
                    <div class="alert alert-success  alert-dismissible fade show">{{ session('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <section class="content">
                    <div class="container-fluid">
                        <div class="card card-body">
                            <form method="POST" enctype="multipart/form-data" action="{{route('category.store')}}">
                                @csrf
                                @method('post')
                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="Category" class="form-label"><span>Parent Category</span></label>
                                        <select name="category_parent_id" class="form-control" id="category_parent_id">
                                            @php
                                                $category_parent_id = old('category_parent_id', isset($level->category_parent_id) ? $level->category_parent_id : '');
                                            @endphp
                                            <option value ="" selected = "selected"> Select Category..</option>
                                            @foreach ($category as $parent_category_name)
                                                <option value="{{ $parent_category_name->id }}"
                                                    @if ($category_parent_id == $parent_category_name->id) {{ 'selected' }} @endif>
                                                    {{ $parent_category_name->name }}</option>
                                            @endforeach
                                        </select>

                                        @if($errors->has('category_parent_id'))
                                            <span style="color:red;">{{$errors->first('category_parent_id')}}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="Category" class="form-label"><span>Is Menu</span></label>
                                        <select name="is_menu" class="form-control" id="category_id">
                                            <option value="1" @if (old('1') == '1') selected = "selected" @endif> Yes</option>
                                            <option value="0" @if (old('0') == '0') selected = "selected" @endif > No</option>
                                        </select>

                                        @if($errors->has('tourist'))
                                            <span style="color:red;">{{$errors->first('tourist')}}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="Category" class="form-label"><span>Category Name</span>*</label>
                                        <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Category Name"
                                            class="form-control">

                                            @if($errors->has('name'))
                                                <span style="color:red;">{{$errors->first('name')}}</span>
                                            @endif
                                    </div>
                                    {{-- <div class="mb-3 form-group-translation col-md-6">
                                        <label for="Category" class="form-label"><span>श्रेणी नाम</span>*</label>
                                        <input id="nepali_name" type="text" name="nepali_name" value="{{ old('nepali_name') }}" placeholder="श्रेणी नाम"
                                            class="form-control">

                                            @if($errors->has('nepali_name'))
                                                <span style="color:red;">{{$errors->first('nepali_name')}}</span>
                                            @endif
                                    </div> --}}
                                </div>

                                <div class="row">
                                        <div class="mb-3 form-group-translation col-md-12">
                                            <label for="exampleFormControlFile1"><span>Category Image</span></label>
                                            <input type="file" class="form-control-file" id="exampleFormControlFile1" value="{{ old('category_image') }}" name="category_image">

                                            @if($errors->has('category_image'))
                                            <span style="color:red;">{{$errors->first('category_image')}}</span>
                                            @endif
                                        </div>

                                    <div class="mt-2 col-md-12 text-right">
                                        <button type="submit" class="btn btn-success save-button"
                                            value="save">{{ __('Add') }}</button>
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
        // ClassicEditor
        //     .create(document.querySelector('#editor'))
        //     .then(editor => {
        //         console.log(editor);
        //     })
        //     .catch(error => {
        //         console.error(error);
        //     });
    </script>
@endsection
