@extends('frontend.layouts.master')

@section('content')
    @php
        $html_title = $shared_site_setting->news_html_title ?? 'QYEC';
        $meta_description = $shared_site_setting->news_meta_description ?? 'QYEC';
        $meta_keyword = $shared_site_setting->news_meta_keyword ?? 'QYEC';
        $favicon_url = asset('frontend/images/QYEC-logo.png');
        $page_url = url()->current();
    @endphp
    <!-- Breadcrumbs -->
    <!-- <section class="bg-gray-7">
        <div class="breadcrumbs-custom box-transform-wrap context-dark">
            <div class="container">
                <h3 class="breadcrumbs-custom-title">News</h3>
                <div class="breadcrumbs-custom-decor"></div>
            </div>
            <div class="box-transform" style="background-image: url('{{ asset('frontend/images/bg-typography.jpg') }}');"></div>
        </div>
        <div class="container">
            <ul class="breadcrumbs-custom-path">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li class="active">News</li>
            </ul>
        </div>
    </section> -->
    <!-- Grid Blog-->
    <section class="section section-lg bg-default">
        <div class="container">
            <h1 class="wow slideInDown h4" data-wow-duration="2s" data-wow-delay=".1s"><b>News</b></h1>
            <div class="row row-40 row-lg-60 justify-content-center">
                @foreach ($news as $key => $homenews)
                    <div class="col-sm-6 col-lg-4 order-lg-1 wow slideInUp">
                        <article class="post post-classic">
                            <div class="post-classic-figure"><img
                                    src="{{ asset('storage/uploads/news/main_image/' . $homenews->main_image) }}"
                                    alt="qyec" width="370" height="210" />
                            </div>
                            <div class="post-classic-content">
                                <p class="post-classic-title"><a
                                        href="{{ route('news.details', $homenews->slug) }}">{{ $homenews->title }}</a>
                                </p>
                            </div>
                            <time class="post-classic-time"
                                datetime="{{ \Carbon\Carbon::parse($homenews->published_date)->format('F d, Y') }}">{{ \Carbon\Carbon::parse($homenews->published_date)->format('F d, Y') }}</time>
                        </article>
                    </div>
                @endforeach
            </div>
            <div class="pagination-wrap">
                {{-- <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li class="page-item page-item-control disabled"><a class="page-link" href="#" aria-label="Previous"><span class="icon" aria-hidden="true"></span></a></li>
                    <li class="page-item active"><span class="page-link">1</span></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item page-item-control"><a class="page-link" href="#" aria-label="Next"><span class="icon" aria-hidden="true"></span></a></li>
                </ul>
            </nav> --}}

                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        {{-- Previous Page Link --}}
                        @if ($news->onFirstPage())
                            <li class="page-item page-item-control disabled" aria-disabled="true"
                                aria-label="@lang('pagination.previous')">
                                <span class="page-link" aria-hidden="true"><span class="icon"
                                        aria-hidden="true"></span></span>
                            </li>
                        @else
                            <li class="page-item page-item-control">
                                <a class="page-link" href="{{ $news->previousPageUrl() }}" rel="prev"
                                    aria-label="@lang('pagination.previous')"><span class="icon" aria-hidden="true"></span></a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($news->links()->elements as $element)
                            {{-- "Three Dots" Separator --}}
                            @if (is_string($element))
                                <li class="page-item disabled" aria-disabled="true"><span
                                        class="page-link">{{ $element }}</span></li>
                            @endif

                            {{-- Array Of Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $news->currentPage())
                                        <li class="page-item active" aria-current="page"><span
                                                class="page-link">{{ $page }}</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link"
                                                href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($news->hasMorePages())
                            <li class="page-item page-item-control">
                                <a class="page-link" href="{{ $news->nextPageUrl() }}" rel="next"
                                    aria-label="@lang('pagination.next')"><span class="icon" aria-hidden="true"></span></a>
                            </li>
                        @else
                            <li class="page-item page-item-control disabled" aria-disabled="true"
                                aria-label="@lang('pagination.next')">
                                <span class="page-link" aria-hidden="true"><span class="icon"
                                        aria-hidden="true"></span></span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    </section>
@endsection
