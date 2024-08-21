@extends('frontend.layouts.master')

@section('content')
    @php
        $html_title = $shared_site_setting->career_html_title ?? 'QYEC';
        $meta_description = $shared_site_setting->career_html_title ?? 'QYEC';
        $meta_keyword = $shared_site_setting->career_html_title ?? 'QYEC';
        $favicon_url = asset('frontend/images/QYEC-logo.png');
        $page_url = url()->current();
    @endphp
    <!-- <section class="bg-gray-7">
                                      <div class="breadcrumbs-custom box-transform-wrap context-dark">
                                        <div class="container">
                                          <h3 class="breadcrumbs-custom-title">Career</h3>
                                          <div class="breadcrumbs-custom-decor"></div>
                                        </div>
                                        <div class="box-transform" style="background-image: url('{{ asset('frontend/images/bg-typography.jpg') }}');"></div>
                                      </div>
                                      <div class="container">
                                        <ul class="breadcrumbs-custom-path">
                                          <li><a href="index.html">Home</a></li>
                                          <li class="active">Career</li>
                                        </ul>
                                      </div>
                                    </section> -->

    <section class="section section-lg bg-default text-left">
        <div class="container">
            <h1 class="mb-4 wow slideInDown h4" data-wow-duration="1s" data-wow-delay=".2s">
                <b>Career</b>
                <p class="h5">Work With Us</p>
            </h1>
            @if ($careers->count() > 0)
                <div class="table-custom-responsive wow customFadeIn" data-wow-duration="2s" data-wow-delay=".2s">
                    <table class="table-custom table-custom-primary">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Short Description</th>
                                <th>Level</th>
                                <th>Deadline</th>
                                <th>More Info</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($careers as $career)
                                <tr>
                                    <td>{{ $career->title }}</td>
                                    <td>{{ $career->short_description }}</td>
                                    <td>{{ $career->level->name ?? '' }}</td>
                                    <td>{{ $career->deadline }}</td>
                                    <td>
                                        <a class="button button-xs button-primary button-winona button-shadow-2"
                                            data-caption-animate="fadeInUp" data-caption-delay="300"
                                            href="{{ route('career.details', $career->slug) }}" title="Apply">View More</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="bold">There is no current Career Opportunities.</p>
            @endif
        </div>
    </section>

    {{-- <section class="section section-lg bg-default text-left wow slideInUp" data-wow-duration="2s">
  <div class="container">
    <div class="row row-60">
      <div class="col-lg-8">
        <h2 class="text-spacing-25 text-transform-none h4"><b>Get in Touch</b></h2>
        <div class="text-spacing-25 text-transform-none h6 my-3">Open position are not suitable for you?</div>
        <div class="text-spacing-25 text-transform-none">Apply for future positions</div>
        <form class="rd-form rd-mailform" data-form-output="form-output-global" data-form-type="contact" method="post">
          <div class="row row-20 gutters-20">
            <!-- Name  -->
            <div class="col-md-6">
              <div class="form-wrap">
                <label for="name">Your Name <span style="color: red;">*</span></label>
                <input class="form-input" id="name" type="text" name="name" placeholder="Enter your name">
              </div>
            </div>

            <!-- Email  -->
            <div class="col-md-6">
              <div class="form-wrap">
                <label for="email">Your Email <span style="color: red;">*</span></label>
                <input class="form-input" id="email" type="email" name="email" placeholder="Enter your email">
              </div>
            </div>

            <!-- CV  -->
            <div class="col-md-12">
              <div class="form-wrap">
                <label for="cv">Upload Your CV <span style="color: red;">*</span></label> <br>
                <input class="form-input-file mt-2" id="cv" type="file" name="cv">
              </div>
            </div>

            <!-- Position  -->
            <div class="col-md-6">
              <div class="form-wrap">
                <label for="cv">Position <span style="color: red;">*</span></label>
                <select class="form-input" data-minimum-results-for-search="Infinity">
                  <option value="1" selected>Internship Positions</option>
                  <option value="2">Value Engineering</option>
                  <option value="3">HVAC Design</option>
                  <option value="4">Geospatial Design</option>
                </select>
              </div>
            </div>

            <!-- salary expectation  -->
            <div class="col-md-6">
              <div class="form-wrap">
                <label for="salary">Salary Expectation <span style="color: red;">*</span></label>
                <input class="form-input" id="salary" type="text" name="salary" placeholder="Enter your expected salary">
              </div>
            </div>

            <!-- Salary Expectation  -->
            <div class="col-md-6">
              <div class="form-wrap">
                <label for="experience">Years of Job experience <span style="color: red;">*</span></label>
                <select class="form-input" data-minimum-results-for-search="Infinity">
                  <option value="1" selected>less than 1 year</option>
                  <option value="2">1 to 2 years</option>
                  <option value="3">2 to 5 years</option>
                  <option value="4">5 to 10 years</option>
                  <option value="5">more than 10 years</option>
                </select>
              </div>
            </div>

            <!-- Highest Level of Education  -->
            <div class="col-md-6">
              <div class="form-wrap">
                <label for="cv">Highest Level of Education <span style="color: red;">*</span></label>
                <select class="form-input" data-minimum-results-for-search="Infinity">
                  <option value="1" selected>High School</option>
                  <option value="2">Bachelors</option>
                  <option value="3">Masters</option>
                  <option value="4">Pg</option>
                  <option value="5">PHD</option>
                </select>
              </div>
            </div>

            <!-- Training  -->
            <div class="col-12">
              <div class="form-wrap">
                <label for="training">Training completed on related field <span style="color: red;">*</span></label>
                <textarea class="form-input" id="training" type="text" name="training" placeholder="Enter any training you completed on related field" cols="8" rows="5"></textarea>
              </div>
            </div>

            <!-- cover letter  -->
            <div class="col-12">
              <div class="form-wrap">
                <label for="coverLetter">Cover Letter <span style="color: red;">*</span></label>
                <textarea class="form-input" id="coverLetter" type="text" name="coverLetter" placeholder="Enter your cover letter" cols="8" rows="10"></textarea>
              </div>
            </div>

          </div>
          <div class="captcha mt-4">
              <span>{!! app('captcha')->display() !!}</span>
          </div>
          <button class="button button-primary" type="button">Send</button>
        </form>
      </div>

      <div class="col-lg-4">
      {{ view('frontend.aside_contacts') }}
      </div>
    </div>
  </div>
</section> --}}
    <section class="section section-lg bg-default text-left">
        <div class="container">
            <div class="row row-60">
                <div class="col-lg-8">
                    {{-- <h4 class="text-spacing-25 text-transform-none"><b>Get in Touch</b></h4> --}}
                    <div class="text-spacing-25 text-transform-none h6 my-3">Open positions are not suitable for you? <a
                            href="{{ route('career.apply', 'future') }}" class="underline">apply for future</a></div>
                    <div id="success-message" class="alert alert-success" style="display:none;">
                        <span id="success-message-text"></span>
                        <button type="button" class="close">&times;</button>
                    </div>
                    {{-- <form id="applicant-form" class="rd-form rd-mailform" data-form-output="form-output-global"
                        data-form-type="contact" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row row-20 gutters-20">
                            <input type="hidden" name="type" value="future">
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

                            <!-- Position  -->
                            <div class="col-md-6">
                                <div class="form-wrap">
                                    <label for="position">Position <span style="color: red;">*</span></label>
                                    <select class="form-input" id="position" name="vacancy_id"
                                        data-minimum-results-for-search="Infinity">
                                        <option value="">Select Position</option>
                                        @foreach ($positions as $position)
                                            <option value="{{ $position->id }}">
                                                {{ $position->title }} ({{ $position->level->name ?? '' }})</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="vacancy_id-error" style="color: red"></span>
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
@endsection
