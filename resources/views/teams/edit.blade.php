@extends('admin.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <div class="content-header px-3">
            <div class="container-fluid">
                <div class="row mb-2 mx-1">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __('Edit Team Member') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="mr-2">
                                <a title="Go Back" href="{{ route('admin.teams.index') }}"
                                    class="btn btn-secondary btn-sm previous round">
                                    <i class="fas fa-arrow-left" aria-hidden="true"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.teams.index') }}">{{ __('Members') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                {{ __('Edit Member') }}
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
                            <form id="doctoraddForm" method="POST" enctype="multipart/form-data"
                                action="{{ route('admin.teams.update', $team->id) }}">
                                @csrf
                                @method('put')


                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="Name" class="form-label">Name <span
                                                class="text-danger">*</span></label>
                                        <input id="name" type="text" name="name"
                                            value="{{ old('name', $team->name) }}" placeholder="Name"
                                            class="form-control @error('name')
                                                is-invalid
                                            @enderror">

                                        @if ($errors->has('name'))
                                            <span style="color:red;">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>

                                    {{-- <div class="mb-3 form-group-translation col-md-6">
                                        <label for="slug" class="form-label">Slug <span
                                                class="text-danger">*</span></label>
                                        <input id="slug" type="text" name="slug"
                                            value="{{ old('slug', $team->slug) }}" placeholder="Slug"
                                            class="form-control @error('slug')
                                                is-invalid
                                            @enderror">

                                        @if ($errors->has('slug'))
                                            <span style="color:red;">{{ $errors->first('slug') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row"> --}}
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="Name of office" class="form-label">Image <span
                                                class="text-danger"></span></label>
                                        <div class="form-group-translation">
                                            <input type="file" class="form-control-file mb-2" accept=".jpg, .jpeg, .png"
                                                id="exampleFormControlFile1" name="profile_image"
                                                value="{{ old('profile_image') }}">
                                            <!-- <label for="exampleFormControlFile1"><span>Profile Image</span>:</label> -->
                                            <p class="text-blue">Note: Please upload image of size 450px X
                                                340px. </p>
                                            @if ($team->profile_image)
                                                <a href="{{ asset('storage/uploads/teams/profile_image/' . $team->profile_image) }}"><img src="{{ asset('storage/uploads/teams/profile_image/thumbnails/admin_' . $team->profile_image) }}"
                                                    alt="Image"/></a>
                                            @endif
                                            <br>

                                            @if ($errors->has('profile_image'))
                                                <span style="color:red;">{{ $errors->first('profile_image') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- <div class="mb-3 form-group-translation col-md-6">
                                        <label for="type" class="form-label">Type <span
                                                class="text-danger">*</span></label>
                                        <select id="type" name="type" class="form-control">
                                            @foreach (App\Enums\TeamTypeEnum::cases() as $type)
                                                <option value="{{ $type->value }}"
                                                    {{ old('type', $team->type) == $type->value ? 'selected' : '' }}>
                                                    {{ $type->label() }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('type'))
                                            <span style="color:red;">{{ $errors->first('type') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="Speciality" class="form-label"><span>Speciality <span
                                                    class="text-danger"> *</span></span></label>
                                        <input id="speciality" type="text" name="speciality" value="{{ old('speciality', $team->speciality) }}"
                                            placeholder="Speciality"
                                            class="form-control @error('speciality')
                                        is-invalid
                                    @enderror">

                                        @if ($errors->has('speciality'))
                                            <span style="color:red;">{{ $errors->first('speciality') }}</span>
                                        @endif
                                    </div> --}}
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="designation_id" class="form-label">Designation <span
                                                class="text-danger">*</span></label>
                                        <select name="designation_id" id="designation_id" class="form-control @error('designation_id')
                                            is-invalid
                                        @enderror">
                                            <option value="">Select Designation</option>
                                            @foreach ($designations as $designation)
                                                <option value="{{ $designation->id }}"
                                                    {{ old('designation_id', $team->designation_id) == $designation->id ? 'selected' : '' }}>
                                                    {{ $designation->title }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('designation_id'))
                                            <span style="color:red;">{{ $errors->first('designation_id') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="Order By" class="form-label"><span>Order By <span
                                                    class="text-danger"></span></span></label>
                                        <input id="order_by" type="number" name="order_by"
                                            value="{{ old('order_by', $team->order_by) }}" placeholder="Order By"
                                            class="form-control @error('order_by')
                                        is-invalid
                                    @enderror">

                                        @if ($errors->has('order_by'))
                                            <span style="color:red;">{{ $errors->first('order_by') }}</span>
                                        @endif
                                    </div>
                                    {{-- <div class="mb-3 form-group-translation col-md-6">
                                        <label for="experience" class="form-label">Experience <span
                                                class="text-danger">*</span></label>
                                        <input id="experience" type="text" name="experience"
                                            value="{{ old('experience', $team->experience) }}" placeholder="Experience"
                                            class="form-control @error('experience')
                                        is-invalid
                                    @enderror">

                                        @if ($errors->has('experience'))
                                            <span style="color:red;">{{ $errors->first('experience') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="facebook" class="form-label">{{ __('Facebook') }}</label>
                                        <input id="facebook" type="text" name="facebook"
                                            value="{{ old('facebook', $team->facebook) }}" placeholder="Facebook"
                                            class="form-control @error('facebook')
                                        is-invalid
                                    @enderror">

                                        @if ($errors->has('facebook'))
                                            <span style="color:red;">{{ $errors->first('facebook') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="twitter" class="form-label">{{ __('Twitter') }}</label>
                                        <input id="twitter" type="text" name="twitter"
                                            value="{{ old('twitter', $team->twitter) }}" placeholder="Twitter"
                                            class="form-control @error('twitter')
                                        is-invalid
                                    @enderror">

                                        @if ($errors->has('twitter'))
                                            <span style="color:red;">{{ $errors->first('twitter') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="instagram" class="form-label">{{ __('Instagram') }}</label>
                                        <input id="instagram" type="text" name="instagram"
                                            value="{{ old('instagram', $team->instagram) }}" placeholder="Instagram"
                                            class="form-control @error('instagram')
                                        is-invalid
                                    @enderror">

                                        @if ($errors->has('instagram'))
                                            <span style="color:red;">{{ $errors->first('instagram') }}</span>
                                        @endif
                                    </div>
                                </div>



                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-12">
                                        <label for="Description" class="form-label">Description <span
                                                class="text-danger">*</span></label>
                                        <textarea name="description" id="editor" cols="20" rows="10" placeholder="Description"
                                            class="form-control ckeditor">{{ old('description', $team->description) }}</textarea>

                                        @if ($errors->has('description'))
                                            <span style="color:red;">{{ $errors->first('description') }}</span>
                                        @endif

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-12">
                                        <label for="Page Title" class="form-label">HTML Title<span class="text-danger"> *</span></label>
                                        <input id="html_title" type="text" name="html_title"
                                            value="{{ old('html_title', $team->html_title) }}" placeholder="Html Title"
                                            class="form-control">
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
                                            class="form-control">{{ old('meta_description', $team->meta_description) }}</textarea>
                                        @if ($errors->has('meta_description'))
                                            <span style="color:red;">{{ $errors->first('meta_description') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-12">
                                        <label for="Meta Keyword" class="form-label">Meta Keyword<span class="text-danger"> *</span></label>
                                        <textarea name="meta_keyword" cols="8" rows="3" placeholder="Keyword" class="form-control">{{ old('meta_keyword', $team->meta_keyword) }}</textarea>
                                        @if ($errors->has('meta_keyword'))
                                            <span style="color:red;">{{ $errors->first('meta_keyword') }}</span>
                                        @endif
                                    </div>
                                </div> --}}

                                <div class="mt-2 col-md-12 text-right">
                                    <button type="submit" class="btn btn-success save-button" value="save"
                                        onclick="disableButtonAndSubmitForm(this);">{{ __('Save') }}</button>
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
            document.getElementById("doctoraddForm").submit();
        }
    </script>
@endsection
