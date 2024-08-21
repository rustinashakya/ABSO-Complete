@extends('admin.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <div class="content-header px-3">
            <div class="container-fluid">
                <div class="row mb-2 mx-1">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __('Add Sector') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="mr-2">
                                <a title="Go Back" href="{{ route('admin.sectors.index') }}"
                                    class="btn btn-secondary btn-sm previous round">
                                    <i class="fas fa-arrow-left" aria-hidden="true"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.sectors.index') }}">{{ __('Sectors') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                {{ __('Add Sector') }}
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
                            <form id="myForm" method="POST" enctype="multipart/form-data"
                                action="{{ route('admin.sectors.store') }}">
                                @csrf
                                @method('post')
                                <div class="row">
                                    <input type="hidden" name="type" value="sector">
                                    <div class="mb-3 form-group-translation col-md-12">
                                        <label for="Name" class="form-label">Title <span
                                                class="text-danger">*</span></label>
                                        <input id="name" type="text" name="name" value="{{ old('name') }}"
                                            placeholder="Name"
                                            class="form-control @error('name')
                                    is-invalid
                                @enderror">
                                        @if ($errors->has('name'))
                                            <span style="color:red;">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                    {{-- <div class="mb-3 form-group-translation col-md-4">
                                        <label for="Page Slug" class="form-label">Slug <span
                                                class="text-danger">*</span></label>
                                        <input id="slug" type="text" name="slug" value="{{ old('slug') }}"
                                            placeholder="Page Slug"
                                            class="form-control @error('slug')
                                    is-invalid
                                @enderror">
                                        @if ($errors->has('slug'))
                                            <span style="color:red;">{{ $errors->first('slug') }}</span>
                                        @endif
                                    </div> --}}
                                    {{-- <div class="mb-3 form-group-translation col-md-4">
                                        <label for="parent_id" class="form-label">Parent Sector <span
                                                class="text-danger"></span></label>
                                        <select id="parent_id" name="parent_id"
                                            class="form-control @error('parent_id')
                                    is-invalid
                                @enderror">
                                            <option value="">Select Parent Sector</option>
                                            @foreach ($parentSectors as $parentSector)
                                                <option id="parent_id" data-youtube="parent_id" value="{{ $parentSector->id }}" {{ old('parent_id') == $parentSector->id ? 'selected' : '' }}>{{ $parentSector->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('parent_id'))
                                            <span style="color:red;">{{ $errors->first('parent_id') }}</span>
                                        @endif
                                    </div> --}}
                                </div>
                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-12">
                                        <label for="Description" class="form-label">Content<span class="text-danger">
                                                *</span></label>
                                        <textarea name="description" cols="8" rows="3" placeholder="Description" class="form-control ckeditor">{{ old('description') }}</textarea>
                                        @if ($errors->has('description'))
                                            <span style="color:red;">{{ $errors->first('description') }}</span>
                                        @endif
                                    </div>
                                </div>
                                {{-- <div class="row">
                                    <div class="mb-3 form-group-translation col-md-12">
                                        <label for="Page Title" class="form-label">Html Title<span class="text-danger">
                                                *</span></label>
                                        <input id="html_title" type="text" name="html_title"
                                            value="{{ old('html_title') }}" placeholder="Html Title"
                                            class="form-control @error('html_title')
                                    is-invalid
                                @enderror">
                                        @if ($errors->has('html_title'))
                                            <span style="color:red;">{{ $errors->first('html_title') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 form-group-translation col-md-12">
                                        <label for="Meta Description" class="form-label">Meta
                                            Description<span class="text-danger"> *</span></label>
                                        <textarea name="meta_description" cols="8" rows="3" placeholder="Meta Description"
                                            class="form-control @error('meta_description')
                                    is-invalid
                                @enderror">{{ old('meta_description') }}</textarea>
                                        @if ($errors->has('meta_description'))
                                            <span style="color:red;">{{ $errors->first('meta_description') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-12">
                                        <label for="Meta Keyword" class="form-label">Meta Keyword<span
                                                class="text-danger"> *</span></label>
                                        <textarea name="meta_keyword" cols="8" rows="3" placeholder="Keyword"
                                            class="form-control @error('meta_keyword')
                                    is-invalid
                                @enderror">{{ old('meta_keyword') }}</textarea>
                                        @if ($errors->has('meta_keyword'))
                                            <span style="color:red;">{{ $errors->first('meta_keyword') }}</span>
                                        @endif
                                    </div>
                                </div> --}}
                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="Type" class="form-label">Media Type <span
                                                class="text-danger">*</span></label>
                                        <select id="type_div1" name="media_type" class="form-control">
                                            <option value="image1" data-image="image"
                                                @if (old('type') == 'image1') selected @endif>Image</option>
                                            <option id="youtube1" data-youtube="youtube" value="youtube1"
                                                @if (old('type') == 'youtube1') selected @endif>Youtube</option>
                                        </select>
                                        @if ($errors->has('type'))
                                            <span style="color:red;">{{ $errors->first('type') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 form-group-translation col-md-6" id="media-input-container">
                                        <div id="showyoutube1" class="myDiv1 youtube_div1">
                                            <label for="Youtube Link" class="form-label">Youtube Link <span
                                                    class="text-danger">*</span></label>
                                            <input id="youtube_link" type="text" name="youtube_link"
                                                value="{{ old('youtube_link') }}" placeholder="Youtube Link"
                                                class="form-control @error('youtube_link')
                                    is-invalid
                                @enderror">
                                            <span id="error_youtube"></span>
                                            @if ($errors->has('youtube_link'))
                                                <span style="color:red;">{{ $errors->first('youtube_link') }}</span>
                                            @endif
                                        </div>
                                        <div class="myDiv1 image_div1" id="showimage1">
                                            <label for="exampleFormControlFile1">
                                                Main Image <span class="text-danger"> *</span>
                                            </label>
                                            <p class="text-blue">Note: Please upload image of size 700px X 700px.</p>
                                            <input type="file" class="form-control-file" id="exampleFormControlFile1"
                                                accept=".jpg, .jpeg, .png" name="main_image"
                                                value="{{ old('main_image') }}">
                                            @if ($errors->has('main_image'))
                                                <span style="color:red;">{{ $errors->first('main_image') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- <div class="mb-3 form-group-translation col-md-12 image_div1" id="showimage2">
                                        <label for="exampleFormControlFile2">
                                            Mobile Image <span class="text-danger"> *</span>
                                        </label>
                                        <p class="text-blue">Note: Please upload image of size 770px X 770px.</p>
                                        <input type="file" class="form-control-file" id="exampleFormControlFile2"
                                            accept=".jpg, .jpeg, .png" name="mobile_image"
                                            value="{{ old('mobile_image') }}">
                                        @if ($errors->has('mobile_image'))
                                            <span style="color:red;">{{ $errors->first('mobile_image') }}</span>
                                        @endif
                                    </div> --}}
                                </div>
                                <div class="row">
                                    <div class="mt-2 col-md-12 text-right">
                                        <button type="submit" class="btn btn-success save-button" value="save"
                                            onclick="disableButtonAndSubmitForm(this);">{{ __('Save') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
            </div>
        </section>
    </div>
    </section>
    </div>
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
