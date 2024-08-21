@extends('admin.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <div class="content-header px-3">
            <div class="container-fluid">
                <div class="row mb-2 mx-1">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __('Add Campaign') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <a title="Go Back" href="{{ route('admin.campaign.index') }}"
                                class="btn btn-secondary btn-sm previous round"> <i class="fas fa-arrow-left"
                                    aria-hidden="true"></i></a> &nbsp;&nbsp;
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.campaign.index') }}">{{ __('Campaigns') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                {{ __('Add Campaign') }}
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
                                action="{{ route('admin.campaign.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="TItle" class="form-label">{{ __('Title') }} <span
                                                class="text-danger">*</span> </label>
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
                                        <label for="url" class="form-label">{{ __('Url') }} <span
                                                class="text-danger"></span> </label>
                                        <input id="url" type="text" name="url" value="{{ old('url') }}"
                                            placeholder="Full Url"
                                            class="form-control @error('url')
                                                is-invalid
                                            @enderror">

                                        @if ($errors->has('url'))
                                            <span style="color:red;">{{ $errors->first('url') }}</span>
                                        @endif

                                    </div>
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="url" class="form-label">{{ __('Status') }} <span
                                                class="text-danger">
                                                *</span> </label>
                                        <div class="form-check">
                                            <span class="yes">
                                                <input class="form-check-input" type="radio" name="status"
                                                    id="exampleRadios1" value="1" checked>
                                                <label class="form-check-label" for="exampleRadios1">
                                                    Active
                                                </label>
                                            </span>

                                            <span class="no ml-5">
                                                <input class="form-check-input" type="radio" name="status"
                                                    id="exampleRadios2" value="0">
                                                <label class="form-check-label" for="exampleRadios2">
                                                    Inactive
                                                </label>
                                            </span>
                                        </div>
                                        @if ($errors->has('status'))
                                            <span style="color:red;">{{ $errors->first('status') }}</span>
                                        @endif

                                    </div>
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="images" class="form-label">{{ __('Images') }}
                                            {{ __('(Multiple)') }}<span class="text-danger"> *</span> </label>
                                        <p class="text-blue">Note: Images size must be at least 576px X 576px.</p>
                                        <input id="images" type="file" accept=".jpg, .jpeg, .png" name="images[]" value="{{ old('images') }}"
                                            placeholder="Images" multiple
                                            class="form-control-file @error('images.*')
                                                is-invalid
                                            @enderror">
                                        @error('images')
                                            <span style="color:red;">{{ $message }}</span>
                                        @enderror
                                        @foreach ($errors->get('images.*') as $key => $error)
                                            <span style="color:red;">{{ $error[0] }}</span>
                                        @endforeach

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
@endsection
