@extends('frontend.layouts.master')

@section('content')
    @php
        $html_title = $static_page->html_title ?? 'QYEC';
        $meta_description = $static_page->meta_description ?? 'QYEC';
        $meta_keyword = $static_page->meta_keyword ?? 'QYEC';
        $favicon_url = asset('/storage/uploads/static_pages/main_image/' . $static_page->main_image) ?? asset('frontend/images/QYEC-logo.png');
        $page_url = url()->current();
    @endphp
    <!-- Breadcrumbs -->
    @if (!empty($static_page))
        <!-- <section class="bg-gray-7">
                <div class="breadcrumbs-custom box-transform-wrap context-dark">
                    <div class="container">
                        <h3 class="breadcrumbs-custom-title">{{ $static_page->name }}</h3>
                        <div class="breadcrumbs-custom-decor"></div>
                    </div>
                    <div class="box-transform" style="background-image: url('{{ asset('frontend/images/bg-typography.jpg') }}');"></div>
                </div>
                <div class="container">
                    <ul class="breadcrumbs-custom-path">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li class="active">{{ $static_page->name }}</li>
                    </ul>
                </div>
            </section> -->
        <section class="section section-lg bg-default">
            <div class="container">
                <div class="tabs-custom row row-50 justify-content-center text-center text-md-left" id="tabs-4">
                    <div class="col-lg-8 col-xl-9">
                        <!-- Tab panes-->
                        <div class="tab-content tab-content-1">
                            <div class="tab-pane fade show active wow customFadeIn" id="tabs-4-1" data-wow-duration="1s"
                                data-wow-delay=".7s">
                                <h1 class="h4"><b>{{ $static_page->name }}</b></h1>
                                <p class="wow slideInUp description-custom">
                                    {!! $static_page->description !!}
                                </p>
                                @if (!empty($static_page->main_image))
                                    <img class="lazy wow slideInUp" data-wow-duration="1s"
                                        src="{{ asset('storage/uploads/static_pages/main_image/' . $static_page->main_image) }} "
                                        alt="qyec" width="835" height="418" title="{{ $static_page->name }}" />
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xl-3 wow slideInRight d-none d-lg-block">
                        <h2 class="text-spacing-200 h5">{{ $static_page->sub_title }}</h2>
                        <ul class="nav list-category list-category-down-md-inline-block">

                            <li class="list-category-item wow fadeInRight" data-wow-duration="1s"><a
                                    href="{{ route('page', 'about-qyec') }}"
                                    class="{{ $static_page->slug == 'about-qyec' ? 'active' : '' }} ">About QYEC</a></li>
                            <li class="list-category-item wow fadeInRight" data-wow-duration="1s" data-wow-delay=".4s"><a
                                    href="{{ route('team') }}" class="">Our Team</a></li>
                            <li class="list-category-item wow fadeInRight" data-wow-duration="1s" data-wow-delay=".5s"><a
                                    href="{{ route('page', 'organisational-chart') }}"
                                    class="{{ $static_page->slug == 'organisational-chart' ? 'active' : '' }} ">Organisational
                                    chart</a></li>
                            <li class="list-category-item wow fadeInRight" data-wow-duration="1s" data-wow-delay=".6s"><a
                                    href="{{ route('gallery') }}" class="">Legal Documents</a></li>
                            <!-- <li class="list-category-item wow fadeInRight" data-wow-duration="1s" data-wow-delay=".7s"><a href="{{ route('history') }}" class="{{ $static_page->slug == 'history' ? 'active' : '' }} ">Our History</a></li> -->
                            <li class="list-category-item wow fadeInRight" data-wow-duration="1s" data-wow-delay=".8s"><a
                                    href="{{ route('clientele') }}" class="">Our Clientele</a></li>
                        </ul><a class="button button-lg button-primary button-winona" href="{{ route('contact') }}">Contact
                            us</a>
                    </div>
                </div>
            </div>
        </section>
    @else
        {{ view('frontend.coming_soon') }}
    @endif
@endsection
