@extends('admin.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <div class="content-header px-3">
            <div class="container-fluid">
                <div class="row mb-2 mx-1">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __('Add Menu Builder') }}</h1>
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
                                {{ __('Add Menu Builder') }}
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
                                action="{{ route('admin.menu.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="TItle" class="form-label">Title <span
                                                class="text-danger">*</span></label>
                                        <input id="title" type="text" name="title" value="{{ old('title') }}"
                                            placeholder="Title"
                                            class="form-control @error('title')
                                                is-invalid
                                            @enderror">

                                        @if ($errors->has('title'))
                                            <span style="color:red;">{{ $errors->first('title') }}</span>
                                        @endif

                                    </div>
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="order_by" class="form-label"><span>{{ __('Parent Menu') }}</span></label>
                                        <select class="form-control" name="parent_id">
                                            <option value="">null</option>
                                            @foreach ($parents as $parent)
                                            <option value="{{ $parent->id }}">{{ $parent->title }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('order_by'))
                                            <span style="color:red;">{{ $errors->first('order_by') }}</span>
                                        @endif

                                    </div>
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="link" class="form-label"><span>{{ __('Link') }}</span> *</label>
                                        <select class="form-control" name="link">
                                            <option value="">--Select a Link--</option>
                                            <option value="/admin/static">Static Page</option>
                                            <option value="/sector">Sector</option>
                                            <option value="/service">Services</option>
                                            <option value="/project">Projects</option>
                                            <option value="/gallery">Galleries</option>
                                        </select>

                                        @if ($errors->has('order_by'))
                                            <span style="color:red;">{{ $errors->first('order_by') }}</span>
                                        @endif

                                    </div>
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="order_by" class="form-label"><span>Order By</span></label>
                                        <input id="order_by" type="number" name="order_by" value="{{ old('order_by') }}"
                                            placeholder="order_by"
                                            class="form-control @error('order_by')
                                                is-invalid
                                            @enderror">

                                        @if ($errors->has('order_by'))
                                            <span style="color:red;">{{ $errors->first('order_by') }}</span>
                                        @endif

                                    </div>
                                    <div class="mb-3 form-group-translation form-check col-md-3 mt-4 ml-2">
                                        <label class="form-label">{{ __('Show on Home Page?') }} *</label><br>
                                        <input class="form-check-input ml-2" type="radio" name="status"
                                            id="exampleRadios1" value="1" checked>
                                        <label class="form-check-label ml-4" for="exampleRadios1">
                                            Yes
                                        </label>
                                        <input class="form-check-input ml-2" type="radio" name="status"
                                            id="exampleRadios2" value="0">
                                        <label class="form-check-label ml-4" for="exampleRadios2">
                                            No
                                        </label>

                                        @if ($errors->has('status'))
                                            <span style="color:red;">{{ $errors->first('status') }}</span>
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
