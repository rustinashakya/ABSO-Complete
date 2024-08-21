@extends('frontend.layouts.master')

@section('content')
    @php
        $meta_description = $shared_site_setting->meta_description ?? 'QYEC';
        $html_title = $shared_site_setting->html_title ?? 'QYEC';
        $meta_keyword = $shared_site_setting->meta_keyword ?? 'QYEC';
        $favicon_url = asset('frontend/images/QYEC-logo.png');
        $page_url = url()->current();
    @endphp
    <!-- <div class="position-relative d-none">
            <div class="swiper-slide context-dark my-video-w">
                <iframe width="" class="w-100 my-video" height="315"
                    src="https://www.youtube.com/embed/ClIHBxMGSdk?si=VJAkF2ImgMWvc_wB?rel=0&amp;autoplay=1&mute=1&controls=0&loop=1"
                    title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                <div class="swiper-slide-caption section-md text-sm-left">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-8 col-md-7 col-xl-6 offset-lg-1 offset-xxl-0">
                                <h3 class="oh swiper-title"><span class="d-inline-block" data-caption-animate="slideInLeft"
                                        data-caption-delay="100">Welcome to QYEC</span></h3>
                                <h5 class="swiper-subtitle" data-caption-animate="fadeInUp" data-caption-delay="0">Leading civil
                                    engineering company</h5>
                                <div class="button-wrap oh"><a
                                        class="button button-lg button-primary button-winona button-shadow-2" href="#"
                                        data-caption-animate="slideInLeft" data-caption-delay="100">View more</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    <!-- Swiper-->
    <section class="section swiper-container swiper-slider swiper-slider-2" style="min-height: 0;"
        data-swiper='{"effect":"fade","loop":"false","simulateTouch":"false","pagination":{"el":".swiper-pagination","clickable":false}}'>
        <div class="swiper-wrapper text-sm-left">
            <!-- <div class="swiper-slide context-dark">
                    <video width="" height="" class="w-100 position-absolute " autoplay loop muted>
                      <source src="./video/hydro.mp4" type="video/mp4">
                      Your browser does not support the video tag.
                    </video>
                    <div class="swiper-slide-caption section-md">
                      <div class="container">
                        <div class="row">
                          <div class="col-sm-8 col-md-7 col-xl-6 offset-lg-1 offset-xxl-0">
                            <h3 class="oh swiper-title"><span class="d-inline-block" data-caption-animate="slideInLeft" data-caption-delay="100">Welcome to QYEC</span></h3>
                            <h5 class="swiper-subtitle" data-caption-animate="fadeInUp" data-caption-delay="0">Leading civil engineering company</h5>
                            <div class="button-wrap oh"><a class="button button-lg button-primary button-winona button-shadow-2" href="#" data-caption-animate="slideInLeft" data-caption-delay="100">View more</a></div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div> -->
            @foreach ($banners as $banner)
                <div class="swiper-slide context-dark">
                    <picture>
                        <source media="(max-width:767px)"
                            srcset="{{ asset('storage/uploads/slider/mobile_image/' . $banner->mobile_image) }}">
                        <img src="{{ asset('storage/uploads/slider/main_image/' . $banner->main_image) }}"
                            alt="{{ $banner->name }}" class="img-fluid w-100 mt-0">
                    </picture>
                    <div class="swiper-slide-caption section-md position-absolute">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-8 col-md-7 col-xl-6 offset-lg-1 offset-xxl-0">
                                    <h3 class="oh swiper-title"><span class="d-inline-block"
                                            data-caption-animate="slideInLeft" data-caption-delay="100">
                                            {{ $banner->name }}
                                        </span></h3>
                                    <h5 class="swiper-subtitle" data-caption-animate="fadeInUp" data-caption-delay="0">
                                        {{ $banner->caption_description }}
                                    </h5>
                                    @if (!empty($banner->url))
                                        <div class="button-wrap oh">
                                            <a title="View more"
                                                class="button button-sm button-primary button-winona button-shadow-2"
                                                href="{{ $banner->url }}" data-caption-animate="slideInLeft"
                                                data-caption-delay="100">View more</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <!-- <div class="swiper-slide context-dark" data-slide-bg="{{ asset('frontend/images/3-banner-image.png') }}">
                    <div class="swiper-slide-caption section-md">
                      <div class="container">
                        <div class="row">
                          <div class="col-sm-8 col-md-7 col-lg-6 offset-lg-1 offset-xxl-0">
                            <h3 class="oh swiper-title"><span class="d-inline-block" data-caption-animate="slideInUp" data-caption-delay="0">Best performance over the years</span></h3>
                            <h5 class="swiper-subtitle" data-caption-animate="fadeInLeft" data-caption-delay="300">We are the award-winning industry leaders</h5><a title="View more" class="button button-sm button-primary button-winona button-shadow-2" href="{{ route('page', 'about-us') }}" data-caption-animate="fadeInUp" data-caption-delay="300">View more</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide context-dark" data-slide-bg="{{ asset('frontend/images/4-banner-image.png') }}">
                    <div class="swiper-slide-caption section-md">
                      <div class="container">
                        <div class="row">
                          <div class="col-sm-9 col-md-8 col-xl-6 offset-lg-1 offset-xxl-0">
                            <h3 class="oh swiper-title"><span class="d-inline-block" data-caption-animate="slideInDown" data-caption-delay="0">trusted industry leader</span></h3>
                            <h5 class="swiper-subtitle" data-caption-animate="fadeInRight" data-caption-delay="300">High-quality civil engineering projects</h5>
                            <div class="button-wrap oh"><a title="View more" class="button button-sm button-primary button-winona button-shadow-2" href="{{ route('page', 'about-us') }}" data-caption-animate="slideInUp" data-caption-delay="0">View more</a></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div> -->
        </div>
        <!-- Swiper Pagination-->
        <div class="swiper-pagination d-none " data-bullet-custom="true"></div>
        <!-- Swiper Navigation-->
        <div class="swiper-button-prev d-none ">
            <div class="preview">
                <div class="preview__img"></div>
            </div>
            <div class="swiper-button-arrow"></div>
        </div>
        <div class="swiper-button-next d-none ">
            <div class="swiper-button-arrow"></div>
            <div class="preview">
                <div class="preview__img"></div>
            </div>
        </div>
    </section>

    @if (count($shared_sectors) >= 1)
        <section class="section section-lg bg-default">
            <div class="container">
                <h2 class="oh-desktop h3"><span class="d-inline-block wow slideInDown">Our Sectors</span></h2>
                <div class="owl-carousel owl-style-3 dots-style-2 my-sector" data-items="1" data-sm-items="2"
                    data-lg-items="3" data-margin="30" data-autoplay="true" data-dots="false"
                    data-animation-in="fadeIn" data-animation-out="fadeOut">
                    @foreach ($shared_sectors as $key => $sector)
                        <article class="services-creative h-100"><a class="services-creative-figure" title="View details"
                                href="{{ route('sector', $sector->slug) }}">
                                <img class="lazy"
                                    data-src="{{ asset('storage/uploads/sectors/mobile_image/' . $sector->mobile_image) }}"
                                    alt="{{ $sector->name }}" width="370" height="230" /></a>
                            <div class="services-creative-caption">
                                <h5 class="services-creative-title"><a title="View details"
                                        href="{{ route('sector', $sector->slug) }}">{{ $sector->name }}</a></h5>
                                <p class="services-creative-text">{{ strip_tags($sector->description) }}</p>
                                <!-- <span class="services-creative-counter box-ordered-item">
                                    @if ($key < 11)
    0{{ $key + 1 }}
