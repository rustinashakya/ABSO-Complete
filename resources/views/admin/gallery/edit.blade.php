 @extends('admin.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <div class="content-header px-3">
            <div class="container-fluid">
                <div class="row mb-2 mx-1">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __(' Edit Gallery') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="mr-2">
                                <a title="Go Back" href="{{ route('admin.gallery.index') }}"
                                    class="btn btn-secondary btn-sm previous round"> <i class="fas fa-arrow-left"
                                        aria-hidden="true"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.gallery.index') }}">{{ __('Galleries') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                {{ __('Edit Gallery') }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->
        <section class="content px-3">
            <div class="container-fluid">
                <section class="content">
                    <div class="container-fluid">
                        <div class="card card-body">
                            <form method="POST" enctype="multipart/form-data" action="{{ route('admin.gallery.update', $gallery->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="Type" class="form-label"><span>Type </span><span
                                                class="text-danger">*</span></label>
                                        <select name="type" class="form-control js-type @error('type')
                                            is-invalid
                                        @enderror">
                                            <option value="document"
                                                @if (old('type', $gallery->type) == 'document') {{ 'selected' }} @endif>Document
                                            </option>
                                            <option value="youtube_link"
                                                @if (old('type', $gallery->type) == 'youtube_link') {{ 'selected' }} @endif>Youtube
                                            </option>
                                            <option value="image"
                                                @if (old('type', $gallery->type) == 'image') {{ 'selected' }} @endif>Image</option>
                                        </select>
                                        @if ($errors->has('type'))
                                            <span id="required_type" style="color:red;">{{ $errors->first('type') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 form-group-translation col-md-6 js-document-block">
                                        <label for="document" class="form-label"><span>Document </span><span
                                                class="text-danger">*</span></label>
                                        <input id="document" type="file" name="document" accept=".doc, .docx, .pdf, .xls, .xlsx"
                                            value="{{ old('document', $gallery->document) }}" placeholder="Document"
                                            class="form-control document @error('document')
                                                is-invalid
                                            @enderror">
                                            @if($gallery->document)
                                                <a href="{{ asset('storage/uploads/gallery/document/'.$gallery->document) }}" target="_blank">{{ $gallery->document }}" </a>
                                            @endif 
                                            <br>
                                        @if ($errors->has('document'))
                                            <span style="color:red;">{{ $errors->first('document') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 form-group-translation col-md-6 js-youtube-block">
                                        <label for="Slug" class="form-label"><span>Youtube Url </span><span
                                                class="text-danger">*</span></label>
                                        <input id="youtube_link" type="text" name="youtube_link"
                                            value="{{ old('youtube_link', $gallery->youtube_link) }}" placeholder="Youtube Url"
                                            class="form-control youtube_link @error('youtube_link')
                                                is-invalid
                                            @enderror">
                                        @if ($errors->has('youtube_link'))
                                            <span style="color:red;">{{ $errors->first('youtube_link') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 form-group-translation col-md-6 js-image-large-block"
                                        style="display: none;">
                                        <label for="File" class="form-label"><span>Main Photo </span><span
                                                class="text-danger"></span></label>
                                        <p class="text-blue">Note: Please upload image of size 1116 X 1552</p>
                                        <input type="file" class="form-control-file main_image @error('main_image')
                                            is-invalid
                                        @enderror" name="main_image" accept=".jpg, .jpeg, .png">
                                        @if($gallery->main_image)
                                            <img src="{{ asset('storage/uploads/gallery/main_image/thumbnail/admin_'.$gallery->main_image) }}" alt="Mobile Image">
                                        @endif
                                        <br>
                                        @if ($errors->has('main_image'))
                                            <span style="color:red;">{{ $errors->first('main_image') }}</span>
                                        @endif
                                    </div>
                                </div>

                                {{-- <div class="row js-image-small-block" style="display: none;">
                                    <div class="mb-3 form-group-translation col-md-12">
                                        <label for="File" class="form-label"><span>Mobile Photo </span><span
                                                class="text-danger"></span></label>
                                        <p class="text-blue">Note: Please upload image of size 767 X 767</p>
                                        <input type="file" class="form-control-file mobile_image @error('mobile_image')
                                            is-invalid
                                        @enderror" name="mobile_image" accept=".jpg, .jpeg, .png">
                                        @if($gallery->mobile_image)
                                            <img src="{{ asset('storage/uploads/gallery/mobile_image/thumbnail/admin_'.$gallery->mobile_image) }}" alt="Mobile Image">
                                        @endif
                                        <br>
                                        @if ($errors->has('mobile_image'))
                                            <span style="color:red;">{{ $errors->first('mobile_image') }}</span>
                                        @endif
                                    </div>
                                </div> --}}

                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-12">
                                        <label for="caption" class="form-label"><span>Caption </span><span
                                                class="text-danger"></span></label>
                                        <input id="caption" type="text" name="caption" value="{{ old('caption', $gallery->caption) }}"
                                            placeholder="Caption" class="form-control caption @error('caption')
                                                is-invalid
                                            @enderror">
                                        @if ($errors->has('caption'))
                                            <span style="color:red;">{{ $errors->first('caption') }}</span>
                                        @endif
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
        $(document).ready(function() {
            $('.js-type').trigger('change'); // Trigger the change event on page load
        });

        $('.js-type').on('change', function() {
            var value = $(this).val();
            if (value === 'image') {
                $('.js-image-large-block').show();
                $('.js-image-small-block').show();
                $('.js-youtube-block').hide();
                $('.js-document-block').hide();
            } else if (value === 'youtube_link') {
                $('.js-image-large-block').hide();
                $('.js-image-small-block').hide();
                $('.js-document-block').hide();
                $('.js-youtube-block').show();
            } else if (value === 'document') {
                $('.js-image-large-block').hide();
                $('.js-image-small-block').hide();
                $('.js-youtube-block').hide();
                $('.js-document-block').show();
            } else {
                $('.js-image-large-block').hide();
                $('.js-image-small-block').hide();
                $('.js-youtube-block').hide();
                $('.js-document-block').hide();
            }
        });
    </script>
@endsection


