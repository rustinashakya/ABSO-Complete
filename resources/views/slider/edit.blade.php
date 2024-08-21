@extends('admin.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <div class="content-header px-3">
            <div class="container-fluid">
                <div class="row mb-2 mx-1">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __(' Edit Homepage Banner') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <a title="Go Back" href="{{ route('admin.slider.index') }}"
                                class="btn btn-secondary btn-sm previous round"> <i class="fas fa-arrow-left"
                                    aria-hidden="true"></i></a> &nbsp;&nbsp;
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.slider.index') }}">{{ __('Homepage Banner') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                {{ __('Edit Homepage Banner') }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->
        <section class="content gray px-3">
            <div class="container-fluid">

                <section class="content">
                    <div class="container-fluid">
                        <div class="card card-body">
                            <form method="POST" enctype="multipart/form-data"
                                action="{{ route('admin.slider.update', $slider->id) }}">
                                @csrf
                                @method('put')
                                <input type="hidden" name="slider_type" value="banner">
                                <input type="hidden" name="type"
                                    value="{{ $slider->main_image && $slider->mobile_image ? 'image1' : 'youtube1' }}">
                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-12">
                                        <label for="name" class="form-label"><span>Caption Title <span
                                                    class="text-danger">*</span></span></label>
                                        <input id="name" type="text" name="name"
                                            value="{{ old('name', $slider->name) }}" placeholder="Caption Title"
                                            class="form-control">
                                        @if ($errors->has('name'))
                                            <span style="color:red;">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>

                                    <!-- Image Link Field -->
                                    {{-- <div class="mb-3 form-group-translation col-md-6" id="showimage">
                                        <label for="url" class="form-label"><span>Url <span
                                                    class="text-danger"></span></span></label>
                                        <input id="url" type="text" name="url"
                                            value="{{ old('url', $slider->url) }}" placeholder="Url" class="form-control">
                                        @if ($errors->has('url'))
                                            <span style="color:red;">{{ $errors->first('url') }}</span>
                                        @endif
                                    </div> --}}
                                </div>

                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-12">
                                        <label for="caption_description" class="form-label"><span>Caption Description
                                                <span class="text-danger"> * </span></span></label>
                                        <textarea name="caption_description" id="caption_description" cols="8" rows="3"
                                            placeholder="Description" class="form-control ckeditor">{{ old('caption_description', $slider->caption_description) }}</textarea>
                                        @if ($errors->has('caption_description'))
                                            <span style="color:red;">{{ $errors->first('caption_description') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Image Upload Fields -->
                                {{-- <div class="row" id="imageUploadFields" style="display: none;">
                                    <div class="mb-3 mt-2 form-group-translation col-md-6">
                                        <label for="main_image">Main Image: <span class="text-danger"></span></label>
                                        <p class="text-blue">Note: Please upload image of size 1920px X 754px.</p>
                                        <input type="file" class="form-control-file" id="main_image"
                                            accept=".jpg, .jpeg, .png" name="main_image"
                                            value="{{ old('main_image', $slider->main_image) }}">
                                        @if ($errors->has('main_image'))
                                            <span style="color:red;">{{ $errors->first('main_image') }}</span>
                                        @endif
                                        @if ($slider->main_image)
                                            <div class="image-trap">
                                                <a href="{{ asset('storage/uploads/slider/main_image/' . $slider->main_image) }}"
                                                    data-toggle="lightbox" data-gallery="multiimages" data-title=""
                                                    class="img-responsive">
                                                    <picture>
                                                        <img src="{{ asset('storage/uploads/slider/main_image/thumbnail/admin_' . $slider->main_image) }}"
                                                            alt="Image">
                                                    </picture>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 mt-2 form-group-translation col-md-6">
                                        <label for="mobile_image">Mobile Image: <span class="text-danger"></span></label>
                                        <p class="text-blue">Note: Please upload image of size 767px X 767px.</p>
                                        <input type="file" class="form-control-file" id="mobile_image"
                                            accept=".jpg, .jpeg, .png" name="mobile_image"
                                            value="{{ old('mobile_image', $slider->mobile_image) }}">
                                        @if ($errors->has('mobile_image'))
                                            <span style="color:red;">{{ $errors->first('mobile_image') }}</span>
                                        @endif
                                        @if ($slider->mobile_image)
                                            <div class="image-trap">
                                                <a href="{{ asset('storage/uploads/slider/mobile_image/' . $slider->mobile_image) }}"
                                                    data-toggle="lightbox" data-gallery="multiimages" data-title=""
                                                    class="img-responsive">
                                                    <picture>
                                                        <img src="{{ asset('storage/uploads/slider/mobile_image/thumbnail/admin_' . $slider->mobile_image) }}"
                                                            alt="Image">
                                                    </picture>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="order_by">Order By <span class="text-danger"></span></label>
                                        <input type="number"
                                            class="form-control @error('order_by')
                                            is-invalid
                                        @enderror"
                                            id="order_by" name="order_by" placeholder="Order By"
                                            value="{{ old('order_by', $slider->order_by) }}">
                                        @if ($errors->has('order_by'))
                                            <span style="color:red;">{{ $errors->first('order_by') }}</span>
                                        @endif
                                    </div>
                                </div> --}}

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
        document.addEventListener('DOMContentLoaded', function() {
            const youtubeField = document.getElementById('showyoutube');
            const imageField = document.getElementById('showimage');
            const imageUploadFields = document.getElementById('imageUploadFields');

            function toggleFields() {
                // Check if YouTube URL is not null or empty
                const youtubeUrl = "{{ $slider->youtube_url }}";
                if (youtubeUrl) {
                    youtubeField.style.display = 'block';
                    imageField.style.display = 'none';
                    imageUploadFields.style.display = 'none';
                } else {
                    youtubeField.style.display = 'none';
                    imageField.style.display = 'block';
                    imageUploadFields.style.display = 'flex';
                }
            }

            toggleFields();
        });
    </script>
    <script>
        function disableButtonAndSubmitForm(button) {
            // Disable the button
            button.disabled = true;
            // Submit the form
            document.getElementById("mediaaddForm").submit();
        }
    </script>
    <script>
        // This sample still does not showcase all CKEditor 5 features (!)
        // Visit https://ckeditor.com/docs/ckeditor5/latest/features/index.html to browse all the features.
        var allEditors = document.querySelectorAll('.ckeditor');
        for (var i = 0; i < allEditors.length; ++i) {
            CKEDITOR.ClassicEditor.create(allEditors[i], {
                // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
                toolbar: {
                    items: [
                        // 'exportPDF','exportWord', '|',
                        // 'findAndReplace', 'selectAll', '|',
                        // 'subscript', 'superscript',strikethrough,'specialCharacters','horizontalLine',
                        'heading', '|',
                        'bold', 'italic', 'underline', 'code', 'removeFormat', '|',
                        'bulletedList', 'numberedList', 'todoList', '|',
                        // 'outdent', 'indent', '|',
                        'undo', 'redo',
                        '-',
                        // 'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|','mediaEmbed', 'codeBlock', 'htmlEmbed',
                        // 'alignment', '|',
                        'link', 'insertImage', 'blockQuote', 'insertTable', '|',
                        'pageBreak', '|',
                        // 'textPartLanguage', '|',
                        'sourceEditing'
                    ],
                    shouldNotGroupWhenFull: true
                },
                // // Changing the language of the interface requires loading the language file using the <script> tag.
                // // language: 'es',
                // list: {
                //     properties: {
                //         styles: true,
                //         startIndex: true,
                //         reversed: true
                //     }
                // },
                // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
                heading: {
                    options: [{
                            model: 'paragraph',
                            title: 'Paragraph',
                            class: 'ck-heading_paragraph'
                        },
                        {
                            model: 'heading1',
                            view: 'h1',
                            title: 'Heading 1',
                            class: 'ck-heading_heading1'
                        },
                        {
                            model: 'heading2',
                            view: 'h2',
                            title: 'Heading 2',
                            class: 'ck-heading_heading2'
                        },
                        {
                            model: 'heading3',
                            view: 'h3',
                            title: 'Heading 3',
                            class: 'ck-heading_heading3'
                        },
                        {
                            model: 'heading4',
                            view: 'h4',
                            title: 'Heading 4',
                            class: 'ck-heading_heading4'
                        },
                        {
                            model: 'heading5',
                            view: 'h5',
                            title: 'Heading 5',
                            class: 'ck-heading_heading5'
                        },
                        {
                            model: 'heading6',
                            view: 'h6',
                            title: 'Heading 6',
                            class: 'ck-heading_heading6'
                        }
                    ]
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
                placeholder: '',
                // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
                // fontFamily: {
                //     options: [
                //         'default',
                //         'Arial, Helvetica, sans-serif',
                //         'Courier New, Courier, monospace',
                //         'Georgia, serif',
                //         'Lucida Sans Unicode, Lucida Grande, sans-serif',
                //         'Tahoma, Geneva, sans-serif',
                //         'Times New Roman, Times, serif',
                //         'Trebuchet MS, Helvetica, sans-serif',
                //         'Verdana, Geneva, sans-serif'
                //     ],
                //     supportAllValues: true
                // },
                // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-size-feature
                fontSize: {
                    options: [10, 12, 14, 'default', 18, 20, 22],
                    supportAllValues: true
                },
                // Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
                // https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
                htmlSupport: {
                    allow: [{
                        name: /.*/,
                        attributes: true,
                        classes: true,
                        styles: true
                    }]
                },
                // Be careful with enabling previews
                // https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
                htmlEmbed: {
                    showPreviews: true
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
                // link: {
                //     decorators: {
                //         addTargetToExternalLinks: true,
                //         defaultProtocol: 'https://',
                //         toggleDownloadable: {
                //             mode: 'manual',
                //             label: 'Downloadable',
                //             attributes: {
                //                 download: 'file'
                //             }
                //         }
                //     }
                // },
                // https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
                // mention: {
                //     feeds: [
                //         {
                //             marker: '@',
                //             feed: [
                //                 '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                //                 '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                //                 '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                //                 '@sugar', '@sweet', '@topping', '@wafer'
                //             ],
                //             minimumCharacters: 1
                //         }
                //     ]
                // },
                // The "super-build" contains more premium features that require additional configuration, disable them below.
                // Do not turn them on unless you read the documentation and know how to configure them and setup the editor.
                removePlugins: [
                    // These two are commercial, but you can try them out without registering to a trial.
                    // 'ExportPdf',
                    // 'ExportWord',
                    // 'CKBox',
                    // 'CKFinder',
                    // 'EasyImage',
                    // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
                    // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
                    // Storing images as Base64 is usually a very bad idea.
                    // Replace it on production website with other solutions:
                    // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
                    // 'Base64UploadAdapter',
                    'RealTimeCollaborativeComments',
                    'RealTimeCollaborativeTrackChanges',
                    'RealTimeCollaborativeRevisionHistory',
                    'PresenceList',
                    'Comments',
                    'TrackChanges',
                    'TrackChangesData',
                    'RevisionHistory',
                    'Pagination',
                    'WProofreader',
                    // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
                    // from a local file system (file://) - load this site via HTTP server if you enable MathType
                    // 'MathType'
                ]
            });
        }
        //         ClassicEditor..create( document.querySelector( '.ckeditor' ), {
        //             plugins: [ SourceEditing, Markdown],
        //             toolbar: [ 'sourceEditing']
        //         } );
        //     }
        // CKEDITOR.ClassicEditor.create(document.getElementById("editor"),
    </script>
@endsection
