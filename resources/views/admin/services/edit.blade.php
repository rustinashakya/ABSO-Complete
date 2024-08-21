@extends('admin.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <div class="content-header px-3">
            <div class="container-fluid">
                <div class="row mb-2 mx-1">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __(' Edit Service') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="mr-2">
                                <a title="Go Back" href="{{ route('admin.services.index') }}"
                                    class="btn btn-secondary btn-sm previous round"> <i class="fas fa-arrow-left"
                                        aria-hidden="true"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.services.index') }}">{{ __('Services') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                {{ __('Edit Service') }}
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
                        <form method="POST" enctype="multipart/form-data"
                            action="{{ route('admin.services.update', $service->id) }}">
                            @csrf
                            @method('put')
                            <div class="card card-body">

                                <div class="row">
                                    <input type="hidden" name="type" value="service">
                                    <div class="mb-3 form-group-translation col-md-12">
                                        <label for="Name" class="form-label">Title <span
                                                class="text-danger">*</span></label>
                                        <input id="name" type="text" name="name"
                                            value="{{ old('name', $service->name) }}" placeholder="Name"
                                            class="form-control @error('name')
                                                is-invalid
                                            @enderror">

                                        @if ($errors->has('name'))
                                            <span style="color:red;">{{ $errors->first('name') }}</span>
                                        @endif

                                    </div>
                                    {{-- <div class="mb-3 form-group-translation col-md-4">
                                        <label for=" Slug" class="form-label">Slug <span
                                                class="text-danger">*</span></label>
                                        <input id="slug" type="text" name="slug"
                                            value="{{ old('slug', $service->slug) }}" placeholder="Slug"
                                            class="form-control @error('slug')
                                                is-invalid
                                            @enderror">

                                        @if ($errors->has('slug'))
                                            <span style="color:red;">{{ $errors->first('slug') }}</span>
                                        @endif

                                    </div>
                                    <div class="mb-3 form-group-translation col-md-4">
                                        <label for="sub_title" class="form-label">Sub-title <span
                                                class="text-danger">*</span></label>
                                        <input id="sub_title" type="text" name="sub_title"
                                            value="{{ old('sub_title', $service->sub_title) }}" placeholder="Sub-title"
                                            class="form-control @error('sub_title')
                                                is-invalid
                                            @enderror">
                                        @if ($errors->has('sub_title'))
                                            <span style="color:red;">{{ $errors->first('sub_title') }}</span>
                                        @endif
                                    </div> --}}
                                </div>

                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-12">
                                        <label for="description" class="form-label">Description <span
                                                class="text-danger"></span></label>
                                        <textarea name="description" id="editor-1" cols="20" rows="10" placeholder="Content"
                                            class="form-control ckeditor @error('description')
                                                is-invalid
                                            @enderror">{{ old('description', $service->description) }}</textarea>

                                        @if ($errors->has('description'))
                                            <span style="color:red;">{{ $errors->first('description') }}</span>
                                        @endif

                                    </div>

                                </div>

                                {{-- <div class="row">
                                    <div class="mb-3 form-group-translation col-md-12">
                                        <label for="Page Title" class="form-label">Html Title<span class="text-danger"> *</span></label>
                                        <input id="html_title" type="text" name="html_title"
                                            value="{{ old('html_title', $service->html_title) }}" placeholder="HTML Title"
                                            class="form-control @error('html_title')
                                                is-invalid
                                            @enderror">

                                        @if ($errors->has('html_title'))
                                            <span style="color:red;">{{ $errors->first('html_title') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-12">
                                        <label for="Meta Description" class="form-label">Meta
                                                Description<span class="text-danger"> *</span></label>
                                        <textarea name="meta_description" id="" cols="8" rows="3" placeholder="Meta Description"
                                            class="form-control @error('meta_description')
                                                is-invalid
                                            @enderror">{{ old('meta_description', $service->meta_description) }}</textarea>

                                        @if ($errors->has('meta_description'))
                                            <span style="color:red;">{{ $errors->first('meta_description') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-12">
                                         <label for="Meta Keyword" class="form-label">Meta Keyword <span class="text-danger"> *</span></label>
                                        <textarea name="meta_keyword" id="" cols="8" rows="3" placeholder="Meta Keyword"
                                            class="form-control @error('meta_keyword')
                                                is-invalid
                                            @enderror">{{ old('meta_keyword', $service->meta_keyword) }}</textarea>

                                        @if ($errors->has('meta_keyword'))
                                            <span style="color:red;">{{ $errors->first('meta_keyword') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="Type" class="form-label">Media Type <span
                                                class="text-danger">*</span></label>
                                        <select id="type_div1" name="media_type" class="form-control">
                                            <option id="youtube1" data-youtube="youtube" value="youtube1"
                                                @if ($service->youtube_link != null) selected @endif>Youtube</option>
                                            <option value="image1" data-image="image"
                                                @if ($service->main_image != null) selected @endif>Image</option>
                                        </select>
                                        @if ($errors->has('type'))
                                            <span style="color:red;">{{ $errors->first('type') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 form-group-translation col-md-6" id="media-input-container">
                                        <div id="showyoutube1" class="myDiv1 youtube_div1">
                                            <label for="Youtube Link" class="form-label">Youtube Link <span
                                                    class="text-danger"></span></label>
                                            <input id="youtube_link" type="text" name="youtube_link"
                                                value="{{ old('youtube_link', $service->youtube_link) }}"
                                                placeholder="Youtube Link"
                                                class="form-control @error('youtube_link')
                                                is-invalid
                                            @enderror">
                                            <span id="error_youtube"></span>
                                            @if ($errors->has('youtube_link'))
                                                <span style="color:red;">{{ $errors->first('youtube_link') }}</span>
                                            @endif
                                        </div>

                                        <div class="div myDiv1 image_div1 mb-3" id="showimage1">
                                            <label for="exampleFormControlFile1">
                                                <span>Main Image</span>:
                                            </label>
                                            <p class="text-blue">Note: Please upload image of size 1540px - 850px.</p>
                                            <input type="file" accept=".jpg, .jpeg, .png"
                                                class="form-control-file @error('main_image')
                                                is-invalid
                                            @enderror"
                                                id="exampleFormControlFile1" name="main_image"
                                                value="{{ old('main_image') }}">
                                            @if ($service->main_image)
                                                <img src="{{ asset('storage/uploads/services/main_image/thumbnail/admin_' . $service->main_image) }}"
                                                    alt="image" height="100" class="mt-2" />
                                            @endif
                                            <br>
                                            @if ($errors->has('main_image'))
                                                <span style="color:red;">{{ $errors->first('main_image') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 form-group-translation col-md-6 image_div1" id="showimage2">
                                        <label for="exampleFormControlFile2">
                                            <span>Mobile Image</span>:
                                        </label>
                                        <p class="text-blue">Note: Please upload image of size 767px X 767px.</p>
                                        <input type="file" accept=".jpg, .jpeg, .png"
                                            class="form-control-file @error('mobile_image')
                                                is-invalid
                                            @enderror"
                                            id="exampleFormControlFile2" name="mobile_image"
                                            value="{{ old('mobile_image') }}">
                                        @if ($service->mobile_image)
                                            <img src="{{ asset('storage/uploads/services/mobile_image/' . $service->mobile_image) }}"
                                                alt="image" height="100" class="mt-2" />
                                        @endif
                                        <br>
                                        @if ($errors->has('mobile_image'))
                                            <span style="color:red;">{{ $errors->first('mobile_image') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 form-group-translation col-md-6 image_div1" id="showimage2">
                                        <label for="order_by">Order By
                                            <span class="text-danger"> </span>
                                        </label>
                                        <input type="number"
                                            placeholder="Order By"
                                            class="form-control @error('order_by')
                                                is-invalid
                                            @enderror"
                                            id="order_by" name="order_by" value="{{ old('order_by', $service->order_by) }}">
                                        @if ($errors->has('order_by'))
                                            <span style="color:red;">{{ $errors->first('order_by') }}</span>
                                        @endif
                                    </div>
                                </div> --}}

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
    </div>
    </section>
@endsection

@section('scripts')
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
    <script>
        $('#type_div1').change(function() {
            var selectedOption = $(this).find(':selected').attr('data-youtube');
            if (selectedOption === 'youtube') {
                $('#showyoutube1').show();
                $('#showimage1').hide();
                $('#showimage2').hide();
            } else {
                $('#showyoutube1').hide();
                $('#showimage1').show();
                $('#showimage2').show();
            }
        }).change();

        function disableButtonAndSubmitForm(btn) {
            btn.disabled = true;
            btn.form.submit();
        }
    </script>
@endsection