@else
    {{ $key + 1 }}
    @endif
                                </span> -->
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Section CTA-->
    <!-- <section class="section parallax-container" data-parallax-img="images/backgroung_building.png"> -->
    <section class="section my-cta position-relative">
        <img src="{{ asset('frontend/images/Banner-1.jpg') }}" alt="" class="img-fluid cta-bgimg">
        <div class="parallax-content section-lg context-dark text-md-left">
            <div class="container">
                <div class="row">
                    <div class="col-sm-7 col-md-6 col-lg-5">
                        <div class="cta-classic">
                            <h2 class="cta-classic-title wow fadeInLeft h4">Creating efficient infrastructure since 1995
                            </h2>
                            <p class="cta-classic-text wow fadeInRight" data-wow-delay=".1s">We provide efficient civil
                                engineering solutions.</p>
                            <a class="button button-lg button-white button-winona wow fadeInUp" title="About QYEC"
                                href="{{ route('page', 'about-qyec') }}" data-wow-delay=".2s">About QYEC</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section section-xl bg-default text-center">
        <div class="container">
            <h2 class="oh-desktop h3"><span class="d-inline-block wow slideInUp">Completed Hydropower Projects</span></h2>
        </div>
        <div class="container-fluid container-inset-0">
            <div class="row row-30 row-desktop-8 gutters-8 hoverdir" data-lightgallery="group">
                @foreach ($hydropowerProjects as $project)
                    @php
                        $image = App\Models\ProjectImage::where('project_id', $project->id)
                            ->where('main_image', '!=', 'null')
                            ->first()->main_image;
                    @endphp
                    <div class="col-sm-6 col-lg-4">
                        <div class="oh-desktop">
                            <article class="thumbnail thumbnail-modern wow slideInUp hoverdir-item"
                                data-hoverdir-target=".thumbnail-modern-caption"><a class="thumbnail-modern-figure"
                                    href="{{ asset('/storage/uploads/project/main_image/thumbnail/home_h_' . $image) }}"
                                    data-lightgallery="item"><img class="lazy"
                                        data-src="{{ asset('/storage/uploads/project/main_image/thumbnail/home_h_' . $image) }}"
                                        alt="{{ $project->title }}" width="474" height="355" /></a>
                                <div class="thumbnail-modern-caption">
                                    <h5 class="thumbnail-modern-title"><a
                                            href="{{ route('project.details', $project->slug) }}"
                                            title="View details">{{ $project->title }}</a>
                                        <div class="home-kpis">
                                            <div class="fs-1"><b>Location</b>
                                                {{ @$project->projectKpis->location ?? '-' }}</div>
                                            <div class="fs-1"><b>Capacity</b>
                                                {{ @$project->projectKpis->capacity ?? '-' }}</div>
                                            <div class="fs-1"><b>Budget</b> {{ @$project->projectKpis->cost ?? '-' }}
                                            </div>
                                            <div class="fs-1"><b>Start Date</b>
                                                {{ @$project->projectKpis->construction_begins ? \Carbon\Carbon::parse(@$project->projectKpis->construction_begins)->format('F d, Y') : '-' }}
                                            </div>
                                            <div class="fs-1"><b>Completion Date</b>
                                                {{ @$project->projectKpis->end_date ? \Carbon\Carbon::parse(@$project->projectKpis->end_date)->format('F d, Y') : '-' }}
                                            </div>
                                        </div>
                                    </h5>
                                </div>
                            </article>
                        </div>
                    </div>
                @endforeach
                {{-- <div class="col-sm-6 col-lg-4">
                    <div class="oh-desktop">
                        <!-- Thumbnail Modern-->
                        <article class="thumbnail thumbnail-modern wow slideInUp hoverdir-item"
                            data-hoverdir-target=".thumbnail-modern-caption"><a class="thumbnail-modern-figure"
                                href="{{ asset('frontend/images/Sankeshu-Hydropower-Station_11zon.png') }}"
                                data-lightgallery="item"><img class="lazy"
                                    data-src="{{ asset('frontend/images/Sankeshu-Hydropower-Station_11zon.png') }}"
                                    alt="" width="474" height="355" /></a>
                            <div class="thumbnail-modern-caption">
                                <h5 class="thumbnail-modern-title">
                                    <a href="#">Sankeshu Hydropower Station</a>
                                    <div class="home-kpis mt-3">
                                        <div class="fs-1"><b>Location</b> China</div>
                                        <div class="fs-1"><b>Capacity</b> 100 MW</div>
                                        <div class="fs-1"><b>Budget</b> $10 Million</div>
                                        <div class="fs-1"><b>Start Date</b> Jan 10, 2023 </div>
                                        <div class="fs-1"><b>End Data</b> Jan 10, 2024</div>
                                    </div>
                                </h5>
                            </div>
                        </article>
                    </div>
                </div>
                 <div class="col-sm-6 col-lg-4">
                    <div class="oh-desktop">
                        <!-- Thumbnail Modern-->
                        <article class="thumbnail thumbnail-modern wow slideInDown hoverdir-item"
                            data-hoverdir-target=".thumbnail-modern-caption"><a class="thumbnail-modern-figure"
                                href="{{ asset('frontend/images/Guwa-Hydropower-Station_11zon') }}"
                                data-lightgallery="item"><img class="lazy"
                                    data-src="{{ asset('frontend/images/Guwa-Hydropower-Station_11zon.png') }}"
                                    alt="" width="474" height="355" /></a>
                            <div class="thumbnail-modern-caption">
                                <h5 class="thumbnail-modern-title"><a href="#">Guwa Hydropower Station</a>
                                    <div class="home-kpis mt-3">
                                        <div class="fs-1"><b>Location</b> China</div>
                                        <div class="fs-1"><b>Capacity</b> 100 MW</div>
                                        <div class="fs-1"><b>Budget</b> $10 Million</div>
                                        <div class="fs-1"><b>Start Date</b> Jan 10, 2023 </div>
                                        <div class="fs-1"><b>End Data</b> Jan 10, 2024</div>
                                    </div></h5>
                            </div>
                        </article>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="oh-desktop">
                        <!-- Thumbnail Modern-->
                        <article class="thumbnail thumbnail-modern wow slideInUp hoverdir-item"
                            data-hoverdir-target=".thumbnail-modern-caption"><a class="thumbnail-modern-figure"
                                href="{{ asset('frontend/images/Xieka-Hydropower-Station_11zon.png') }}"
                                data-lightgallery="item"><img class="lazy"
                                    data-src="{{ asset('frontend/images/Xieka-Hydropower-Station_11zon.png') }}"
                                    alt="" width="474" height="355" /></a>
                            <div class="thumbnail-modern-caption">
                                <h5 class="thumbnail-modern-title"><a href="#">Xieka Photovoltaic Power Station</a>
                                    <div class="home-kpis mt-3">
                                        <div class="fs-1"><b>Location</b> China</div>
                                        <div class="fs-1"><b>Capacity</b> 100 MW</div>
                                        <div class="fs-1"><b>Budget</b> $10 Million</div>
                                        <div class="fs-1"><b>Start Date</b> Jan 10, 2023 </div>
                                        <div class="fs-1"><b>End Data</b> Jan 10, 2024</div>
                                    </div>
                                </h5>
                            </div>
                        </article>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="oh-desktop">
                        <!-- Thumbnail Modern-->
                        <article class="thumbnail thumbnail-modern wow slideInDown hoverdir-item"
                            data-hoverdir-target=".thumbnail-modern-caption"><a class="thumbnail-modern-figure"
                                href="{{ asset('frontend/images/Xieka-Photovoltaic-Power-Station.png') }}"
                                data-lightgallery="item"><img class="lazy"
                                    data-src="{{ asset('frontend/images/Xieka-Photovoltaic-Power-Station.png') }}"
                                    alt="" width="474" height="355" /></a>
                            <div class="thumbnail-modern-caption">
                                <h5 class="thumbnail-modern-title"><a href="#">Xigu Photovoltaic Power Station</a>
                                    <div class="home-kpis mt-3">
                                        <div class="fs-1"><b>Location</b> China</div>
                                        <div class="fs-1"><b>Capacity</b> 100 MW</div>
                                        <div class="fs-1"><b>Budget</b> $10 Million</div>
                                        <div class="fs-1"><b>Start Date</b> Jan 10, 2023 </div>
                                        <div class="fs-1"><b>End Data</b> Jan 10, 2024</div>
                                    </div>
                                </h5>
                            </div>
                        </article>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="oh-desktop">
                        <!-- Thumbnail Modern-->
                        <article class="thumbnail thumbnail-modern wow slideInDown hoverdir-item"
                            data-hoverdir-target=".thumbnail-modern-caption"><a class="thumbnail-modern-figure"
                                href="{{ asset('frontend/images/Mayihe-Water-Conservancy-Project_11zon.png') }}"
                                data-lightgallery="item"><img class="lazy"
                                    data-src="{{ asset('frontend/images/Mayihe-Water-Conservancy-Project_11zon.png') }}"
                                    alt="" width="474" height="355" /></a>
                            <div class="thumbnail-modern-caption">
                                <h5 class="thumbnail-modern-title"><a href="#">Mayihe Water Conservancy Project</a>
                                    <div class="home-kpis mt-3">
                                        <div class="fs-1"><b>Location</b> China</div>
                                        <div class="fs-1"><b>Capacity</b> 100 MW</div>
                                        <div class="fs-1"><b>Budget</b> $10 Million</div>
                                        <div class="fs-1"><b>Start Date</b> Jan 10, 2023 </div>
                                        <div class="fs-1"><b>End Data</b> Jan 10, 2024</div>
                                    </div>
                                </h5>
                            </div>
                        </article>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="oh-desktop">
                        <!-- Thumbnail Modern-->
                        <article class="thumbnail thumbnail-modern wow slideInUp hoverdir-item"
                            data-hoverdir-target=".thumbnail-modern-caption"><a class="thumbnail-modern-figure"
                                href="{{ asset('frontend/images/Niangyong-Hydropower-Station.png') }}"
                                data-lightgallery="item"><img class="lazy"
                                    data-src="{{ asset('frontend/images/Niangyong-Hydropower-Station.png') }}"
                                    alt="" width="474" height="355" /></a>
                            <div class="thumbnail-modern-caption">
                                <h5 class="thumbnail-modern-title"><a href="#">Niangyong Hydropower Station</a>
                                    <div class="home-kpis mt-3">
                                        <div class="fs-1"><b>Location</b> China</div>
                                        <div class="fs-1"><b>Capacity</b> 100 MW</div>
                                        <div class="fs-1"><b>Budget</b> $10 Million</div>
                                        <div class="fs-1"><b>Start Date</b> Jan 10, 2023 </div>
                                        <div class="fs-1"><b>End Data</b> Jan 10, 2024</div>
                                    </div>
                            </div>
                        </article>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="oh-desktop">
                        <!-- Thumbnail Modern-->
                        <article class="thumbnail thumbnail-modern wow slideInDown hoverdir-item"
                            data-hoverdir-target=".thumbnail-modern-caption"><a class="thumbnail-modern-figure"
                                href="{{ asset('frontend/images/Wanbahe-1-Hydropower-Station_11zon.png') }}"
                                data-lightgallery="item"><img class="lazy"
                                    data-src="{{ asset('frontend/images/Wanbahe-1-Hydropower-Station_11zon.png') }}"
                                    alt="" width="474" height="355" /></a>
                            <div class="thumbnail-modern-caption">
                                <h5 class="thumbnail-modern-title"><a href="#">Wanbahe-1 Hydropower Station</a>
                                    <div class="home-kpis mt-3">
                                        <div class="fs-1"><b>Location</b> China</div>
                                        <div class="fs-1"><b>Capacity</b> 100 MW</div>
                                        <div class="fs-1"><b>Budget</b> $10 Million</div>
                                        <div class="fs-1"><b>Start Date</b> Jan 10, 2023 </div>
                                        <div class="fs-1"><b>End Data</b> Jan 10, 2024</div>
                                    </div>
                            </div>
                        </article>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="oh-desktop">
                        <!-- Thumbnail Modern-->
                        <article class="thumbnail thumbnail-modern wow slideInUp hoverdir-item"
                            data-hoverdir-target=".thumbnail-modern-caption"><a class="thumbnail-modern-figure"
                                href="{{ asset('frontend/images/Shaping-Hydropower-Station_.jpg') }}"
                                data-lightgallery="item"><img class="lazy"
                                    data-src="{{ asset('frontend/images/Shaping-Hydropower-Station_.jpg') }}"
                                    alt="" width="474" height="355" /></a>
                            <div class="thumbnail-modern-caption">
                                <h5 class="thumbnail-modern-title"><a href="#">Shaping Hydropower Station</a>
                                    <div class="home-kpis mt-3">
                                        <div class="fs-1"><b>Location</b> China</div>
                                        <div class="fs-1"><b>Capacity</b> 100 MW</div>
                                        <div class="fs-1"><b>Budget</b> $10 Million</div>
                                        <div class="fs-1"><b>Start Date</b> Jan 10, 2023 </div>
                                        <div class="fs-1"><b>End Data</b> Jan 10, 2024</div>
                                    </div></h5>
                            </div>
                        </article>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="oh-desktop">
                        <!-- Thumbnail Modern-->
                        <article class="thumbnail thumbnail-modern wow slideInUp hoverdir-item"
                            data-hoverdir-target=".thumbnail-modern-caption"><a class="thumbnail-modern-figure"
                                href="{{ asset('frontend/images/Yidaoqiao-Hydropower-Station (1).jpg') }}"
                                data-lightgallery="item"><img
                                    src="{{ asset('frontend/images/Yidaoqiao-Hydropower-Station (1).jpg') }}"
                                    alt="" width="474" height="355" /></a>
                            <div class="thumbnail-modern-caption">
                                <h5 class="thumbnail-modern-title"><a href="#">Yidaoqiao Hydropower Station</a>
                                    <div class="home-kpis mt-3">
                                        <div class="fs-1"><b>Location</b> China</div>
                                        <div class="fs-1"><b>Capacity</b> 100 MW</div>
                                        <div class="fs-1"><b>Budget</b> $10 Million</div>
                                        <div class="fs-1"><b>Start Date</b> Jan 10, 2023 </div>
                                        <div class="fs-1"><b>End Data</b> Jan 10, 2024</div>
                                    </div></h5>
                            </div>
                        </article>
                    </div>
                </div> --}}
            </div>
        </div>
    </section>


    <section class="section section-inset-8 bg-image-5 context-dark text-center">
        <div class="container">
            <h2 class="oh-desktop h3"><span class="d-inline-block wow slideInDown">Renewable Energy projects</span></h2>
            <div class="owl-style-4">
                <div class="owl-carousel dots-style-2" data-items="1" data-md-items="2" data-margin="30"
                    data-md-margin="0" data-nav="true" data-dots="true" data-smart-speed="400" data-autoplay="true">
                    @foreach ($renewableEnergyProjects as $project)
                        @php
                            $image = App\Models\ProjectImage::where('project_id', $project->id)
                                ->where('main_image', '!=', 'null')
                                ->first()->main_image;
                        @endphp
                        <article class="project-classic"><a class="project-classic-figure" href="#"><img
                                    src="{{ asset('/storage/uploads/project/main_image/thumbnail/home_r_' . $image) }}"
                                    alt="" width="570" height="370" /></a>
                            <div class="project-classic-caption">
                                <h5 class="project-classic-title"><a href="#">{{ $project->title }}</a>
                                </h5>
                                @if (!empty($project->projectKpis->location))
                                    <div class="project-classic-location"><span
                                            class="icon mdi mdi-map-marker"></span><span>{{ $project->projectKpis->location }}</span>
                                    </div>
                                @endif
                                <p class="project-classic-text">{{ $project->short_description }}</p>
                            </div>
                        </article>
                    @endforeach
                    {{-- <!-- Project Classic-->
                    <article class="project-classic"><a class="project-classic-figure" href="#"><img
                                src="{{ asset('frontend/images/Yanyuan-Photovoltaic-Power-Station.png') }}"
                                alt="" width="570" height="370" /></a>
                        <div class="project-classic-caption">
                            <h5 class="project-classic-title"><a href="#">Yanyuan Photovoltaic Power Station</a>
                            </h5>
                            <div class="project-classic-location"><span
                                    class="icon mdi mdi-map-marker"></span><span>China</span></div>
                            <p class="project-classic-text">Civil Group provided engineering design and planning for this
                                project completed in early 2021.</p>
                        </div>
                    </article>
                    <!-- Project Classic-->
                    <article class="project-classic"><a class="project-classic-figure" href="#"><img
                                src="{{ asset('frontend/images/Yanyuan-Photovoltaic-Power-Station-phase-one1.png') }}"
                                alt="" width="570" height="370" /></a>
                        <div class="project-classic-caption">
                            <h5 class="project-classic-title"><a href="#">Yanyuan Photovoltaic Power Station (phase
                                    one)</a></h5>
                            <div class="project-classic-location"><span
                                    class="icon mdi mdi-map-marker"></span><span>China</span></div>
                            <p class="project-classic-text">Our team of engineers cooperated with Dynamics construction
                                company on this ambitious project.</p>
                        </div>
                    </article>
                    <!-- Project Classic-->
                    <article class="project-classic"><a class="project-classic-figure" href="#"><img
                                src="{{ asset('frontend/images/Xigu-Photovoltaic-Power-Station.png') }}" alt=""
                                width="570" height="370" /></a>
                        <div class="project-classic-caption">
                            <h5 class="project-classic-title"><a href="#">Xigu Photovoltaic Power Station</a></h5>
                            <div class="project-classic-location"><span
                                    class="icon mdi mdi-map-marker"></span><span>China</span></div>
                            <p class="project-classic-text">Civil Group provided engineering design and planning for this
                                project completed in early 2021.</p>
                        </div>
                    </article>
                    <!-- Project Classic-->
                    <article class="project-classic"><a class="project-classic-figure" href="#"><img
                                src="{{ asset('frontend/images/Xigu-Hydropower-Station_11zon.png') }}" alt=""
                                width="570" height="370" /></a>
                        <div class="project-classic-caption">
                            <h5 class="project-classic-title"><a href="#">Xigu Hydropower Station</a></h5>
                            <div class="project-classic-location"><span
                                    class="icon mdi mdi-map-marker"></span><span>China</span></div>
                            <p class="project-classic-text">Our team of engineers cooperated with Dynamics construction
                                company on this ambitious project.</p>
                        </div>
                    </article> --}}
                </div>
            </div>
        </div>
    </section>

    <section class="section parallax-container">
        <div class="parallax-content section-inset-9 context-dark">
            <div class="container">
                <div class="row row-30 justify-content-center justify-content-xl-between align-items-lg-end">
                    <div class="col-sm-6 col-md-3">
                        <div class="counter-classic">
                            <h3 class="counter-classic-number"><span class="counter">
                                    250
                                    <!-- {{ $projectNo }} -->
                                </span> +
                            </h3>
                            <h6 class="counter-classic-title">Projects</h6>
                            <div class="counter-classic-decor"></div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="counter-classic">
                            <h3 class="counter-classic-number"><span class="counter">{{ count($shared_sectors) }}</span>
                            </h3>
                            <h6 class="counter-classic-title">Sectors</h6>
                            <div class="counter-classic-decor"></div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="counter-classic">
                            <h3 class="counter-classic-number"><span class="counter">
                                    200
                                    <!-- {{ $teamNo }} -->
                                </span> +
                            </h3>
                            <h6 class="counter-classic-title">Our Team</h6>
                            <div class="counter-classic-decor"></div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="counter-classic">
                            <h3 class="counter-classic-number"><span class="counter">
                                    6
                                    <!-- {{ $clientNo }} -->
                                </span>
                            </h3>
                            <h6 class="counter-classic-title">our clients</h6>
                            <div class="counter-classic-decor"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Subscribe to Our Newsletter-->
    <!-- <section class="section parallax-container" data-parallax-img="">
            <div class="parallax-content section-md context-dark text-md-left">
                <div class="container">
                    <div class="row row-30 justify-content-center align-items-center">
                        <div class="col-lg-4 col-xl-3">
                            <h5 class="oh-desktop"><span class="d-inline-block wow slideInUp">Newsletter</span></h5>
                            <p class="oh-desktop"><span class="d-inline-block wow slideInDown">Sign up to our newsletter to
                                    receive the latest news.</span></p>
                        </div>
                        <div class="col-lg-8 col-xl-9">
                            <div class="block-center">
                                <form class="rd-form rd-mailform rd-form-inline oh-desktop rd-form-inline-lg"
                                    data-form-output="form-output-global" data-form-type="subscribe" method="post"
                                    action="bat/rd-mailform.php">
                                    <div class="form-wrap wow slideInUp">
                                        <input class="form-input" id="subscribe-form-0-email" type="email"
                                            name="email" />
                                        <label class="form-label" for="subscribe-form-0-email">Your E-mail*</label>
                                    </div>
                                    <div class="form-button wow slideInRight">
                                        <button class="button button-winona button-lg button-primary"
                                            type="submit">Subscribe</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
    @if (count($news) >= 1)
        <section class="section section-lg bg-default">
            <div class="container">
                <h2 class="tabs-post-title oh-desktop h3"><span class="d-inline-block wow slideInDown"
                        style="visibility: visible; animation-name: slideInDown;">Latest news</span></h2>
                <div class="row row-40 row-lg-60 justify-content-center">
                    @foreach ($news as $key => $homenews)
                        @if ($key < 3)
                            <div class="col-sm-6 col-lg-4 order-lg-1">
                                <article class="post post-classic">
                                    <div class="post-classic-figure"><img
                                            src="{{ asset('storage/uploads/news/main_image/thumbnail/home_' . $homenews->main_image) }}"
                                            alt="{{ $homenews->title }}" width="370" height="210" />
                                    </div>
                                    <div class="post-classic-content">
                                        <p class="post-classic-title"><a title="View details"
                                                href="{{ route('news.details', $homenews->slug) }}">{{ $homenews->title }}</a>
                                        </p>
                                    </div>
                                    <time class="post-classic-time"
                                        datetime="2021-04-30">{{ \Carbon\Carbon::parse($homenews->published_date)->format('F d, Y') }}</time>
                                </article>
                            </div>
                        @endif
                    @endforeach
                    <div class="pagination-wrap">
                    </div>
                </div>
        </section>
    @endif
    <!-- Modal -->
    <div class="modal fade" id="campaignModal" tabindex="-1" role="dialog" aria-labelledby="campaignModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="owl-style-4 mt-0">
                        <div class="owl-carousel dots-style-2 camp-carousel" data-items="1" data-nav="true"
                            data-dots="true" data-smart-speed="400" data-autoplay="true">
                            @foreach ($campaigns as $campaign)
                                @foreach ($campaign->images as $image)
                                    @if (!empty($campaign->url))
                                        <a href="{{ $campaign->url }}" title="View details">
                                    @endif
                                    <div>
                                        <img src="{{ asset('storage/uploads/campaign/main_image/' . $image->main_image) }}"
                                            alt="{{ $campaign->title }}" class="img-fluid camp-img">
                                        <h6 class="caption text-white mt-0">{{ $campaign->title }}</h6>
                                    </div>
                                    @if (!empty($campaign->url))
                                        </a>
                                    @endif
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            var campaigns = "{{ $campaigns }}";
            if (campaigns.length > 2) {
                $('#campaignModal').modal('toggle')
            }
        })
    </script>
@endsection
