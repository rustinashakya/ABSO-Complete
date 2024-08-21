@extends('admin.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <div class="content-header px-3">
            <div class="container-fluid">
                <div class="row mb-2 mx-1">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __(' Add News') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <a title="Go Back" href="{{ route('admin.news.index') }}"
                                class="btn btn-secondary btn-sm previous round"> <i class="fas fa-arrow-left"
                                    aria-hidden="true"></i></a> &nbsp;&nbsp;
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.news.index') }}">{{ __('News') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                {{ __('Add News') }}
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
                            <form id="mediaaddForm" method="POST" enctype="multipart/form-data"
                                action="{{ route('admin.news.store') }}">
                                @csrf
                                @method('post')
                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-4">
                                        <label for="TItle" class="form-label">Title <span class="text-danger">*</span>
                                        </label>
                                        <input id="title" type="text" name="title" value="{{ old('title') }}"
                                            placeholder="Title"
                                            class="form-control @error('title')
                                            is-invalid
                                        @enderror">

                                        @if ($errors->has('title'))
                                            <span style="color:red;">{{ $errors->first('title') }}</span>
                                        @endif

                                    </div>

                                    <div class="mb-3 form-group-translation col-md-4">
                                        <label for="Slug" class="form-label">Slug <span class="text-danger">*</span>
                                        </label>
                                        <input id="slug" type="text" name="slug" value="{{ old('slug') }}"
                                            placeholder="Slug"
                                            class="form-control @error('slug')
                                            is-invalid
                                        @enderror">

                                        @if ($errors->has('slug'))
                                            <span style="color:red;">{{ $errors->first('slug') }}</span>
                                        @endif

                                    </div>
                                    <div class="mb-3 form-group-translation col-md-4">
                                        <label for="published date" class="form-label"> Published date <span
                                                class="text-danger">*</span> </label>
                                        <input type="date" name="published_date" value="{{ old('published_date') }}"
                                            class="form-control @error('published_date')
                                            is-invalid
                                        @enderror">

                                        @if ($errors->has('published_date'))
                                            <span style="color:red;">{{ $errors->first('published_date') }}</span>
                                        @endif

                                    </div>

                                </div>


                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-4">
                                        <label for="author" class="form-label"> Author <span
                                                class="text-danger">*</span> </label>
                                        <input type="text" name="author" value="{{ old('author') }}"
                                            placeholder= "Author"
                                            class="form-control @error('author')
                                            is-invalid
                                        @enderror">

                                        @if ($errors->has('author'))
                                            <span style="color:red;">{{ $errors->first('author') }}</span>
                                        @endif

                                    </div>
                                    <div class="mb-3 form-group-translation col-md-4">
                                        <label for="Type" class="form-label">Type <span class="text-danger">*</span>
                                        </label>
                                        <select id="type_div" name="type" class="form-control">
                                            <option id="youtube" data-youtube="youtube" value="youtube"
                                                {{ old('type') == 'youtube' ? 'selected' : '' }}>Youtube
                                            </option>
                                            <option value="image" data-image="image"
                                                {{ old('type') == 'image' ? 'selected' : '' }}>Image</option>
                                        </select>

                                        @if ($errors->has('type'))
                                            <span style="color:red;">{{ $errors->first('type') }}</span>
                                        @endif

                                    </div>
                                    <div class="mb-3 form-group-translation col-md-4">

                                        <div id="showyoutube" class="myDiv youtube_div">

                                            {{-- <label for="Name of office" class="form-label">File <span class="text-danger">*</span> </label> --}}
                                            <label for="Youtube Link" class="form-label">Youtube Link <span
                                                    class="text-danger">*</span></label>
                                            <input id="youtube_link" type="text" name="youtube_link"
                                                value="{{ old('youtube_link') }}" placeholder="Youtube Link"
                                                class="form-control @error('youtube_link')
                                            is-invalid
                                        @enderror"
                                                accept=".doc,.docx,.pdf">
                                            <span id="error_youtube"></span>
                                            @if ($errors->has('youtube_link'))
                                                <span style="color:red;">{{ $errors->first('youtube_link') }}</span>
                                            @endif
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-9">
                                        <div id="showimage" class="row myDiv image_div">

                                            <label for="Name of office" class="form-label ml-2">Image <span
                                                    class="text-danger">*</span></label>


                                            <input type="file"
                                                class="form-control-file main_image ml-2 @error('main_image')
                                            is-invalid
                                        @enderror"
                                                id="exampleFormControlFile1" name="main_image"
                                                value="{{ old('main_image') }}" accept=".jpg, .jpeg, .png">
                                            <span id="main_image_error" style="color:red;"></span>
                                            <input type="hidden" name="main_image" id="error_main_image_value">

                                            @if ($errors->has('main_image'))
                                                <span id="required_main_image"
                                                    style="color:red;">{{ $errors->first('main_image') }}</span>
                                            @endif
                                            <br><span class="text-blue col-md-12">Note: Please upload image of size 1540px X 810px. </span>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-12">
                                        <label for="Description" class="form-label">Description <span
                                                class="text-danger">*</span></label>
                                        <textarea name="description" id="editor" cols="20" rows="20" placeholder="Description"
                                            class="form-control ckeditor @error('description')
                                            is-invalid
                                        @enderror">
                                    {{ old('description') }}
                                    </textarea>

                                        @if ($errors->has('description'))
                                            <span style="color:red;">{{ $errors->first('description') }}</span>
                                        @endif

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-12">
                                        <label for="html_title" class="form-label">Html title <span class="text-danger">
                                                *</span></label>
                                        <textarea cols="8" rows="3" name="html_title" id="html_title" placeholder="Html title"
                                            class="form-control @error('html_title')
                                            is-invalid
                                        @enderror">{{ old('html_title') }}</textarea>

                                        @if ($errors->has('html_title'))
                                            <span style="color:red;">{{ $errors->first('html_title') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-12">
                                        <label for="meta_description" class="form-label">Meta
                                            Description <span class="text-danger"> *</span>
                                        </label>
                                        <textarea name="meta_description" id="meta_description" placeholder="Meta Description" cols="8"
                                            rows="3"
                                            class="form-control @error('meta_description')
                                            is-invalid
                                        @enderror">{{ old('meta_description') ? old('meta_description') : '' }}</textarea>

                                        @if ($errors->has('meta_description'))
                                            <span style="color:red;">{{ $errors->first('meta_description') }}</span>
                                        @endif
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-12">
                                        <label for="Meta Keyword" class="form-label">Meta Keyword <span
                                                class="text-danger"> *</span></label>
                                        <textarea cols="8" rows="3" name="meta_keyword" id="ckeditor_3" placeholder="Keyword"
                                            class="form-control @error('meta_keyword')
                                            is-invalid
                                        @enderror">{{ old('meta_keyword') }}</textarea>

                                        @if ($errors->has('meta_keyword'))
                                            <span style="color:red;">{{ $errors->first('meta_keyword') }}</span>
                                        @endif
                                    </div>
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
                </section>
            </div>
            <!-- /.container-fluid -->
        </section>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Function to toggle the divs based on the selected option
            function toggleDivs() {
                var selectedType = $('#type_div').val();
                if (selectedType === 'youtube') {
                    $('#showyoutube').show();
                    $('#showimage').hide();
                } else if (selectedType === 'image') {
                    $('#showimage').show();
                    $('#showyoutube').hide();
                } else {
                    $('#showyoutube').hide();
                    $('#showimage').hide();
                }
            }

            // Initial call to set the correct visibility on page load
            toggleDivs();

            // Event listener for change event on the select element
            $('#type_div').change(function() {
                toggleDivs();
            });
        });
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
                        'heading', '|',
                        'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript',
                        'removeFormat', '|',
                        'bulletedList', 'numberedList', 'todoList', '|',
                        // 'outdent', 'indent', '|',
                        'undo', 'redo',
                        '-',
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                        'alignment', '|',
                        'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock',
                        'htmlEmbed', '|',
                        'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                        'textPartLanguage', '|',
                        'sourceEditing'
                    ],
                    shouldNotGroupWhenFull: true
                },
                // Changing the language of the interface requires loading the language file using the <script> tag.
                // language: 'es',
                list: {
                    properties: {
                        styles: true,
                        startIndex: true,
                        reversed: true
                    }
                },
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
                fontFamily: {
                    options: [
                        'default',
                        'Arial, Helvetica, sans-serif',
                        'Courier New, Courier, monospace',
                        'Georgia, serif',
                        'Lucida Sans Unicode, Lucida Grande, sans-serif',
                        'Tahoma, Geneva, sans-serif',
                        'Times New Roman, Times, serif',
                        'Trebuchet MS, Helvetica, sans-serif',
                        'Verdana, Geneva, sans-serif'
                    ],
                    supportAllValues: true
                },
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
        function disableButtonAndSubmitForm(button) {
            // Disable the button
            button.disabled = true;
            // Submit the form
            document.getElementById("mediaaddForm").submit();
        }
    </script>
@endsection
