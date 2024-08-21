@extends('admin.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <div class="content-header px-3">
            <div class="container-fluid">
                <div class="row mb-2 mx-1">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ __('Add kpis of ' . $project->title) }}</h1>
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
                                {{ __('Add kpis') }}
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
                            <form id="faqaddForm" method="POST" enctype="multipart/form-data" action="{{ route('admin.project.kpi.store') }}">
                                @csrf
                                {{-- @method('put') --}}

                                <div class="row">
                                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="sector" class="form-label">Sector<span class="text-danger"> *</span>
                                        </label>
                                        <select id="sector" name="sector"
                                            class="form-control @error('sector')
                                                is-invalid
                                            @enderror">
                                            {{-- <option value="">Select Sector</option> --}}
                                            <option value="hydropower" {{ old('sector', @$projectKpi->sector) == 'hydropower' ? 'selected' : '' }}>Hydropower</option>
                                            <option value="renewable_energy" {{ old('sector', @$projectKpi->sector) == 'renewable_energy' ? 'selected' : '' }}>Renewable Enery</option>
                                            <option value="water_conservation" {{ old('sector', @$projectKpi->sector) == 'water_conservation' ? 'selected' : '' }}>Water Conservation</option>
                                            <option value="distrubution_infrastructure" {{ old('sector', @$projectKpi->sector) == 'distrubution_infrastructure' ? 'selected' : '' }}>Distrubution Infrastructure</option>
                                        </select>
                                        @if ($errors->has('sector'))
                                            <span style="color:red;">{{ $errors->first('sector') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="location" class="form-label">Location<span class="text-danger"> *</span>
                                        </label>
                                        <input id="location" type="text" name="location" value="{{ old('location', @$projectKpi->location) }}"
                                            placeholder="location"
                                            class="form-control @error('location')
                                        is-invalid
                                    @enderror">
                                        @if ($errors->has('location'))
                                            <span style="color:red;">{{ $errors->first('location') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="altitude" class="form-label">Altitude<span class="text-danger"> *</span>
                                        </label>
                                        <input id="altitude" type="text" name="altitude" value="{{ old('altitude', @$projectKpi->altitude) }}"
                                            placeholder="altitude"
                                            class="form-control @error('altitude')
                                        is-invalid
                                    @enderror">
                                        @if ($errors->has('altitude'))
                                            <span style="color:red;">{{ $errors->first('altitude') }}</span>
                                        @endif
                                    </div>

                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="kw_per_year" class="form-label">KW per Year<span class="text-danger">
                                                *</span>
                                        </label>
                                        <input id="kw_per_year" type="text" name="kw_per_year"
                                            value="{{ old('kw_per_year') }}" placeholder="kw_per_year"
                                            class="form-control @error('kw_per_year')
                                        is-invalid
                                    @enderror">
                                        @if ($errors->has('kw_per_year'))
                                            <span style="color:red;">{{ $errors->first('kw_per_year', @$projectKpi->kw_per_year) }}</span>
                                        @endif
                                    </div>

                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="full_load_hours" class="form-label">Full load Hours<span
                                                class="text-danger"> *</span>
                                        </label>
                                        <input id="full_load_hours" type="text" name="full_load_hours"
                                            value="{{ old('full_load_hours') }}" placeholder="full_load_hours"
                                            class="form-control @error('full_load_hours')
                                        is-invalid
                                    @enderror">
                                        @if ($errors->has('full_load_hours'))
                                            <span style="color:red;">{{ $errors->first('full_load_hours', @$projectKpi->full_load_hours) }}</span>
                                        @endif
                                    </div>


                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="plant_availability" class="form-label">Plant Availability<span
                                                class="text-danger"> *</span>
                                        </label>
                                        <input id="plant_availability" type="text" name="plant_availability"
                                            value="{{ old('plant_availability') }}" placeholder="plant_availability"
                                            class="form-control @error('plant_availability')
                                        is-invalid
                                    @enderror">
                                        @if ($errors->has('plant_availability'))
                                            <span style="color:red;">{{ $errors->first('plant_availability', @$projectKpi->plant_availability) }}</span>
                                        @endif
                                    </div>


                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="circulation_rate" class="form-label">Circulation Rate<span
                                                class="text-danger"> *</span>
                                        </label>
                                        <input id="circulation_rate" type="text" name="circulation_rate"
                                            value="{{ old('circulation_rate', @$projectKpi->circulation_rate) }}" placeholder="circulation_rate"
                                            class="form-control @error('circulation_rate')
                                        is-invalid
                                    @enderror">
                                        @if ($errors->has('circulation_rate'))
                                            <span style="color:red;">{{ $errors->first('circulation_rate') }}</span>
                                        @endif
                                    </div>

                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="capacity" class="form-label">Capacity<span class="text-danger">
                                                *</span>
                                        </label>
                                        <input id="capacity" type="text" name="capacity"
                                            value="{{ old('capacity', @$projectKpi->capacity) }}" placeholder="capacity"
                                            class="form-control @error('capacity')
                                        is-invalid
                                    @enderror">
                                        @if ($errors->has('capacity'))
                                            <span style="color:red;">{{ $errors->first('capacity') }}</span>
                                        @endif
                                    </div>

                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="cost" class="form-label">Cost<span class="text-danger"> *</span>
                                        </label>
                                        <input id="cost" type="text" name="cost" value="{{ old('cost', @$projectKpi->cost) }}"
                                            placeholder="cost"
                                            class="form-control @error('cost')
                                        is-invalid
                                    @enderror">
                                        @if ($errors->has('cost'))
                                            <span style="color:red;">{{ $errors->first('cost') }}</span>
                                        @endif
                                    </div>

                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="funding_by" class="form-label">Funding By<span class="text-danger">
                                                *</span>
                                        </label>
                                        <input id="funding_by" type="text" name="funding_by"
                                            value="{{ old('funding_by', @$projectKpi->funding_by) }}" placeholder="funding_by"
                                            class="form-control @error('funding_by')
                                        is-invalid
                                    @enderror">
                                        @if ($errors->has('funding_by'))
                                            <span style="color:red;">{{ $errors->first('funding_by') }}</span>
                                        @endif
                                    </div>

                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="source" class="form-label">Source<span class="text-danger">
                                                *</span>
                                        </label>
                                        <input id="source" type="text" name="source" value="{{ old('source', @$projectKpi->source) }}"
                                            placeholder="source"
                                            class="form-control @error('source')
                                        is-invalid
                                    @enderror">
                                        @if ($errors->has('source'))
                                            <span style="color:red;">{{ $errors->first('source') }}</span>
                                        @endif
                                    </div>

                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="subbasin" class="form-label">Subbasin<span class="text-danger">
                                                *</span>
                                        </label>
                                        <input id="subbasin" type="text" name="subbasin"
                                            value="{{ old('subbasin', @$projectKpi->subbasin) }}" placeholder="subbasin"
                                            class="form-control @error('subbasin')
                                        is-invalid
                                    @enderror">
                                        @if ($errors->has('subbasin'))
                                            <span style="color:red;">{{ $errors->first('subbasin') }}</span>
                                        @endif
                                    </div>

                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="construction_begins" class="form-label">Construction Begins<span
                                                class="text-danger"> *</span>
                                        </label>
                                        <input id="construction_begins" type="date" name="construction_begins"
                                            value="{{ old('construction_begins', @$projectKpi->construction_begins) }}" placeholder="construction_begins"
                                            class="form-control @error('construction_begins')
                                        is-invalid
                                    @enderror">
                                        @if ($errors->has('construction_begins'))
                                            <span style="color:red;">{{ $errors->first('construction_begins') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label for="end_date" class="form-label">Completion Date<span
                                                class="text-danger"> </span>
                                        </label>
                                        <input id="end_date" type="date" name="end_date"
                                            value="{{ old('end_date', @$projectKpi->end_date) }}" placeholder="End Date"
                                            class="form-control @error('end_date')
                                        is-invalid
                                    @enderror">
                                        @if ($errors->has('end_date'))
                                            <span style="color:red;">{{ $errors->first('end_date') }}</span>
                                        @endif
                                    </div>


                                    <div class="mb-3 form-group-translation col-md-6">
                                        <label class="form-check-label mb-3">
                                            {{ __('Status ') }} <span class="text-danger"> *</span>
                                        </label>

                                        <div class="d-flex">
                                            <div class="form-check form-check-inline" style="margin-right: 10px;">
                                                <input
                                                    class="form-check-input @error('status') is-invalid @enderror"
                                                    type="checkbox" value="operating" name="status" id="statusYes"
                                                    {{ old('status', @$projectKpi->status) == 'operating' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="statusYes">Operating</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input
                                                    class="form-check-input @error('status') is-invalid @enderror"
                                                    type="checkbox" value="construction" name="status"
                                                    id="statusNo" {{ old('status', @$projectKpi->status) == 'construction' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="statusNo">Construction</label>
                                            </div>
                                        </div>

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
                                <!-- </div> -->
                            </form>
                        </div>
                    </div>
                </section>
            </div>

    </div>
    <!-- /.container-fluid -->
    </section>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to show/hide fields based on sector selection
            function toggleFields() {
                const sector = $('#sector').val();
                const fieldsToHide = {
                    hydropower: ['#kw_per_year', '#full_load_hours', '#plant_availability', '#circulation_rate'],
                    renewable_energy: ['#altitude', '#subbasin', '#circulation_rate'],
                    water_conservation: ['#altitude', '#subbasin', '#kw_per_year', '#full_load_hours', '#plant_availability'],
                    distrubution_infrastructure: ['#altitude', '#source', '#subbasin', '#kw_per_year', '#full_load_hours', '#plant_availability', '#circulation_rate']
                };
                
                // Hide all fields initially
                $('.form-group-translation').show();
                
                // Show/hide fields based on selected sector
                if (fieldsToHide[sector]) {
                    fieldsToHide[sector].forEach(field => $(field).closest('.form-group-translation').hide());
                }
            }

            // Initial call to set visibility based on default selection
            toggleFields();

            // Call toggleFields function when sector changes
            $('#sector').change(function() {
                toggleFields();
            });
        });

        function disableButtonAndSubmitForm(button) {
            // Disable the button
            button.disabled = true;
            // Submit the form
            document.getElementById("faqaddForm").submit();
        }
    </script>
@endsection
