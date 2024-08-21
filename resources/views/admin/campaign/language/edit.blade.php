@extends('admin.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <div class="content-header px-3">
            <div class="container-fluid">
                <div class="row mb-2 mx-1">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __('Edit Campaign Language') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <a title="Go Back" href="{{ route('admin.campaign.language.index', $campaign->id) }}"
                                class="btn btn-secondary btn-sm previous round"> <i class="fas fa-arrow-left"
                                    aria-hidden="true"></i></a> &nbsp;&nbsp;
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a
                                    href="{{ route('admin.campaign.language.index', $campaign->id) }}">{{ __('Campaign Languages') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                {{ __('Edit Campaign Language') }}
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
                                action="{{ route('admin.campaign.language.update', ['id' => $campaignLanguage->id, 'campaign_id' => $campaign->id]) }}">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="col-md-4">
                                    <div class="mb-3 form-group-translation col-md-12">
                                        <label for="TItle" class="form-label">{{ __('Language') }} <span
                                                class="text-danger">*</span> </label>
                                        <p>{{ $lang->language->name ?? '' }}</p>

                                    </div>
                                    <div class="mb-3 form-group-translation col-md-12">
                                        <label for="TItle" class="form-label">{{ __('Title') }} <span
                                                class="text-danger">*</span> </label>
                                        <p>{{ $campaign->title }}</p>

                                    </div>
                                    </div>
                                    <div class="mb-3 form-group-translation col-md-8">
                                        <div class="row">
                                            <div class="mb-3 form-group-translation col-md-12">
                                                <label for="Language" class="form-label">{{ __('Language') }}<span
                                                        class="text-danger"> *</span>
                                                </label>
                                                <select name="language_id" id="language_id"
                                                    class="form-control @error('language_id')
                                                is-invalid
                                            @enderror">
                                                    @foreach ($languages as $language)
                                                        <option value="{{ $language->id }}"
                                                            {{ old('language_id', $campaignLanguage->language_id) == $language->id ? 'selected' : '' }}>
                                                            {{ $language->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 form-group-translation col-md-12">
                                                <label for="Language" class="form-label">{{ __('Title') }}<span
                                                        class="text-danger"> *</span>
                                                </label>
                                                <input type="text" name="title" id="title"
                                                    value="{{ old('title', $campaignLanguage->title) }}"
                                                    class="form-control @error('title')
                                                is-invalid
                                            @enderror">

                                                @error('title')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
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
