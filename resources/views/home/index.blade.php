@extends('frontend.layout')
@section('content')
    <div class="home-section-container home-desktop" data-label="desktop-page" id="homepage">
        <!-- Slider main container -->

        <div class="swiper mySwiper">
            <div class="swiper mySwiper" id="mySwiper_1">
                <div class="swiper-wrapper" >

                    @foreach ($slider as $key => $sliders)

                        @if ($sliders->youtube_url != null)
                    <div class="swiper-slide">


                        <iframe id="my_slider_video" class="video-home"
                        src="{{ $sliders->youtube_url}}?controls=0" title="YouTube video player" style="object-fit: fill;width: 100%;height: 75vh;"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>

{{--
                           <video id="myVideo" loop autoplay muted style="object-fit: fill;width: 100%;height: 90vh;">
                            <source src="{{ asset('assets/frontend/video/sidd_video.mp4') }}"
                    type="video/mp4">
                            <source src={{$sliders->youtube_url}}>
                    Your browser does not support the video tag.
                    </video> --}}

                </div>

                 @endif

                    @endforeach

                    @foreach ($slider as $key => $sliders)

                        @if ($sliders->slider_type == 'banner')
                        @if ($sliders->main_image != null)
                            <div class="swiper-slide">
                                {{-- <img alt="slider" class="img-fluid w-100" id="slider-img"
                                    src="{{ asset('storage/uploads/main_image/' . $sliders->main_image) }}"> --}}
                                    <picture>
                                        <source media="(min-width:1920px)" srcset="{{ asset('/storage/uploads/main_image/' . $sliders->main_image) }}" />
                                        <source media="(min-width:1200px)" srcset="{{ asset('/storage/uploads/main_image/thumbnail/large_' . $sliders->main_image) }}" />
                                        <source media="(min-width:992px)" srcset="{{ asset('/storage/uploads/main_image/thumbnail/medium_' . $sliders->main_image) }}" />
                                        <source media="(min-width:768px)" srcset="{{ asset('/storage/uploads/main_image/thumbnail/small_' . $sliders->main_image) }}" />


                                        <img src="{{ asset('/storage/uploads/mobile_image/' . $sliders->mobile_image) }}" alt="Image" >
                                    </picture>
                                {{-- <img alt="slider" class="d-block w-100"
                                src="{{ asset('assets/frontend/img/5a.png') }}" alt="First
                        slide"> --}}
                            @if (!empty($sliders->caption_description || $sliders->name))
                                <p class="text-slider bg-gradient bg-dark p-3"><span style="font-size:20px; ">{{ $sliders->name }} </span><br>
                                    <span>{{ $sliders->caption_description }}</span>
                                </p>
                            @endif

                            </div>
                        @endif

                        @endif
                    @endforeach
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
        @if ($site_setting->show_ticket == '1')
            {{-- @dd($site_setting) --}}
            <div class="booking-area" >
                <div class="container ticket-container">
                    <img class="text-center ticket-img" src="{{ asset('assets/frontend/img/ticket-coming.png') }}"
                        alt="ticket">
                        <div class="bottom-right">
                            <a href="{{$site_setting->ticket_url}}" target="_blank"
                                class="btn btn-primary btn-ticket-home text-uppercase">Buy your ticket now</a>
                        </div>
                </div>
            </div>
        @endif
        {{-- first section --}}
        <div class="fade nuwakot-section bg-white mt-3 pt-4 mb-4 pb-5">
            <section class="container">
                @php
                    $get_lang = Session::get('locale');
                @endphp
                <div class="row">
                    <div class="col-md-6">
                        <iframe id="myVideo" class="video-home" height="330"
                            src="{{ $site_setting->youtube }}?controls=0" title="YouTube video player" style="border:0;"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                    </div>
                    <div class="col-md-6" style="padding-top: 6px;padding-left: 40px;">
                        <div class="first-title">
                            <h1 class="main-title" style="margin-bottom:2.25rem;">
                                <span>{{ __('message.about_siddhartha') }}
                                </span></h1>
                            {{-- <h4 class="bold-text" style="color:#FE6600;font-size:18px;margin-top:2.5rem;">
                       {{ __('message.about-the-ride') }}</h4> --}}
                            @if ($get_lang == 'en')
                                {!! $site_setting->home_about_us !!}
                            @endif
                            @if ($get_lang == 'np')
                                {!! $site_setting->nepali_home_about_us !!}
                            @endif
                            {{-- </ul> --}}

                            <div class="mt-5 pt-4" style="text-align: right;">
                                <a class="btn btn-secondary  px-3"
                                    href="https://siddharthacablecar.com.np/introduction-to-the-project">{{ __('message.show_more') }}</a>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>


        <div class="fade how mt-4 py-5" style="background-color: #ebb71f;">
            <div class="text-center">
                <h2 class="main-title">{{ __('message.how_to_reach') }}</h2>
            </div>
            <div class="container text-center">
                <div>
                    <div class="map-container" id="map"></div>
                    <!-- <img style="width:60%;" src="{{ asset('assets/frontend/img/final-map.png') }}"
                    alt="map"> -->
                </div>
            </div>
        </div>

        {{-- second section --}}
        <div class=" facilities-section mt-3 pt-5 mb-4 pb-4" style="background-color: #fff;">
            <div class="fade container">
                <div class="row">
                    <div class=" col-md-12 text-center">
                        <div class="first-title ">
                            <h2 class="main-title ">{{ __('message.our_facilites') }}</h2>

                        </div>
                    </div>
                </div>
                <div class="row place-img  mt-5">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="d-flex align-items-lg-stretch mb-4 col-lg-3 facility-container">
                                <a href="{{ route('our.facilities', 'lotus-garden') }}">
                                    <div class="img-overlay">
                                        <img class="img-overlay-image card top-facility-square border-0  facility-image-1 image-zoom"
                                            src="{{ asset('assets/frontend/img/lotus1.png') }}" alt="lotus">
                                        <div class="overlay">
                                            <div class="text">
                                                <h5 class="facility-text">{{ __('message.lotus_garden') }}
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="d-flex align-items-lg-stretch mb-4 col-lg-3 facility-container">
                                <a href="{{ route('our.facilities', 'outdoor-sitting-area') }}">
                                    <div class="img-overlay">
                                        <img class="img-overlay-image card top-facility-square border-0  facility-image-1"
                                            src="{{ asset('assets/frontend/img/outdoor.png') }}" alt="outdoor">
                                        <div class="overlay">
                                            <div class="text">
                                                <h5 class="facility-text">{{ __('message.outdoor') }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="d-flex align-items-lg-stretch mb-4 col-lg-6 facility-container">
                                <a href="{{ route('our.facilities', 'cable-car') }}">
                                    <div class="img-overlay">
                                        <img class="card top-facility-landscape border-0 w-100 facility-image"
                                            src="{{ asset('assets/frontend/img/cable2.png') }}" alt="cable car">
                                        <div class="overlay">
                                            <div class="text">
                                                <h5 class="facility-text">{{ __('message.cable-car') }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="d-flex align-items-lg-stretch mb-4 col-lg-6 facility-container">
                                <a href="{{ route('our.facilities', 'parking-area') }}">
                                    <div class="img-overlay">
                                        <img class="card top-facility-landscape border-0  w-100 facility-image"
                                            src="{{ asset('assets/frontend/img/parking-front.jpg') }}" alt="parking">


                                        <div class="overlay">
                                            <div class="text">
                                                <h5 class="facility-text">{{ __('message.parking-area') }}
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="d-flex align-items-lg-stretch mb-4 col-lg-3 facility-container">
                                <a href="{{ route('our.facilities', 'restaurant') }}">
                                    <div class="img-overlay">
                                        <img class="img-overlay-image card top-facility-square border-0  facility-image-1"
                                            src="{{ asset('assets/frontend/img/res.png') }}" alt="restaurant">
                                        <div class="overlay">
                                            <div class="text">
                                                <h5 class="facility-text">{{ __('message.restaurant') }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="d-flex align-items-lg-stretch mb-4 col-lg-3 facility-container">
                                <a href="{{ route('our.facilities', 'dhungedhara') }}">
                                    <div class="img-overlay">
                                        <img class="img-overlay-image card top-facility-square border-0  facility-image-1"
                                            src="{{ asset('assets/frontend/img/dhunga.png') }}" alt="dhungedhara">
                                        <div class="overlay">
                                            <div class="text">
                                                <h5 class="facility-text">{{ __('message.dhungedhara') }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="fade attraction-section mt-3 pt-4 mb-4 pb-5" style="background-color: #fffdf0;"  id="attraction-section">
            <div class="first-title  text-center">
                {{-- <span class="unique-text text-center">{{ __('message.popular') }}</span>
        <br> --}}
                <h2 class="main-title  mb-3"><span class="text-center">{{ __('message.tourist_attractions') }}</span>
                </h2>
            </div>
            <div class="container  mt-5">
                <div class="slider">
                    @if ($get_lang == 'en')
                        @foreach ($page as $items)
                            @foreach ($items->pages as $item)
                                <div>
                                    <a class="tile-link" href="{{ route('introduction.about', $item->page_slug) }}"><img
                                            style="border-radius:3px; height: 196px;object-fit: cover;" class="w-100"
                                            src="{{ asset('/storage/uploads/mobile_image/' . $item->mobile_image) }}"
                                            alt="package image1"></a>
                                    <a class="tile-link" href="{{ route('introduction.about', $item->page_slug) }}">
                                        <p class="text-center mt-3 place-name">{{ $item->name }}</p>
                                    </a>

                                </div>
                            @endforeach
                        @endforeach
                    @endif
                    @if ($get_lang == 'np')
                        @foreach ($page as $items)
                            @foreach ($items->pages as $item)
                                <div>
                                    <a class="tile-link" href="{{ route('introduction.about', $item->page_slug) }}"><img
                                            style="border-radius:3px; height: 196px;object-fit: cover;" class="w-100"
                                            src="{{ asset('/storage/uploads/mobile_image/' . $item->mobile_image) }}"
                                            alt="package image2"></a>
                                    <a class="tile-link" href="{{ route('introduction.about', $item->page_slug) }}">
                                        <h6 class="text-center mt-3 place-name">{{ $item->nepali_name }}</h6>
                                    </a>
                                </div>
                            @endforeach
                        @endforeach
                    @endif
                </div>
            </div>
        </div>





        {{-- third-section --}}
        <div class="fade third-section bg-white mb-5" id="banner">
            <section class="email-banner">
                <div class="container pb-0">
                    <form method="POST" enctype="multipart/form-data" action="{{ route('newsletter.store') }}">
                        @csrf
                        @method('post')
                        <div class="home-s-w">
                            <div>
                                <img style="width:54%;padding-left: 22px;"
                                    src="{{ asset('assets/frontend/img/icon-cable.png') }}" alt="icon">
                            </div>
                            <div style="margin-left: -5em;">
                                <h3 class="message-keep-up">{{ __('message.keep_up') }}
                                    <br>{{ __('message.latest_news') }}
                                </h3>
                                {{-- <p>With the siddhartha cable car newsletter</p> --}}
                            </div>

                            <div style="margin-left: 4em;">
                                <input style="width:300px;" type="text" class="form-control"
                                    placeholder="{{ __('message.placeholder_email') }}" name="email">
                                @if ($errors->has('email'))
                                    <span style="color:rgb(68, 75, 173);">{{ $errors->first('email') }}</span>
                                @endif
                                <div class="captcha mt-2">
                                    <div>{!! app('captcha')->display() !!}</div>
                                    {{-- <button type="button" class="btn btn-success refresh-cpatcha"><i class="fa fa-refresh"></i></button> --}}
                                </div>

                                @error('g-recaptcha-response')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                            </div>
                            <div style="margin-right: 40px;margin-top: 80px;">
                                <button type="submit"
                                    class="btn btn-secondary px-4">{{ __('message.sign_up') }}</button>
                            </div>
                        </div>
                    </form>
                </div>


                <!-- Modal -->
                @include('home.ticket-rate')
            </section>

            {{-- <div class="promo-container">
           Slider main container
            <div class="swiper-container  promo-section">
              Additional required wrapper
                <div class="swiper-wrapper promo-wrapper">
@foreach ($slider as $sliders)
@if ($sliders->slider_type == 'promo')
                    <div class="swiper-slide promo-slide "><img
                            src="{{ asset('/storage/uploads/main_image/'.$sliders->main_image) }}"
    alt="promo1">
</div>
@endif
@endforeach
</div>
If we need navigation buttons
<div class="swiper-button-prev promo-button-prev"></div>
<div class="swiper-button-next promo-button-next"></div>

</div>
</div> --}}
        </div>


    </div>


    {{-- Mobile display --}}
    <div class="home-section-container home-mobile" data-label="mobile-page" id="homepage1">

        <!-- Slider main container -->
        <div class="swiper mySwiper" id="mySwiper_1">
            <div class="swiper-wrapper">
                @foreach ($slider as $sliders)
                    @if ($sliders->slider_type == 'banner')
                        <div class="swiper-slide">
                            <img class="d-block w-100" id="slider-img"
                                src="{{ asset('/storage/uploads/mobile_image/' . $sliders->mobile_image) }}"
                                alt="First slide">
                                @if (!empty($sliders->caption_description || $sliders->name))
                                <p class="text-slider bg-gradient bg-dark p-3"><span style="font-size:20px; ">{{ $sliders->name }} </span><br>
                                    <span>{{ $sliders->caption_description }}</span>
                                </p>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>

        @if ($site_setting->show_ticket == '1')
            <div class="booking-area">
                <div class="container " style="    margin-top: 1.5rem;

    z-index: 999;">
                    <img class="text-center" style="width:100%;" src="{{ asset('assets/frontend/img/mob-coming.png') }}"
                        alt="ticket-mob">
                    <div class="text-center bottom-rightmob">
                        <a href="https://siddharthacablecar.com.np/coming-soon"
                            class="btn btn-primary btn-ticket-home text-uppercase">Buy your ticket now</a>
                    </div>
                </div>
            </div>
        @endif

        <div class="nuwakot-section bg-white " style="margin-top: 1rem">
            <section class="container">
                @php
                    $get_lang = Session::get('locale');
                @endphp
                <div class="row">
                    <div class="col-md-6">
                        <iframe id="myVideo1" class="video-home" height="330"
                            src="{{ $site_setting->youtube }}?controls=0" title="YouTube video player" style="border:0;"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                    </div>
                    <div class="col-md-6">
                        <div class="first-title  mt-3">
                            <h2 class="text-center main-title">
                                <span>{{ __('message.about_siddhartha') }}
                                </span>
                            </h2>


                            <div class="text-center">
                                @if ($get_lang == 'en')
                                    {!! $site_setting->home_about_us !!}
                                @endif
                                @if ($get_lang == 'np')
                                    {!! $site_setting->nepali_home_about_us !!}
                                @endif
                            </div>

                            {{-- </ul> --}}

                            <div class="mt-4 mb-4" style="text-align: center;">
                                <a class="btn btn-secondary  px-3"
                                    href="https://siddharthacablecar.com.np/introduction-to-the-project">{{ __('message.show_more') }}</a>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div class="fade how mt-5 py-5" style="background-color: #ebb71f;">
            <div class="text-center">
                <h2 class="main-title">{{ __('message.how_to_reach') }}</h2>
            </div>
            <div class="container text-center">
                <div class="map-container" id="map-mobile"></div>
                <!-- <div>
                    <img style="width:100%;" src="{{ asset('assets/frontend/img/final-map.png') }}"
                        alt="map mob">
                </div> -->
            </div>
        </div>

        {{-- second section --}}
        <div class="second-part mt-3" style="background-color: #fff;">
            <section class="container">
                <div class="row">
                    <div class=" col-md-12 text-center">
                        <div class="first-title ">
                            <h2 class="main-title pb-3">{{ __('message.our_facilites') }}</h2>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="d-flex align-items-lg-stretch mb-4 col-6 col-lg-2 col-sm-3 facility-container">
                                <a href="{{ route('our.facilities', 'lotus-garden') }}">
                                    <div class="img-overlay">
                                        <img class="img-overlay-image card top-facility-square border-0 w-100 facility-image-1"
                                            src="{{ asset('assets/frontend/img/lotus1.png') }}" alt="lotus img">
                                        <div class="overlay">
                                            <div class="text">
                                                <h5 class="facility-text">{{ __('message.lotus_garden') }}
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="d-flex align-items-lg-stretch mb-4 col-6 col-lg-2 col-sm-3 facility-container">
                                <a href="{{ route('our.facilities', 'outdoor-sitting-area') }}">
                                    <div class="img-overlay">
                                        <img class="img-overlay-image card top-facility-square border-0 w-100 facility-image-1"
                                            src="{{ asset('assets/frontend/img/5a.png') }}" alt="outdoor img">
                                        <div class="overlay">
                                            <div class="text">
                                                <h5 class="facility-text">{{ __('message.outdoor') }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="d-flex align-items-lg-stretch mb-4 col-lg-6 facility-container">
                                <a href="{{ route('our.facilities', 'cable-car') }}">
                                    <div class="img-overlay">
                                        <img class="card top-facility-landscape border-0 w-100 facility-image"
                                            src="{{ asset('assets/frontend/img/cable.png') }}" alt="cable img">
                                        <div class="overlay">
                                            <div class="text">
                                                <h5 class="facility-text">Cable Car</h5>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="d-flex align-items-lg-stretch mb-4 col-lg-6 facility-container">
                                <a href="{{ route('our.facilities', 'parking-area') }}">
                                    <div class="img-overlay">
                                        <img class="card top-facility-landscape border-0 w-100 facility-image"
                                            src="{{ asset('assets/frontend/img/parking-front.jpg') }}" alt="parking img">
                                        <div class="overlay">
                                            <div class="text">
                                                <h5 class="facility-text">Parking Area</h5>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                        </div>
                        <div class="row">
                            <div class="d-flex align-items-lg-stretch mb-4 col-6 col-lg-2 col-sm-3 facility-container">
                                <a href="{{ route('our.facilities', 'restaurant') }}">
                                    <div class="img-overlay">
                                        <img class="img-overlay-image card top-facility-square border-0 w-100 facility-image-1"
                                            src="{{ asset('assets/frontend/img/img1.jpg') }}" alt="restaurant-img">
                                        <div class="overlay">
                                            <div class="text">
                                                <h5 class="facility-text">{{ __('message.restaurant') }}
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="d-flex align-items-lg-stretch mb-4 col-6 col-lg-2 col-sm-3 facility-container">
                                <a href="{{ route('our.facilities', 'dhungedhara') }}">
                                    <div class="img-overlay">
                                        <img class="img-overlay-image card top-facility-square border-0 facility-image-1"
                                            src="{{ asset('assets/frontend/img/9.jpg') }}" alt="dhungedhara img">
                                        <div class="overlay">
                                            <div class="text">
                                                <h5 class="facility-text">{{ __('message.dhungedhara') }}
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        {{-- first section --}}
        <div class="fade attraction-section mb-2 pb-5 pt-2" style="background-color: #fffdf0;">
            <div class="first-title  text-center">
                {{-- <span class="unique-text text-center">{{ __('message.popular') }}</span>
            <br> --}}
                <h2 class="main-title  mb-3"><span class="text-center">{{ __('message.tourist_attractions') }}</span>
                </h2>
            </div>
            <div class="container  mt-4">
                <div class="slider">
                    @if ($get_lang == 'en')
                        @foreach ($page as $items)
                            @foreach ($items->pages as $item)
                                <div>
                                    <a class="tile-link" href="{{ route('introduction.about', $item->page_slug) }}"><img
                                            style="border-radius:3px; height: 196px;object-fit: cover;" class="w-100"
                                            src="{{ asset('/storage/uploads/mobile_image/' . $item->mobile_image) }}"
                                            alt="package img"></a>
                                    <a class="tile-link" href="{{ route('introduction.about', $item->page_slug) }}">
                                        <h6 class="text-center mt-3 place-name">{{ $item->name }}</h6>
                                    </a>
                                    {{-- <span class="desc-place">{!! $item->description !!}</span> --}}
                                    {{-- <div class="text-center mt-3">
                    <a class="read-more" href="{{ route('introduction.about',$item->page_slug) }}">Read
                                More
                                </a>
                            </div> --}}
                                </div>
                            @endforeach
                        @endforeach
                    @endif
                    @if ($get_lang == 'np')
                        @foreach ($page as $items)
                            @foreach ($items->pages as $item)
                                <div>
                                    <a class="tile-link" href="{{ route('introduction.about', $item->page_slug) }}"><img
                                            style="border-radius:3px; height: 196px;object-fit: cover;" class="w-100"
                                            src="{{ asset('/storage/uploads/mobile_image/' . $item->mobile_image) }}"
                                            alt="package img1"></a>
                                    <a class="tile-link" href="{{ route('introduction.about', $item->page_slug) }}">
                                        <h6 class="text-center mt-3 place-name">{{ $item->nepali_name }}</h6>
                                    </a>
                                    {{-- <span class="desc-place">{!! $item->description !!}</span> --}}
                                    {{-- <div class="text-center mt-3">
                    <a class="read-more" href="{{ route('introduction.about',$item->page_slug) }}">Read
                            More
                            </a>
                        </div> --}}
                                </div>
                            @endforeach
                        @endforeach
                    @endif
                </div>
            </div>
        </div>


        {{-- third-section --}}
        <div class="third-section bg-white">
            <section class="email-banner">
                <div class="container pb-0">

                    <form method="POST" enctype="multipart/form-data" action="{{ route('newsletter.store') }}">
                        @csrf
                        @method('post')
                        <div class="home-s-mob">
                            <div class="img-cable text-center">
                                <img style="width: 25%;padding-top: 14px;"
                                    src="{{ asset('assets/frontend/img/icon-cable.png') }}" alt="icon-cable">
                            </div>
                            <div class="text-center mt-3" style="color: #333333;">
                                <h3 class="message-keep-up">{{ __('message.keep_up') }}
                                    {{ __('message.latest_news') }}</h3>
                                {{-- <p>With the siddhartha cable car newsletter</p> --}}
                            </div>
                            <div class="text-center mt-3" style="color: #333333;">
                                <input style="width: 300px;height: 50px;
                    " type="text"
                                    name="email" placeholder="Email Address">
                                @if ($errors->has('email'))
                                    <span style="color:rgb(68, 75, 173);">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="form-group mt-3"
                                style="
                    text-align: -webkit-center;
                ">
                                <div class="captcha mx-3">
                                    <div>{!! app('captcha')->display() !!}</div>
                                    {{-- <button type="button" class="btn btn-success refresh-cpatcha"><i class="fa fa-refresh"></i></button> --}}
                                </div>

                                @error('g-recaptcha-response')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="text-center mt-3 pb-4 mb-3">
                                <button type="submit"
                                    class="btn btn-secondary px-3">{{ __('message.sign_up') }}</button>
                            </div>
                        </div>
                    </form>

                </div>
                <!-- Modal -->
                @include('home.ticket-rate-mob')
            </section>
        </div>
    </div>

@endsection

