@extends('admin.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __('Edit Menu Builder') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <a title="Go Back" href="{{ route('admin.menu.index') }}"
                                class="btn btn-secondary btn-sm previous round" style=""> <i class="fas fa-arrow-left"
                                    aria-hidden="true"></i></a> &nbsp;&nbsp;
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                {{ __('Menu Builder') }}
                            </li>
                            <li class="breadcrumb-item">
                                {{ __('Edit Menu Builder') }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->
        <section class="content gray">
            <div class="container-fluid">

                <section class="content row">
                    <div class="container-fluid">
                        <div class="card card-body">
                            <form id="mediaaddForm" method="POST" enctype="multipart/form-data"
                                action="{{ route('admin.menu.update', $menu->id) }}">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="TItle" class="form-label"><span>Title</span>*</label>
                                        <input id="title" type="text" name="title" value="{{ old('title', $menu->title) }}"
                                            placeholder="Title"
                                            class="form-control @error('title')
                                                is-invalid
                                            @enderror">

                                        @if ($errors->has('title'))
                                            <span style="color:red;">{{ $errors->first('title') }}</span>
                                        @endif

                                    </div>
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="icon_image" class="form-label"><span>Icon Image</span>*</label>
                                        <input id="icon_image" type="file" name="icon_image"
                                            class="form-control @error('icon_image')
                                                is-invalid
                                            @enderror">

                                        @if ($errors->has('icon_image'))
                                            <span style="color:red;">{{ $errors->first('icon_image') }}</span>
                                        @endif

                                        @if($menu->icon_image)
                                            <img src="{{ asset('storage/'.$menu->icon_image) }}" class="img-fluid mt-1" height="100" width="100" />
                                        @endif

                                    </div>
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="order_by" class="form-label"><span>Order By</span></label>
                                        <input id="order_by" type="number" name="order_by" value="{{ old('order_by', $menu->order_by) }}"
                                            placeholder="order_by"
                                            class="form-control @error('order_by')
                                                is-invalid
                                            @enderror">

                                        @if ($errors->has('order_by'))
                                            <span style="color:red;">{{ $errors->first('order_by') }}</span>
                                        @endif

                                    </div>
                                    <div class="mb-3 form-group-translation form-check col-md-3 mt-4 ml-2">
                                        <input
                                            class="form-check-input @error('status')
                                            is-invalid
                                        @enderror"
                                            type="checkbox" value="{{ old('status', 1) }}" name="status" @if($menu->status == 1)
                                                checked
                                            @endif
                                            id="defaultCheck1">
                                        <label class="form-check-label" for="defaultCheck1">
                                            {{ __('status') }}
                                        </label>

                                        @if ($errors->has('status'))
                                            <span style="color:red;">{{ $errors->first('status') }}</span>
                                        @endif

                                    </div>
                                    <div class="mb-3 form-group-translation form-check col-md-3 mt-4 ml-2">
                                        <input
                                            class="form-check-input @error('has_submenu')
                                            is-invalid
                                        @enderror"
                                            type="checkbox" value="{{ old('has_submenu', 1) }}" name="has_submenu" @if($menu->has_sub_menu == 1)
                                                checked
                                            @endif
                                            id="defaultCheck2">
                                        <label class="form-check-label" for="defaultCheck2">
                                            {{ __('has_submenu') }}
                                        </label>

                                        @if ($errors->has('has_submenu'))
                                            <span style="color:red;">{{ $errors->first('has_submenu') }}</span>
                                        @endif

                                    </div>
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="custome_link" class="form-label"><span>Custome Link</span>*</label>
                                        <input id="custome_link" type="text" name="custome_link"
                                            value="{{ old('custome_link', $menu->url) }}" placeholder="custome_link"
                                            class="form-control @error('custome_link')
                                                is-invalid
                                            @enderror">

                                        @if ($errors->has('custome_link'))
                                            <span style="color:red;">{{ $errors->first('custome_link') }}</span>
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
        function disableButtonAndSubmitForm(button) {
            // Disable the button
            button.disabled = true;
            // Submit the form
            document.getElementById("mediaaddForm").submit();
        }
    </script>
    <script>
        $(document).ready(function() {
            // Initial check on page load
            toggleCustomLink();

            // Check the state of the checkbox and toggle the custom link field
            function toggleCustomLink() {
                if ($('#defaultCheck2').is(':checked')) {
                    $('#custome_link').parent().hide(); // Hide the parent div of the custom link input
                } else {
                    $('#custome_link').parent().show(); // Show the parent div of the custom link input
                }
            }

            // Event listener for the checkbox change event
            $('#defaultCheck2').change(function() {
                toggleCustomLink();
            });
        });
    </script>
@endsection
