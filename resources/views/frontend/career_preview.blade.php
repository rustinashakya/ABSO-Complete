@extends('frontend.layouts.master')

@section('content')
    <section class="section section-lg bg-default text-left">
        <div class="container">
            <div class="row row-60">
                <div class="col-lg-12">
                    <h1 class="text-spacing-25 text-transform-none h4"><b>Preview</b></h1>
                    <div class="text-gray text-transform-none h6 text-center text-lg-left">
                        Please confirm your application details. 
                    </div>
                    
                    <div class="row row-20 gutters-20">
                        <!-- Name  -->
                        <div class="col-md-6 col-lg-5">
                            <div class="form-wrap">
                                <label for="name">Your Name</label>
                                <div class="preview-data form-input">{{ $applicant->name }}</div>
                            </div>
                        </div>

                        <!-- Email  -->
                        <div class="col-md-6 col-lg-4">
                            <div class="form-wrap">
                                <label for="email">Your Email</label>
                                <div class="preview-data form-input">{{ $applicant->email }}</div>
                            </div>
                        </div>

                        <!-- CV  -->
                        <div class="col-md-12">
                            <div class="form-wrap">
                                <label for="cv">Upload Your CV</label> <br>
                                <a href="{{ asset('storage/uploads/applicant/cv_file/' . $applicant->cv_file) }}"
                                    download>{{ $applicant->cv_file }}</a>
                            </div>
                        </div>

                        <!-- Position  -->
                        <div class="col-md-6 col-lg-4">
                            <div class="form-wrap">
                                <label for="position">Position</label>
                                <div class="preview-data form-input">{{ $applicant->vacancy->title ?? '' }}
                                    @if($applicant->vacancy_level_id) ({{ $applicant->vacancy->level->name ?? '' }}) @endif</div>
                            </div>
                        </div>

                        <!-- Salary expectation  -->
                        <div class="col-md-6 col-lg-4">
                            <div class="form-wrap">
                                <label for="salary_expectation">Salary Expectation</label>
                                <div class="preview-data form-input">{{ $applicant->salary_expectation }}</div>
                            </div>
                        </div>

                        <!-- Experience  -->
                        <div class="col-md-6 col-lg-4">
                            <div class="form-wrap">
                                <label for="experience">Years of Job Experience</label>
                                <div class="preview-data form-input">{{ $applicant->experience }}</div>
                            </div>
                        </div>

                        <!-- Highest Level of Education  -->
                        <div class="col-md-6 col-lg-4">
                            <div class="form-wrap">
                                <label for="high_level_education">Highest Level of Education</label>
                                <div class="preview-data form-input">{{ $applicant->high_level_education }}</div>
                            </div>
                        </div>

                        <!-- Training  -->
                        <div class="col-12">
                            <div class="form-wrap">
                                <label for="training_description">Training completed on related field <span
                                        style="color: red;"></span></label>
                                <div class="preview-data form-input">{!! $applicant->training_description !!}</div>
                            </div>
                        </div>

                        <!-- Cover Letter  -->
                        <div class="col-12">
                            <div class="form-wrap">
                                <label for="cover_letter">Cover Letter</label>
                                <div class="preview-data form-input">{!! $applicant->cover_letter !!}</div>
                            </div>
                        </div>

                    </div>

                    <div class="text-center text-lg-left">
                        <a href="{{ route('career.edit', $encrypted_id) }}" class="button button-primary mt-4">Edit</a>
                        <a href="{{ route('career.confirm', $encrypted_id) }}"
                            class="button button-primary mt-4">Confirm</a>
                    </div>
                </div>

                <!-- <div class="col-lg-4">
                    {{ view('frontend.aside_contacts') }}
                </div> -->
            </div>
        </div>
    </section>
@endsection
