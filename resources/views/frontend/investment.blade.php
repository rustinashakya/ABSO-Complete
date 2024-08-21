@extends('frontend.layouts.master')

@section('content')
    @php
        $html_title = $shared_site_setting->investment_html_title ?? 'QYEC';
        $meta_description = $shared_site_setting->investment_meta_description ?? 'QYEC';
        $meta_keyword = $shared_site_setting->investment_meta_keyword ?? 'QYEC';
        $favicon_url = asset('frontend/images/QYEC-logo.png');
        $page_url = url()->current();
    @endphp
    @if ($investments->count() > 0)
        <section class="section section-lg bg-default">
            <div class="container">
                <h1 class="wow slideInDown h4 mb-4" data-wow-duration="2s" data-wow-delay=".1s"><b>Investment Portfolio</b>
                </h1>
                <div class="isotope-wrap">
                    <!-- <div class="isotope-filters isotope-filters-horizontal">
                                        <button class="isotope-filters-toggle button button-sm button-icon button-icon-right button-gray-3" data-custom-toggle=".isotope-filters-list" data-custom-toggle-disable-on-blur="true"><span class="icon mdi mdi-chevron-down"></span>Filter</button>
                                        <ul class="isotope-filters-list">
                                            <li><a class="active" href="#" data-isotope-filter="*" data-isotope-group="gallery">All</a>
                                            </li>

                                            <li><a href="#" data-isotope-filter="Type 2" data-isotope-group="gallery">Water COnservancy</a></li>
                                            <li><a href="#" data-isotope-filter="Type 3" data-isotope-group="gallery">Transmission Line Substation</a></li>
                                            <li><a href="#" data-isotope-filter="Type 4" data-isotope-group="gallery">Renewable Energy</a></li>
                                        </ul>
                                    </div> -->
                    <div class="row isotope wow slideInFromBottom" data-wow-duration="2s" data-wow-delay=".3s"
                        data-isotope-layout="masonry" data-column-class=".col-1" data-lightgallery="group">
                        <div class="col-1 isotope-item isotope-sizer"></div>
                        @foreach ($investments as $key => $investment)
                            <div class="col-md-6 col-lg-4 isotope-item" data-filter="Type " . $key>
                                <!-- Thumbnail Classic-->
                                <article class="thumbnail thumbnail-classic thumbnail-lg">
                                    <a class="thumbnail-classic-figure"
                                        href="{{ route('investment.details', $investment->slug) }}">
                                        <img src="{{ asset('/storage/uploads/investment/main_image/thumbnail/home_r_' . @$investment->main_image) }}"
                                            alt="{{ $investment->title }}" width="570" height="299" />
                                    </a>
                                    <div class="thumbnail-classic-caption">
                                        <h6 class="thumbnail-classic-title"><a
                                                href="{{ route('investment.details', $investment->slug) }}">{{ $investment->title }}</a>
                                        </h6>
                                        <div class="thumbnail-classic-time">
                                            {{ ucwords($investment->page->name ?? '') }}
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @endforeach

                        {{-- <div class="col-md-6 col-lg-4 isotope-item" data-filter="Type 2">
                                <!-- Thumbnail Classic-->
                                <article class="thumbnail thumbnail-classic thumbnail-lg">
                                    <a class="thumbnail-classic-figure" href="{{ route('investment.details', 'investment-one') }}">
                        <img src="{{ asset('frontend/images/project-1-570x299.jpg') }}" alt="" width="570" height="299" />
                        </a>
                        <div class="thumbnail-classic-caption">
                            <h6 class="thumbnail-classic-title"><a href="{{ route('investment.details', 'investment-one') }}">Investment Project 2</a>
                            </h6>
                            <div class="thumbnail-classic-time">
                                <time datetime="2021-04-05">April 05, 2021</time>
                            </div>
                        </div>
                        </article>
                    </div>
                    <div class="col-md-6 col-lg-4 isotope-item" data-filter="Type 1">
                        <!-- Thumbnail Classic-->
                        <article class="thumbnail thumbnail-classic thumbnail-lg">
                            <a class="thumbnail-classic-figure" href="{{ route('investment.details', 'investment-one') }}">
                                <img src="{{ asset('frontend/images/project-1-570x299.jpg') }}" alt="" width="570" height="299" />
                            </a>
                            <div class="thumbnail-classic-caption">
                                <h6 class="thumbnail-classic-title"><a href="{{ route('investment.details', 'investment-one') }}">Investment Project 1</a>
                                </h6>
                                <div class="thumbnail-classic-time">
                                    <time datetime="2021-04-05">April 05, 2021</time>
                                </div>
                            </div>
                        </article>
                    </div>

                    <div class="col-md-6 col-lg-4 isotope-item" data-filter="Type ">
                        <!-- Thumbnail Classic-->
                        <article class="thumbnail thumbnail-classic thumbnail-lg">
                            <a class="thumbnail-classic-figure" href="{{ route('investment.details', 'investment-one') }}">
                                <img src="{{ asset('frontend/images/project-1-570x299.jpg') }}" alt="" width="570" height="299" />
                            </a>
                            <div class="thumbnail-classic-caption">
                                <h6 class="thumbnail-classic-title"><a href="{{ route('investment.details', 'investment-one') }}">Investment Project 3</a>
                                </h6>
                                <div class="thumbnail-classic-time">
                                    <time datetime="2021-04-05">April 05, 2021</time>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6 col-lg-4 isotope-item" data-filter="Type 4">
                        <!-- Thumbnail Classic-->
                        <article class="thumbnail thumbnail-classic thumbnail-lg">
                            <a class="thumbnail-classic-figure" href="{{ route('investment.details', 'investment-one') }}">
                                <img src="{{ asset('frontend/images/project-1-570x299.jpg') }}" alt="" width="570" height="299" />
                            </a>
                            <div class="thumbnail-classic-caption">
                                <h6 class="thumbnail-classic-title"><a href="{{ route('investment.details', 'investment-one') }}">Investment Project 4</a>
                                </h6>
                                <div class="thumbnail-classic-time">
                                    <time datetime="2021-04-05">April 05, 2021</time>
                                </div>
                            </div>
                        </article>
                    </div> --}}
                    </div>
                </div>
                <div class="pagination-wrap">
                    <!-- Bootstrap Pagination-->
                    <!-- Pagination -->
                    {{-- <div class="pagination-wrap">
                            <!-- Bootstrap Pagination-->
                            <nav aria-label="Page navigation">
                                <ul class="pagination">
                                    <li class="page-item page-item-control disabled"><a class="page-link" href="#"
                                            aria-label="Previous"><span class="icon" aria-hidden="true"></span></a></li>
                                    <li class="page-item active"><span class="page-link">1</span></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item page-item-control"><a class="page-link" href="#"
                                            aria-label="Next"><span class="icon" aria-hidden="true"></span></a></li>
                                </ul>
                            </nav>
                        </div> --}}
                </div>
            </div>
        </section>
    @else
        {{ view('frontend.coming_soon') }}
    @endif
@endsection
