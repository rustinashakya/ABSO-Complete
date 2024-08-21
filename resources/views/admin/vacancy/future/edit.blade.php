@extends('admin.layout')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-wrapper">
    <div class="content-header px-3">
        <div class="container-fluid">
            <div class="row mb-2 mx-1">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Edit Future Position') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <a title="Go Back" href="{{ route('admin.vacancy.future.index') }}" class="btn btn-secondary btn-sm previous round"> <i class="fas fa-arrow-left" aria-hidden="true"></i></a> &nbsp;&nbsp;
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.vacancy.future.index') }}">{{ __('Future Vacancies') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            {{ __('Edits Future Position') }}
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
                        <form id="mediaaddForm" method="POST" enctype="multipart/form-data" action="{{ route('admin.vacancy.future.update', $vacancy->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="mb-3 form-group-translation col-md-6">
                                    <label for="Title" class="form-label">Job Title <span class="text-danger">*</span> </label>
                                    <input id="title" type="text" name="title" value="{{ old('title', $vacancy->title) }}" placeholder="Job Title" class="form-control @error('title')
                                                is-invalid
                                            @enderror">

                                    @if ($errors->has('title'))
                                    <span style="color:red;">{{ $errors->first('title') }}</span>
                                    @endif

                                </div>


                                <div class="mb-3 form-group-translation col-md-6">
                                    <label for="slug" class="form-label">Slug <span class="text-danger">*</span> </label>
                                    <input id="slug" type="text" name="slug" value="{{ old('slug', $vacancy->slug) }}" placeholder="Slug" class="form-control @error('slug')
                                                is-invalid
                                            @enderror">

                                    @if ($errors->has('slug'))
                                    <span style="color:red;">{{ $errors->first('slug') }}</span>
                                    @endif

                                </div>

                                <div class="mb-3 form-group-translation col-md-12">
                                    <label for="short_description" class="form-label">Short Description <span class="text-danger">*</span> </label>
                                    <textarea name="short_description" id="short_description" cols="8" rows="3" placeholder="Short Description" class="form-control @error('short_description')
                                                is-invalid
                                            @enderror">{{ old('short_description', $vacancy->short_description) }}</textarea>
                                    @if ($errors->has('short_description'))
                                    <span style="color:red;">{{ $errors->first('short_description') }}</span>
                                    @endif

                                </div>

                                


                                <div class="mb-3 form-group-translation col-md-6">
                                    <label for="image" class="form-label">Image <span class="text-danger"></span></label>
                                    <div class="form-group-translation" style="overflow: hidden;">
                                        <input id="image" type="file" name="image" accept=".jpg, .jpeg, .png" class="form-control-file @error('image') is-invalid @enderror">

                                        @if ($errors->has('image'))
                                        <span style="color:red;">{{ $errors->first('image') }}</span>
                                        @endif
                                        <br>
                                        @if($vacancy->image)
                                            <img src="{{ asset('/storage/uploads/vacancy/image/'.$vacancy->image) }}" width="100px" height="100px" alt="image" >
                                        @endif
                                    </div>
                                </div>

                                {{-- <div class="mb-3 form-group-translation col-md-6">
                                    <label class="form-check-label mb-3">
                                        {{ __('Is Vacant? ') }} <span class="text-danger">*</span>
                                    </label>

                                    <div class="d-flex">
                                        <div class="form-check form-check-inline" style="margin-right: 10px;">
                                            <input class="form-check-input @error('status') is-invalid @enderror" type="checkbox" value="active" name="status" id="statusYes" {{ old('status') == 'active' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="statusYes">Yes</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('status') is-invalid @enderror" type="checkbox" value="inactive" name="status" id="statusNo" {{ old('status') == 'inactive' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="statusNo">No</label>
                                        </div>
                                    </div>

                                    @if ($errors->has('status'))
                                    <span style="color:red;">{{ $errors->first('status') }}</span>
                                    @endif
                                </div> --}}

                                

                                <div class="mb-3 form-group-translation col-md-6">
                                    <label for="reports_to" class="form-label"><span>{{ __('Reports To') }} <span class="text-danger"></span></span></label>
                                    <input id="reports_to" type="text" name="reports_to" value="{{ old('reports_to', $vacancy->reports_to) }}" placeholder="Reports To" class="form-control @error('reports_to') is-invalid @enderror">

                                    @if ($errors->has('reports_to'))
                                    <span style="color:red;">{{ $errors->first('reports_to') }}</span>
                                    @endif
                                </div>

                                <div class="mb-3 form-group-translation col-md-12">
                                    <label for="Description" class="form-label">Description <span class="text-danger">*</span> </label>
                                    <textarea name="description" id="editor" cols="20" rows="20" placeholder="Description" class="form-control ckeditor @error('description')
                                                is-invalid
                                            @enderror">
                                    {{ old('description', $vacancy->description) }}
                                    </textarea>

                                    @if ($errors->has('description'))
                                    <span style="color:red;">{{ $errors->first('description') }}</span>
                                    @endif

                                </div>
                                <div class="mb-3 form-group-translation col-md-12">
                                    <label for="HTML title" class="form-label">{{ __('HTML Title') }}<span class="text-danger"> *</span></label>
                                    <input name="html_title" type="text" placeholder="HTML Title" id="ckeditor_2" value="{{ old('html_title', $vacancy->html_title) }}" class="form-control @error('html_title')
                                            is-invalid
                                        @enderror">

                                    @if ($errors->has('html_title'))
                                    <span style="color:red;">{{ $errors->first('html_title') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3 form-group-translation col-md-12">
                                    <label for="Meta Description" class="form-label">{{ __('Meta Description') }}<span class="text-danger"> *</span></label>
                                    <textarea name="meta_description" placeholder="Meta Description" id="ckeditor_2" cols="8" rows="3" class="form-control @error('meta_description')
                                            is-invalid
                                        @enderror">{{ old('meta_description', $vacancy->meta_description) }}</textarea>

                                    @if ($errors->has('meta_description'))
                                    <span style="color:red;">{{ $errors->first('meta_description') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3 form-group-translation col-md-12">
                                    <label for="Meta Keyword" class="form-label">{{ __('Meta Keyword') }}<span class="text-danger"> *</span></label>
                                    <textarea cols="8" rows="3" name="meta_keyword" id="ckeditor_3" placeholder="Meta Keyword" class="form-control @error('meta_keyword')
                                                is-invalid
                                            @enderror">{{ old('meta_keyword', $vacancy->meta_keyword) }}</textarea>

                                    @if ($errors->has('meta_keyword'))
                                    <span style="color:red;">{{ $errors->first('meta_keyword') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="mt-2 col-md-12 text-right">
                                    <button type="submit" class="btn btn-success save-button" value="save" onclick="disableButtonAndSubmitForm(this);">{{ __('Save') }}</button>
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
{{-- <script>
        var allEditors = document.querySelectorAll('.ckeditor');
        for (var i = 0; i < allEditors.length; ++i) {
            ClassicEditor.create(allEditors[i]);
        }
    </script> --}}

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
<script>
    function disableButtonAndSubmitForm(button) {
        // Disable the button
        button.disabled = true;
        // Submit the form
        document.getElementById("mediaaddForm").submit();
    }
</script>
@endsection