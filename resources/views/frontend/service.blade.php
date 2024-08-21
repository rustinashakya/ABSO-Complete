@extends('frontend.layouts.master')

@section('content')
    @php
        $html_title = $service->html_title ?? 'QYEC';
        $meta_description = $service->meta_description ?? 'QYEC';
        $meta_keyword = $service->meta_keyword ?? 'QYEC';
        $favicon_url =
            asset('storage/uploads/services/main_image/' . $service->main_image) ??
            asset('frontend/images/QYEC-logo.png');
        $page_url = url()->current();
    @endphp
    @if (empty($service))
        {{ view('frontend.coming_soon') }}
    @else
        <!-- Breadcrumbs -->
        <!-- <section class="bg-gray-7">
        <div class="breadcrumbs-custom box-transform-wrap context-dark">
            <div class="container">
                <h3 class="breadcrumbs-custom-title">{{ $service->name }}</h3>
                <div class="breadcrumbs-custom-decor"></div>
            </div>
            <div class="box-transform" style="background-image: url('{{ asset('frontend/images/bg-typography.jpg') }}')"></div>
        </div>
        <div class="container">
            <ul class="breadcrumbs-custom-path">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li class="active"> {{ $service->name }}</li>
            </ul>
        </div>
    </section> -->
        <!-- Services-->
        <section class="section section-sm section-first bg-default text-left">
            <div class="container">
                <div class="row row-60 mb-1">
                    <div class="col-md-7 col-xl-8">
                        <div class="single-service">
                            <div>
                                <h1 class="wow slideInUp h4" data-wow-duration="1s" data-wow-delay=".5s">
                                    <b>{{ $service->name }}</b></h1>
                                <div class="description-custom"> {!! $service->description !!} </div>
                            </div>


                            <!-- <div class="row row-50 flex-xl-row-reverse">
                            <div class="col">
                                <div class="card-group-custom card-group-corporate" id="accordion3" role="tablist" aria-multiselectable="false">
                                    @foreach ($service->serviceAccordions as $key => $serviceAccordion)
    <article class="card card-custom card-corporate">
                                        <div class="card-header" id="accordion3Heading1" role="tab">
                                            <div class="card-title"><a role="button" data-toggle="collapse" data-parent="#accordion3" href="#accordion3Collapse1" aria-controls="accordion3Collapse1" aria-expanded="true">{{ $serviceAccordion->title }}
                                                    <div class="card-arrow"></div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="collapse show" id="accordion3Collapse1" role="tabpanel" aria-labelledby="accordion3Heading1">
                                            <div class="card-body">
                                                <p>{{ $serviceAccordion->body }}</p>
                                            </div>
                                        </div>
                                    </article>
    @endforeach
                                </div>
                            </div>
                        </div> -->
                        </div>
                    </div>
                    <div class="col-md-5 col-xl-4 d-none d-md-block">
                        <div class="aside aside-services">
                            <div class="row row-60">
                                <div class="aside-item col-12">
                                    <h2 class="aside-services-title h5">{{ $service->sub_title }}</h2>
                                    <ul class="list-category">
                                        @foreach ($shared_services as $index => $other_service)
                                            <li class="list-category-item wow fadeInRight" data-wow-duration="1s"
                                                data-wow-delay="{{ $index * 0.1 }}s"><a
                                                    class="{{ $service->slug == $other_service->slug ? 'active' : '' }}"
                                                    href="{{ route('service', $other_service->slug) }}">{{ $other_service->name }}</a>
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>
                                <!-- <div class="aside-item col-md-6 col-md-12">
                                <h5 class="aside-services-title">Our contacts</h5>
                                <div class="box-contacts">
                                    <div class="box-contacts-item">
                                        <div class="box-contacts-title">Free consultation</div>
                                        <div class="unit unit-spacing-xs flex-column flex-md-row">
                                            <div class="unit-left"><span class="icon icon-24 mdi mdi-phone"></span></div>
                                            <div class="unit-body"><a class="phone" href="tel:#">+1 718-999-3939</a></div>
                                        </div>
                                    </div>
                                    <div class="box-contacts-item">
                                        <div class="box-contacts-title">Office</div>
                                        <div class="unit unit-spacing-xs flex-column flex-md-row">
                                            <div class="unit-left"><span class="icon icon-28 mdi mdi-map-marker"></span></div>
                                            <div class="unit-body"><a class="address" href="#">514 S. Magnolia St. Orlando, FL 32806</a></div>
                                        </div>
                                    </div>
                                    <div class="box-contacts-item">
                                        <div class="box-contacts-title">E-mail</div>
                                        <div class="unit unit-spacing-xs flex-column flex-md-row">
                                            <div class="unit-left"><span class="icon mdi mdi-email"></span></div>
                                            <div class="unit-body"><a class="mail" href="mailto:#">info@demolink.org</a></div>
                                        </div>
                                    </div>
                                </div>
                                <a class="button button-lg button-icon button-icon-left button-primary button-winona" href="{{ route('contact') }}">Contact Us</a>

                            </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

@endsection
