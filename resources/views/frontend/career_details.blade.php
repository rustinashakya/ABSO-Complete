@extends('frontend.layouts.master')

@section('content')
    @php
        $html_title = $career->html_title ?? 'QYEC';
        $meta_description = $career->meta_description ?? 'QYEC';
        $meta_keyword = $career->meta_keyword ?? 'QYEC';
        $favicon_url =
            asset('storage/uploads/vacancy/image/' . $career->image) ??
            asset('frontend/images/QYEC-logo.png');
        $page_url = url()->current();
    @endphp
    <!-- <section class="bg-gray-7">
                                    <div class="breadcrumbs-custom box-transform-wrap context-dark">
                                        <div class="container">
                                            <h3 class="breadcrumbs-custom-title">Career Details</h3>
                                            <div class="breadcrumbs-custom-decor"></div>
                                        </div>
                                        <div class="box-transform" style="background-image: url('{{ asset('frontend/images/bg-typography.jpg') }}');"></div>
                                    </div>
                                    <div class="container">
                                        <ul class="breadcrumbs-custom-path">
                                            <li><a href="{{ url('/') }}">Home</a></li>
                                            <li><a href="{{ url('/career') }}">Career</a></li>
                                            <li class="active">Career Details</li>
                                        </ul>
                                    </div>
                                </section> -->

    <section class="section section-lg bg-default text-left">
        <div class="container">
            <div>
                <div>
                    <h4 class="text-spacing-25 text-transform-none mb-4"><b>{{ $career->title }}</b></h4>
                </div>
                <div>
                    <p>Position - {{ $career->level->name ?? '' }}</p>
                    <p>Deadline - {{ $career->deadline }}</p>
                    <p>
                        {{ $career->short_description }}
                    </p>
                    <p><b>Reports to: {{ $career->reports_to }}</b> </p>
                </div>

                <div class="mt-4">
                    <h5 class="text-spacing-25 text-transform-none mb-3">Description: </h5>
                    <p>{!! $career->description !!}</p>
                    {{-- <ul>
                    <li aria-level="1">
                        Lead design, analysis, and management of hydropower projects from inception to completion.
                    </li>
                    <li aria-level="1">
                        Ensure compliance with regulatory standards and optimize project efficiency.
                    </li>
                    <li aria-level="1">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati tenetur eligendi quam saepe voluptates voluptatem.
                    </li>
                </ul> --}}
                </div>

                {{-- <div class="mt-4">
                <h5 class="text-spacing-25 text-transform-none mb-3">Required Experience:</h5>
                <ul>
                    <li aria-level="1">
                        Bachelor’s degree in Civil, Mechanical, Electrical Engineering or related field.
                    </li>
                    <li aria-level="1">
                        7-10 years of progressive experience in hydropower engineering.
                    </li>
                    <li aria-level="1">
                        Experience in project management and technical design.
                    </li>
                </ul>
            </div> --}}

                {{-- <div class="mt-4">
                <h5 class="text-spacing-25 text-transform-none mb-3">Responsibilities: </h5>
                <ul>
                    <li aria-level="1">
                        Conduct technical design and analysis of hydropower systems.
                    </li>
                    <li aria-level="1">
                        Manage project phases: feasibility, design, construction, and commissioning.
                    </li>
                    <li aria-level="1">
                        Assess risks and develop mitigation strategies.
                    </li>
                    <li aria-level="1">
                        Engage with clients, stakeholders, and regulatory bodies.
                    </li>
                </ul>
            </div>

            <div class="mt-4">
                <h5 class="text-spacing-25 text-transform-none mb-3">Skills: </h5>
                <ul>
                    <li aria-level="1">
                        Proficient in CAD software (AutoCAD, SolidWorks) and hydropower design tools.
                    </li>
                    <li aria-level="1">
                        Strong analytical and problem-solving abilities.
                    </li>
                    <li aria-level="1">
                        Excellent communication and collaboration skills.
                    </li>
                    <li aria-level="1">
                        Professional Engineer (PE) license preferred; PMP certification a plus.
                    </li>
                </ul>
            </div>

            <div class="mt-4">
                <h5 class="text-spacing-25 text-transform-none mb-3">Benefits: </h5>
                <ul>
                    <li aria-level="1">
                        Competitive salary and comprehensive benefits package.
                    </li>
                    <li aria-level="1">
                        Opportunities for professional development and advancement.
                    </li>
                    <li aria-level="1">
                        Work in an innovative and sustainable industry.
                    </li>
                </ul>
            </div> --}}


                <!-- <a class="button button-primary mb-5" href="#apply-now" type="submit" style="scroll-behavior: smooth;">Apply</a> -->

            </div>




            <!-- <div>
                                                    <h3>Application</h3>
                                                    <p class="lg-font">Upload your CV to apply for the open position or to be for future openings.&nbsp;</p>
                                                </div> -->

            <hr style="border-top: 1px dashed red;" id="apply-now" class="mt-5">
            <br>
            <div id="success-message" class="alert alert-success" style="display:none;">
                <span id="success-message-text"></span>
                <button type="button" class="close">&times;</button>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <a href="{{ route('career.apply', $career->slug) }}" class="btn btn-md btn-primary">Apply Now</a>
                    {{-- <h4 class="text-spacing-25 text-transform-none">Apply Now</h4> --}}
                    {{-- <form id="applicant-form" class="rd-form rd-mailform" data-form-output="form-output-global"
                        data-form-type="contact" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row row-20 gutters-20">
                            <input type="hidden" name="type" value="job-details">
                            <input type="hidden" name="vacancy_id" value="{{ $career->id }}">
                            <!-- Name  -->
                            <div class="col-md-6">
                                <div class="form-wrap">
                                    <label for="name">Your Name <span style="color: red;">*</span></label>
                                    <input class="form-input" id="name" type="text" name="name"
                                        placeholder="Enter your name">
                                    <span class="text-danger" id="name-error" style="color: red"></span>
                                </div>
                            </div>

                            <!-- Email  -->
                            <div class="col-md-6">
                                <div class="form-wrap">
                                    <label for="email">Your Email <span style="color: red;">*</span></label>
                                    <input class="form-input" id="email" type="email" name="email"
                                        placeholder="Enter your email">
                                    <span class="text-danger" id="email-error" style="color: red"></span>
                                </div>
                            </div>

                            <!-- CV  -->
                            <div class="col-md-12">
                                <div class="form-wrap">
                                    <label for="cv">Upload Your CV <span style="color: red;">*</span></label> <br>
                                    <input class="form-input-file mt-2" id="cv" type="file" name="cv_file"
                                        accept=".pdf, .doc, .docx">
                                    <p class="text-danger" id="cv_file-error" style="color: red"></p>
                                </div>
                            </div>

                            <!-- Salary expectation  -->
                            <div class="col-md-6">
                                <div class="form-wrap">
                                    <label for="salary_expectation">Salary Expectation <span
                                            style="color: red;">*</span></label>
                                    <input class="form-input" id="salary_expectation" type="text"
                                        name="salary_expectation" placeholder="Enter your expected salary">
                                    <span class="text-danger" id="salary_expectation-error" style="color: red"></span>
                                </div>
                            </div>

                            <!-- Experience  -->
                            <div class="col-md-6">
                                <div class="form-wrap">
                                    <label for="experience">Years of Job Experience <span
                                            style="color: red;">*</span></label>
                                    <select class="form-input" id="experience" name="experience"
                                        data-minimum-results-for-search="Infinity">

                                        <option value="">Select Experience</option>
                                        @foreach (App\Enums\ExperienceEnum::cases() as $experience)
                                            <option value="{{ $experience->value }}">
                                                {{ $experience->label() }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="experience-error" style="color: red"></span>
                                </div>
                            </div>

                            <!-- Highest Level of Education  -->
                            <div class="col-md-6">
                                <div class="form-wrap">
                                    <label for="high_level_education">Highest Level of Education <span
                                            style="color: red;">*</span></label>
                                    <select class="form-input" id="high_level_education" name="high_level_education"
                                        data-minimum-results-for-search="Infinity">
                                        <option value="">Select Education</option>
                                        @foreach (App\Enums\HighLevelEducationEnum::cases() as $education)
                                            <option value="{{ $education->value }}">
                                                {{ $education->label() }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="high_level_education-error" style="color: red"></span>
                                </div>
                            </div>

                            <!-- Training  -->
                            <div class="col-12">
                                <div class="form-wrap">
                                    <label for="training_description">Training completed on related field <span
                                            style="color: red;"></span></label>
                                    <textarea class="form-input" id="training_description" name="training_description"
                                        placeholder="Enter any training you completed on related field" cols="8" rows="5"></textarea>
                                    <span class="text-danger" id="training_description-error" style="color: red"></span>
                                </div>
                            </div>

                            <!-- Cover Letter  -->
                            <div class="col-12">
                                <div class="form-wrap">
                                    <label for="cover_letter">Cover Letter <span style="color: red;">*</span></label>
                                    <textarea class="form-input" id="cover_letter" name="cover_letter" placeholder="Enter your cover letter"
                                        cols="8" rows="10"></textarea>
                                    <span class="text-danger" id="cover_letter-error" style="color: red"></span>
                                </div>
                            </div>

                        </div>
                        <div class="captcha mt-4">
                            <span>{!! app('captcha')->display() !!}</span>
                            <span class="text-danger" id="g-recaptcha-response-error" style="color: red"></span>
                        </div>
                        <button id="submit-btn" class="button button-primary" type="button">Send</button>
                    </form> --}}
                </div>
                {{-- <div class="col-lg-4">
                    {{ view('frontend.aside_contacts') }}
                </div> --}}
            </div>
        </div>
    </section>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#submit-btn').on('click', function() {
                $('#success-message').hide();
                $('#error-message').hide();
                $('.text-danger').html('');
                $('.form-input').removeClass('is-invalid');

                var formData = new FormData($('#applicant-form')[0]);

                $.ajax({
                    url: "{{ route('applicant.store') }}",
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#success-message-text').html(response.success);
                        $('#success-message').show();
                        $('#applicant-form')[0].reset();
                        grecaptcha.reset(); // Reset reCAPTCHA
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            for (var key in errors) {
                                if (errors.hasOwnProperty(key)) {
                                    if (key === 'g-recaptcha-response') {
                                        $('#g-recaptcha-response-error').html(errors[key][0])
                                            .css('font-size', '14px');
                                    } else {
                                        $('#' + key + '-error').html(errors[key][0]).css(
                                            'font-size', '14px');
                                        $('input[name=' + key + '], textarea[name=' + key +
                                                '], select[name=' + key + ']')
                                            .addClass('is-invalid');
                                    }
                                }
                            }
                        } else {
                            $('#error-message').html(
                                'An error occurred. Please try again later.').show();
                        }
                    }
                });
            });

            $(document).on('click', '.close', function() {
                $(this).closest('.alert').hide();
            });
        });
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
