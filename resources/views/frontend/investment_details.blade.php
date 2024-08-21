@extends('frontend.layouts.master')

@section('content')
    @php
        $html_title = $investment->html_title ?? 'QYEC';
        $meta_description = $investment->meta_description ?? 'QYEC';
        $meta_keyword = $investment->meta_keyword ?? 'QYEC';
        $favicon_url =
            asset('storage/uploads/investment/main_image/' . $investment->main_image) ??
            asset('frontend/images/QYEC-logo.png');
        $page_url = url()->current();
    @endphp
    <!-- Breadcrumbs -->
    <section class="section section-lg bg-default">
        <div class="container">
            <div class="tabs-custom row row-50 justify-content-center text-center text-md-left" id="tabs-4">
                <div class="col-lg-8 col-xl-9">
                    <!-- Tab panes-->
                    <div class="tab-content tab-content-1">
                        <div class="tab-pane fade show active wow customFadeIn" id="tabs-4-1" data-wow-duration="1s"
                            data-wow-delay=".7s">
                            <h4><b>{{ $investment->title }}</b></h4>
                            <div class="wow slideInUp mt-3 description-custom">
                                {!! $investment->description !!}
                            </div>

                            <img class="lazy wow slideInUp" data-wow-duration="1s"
                                src="{{ asset('/storage/uploads/investment/main_image/' . $investment->main_image) }}"
                                alt="{{ $investment->title }}" width="835" height="418"
                                title="{{ $investment->title }}" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-xl-3 slideInLeft">
                    <!-- <h5 class="text-spacing-200">KPIs</h5> -->
                    <ul
                        class="nav list-category list-category-down-md-inline-block custom-list-category text-center text-lg-left">
                        <li class="list-category-item wow fadeInRight" data-wow-duration="1s">
                            <a href="#"><b>Type Of Service:</b> <br />{{ ucwords($investment->type_of_service) }} </a>
                        </li>
                        <li class="list-category-item wow fadeInRight" data-wow-duration="1s">
                            <a href="#"><b>Sector:</b> <br />{{ $investment->page->name ?? '' }} </a>
                        </li>
                        <li class="list-category-item wow fadeInRight" data-wow-duration="1s">
                            <a href="#"><b>Capital:</b> <br />{{ $investment->capital }} </a>
                        </li>
                        <li class="list-category-item wow fadeInRight" data-wow-duration="1s">
                            <a href="#"><b>Start Year:</b> <br />{{ $investment->start_year }}</a>
                        </li>
                        <li class="list-category-item wow fadeInRight" data-wow-dura, 2020tion="1s">
                            <a href="#"><b>Payback Period:</b> <br />{{ $investment->payback_period }}</a>
                        </li>
                        <li class="list-category-item wow fadeInRight" data-wow-duration="1s">
                            <a href="#"><b>ROI:</b> <br />{{ $investment->roi }}</a>
                        </li>
                        <li class="list-category-item wow fadeInRight" data-wow-duration="1s">
                            <a href="#"><b>Stage:</b> <br />{{ $investment->stage }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
