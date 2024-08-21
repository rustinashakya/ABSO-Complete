@extends('frontend.layouts.master')

@section('content')
    @php
        $html_title = $shared_site_setting->contact_us_html_title ?? 'QYEC';
        $meta_description = $shared_site_setting->contact_us_meta_description ?? 'QYEC';
        $meta_keyword = $shared_site_setting->contact_us_meta_keyword ?? 'QYEC';
        $favicon_url = asset('frontend/images/QYEC-logo.png');
        $page_url = url()->current();
    @endphp
    <!-- <section class="bg-gray-7">
                                              <div class="breadcrumbs-custom box-transform-wrap context-dark">
                                                <div class="container">
                                                  <h3 class="breadcrumbs-custom-title">Contact Us</h3>
                                                  <div class="breadcrumbs-custom-decor"></div>
                                                </div>
                                                <div class="box-transform" style="background-image: url('{{ asset('frontend/images/bg-typography.jpg') }}');"></div>
                                              </div>
                                              <div class="container">
                                                <ul class="breadcrumbs-custom-path">
                                                  <li><a href="index.html">Home</a></li>
                                                  <li class="active">Contact Us</li>
                                                </ul>
                                              </div>
                                            </section> -->

    {{-- <section class="section section-lg bg-default text-md-left">
        <div class="container">
          <div class="row row-60 justify-content-center">
            <div class="col-lg-8">
              <h4 class="text-spacing-25 text-transform-none mb-3 wow slideInDown" data-wow-duration="2s" data-wow-delay=".7s"><b>Contact Us</b></h4>
              <h6 class="text-spacing-25 text-transform-none wow slideInDown" data-wow-duration="2s" data-wow-delay=".7s">Get in Touch</h6>
              <form class="rd-form rd-mailform wow slideInFromBottom" data-wow-duration="2s" data-wow-delay=".7s" data-form-output="form-output-global" data-form-type="contact" method="post">
                <div class="row row-20 gutters-20">
                  <div class="col-md-6">
                    <div class="form-wrap">
                      <input class="form-input form-control-has-validation" id="contact-your-name-5" type="text" name="name"><span class="form-validation"></span>
                      <label class="form-label rd-input-label" for="contact-your-name-5">Your Name*</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-wrap">
                      <input class="form-input form-control-has-validation" id="contact-email-5" type="email" name="email"><span class="form-validation"></span>
                      <label class="form-label rd-input-label" for="contact-email-5">Your E-mail*</label>
                    </div>
                  </div>
                  
                  <div class="col-md-6">
                    <div class="form-wrap">
                      <input class="form-input form-control-has-validation" id="contact-phone-5" type="text" name="phone"><span class="form-validation"></span>
                      <label class="form-label rd-input-label" for="contact-phone-5">Your Phone*</label>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-wrap">
                      <label class="form-label rd-input-label" for="contact-message-5">Message</label>
                      <textarea class="form-input textarea-lg form-control-has-validation form-control-last-child" id="contact-message-5" name="message"></textarea><span class="form-validation"></span>
                    </div>
                  </div>
                </div>
                <div class="captcha mt-4">
                    <span>{!! app('captcha')->display() !!}</span>
                </div>
                <button class="button button-primary" type="button"><div class="content-original">Contact us</div><div class="content-dubbed">Contact us</div></button>
              </form>
            </div>
            <div class="col-lg-4">
              {{ view('frontend.aside_contacts') }}
            </div>
          </div>
        </div>
      </section> --}}

    <section class="section section-lg bg-default text-md-left">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-4 mb-lg-5">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <h1 class="h4">HEADQUARTERS</h1>
                            <div class="footer-classic-contacts">
                                <div class="footer-classic-contacts-item">
                                    <div class="unit unit-spacing-sm align-items-center">
                                        <div class="unit-left mb-0"><span
                                                class="icon icon-24 text-black mdi mdi-map-marker"></span></div>
                                        <div class="unit-body mb-0"><a class="phone" href="#"
                                                title="9 Caotang Road, Chengdu, Sichuan, P.R.China">9 Caotang Road, Chengdu,
                                                Sichuan, P.R.China</a></div>
                                    </div>
                                </div>
                                <div class="footer-classic-contacts-item">
                                    <div class="unit unit-spacing-sm align-items-center">
                                        <div class="unit-left mb-0"><span
                                                class="icon icon-24 text-black mdi mdi-phone"></span></div>
                                        <div class="unit-body mb-0"><a class="phone" href="tel:+86 28 87397141"
                                                title="Call +86 28 87397141">+86 28 87397141</a></div>
                                    </div>
                                </div>
                                <div class="footer-classic-contacts-item">
                                    <div class="unit unit-spacing-sm align-items-center">
                                        <div class="unit-left mb-0"><span class="icon text-black mdi mdi-email"></span>
                                        </div>
                                        <div class="unit-body mb-0"><a class="mail"
                                                href="mailto:{{ $shared_site_setting->email }}"
                                                title="Mail to {{ $shared_site_setting->email }}">{{ $shared_site_setting->email }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="footer-classic-contacts">
                                <div class="footer-classic-contacts-item">
                                    <div class="unit unit-spacing-sm align-items-center">
                                        <div class="map-padding_ position-relative w-100">
                                            <iframe class="my-map w-100" src="{{ $shared_site_setting->head_office_map }}"
                                                width="100%" height="250px" style="border:0;" allowfullscreen=""
                                                loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                            <div class="overlay"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <h1 class="h4">Nepal branch</h1>
                            <div class="footer-classic-contacts">
                                <div class="footer-classic-contacts-item">
                                    <div class="unit unit-spacing-sm align-items-center">
                                        <div class="unit-left mb-0"><span
                                                class="icon icon-24 text-black mdi mdi-map-marker"></span></div>
                                        <div class="unit-body mb-0"><a class="phone" href="#"
                                                title="{{ $shared_site_setting->address }}">{{ $shared_site_setting->address }}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer-classic-contacts-item">
                                    <div class="unit unit-spacing-sm align-items-center">
                                        <div class="unit-left mb-0"><span
                                                class="icon icon-24 text-black mdi mdi-phone"></span></div>
                                        <div class="unit-body mb-0"><a class="phone"
                                                href="tel:{{ $shared_site_setting->phone_no }}"
                                                title="Call {{ $shared_site_setting->phone_no }}">{{ $shared_site_setting->phone_no }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="footer-classic-contacts">
                                <div class="footer-classic-contacts-item">
                                    <div class="unit unit-spacing-sm align-items-center">
                                        <div class="map-padding_ position-relative w-100">
                                            <iframe class="my-map w-100" src="{{ $shared_site_setting->google_map }}"
                                                width="100%" height="250px" style="border:0;" allowfullscreen=""
                                                loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                            <div class="overlay"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row row-60 justify-content-center">
                <div class="col-lg-8">
                    <h4 class="text-spacing-25 text-transform-none mb-3 wow fadeIn" data-wow-duration="1s"
                        data-wow-delay=".3s"><b>Contact Us</b></h4>
                    <h6 class="text-spacing-25 text-transform-none wow fadeIn" data-wow-duration="1s">
                        Get in Touch</h6>

                    <div id="success-message" class="alert alert-success"
                        style="display: none; background-color: #d4edda; color: #155724;">
                        <button type="button" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <span id="success-message-text"></span>
                    </div>
                    <div id="error-message" class="alert alert-danger" style="display: none; color: red"></div>

                    <form id="contact-form" class="rd-form rd-mailform wow fadeIn" data-wow-duration="1s"
                        action="{{ route('contact.store') }}" method="post">
                        @csrf
                        <div class="row row-20 gutters-20">
                            <div class="col-md-6">
                                <div class="form-wrap">
                                    <label for="name">Your Name <span style="color: red;">*</span></label>
                                    <input class="form-input" id="name" placeholder="Enter your name"
                                        type="text" name="name" value="{{ old('name') }}">
                                    <span class="form-validation text-danger" id="name-error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-wrap">
                                    <label for="email">Your Email <span style="color: red;">*</span></label>
                                    <input class="form-input" id="email" placeholder="Enter your email"
                                        type="email" name="email" value="{{ old('email') }}">
                                    <span class="form-validation text-danger" id="email-error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-wrap">
                                    <label for="email">Your Phone No. <span style="color: red;">*</span></label>
                                    <input class="form-input" id="phone" placeholder="Enter your phone no."
                                        type="text" name="phone" value="{{ old('phone') }}">
                                    <span class="form-validation text-danger" id="phone-error"></span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-wrap">
                                    <label for="email">Your Message <span style="color: red;">*</span></label>
                                    <textarea class="form-input textarea-lg form-control-last-child" id="message" placeholder="Enter your message"
                                        name="message">{{ old('message') }}</textarea>
                                    <span class="form-validation text-danger" id="message-error"></span>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-wrap captcha mt-4">
                                    <div>{!! app('captcha')->display() !!}</div>
                                </div>
                                <span class="form-validation text-danger col-12 pl-4"
                                    id="g-recaptcha-response-error"></span>

                            </div>
                        </div>
                        <button class="button button-primary" type="submit">
                            Contact us
                        </button>
                    </form>
                </div>
                <div class="col-lg-4">
                    <!-- {{ view('frontend.aside_contacts') }} -->
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        $(document).ready(function() {
            $('#contact-form').on('submit', function(e) {
                e.preventDefault();
                $('#success-message').hide();
                $('#error-message').hide();
                $('.form-validation').html('');
                $('.form-input').removeClass('is-invalid');

                // Disable the submit button
                var $submitButton = $(this).find('button[type="submit"]');
                $submitButton.prop('disabled', true);

                var formData = $(this).serialize();

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        //$('#success-message-text').html(response.success);
                        //$('#success-message').show();
                        $('#contact-form')[0].reset();
                        grecaptcha.reset(); // Reset reCAPTCHA

                        window.location.href = '/contact-confirm';
                    },
                    error: function(xhr) {
                        // Re-enable the submit button on error
                        $submitButton.prop('disabled', false);

                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            var firstErrorElement = null;

                            for (var key in errors) {
                                if (errors.hasOwnProperty(key)) {
                                    if (key === 'g-recaptcha-response') {
                                        $('#g-recaptcha-response-error').html(errors[key][0])
                                            .css('font-size', '14px');
                                    } else {
                                        $('#' + key + '-error').html(errors[key][0]).css(
                                            'font-size', '14px');
                                        var inputElement = $('input[name=' + key +
                                            '], textarea[name=' + key + ']');
                                        inputElement.addClass('is-invalid');

                                        if (!firstErrorElement) {
                                            firstErrorElement = inputElement;
                                        }
                                    }
                                }
                            }
                            if (firstErrorElement) {
                                $('html, body').animate({
                                    scrollTop: firstErrorElement.offset().top - 120
                                }, 500);
                            }
                        } else {
                            $('#error-message').html(
                                    'An error occurred. Please try again later.')
                                .show();
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
