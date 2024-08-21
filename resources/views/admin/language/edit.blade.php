@extends('admin.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <div class="content-header px-3">
            <div class="container-fluid">
                <div class="row mb-2 mx-1">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __('Edit Language') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <a title="Go Back" href="{{ route('admin.language.index') }}"
                                class="btn btn-secondary btn-sm previous round"> <i class="fas fa-arrow-left"
                                    aria-hidden="true"></i></a> &nbsp;&nbsp;
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                            <a href="{{ route('admin.language.index') }}">{{ __('Languages') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                {{ __('Edit Language') }}
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
                                action="{{ route('admin.language.update', $language->id) }}">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="mb-3 form-group-translation col-md-12">
                                        <label for="list_id" class="form-label">Language <span class="text-danger">*</span> </label>
                                        <select id="name" name="list_id" class="form-control @error('list_id')
                                            is-invalid
                                        @enderror">
                                            @foreach ($lists as $list)
                                                <option value="{{ $list->id }}" {{ old('list_id', $language->flag) == $list->flag ? 'selected' : '' }}>{{ $list->name }} - {{ $list->flag }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('list_id'))
                                            <span style="color:red;">{{ $errors->first('list_id') }}</span>
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
