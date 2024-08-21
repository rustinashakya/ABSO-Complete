@extends('frontend.layouts.master')

@section('content')
    <section class="section section-lg bg-default text-left wow slideInUp" data-wow-duration="2s">
        <div class="container">
            <div class="row row-60">
                <div class="col-lg-8">
                    @if ($applicant->type == 'future')
                        <h4 class="text-spacing-25 text-transform-none"><b>Work with us</b></h4>
                    @else
                        <h4 class="text-spacing-25 text-transform-none"><b>{{ $applicant->vacancy->title }} Vacancy -
                                Application Form</b></h4>
                    @endif
                    {{-- <h4 class="text-spacing-25 text-transform-none"><b>Get in Touch</b></h4> --}}
                    {{-- <div class="text-spacing-25 text-transform-none h6 my-3">Open positions are not suitable for you?</div> --}}
                    <form method="post" action="{{ route('applicant.update', $encrypted_id) }}" enctype="multipart/form-data"
                        id="applicant-form">
                        @csrf
                        @method('PUT')
                        <div class="row row-20 gutters-20">
                            <input type="hidden" name="type" value="{{ $applicant->type }}">
                            <!-- Name  -->
                            <div class="col-md-6">
                                <div class="form-wrap">
                                    <label for="name">Your Name <span style="color: red;">*</span></label>
                                    <input class="form-input @error('name') is-invalid @enderror" id="name"
                                        type="text" name="name" value="{{ old('name', $applicant->name) }}"
                                        placeholder="Enter your name">
                                    @error('name')
                                        <span class="text-danger" id="name-error" style="color: red">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email  -->
                            <div class="col-md-6">
                                <div class="form-wrap">
                                    <label for="email">Your Email <span style="color: red;">*</span></label>
                                    <input class="form-input @error('email') is-invalid @enderror" id="email"
                                        value="{{ old('email', $applicant->email) }}" type="email" name="email"
                                        placeholder="Enter your email">
                                    @error('email')
                                        <span class="text-danger" id="name-error" style="color: red">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- CV  -->
                            <div class="col-md-12">
                                <div class="form-wrap">
                                    <label for="cv">Upload Your CV <span style="color: red;"></span></label> <br>
                                    <input class="form-input-file mt-2" id="cv" type="file" name="cv_file"
                                        accept=".pdf, .doc, .docx">
                                    @error('cv_file')
                                        <p class="text-danger" id="name-error" style="color: red">{{ $message }}</p>
                                    @enderror
                                    <br>
                                    @if ($applicant->cv_file)
                                        <a href="{{ asset('storage/uploads/applicant/cv_file/' . $applicant->cv_file) }}"
                                            download>{{ $applicant->cv_file }}</a>
                                    @endif
                                </div>
                            </div>

                            <!-- Position  -->
                            <div class="col-md-6">
                                <div class="form-wrap">
                                    <label for="position">Position <span style="color: red;">*</span></label>
                                    <select class="form-input @error('vacancy_id') is-invalid @enderror" id="position"
                                        name="vacancy_id" data-minimum-results-for-search="Infinity"
                                        {{ $applicant->type == 'future' ? '' : 'disabled' }}>
                                        <option value="">Select Position</option>
                                        @foreach ($positions as $position)
                                            <option value="{{ $position->id }}" {{ old('vacancy_id', $applicant->vacancy_id) == $position->id ? 'selected' : '' }}>
                                                {{ $position->title }} @if ($position->vacancy_level_id)
                                                    ({{ $position->level->name ?? '' }})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @if (@$applicant->type != 'future')
                                        <input type="hidden" name="vacancy_id"
                                            value="{{ old('vacancy_id', @$applicant->vacancy_id) }}">
                                    @endif
                                    @error('vacancy_id')
                                        <span class="text-danger" id="name-error" style="color: red">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Salary expectation  -->
                            <div class="col-md-6">
                                <div class="form-wrap">
                                    <label for="salary_expectation">Salary Expectation <span
                                            style="color: red;">*</span></label>
                                    <input class="form-input @error('salary_expectation') is-invalid @enderror"
                                        id="salary_expectation" type="text"
                                        value="{{ old('salary_expectation', $applicant->salary_expectation) }}"
                                        name="salary_expectation" placeholder="Enter your expected salary">
                                    @error('salary_expectation')
                                        <span class="text-danger" id="name-error" style="color: red">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Experience  -->
                            <div class="col-md-6">
                                <div class="form-wrap">
                                    <label for="experience">Years of Job Experience <span
                                            style="color: red;">*</span></label>
                                    <select class="form-input @error('experience') is-invalid @enderror" id="experience"
                                        name="experience" data-minimum-results-for-search="Infinity">

                                        <option value="">Select Experience</option>
                                        @foreach (App\Enums\ExperienceEnum::cases() as $experience)
                                            <option value="{{ $experience->value }}"
                                                {{ old('experience', $applicant->experience) == $experience->value ? 'selected' : '' }}>
                                                {{ $experience->label() }}</option>
                                        @endforeach
                                    </select>
                                    @error('experience')
                                        <span class="text-danger" id="name-error" style="color: red">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Highest Level of Education  -->
                            <div class="col-md-6">
                                <div class="form-wrap">
                                    <label for="high_level_education">Highest Level of Education <span
                                            style="color: red;">*</span></label>
                                    <select class="form-input @error('high_level_education') is-invalid @enderror"
                                        id="high_level_education" name="high_level_education"
                                        data-minimum-results-for-search="Infinity">
                                        <option value="">Select Education</option>
                                        @foreach (App\Enums\HighLevelEducationEnum::cases() as $education)
                                            <option value="{{ $education->value }}"
                                                {{ old('high_level_education', $applicant->high_level_education) == $education->value ? 'selected' : '' }}>
                                                {{ $education->label() }}</option>
                                        @endforeach
                                    </select>
                                    @error('high_level_education')
                                        <span class="text-danger" id="name-error"
                                            style="color: red">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Training  -->
                            <div class="col-12">
                                <div class="form-wrap">
                                    <label for="training_description">Training completed on related field <span
                                            style="color: red;"></span></label>
                                    <textarea class="form-input @error('training_description') is-invalid @enderror editor" id="training_description"
                                        name="training_description" placeholder="Enter any training you completed on related field" cols="8"
                                        rows="5">{{ old('training_description', $applicant->training_description) }}</textarea>
                                    @error('training_description')
                                        <span class="text-danger" id="name-error"
                                            style="color: red">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Cover Letter  -->
                            <div class="col-12">
                                <div class="form-wrap">
                                    <label for="cover_letter">Cover Letter <span style="color: red;">*</span></label>
                                    <textarea class="form-input @error('cover_letter') is-invalid @enderror editor" id="cover_letter" name="cover_letter"
                                        placeholder="Enter your cover letter" cols="8" rows="10">{{ old('cover_letter', $applicant->cover_letter) }}</textarea>
                                    @error('cover_letter')
                                        <span class="text-danger" id="name-error"
                                            style="color: red">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="captcha mt-4">
                            <span>{!! app('captcha')->display() !!}</span>
                            @error('g-recaptcha-response')
                                <span class="text-danger" id="name-error" style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                        <button class="button button-primary" type="submit">Send</button>
                    </form>
                </div>

                <div class="col-lg-4">
                    {{ view('frontend.aside_contacts') }}
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/super-build/ckeditor.js"></script> -->
    <script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>

    <script>
        $(document).ready(function() {
            $('#submit').on('click', function() {
                //
            });
        });


        var allEditors = document.querySelectorAll('.editor');
        for (var i = 0; i < allEditors.length; ++i) {
            ClassicEditor.create(allEditors[i], {
                    // Specify needed CKEditor configuration options here
                    toolbar: ['heading', '|', 'bold', 'italic', '|', 'bulletedList', 'numberedList'],
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
                            }
                        ]
                    },
                    // More options can be added as needed
                })
                .catch(error => {
                    console.error(error);
                });
        }
    </script>

    <style>
        .is-invalid {
            border-color: #dc3545;
        }

        .text-danger {
            font-size: 14px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-success .close {
            color: #155724;
        }
    </style>
@endsection
