@extends('admin.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <div class="content-header px-3">
            <div class="container-fluid">
                <div class="row mb-2 mx-1">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __('Add Client') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <a title="Go Back" href="{{ route('admin.client.index') }}"
                                class="btn btn-secondary btn-sm previous round"> <i class="fas fa-arrow-left"
                                    aria-hidden="true"></i></a> &nbsp;&nbsp;
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                            <a href="{{ route('admin.designation.index') }}">{{ __('Clients') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                {{ __('Add Client') }}
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
                                action="{{ route('admin.client.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="name" class="form-label">Name <span class="text-danger">*</span> </label>
                                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') 
                                        is-invalid
                                        @enderror" placeholder="Name" />

                                        @if ($errors->has('name'))
                                            <span style="color:red;">{{ $errors->first('name') }}</span>
                                        @endif

                                    </div>
                                    {{-- <div class="mb-3 form-group-translation col-md-4">
                                        <label for="slug" class="form-label">Slug <span class="text-danger"></span> </label>
                                        <input type="text" name="slug" id="slug" value="{{ old('slug') }}" class="form-control @error('slug') 
                                        is-invalid
                                        @enderror" placeholder="Slug" />

                                        @if ($errors->has('slug'))
                                            <span style="color:red;">{{ $errors->first('slug') }}</span>
                                        @endif

                                    </div>
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="designation" class="form-label">Designation <span class="text-danger"></span> </label>
                                        <input type="text" name="designation" id="designation" value="{{ old('designation') }}" class="form-control @error('designation') 
                                        is-invalid
                                        @enderror" placeholder="Designation" />

                                        @if ($errors->has('designation'))
                                            <span style="color:red;">{{ $errors->first('designation') }}</span>
                                        @endif

                                    </div>
                                    <div class="mb-3 form-group-translation col-md-4">
                                        <label for="profile_image" class="form-label">Profile Image <span class="text-danger"></span> </label>
                                    <p class="text-blue">Note: Please upload image of size 500px X 500px.</p>
                                        <input type="file" name="profile_image" id="profile_image" accept=".jpg, .jpeg, .png" class=" @error('profile_image') 
                                        is-invalid
                                        @enderror" placeholder="profile_image" />
                                        <br>
                                        @if ($errors->has('profile_image'))
                                            <span style="color:red;">{{ $errors->first('profile_image') }}</span>
                                        @endif

                                    </div> --}}
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="organisation_logo" class="form-label">Organisation Logo <span class="text-danger">*</span> </label>
                                        <p class="text-blue">Note: Please upload image of size 150px X 150px.</p>
                                        <input type="file" name="organisation_logo" id="organisation_logo" accept=".jpg, .jpeg, .png" class=" @error('organisation_logo') 
                                        is-invalid
                                        @enderror" placeholder="Organisation Logo" />
                                        <br>
                                        @if ($errors->has('organisation_logo'))
                                            <span style="color:red;">{{ $errors->first('organisation_logo') }}</span>
                                        @endif

                                    </div>
                                    {{-- <div class="mb-3 form-group-translation col-md-6">
                                        <label for="url" class="form-label">Organisation Website <span class="text-danger"></span> </label>
                                        <input type="text" name="url" id="url" value="{{ old('url') }}" class="form-control @error('url') 
                                        is-invalid
                                        @enderror" placeholder="Organisation Website" />
                                        
                                        @if ($errors->has('url'))
                                            <span style="color:red;">{{ $errors->first('url') }}</span>
                                        @endif

                                    </div>
                                    <div class="mb-3 form-group-translation col-md-12">
                                        <label for="url" class="form-label">Description <span class="text-danger"></span> </label>
                                        <textarea name="description" cols="8" rows="3" placeholder="Description" class="form-control ckeditor">{{ old('description') }}</textarea>

                                        @if ($errors->has('url'))
                                            <span style="color:red;">{{ $errors->first('url') }}</span>
                                        @endif

                                    </div> --}}
                                    {{-- <div class="mb-3 form-group-translation col-md-12">
                                        <label for="html_title" class="form-label">Html Title <span class="text-danger"></span> </label>
                                        <textarea name="html_title" cols="8" rows="3" placeholder="Html Title" class="form-control @error('html_title') is-invalid @enderror">{{ old('html_title') }}</textarea>

                                        @if ($errors->has('html_title'))
                                            <span style="color:red;">{{ $errors->first('html_title') }}</span>
                                        @endif

                                    </div>
                                    <div class="mb-3 form-group-translation col-md-12">
                                        <label for="meta_description" class="form-label">Meta Description <span class="text-danger"></span> </label>
                                        <textarea name="meta_description" cols="8" rows="3" placeholder="Meta Description" class="form-control @error('meta_description') is-invalid @enderror">{{ old('meta_description') }}</textarea>

                                        @if ($errors->has('meta_description'))
                                            <span style="color:red;">{{ $errors->first('meta_description') }}</span>
                                        @endif

                                    </div>
                                    <div class="mb-3 form-group-translation col-md-12">
                                        <label for="meta_keyword" class="form-label">Meta Keyword <span class="text-danger"></span> </label>
                                        <textarea name="meta_keyword" cols="8" rows="3" placeholder="Meta Keyword" class="form-control @error('meta_keyword') is-invalid @enderror">{{ old('meta_keyword') }}</textarea>

                                        @if ($errors->has('meta_keyword'))
                                            <span style="color:red;">{{ $errors->first('meta_keyword') }}</span>
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
                </section>
            </div>
            <!-- /.container-fluid -->
        </section>
    </div>
@endsection

@section('scripts')
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


    ////checkboxes yes and no 
    document.getElementById('statusYes').addEventListener('change', function() {
        if (this.checked) {
            document.getElementById('statusNo').checked = false;
        }
    });

    document.getElementById('statusNo').addEventListener('change', function() {
        if (this.checked) {
            document.getElementById('statusYes').checked = false;
        }
    });
</script>
@endsection
