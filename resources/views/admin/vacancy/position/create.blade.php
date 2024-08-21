@extends('admin.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <div class="content-header px-3">
            <div class="container-fluid">
                <div class="row mb-2 mx-1">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __('Add Vacancy Position') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <a title="Go Back" href="{{ route('admin.vacancy.position.index') }}"
                                class="btn btn-secondary btn-sm previous round"> <i class="fas fa-arrow-left"
                                    aria-hidden="true"></i></a> &nbsp;&nbsp;
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                            <a href="{{ route('admin.vacancy.position.index') }}">{{ __('Levels') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                {{ __('Add Levels') }}
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
                                action="{{ route('admin.vacancy.position.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-12">
                                        <label for="TItle" class="form-label">Title <span class="text-danger">*</span> </label>
                                        <input id="title" type="text" name="name" value="{{ old('name') }}"
                                            placeholder="Title"
                                            class="form-control @error('name')
                                                is-invalid
                                            @enderror">

                                        @if ($errors->has('name'))
                                            <span style="color:red;">{{ $errors->first('name') }}</span>
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
@endsection
