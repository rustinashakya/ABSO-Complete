@extends('admin.layout')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __(' Edit Testimonial') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <a title="Go Back" href="{{ route('testimonial.index') }}"
                                class="btn btn-secondary btn-sm previous round" style=""> <i class="fas fa-arrow-left"
                                    aria-hidden="true"></i></a> &nbsp;&nbsp;
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            {{ __('Testimonials') }}
                        </li>
                        <li class="breadcrumb-item">
                            {{ __('Edit Testimonial') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->
    <section class="content gray">
        <section class="content">
            <div class="container-fluid">
            @if (session('message'))
                    <div class="alert alert-success  alert-dismissible fade show">{{ session('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="card card-body">
                    <form method="POST" enctype="multipart/form-data" action="{{ route('testimonial.update',$testimonial->id) }}">
                        @csrf
                        @method('post')

                        <div class="container-fluid">

                            <div class="row">

                                
                                
                                
                                <div class="mb-3 form-group-translation col-md-6">
                                
                                    <div id="showyoutube" class="row myDiv youtube_div">
                                
                                        {{-- <label for="Name of office" class="form-label"><span>File</span>*</label> --}}
                                        <label for="Youtube Link" class="form-label"><span>Youtube Link*</span></label>
                                        <input id="link" type="text" name="link" value="{{$testimonial->link }}"
                                            placeholder="Youtube Link" class="form-control" accept=".doc,.docx,.pdf">
                                        <span id="error_youtube"></span>
                                        @if ($errors->has('link'))
                                        <span style="color:red;">{{ $errors->first('link') }}</span>
                                        @endif
                                    </div>
                                
                                </div>
                                
                                <div class="mb-3 form-group-translation col-md-12">
                                        <div class="mb-3 mt-3 form-group-translation col-md-6">
                                            <label for="exampleFormControlFile1"><span>Thumbnail</span>*</label>
                                
                                            <input type="hidden" name="thumbnail_1" value="{{ $testimonial->thumbnail }}">
                                            <input type="file" class="form-control-file" id="exampleFormControlFile1"
                                                value="{{ old('thumbnail',$testimonial->thumbnail) }}" name="thumbnail" accept="image/*">
                                
                                            <div class="col-md-6">
                                                <div class="image-trap">
                                                    <a href="{{asset('storage/uploads/testimonial_thumbnail/'.$testimonial->thumbnail)}}" data-toggle="lightbox"
                                                        data-gallery="multiimages" data-title="" class=" img-responsive">
                                                        <picture>
                                                            <source media="(min-width:3840px)"
                                                                srcset="{{ asset('/storage/uploads/testimonial_thumbnail/' . $testimonial->thumbnail) }}" />
                                                            <source media="(min-width:2048px)"
                                                                srcset="{{ asset('/storage/uploads/testimonial_thumbnail/thumbnail/large_' . $testimonial->thumbnail) }}" />
                                
                                                            <source media="(min-width:1920px)"
                                                                srcset="{{ asset('/storage/uploads/testimonial_thumbnail/thumbnail/medium_' . $testimonial->thumbnail) }}" />
                                                            <source media="(min-width:768px)"
                                                                srcset="{{ asset('/storage/uploads/testimonial_thumbnail/thumbnail/small_' . $testimonial->thumbnail) }}" />
                                
                                                            <img src="{{ asset('/storage/uploads/testimonial_thumbnail/thumbnail/vsmall_' . $testimonial->thumbnail) }}"
                                                                alt="Image">
                                                        </picture>
                                                        {{-- <img class="img-thumbnail image_list" style="width:100%;"
                                                            src="{{asset('storage/uploads/testimonial_thumbnail/'.$testimonial->thumbnail)}}" alt="image"> --}}
                                                    </a>
                                                </div>
                                            </div>
                                
                                            @if($errors->has('thumbnail'))
                                            <span style="color:red;">{{$errors->first('thumbnail')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="mt-2 col-md-12 text-right">
                                    <button type="submit" class="btn btn-success save-button" value="save">{{
                                        __('Save')
                                        }}</button>
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
@endsection