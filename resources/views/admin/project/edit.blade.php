@extends('admin.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <div class="content-header px-3">
            <div class="container-fluid">
                <div class="row mb-2 mx-1">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __('Edit Project') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="mr-2">
                                <a title="Go Back" href="{{ route('admin.project.index') }}"
                                    class="btn btn-secondary btn-sm previous round"> <i class="fas fa-arrow-left"
                                        aria-hidden="true"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.project.index') }}">{{ __('Projects') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                {{ __('Edit Project') }}
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
                            <form id="faqaddForm" method="POST" enctype="multipart/form-data"
                                action="{{ route('admin.project.update', $project->id) }}">
                                @csrf
                                @method('put')

                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="title" class="form-label"><span id="titleLabel">Title</span> <span
                                                class="text-danger">*</span> </label>
                                        <input id="title" type="text" name="title" value="{{ old('title', $project->title) }}"
                                            placeholder="Title"
                                            class="form-control @error('title')
                                        is-invalid
                                    @enderror">
                                        @if ($errors->has('title'))
                                            <span style="color:red;">{{ $errors->first('title') }}</span>
                                        @endif
                                    </div>

                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="Slug" class="form-label"><span id="slugLabel">Slug</span> <span
                                                class="text-danger">*</span> </label>
                                        <input id="slug" type="text" name="slug" value="{{ old('slug', $project->slug) }}"
                                            placeholder="Slug"
                                            class="form-control @error('slug')
                                        is-invalid
                                    @enderror">
                                        @if ($errors->has('slug'))
                                            <span style="color:red;">{{ $errors->first('slug') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-12">
                                        <label for="short_description" class="form-label"><span id="shortDescLabel">Short
                                                Description</span> <span class="text-danger">*</span> </label>
                                        <textarea cols="8" rows="2" id="short_description" name="short_description" placeholder="Short Description"
                                            class="form-control @error('slug')
                                        is-invalid
                                    @enderror">{{ old('short_description', $project->short_description) }}</textarea>
                                        @if ($errors->has('short_description'))
                                            <span style="color:red;">{{ $errors->first('short_description') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-12">
                                        <label for="desc" class="form-label">
                                            <span id="descLabel">Description </span>
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea name="description" id="description" cols="8" rows="3" placeholder="Description"
                                            class="form-control ckeditor @error('description')
                                        
                                    @enderror">{{ old('description', $project->description) }}</textarea>

                                        @if ($errors->has('description'))
                                            <span style="color:red;">{{ $errors->first('description') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="exampleFormControlFile1">
                                            <span>Main Image: <span class="text-danger" style="font-size: 12px;">
                                                    (multiple)</span></span>
                                        </label>
                                        <p class="text-blue">Note: Please upload image of width 1340px X 960px..</p>
                                        <input type="file"
                                            class="form-control-file @error('main_image.*')
                                        is-invalid
                                    @enderror"
                                            id="exampleFormControlFile1" accept=".jpg, .jpeg, .png" name="main_image[]" multiple>
                                        @error('main_image')
                                            <span style="color:red;">{{ $message }}</span>
                                        @enderror
                                        @foreach ($errors->get('main_image.*') as $key => $error)
                                            <span style="color:red;">{{ $error[0] }}</span>
                                        @endforeach
                                    </div>

                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="exampleFormControlFile2">
                                            <span>Mobile Image: <span class="text-danger" style="font-size: 12px;">
                                                    (multiple)</span></span>
                                        </label>
                                        <p class="text-blue">Note: Please upload image of size 767px X 767px.</p>
                                        <input type="file" acce
                                            class="form-control-file @error('mobile_image.*')
                                        is-invalid
                                    @enderror"
                                            id="exampleFormControlFile2" accept=".jpg, .jpeg, .png" name="mobile_image[]" multiple>
                                        @error('mobile_image')
                                            <span style="color:red;">{{ $message }}</span>
                                        @enderror
                                        @foreach ($errors->get('mobile_image.*') as $key => $error)
                                            <span style="color:red;">{{ $error[0] }}</span>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="project_type_id" class="form-label">Project Type <span
                                                class="text-danger">*</span> </label>
                                        <select id="project_type_id" name="project_type_id"
                                            class="form-control @error('project_type_id')
                                            is-invalid
                                        @enderror">
                                            <option value="">Select Project Type</option>
                                            @foreach ($projectTypes as $projectType)
                                                <option value="{{ $projectType->id }}"
                                                    {{ old('project_type_id', $project->project_type_id) == $projectType->id ? 'selected' : '' }}>
                                                    {{ $projectType->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('project_type_id'))
                                            <span style="color:red;">{{ $errors->first('project_type_id') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="page_id" class="form-label">Sector <span
                                                class="text-danger">*</span> </label>
                                        <select id="page_id" name="page_id"
                                            class="form-control @error('page_id')
                                            is-invalid
                                        @enderror">
                                            <option value="">Select Project Type</option>
                                            @foreach ($pages as $page)
                                                <option value="{{ $page->id }}"
                                                    {{ old('page_id', $project->page_id) == $page->id ? 'selected' : '' }}>
                                                    {{ $page->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('page_id'))
                                            <span style="color:red;">{{ $errors->first('page_id') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="service_id" class="form-label">Type of Service <span
                                                class="text-danger"> </span> </label>
                                        <select id="service_id" name="service_id"
                                            class="form-control @error('service_id')
                                            is-invalid
                                        @enderror">
                                            <option value="">Select Service</option>
                                            @foreach ($services as $service)
                                                <option value="{{ $service->id }}"
                                                    {{ old('service_id', $project->service_id) == $service->id ? 'selected' : '' }}>
                                                    {{ $service->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('service_id'))
                                            <span style="color:red;">{{ $errors->first('service_id') }}</span>
                                        @endif
                                    </div>
                                    {{-- <div class="mb-3 form-group-translation col-md-6">
                                        <label class="form-check-label mb-3">
                                            {{ __('Do you want to show the project on menu? ') }} <span
                                                class="text-danger"></span>
                                        </label>

                                        <div class="d-flex">
                                            <div class="form-check form-check-inline" style="margin-right: 10px;">
                                                <input class="form-check-input @error('show_on_menu') is-invalid @enderror"
                                                    type="checkbox" value="1" name="show_on_menu" id="statusYes"
                                                    {{ old('show_on_menu', $project->show_on_menu) == '1' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="statusYes">Yes</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input @error('show_on_menu') is-invalid @enderror"
                                                    type="checkbox" value="1" name="show_on_menu" id="statusNo"
                                                    {{ old('show_on_menu', $project->show_on_menu) == '0' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="statusNo">No</label>
                                            </div>
                                        </div>

                                        @if ($errors->has('show_on_menu'))
                                            <span style="color:red;">{{ $errors->first('show_on_menu') }}</span>
                                        @endif
                                    </div> --}}
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="Status" class="form-label">Stage: <span
                                                class="text-danger">*</span> </label>
                                        <select id="stage" name="stage"
                                            class="form-control @error('stage')
                                        is-invalid
                                        @enderror">
                                            <option value="completed" {{ old('stage', $project->stage) == 'completed' ? 'selected' : '' }}>Complete</option>
                                            <option value="ongoing" {{ old('stage', $project->stage) == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label class="form-check-label mb-3">
                                            {{ __('Do you want to show the project? ') }} <span
                                                class="text-danger"></span>
                                        </label>

                                        <div class="d-flex">
                                            <div class="form-check form-check-inline" style="margin-right: 10px;">
                                                <input class="form-check-input @error('show') is-invalid @enderror"
                                                    type="checkbox" value="1" name="show" id="show"
                                                    {{ old('show', $project->show) == '1' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="show">Yes</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input @error('show') is-invalid @enderror"
                                                    type="checkbox" value="0" name="show" id="hide"
                                                    {{ old('show', $project->show) == '0' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="hide">No</label>
                                            </div>
                                        </div>

                                        @if ($errors->has('show'))
                                            <span style="color:red;">{{ $errors->first('show') }}</span>
                                        @endif
                                    </div>
                                </div>



                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-12">
                                        <label for="Page Title" class="form-label">Html Title<span class="text-danger"> *</span></label>
                                        <input id="html_title" type="text" name="html_title"
                                            value="{{ old('html_title', $project->html_title) }}" placeholder="Html Title"
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
                                        <textarea name="meta_description" cols="8" rows="3" placeholder="Meta Description"
                                            class="form-control @error('meta_description')
                                                is-invalid
                                            @enderror">{{ old('meta_description', $project->meta_description) }}</textarea>
                                        @if ($errors->has('meta_description'))
                                            <span style="color:red;">{{ $errors->first('meta_description') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-12">
                                        <label for="Meta Keyword" class="form-label">Meta Keyword<span class="text-danger"> *</span></label>
                                        <textarea name="meta_keyword" cols="8" rows="3" placeholder="Keyword" class="form-control @error('meta_keyword')
                                            is-invalid
                                        @enderror">{{ old('meta_keyword', $project->meta_keyword) }}</textarea>
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
                                <!-- </div> -->
                            </form>
                        </div>
                    </div>
                </section>
            </div>

    </div>
    <!-- /.container-fluid -->
    </section>
    <script>
        // JavaScript to update form labels based on selected language
        document.getElementById('language').addEventListener('change', function() {
            var selectedLanguage = this.value;
            document.getElementById('questionLabel').innerText = 'Question (In ' + selectedLanguage.charAt(0)
                .toUpperCase() + selectedLanguage.slice(1) + ')';
            document.getElementById('answerLabel').innerText = 'Answer (In ' + selectedLanguage.charAt(0)
                .toUpperCase() + selectedLanguage.slice(1) + ')';
        });
    </script>
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
            document.getElementById("faqaddForm").submit();
        }
    </script>
@endsection
