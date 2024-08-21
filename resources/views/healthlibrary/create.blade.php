@extends('admin.layout')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-wrapper">
    <div class="content-header px-3">
        <div class="container-fluid">
            <div class="row mb-2 mx-1">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Add Health Library') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <a title="Go Back" href="{{ route('healthlibrary.index') }}"
                                class="btn btn-secondary btn-sm previous round" style=""> <i class="fas fa-arrow-left"
                                    aria-hidden="true"></i></a> &nbsp;&nbsp;
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            {{ __('Health Library') }}
                        </li>
                        <li class="breadcrumb-item">
                            {{ __('Add Health Library') }}
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
                        <form id="testimonialaddForm" method="POST" enctype="multipart/form-data" action="{{ route('healthlibrary.store') }}">
                            @csrf
                            @method('post')

                            <div class="container-fluid">

                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-6">
                                                <label for="Title" class="form-label">Title <span class="text-danger">*</span></label>
                                                <input id="title" type="text" name="title" value="{{ old('title') }}"
                                                    placeholder="Title" class="form-control">

                                                @if ($errors->has('title'))
                                                    <span style="color:red;">{{ $errors->first('title') }}</span>
                                                @endif

                                            </div>

                                        <div class="mb-3 form-group-translation col-md-6">
                                                <label for="published date" class="form-label">Published date <span class="text-danger">*</span> </label>
                                                <input type="date" name="published_date" value="{{ old('published_date') }}"
                                                    class="form-control">

                                                @if ($errors->has('published_date'))
                                                    <span style="color:red;">{{ $errors->first('published_date') }}</span>
                                                @endif

                                            </div>
                                            

                                            <div class="mb-3 form-group-translation col-md-6">

                                                <label for="Youtube Link" class="form-label">Testimonial Link <span class="text-danger">*</span> </label>
                                                <input id="link" type="text" name="link"
                                                    value="{{ old('link') }}" placeholder="Youtube Link"
                                                    class="form-control" accept=".doc,.docx,.pdf">
                                                <span id="error_youtube"></span>
                                                @if ($errors->has('link'))
                                                    <span style="color:red;">{{ $errors->first('link') }}</span>
                                                @endif
                                            </div>

                                        </div>
                                    <div class="mb-3 form-group-translation col-md-12">
                                        <label for="Name of office" class="form-label">Testimonial Image <span class="text-danger">*</span> </label>
                                
                                        <div class="mb-3 mt-2 form-group-translation">
                                            <label for="exampleFormControlFile1"><span>Add Thumbnail</span>:</label>
                                            <!-- <p class="text-blue">Note: Please upload image of size 230px X 230px. </p> -->
                                
                                            <input type="file" class="form-control-file" id="exampleFormControlFile1" name="thumbnail"
                                                value="{{ old('thumbnail') }}"  accept="image/png, image/jpeg, image/jpg">
                                
                                            @if ($errors->has('thumbnail'))
                                            <span style="color:red;">{{ $errors->first('thumbnail') }}</span>
                                            @endif
                                        </div>
                                
                                    </div>
                                </div>

                                    </div>

                                    <div class="row">
                                        <div class="mt-2 col-md-12 text-right">
                                            <button type="submit" class="btn btn-success save-button" value="save" onclick="disableButtonAndSubmitForm(this);">{{
                                                __('Save')
                                                }}</button>
                                        </div>
                                    </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
        
</div>
<!-- /.container-fluid -->
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
            document.getElementById("testimonialaddForm").submit();
        }
</script>
@endsection