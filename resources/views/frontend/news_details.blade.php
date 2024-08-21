@extends('frontend.layouts.master')

@section('content')
    @php
        $html_title = $news->html_title ?? 'QYEC';
        $meta_description = $news->meta_description ?? 'QYEC';
        $meta_keyword = $news->meta_keyword ?? 'QYEC';
        $favicon_url =
            asset('/storage/uploads/news/main_image/' . $news->main_image) ?? asset('frontend/images/QYEC-logo.png');
        $page_url = url()->current();
    @endphp
    <!-- Breadcrumbs -->
    <!-- <section class="bg-gray-7">
        <div class="breadcrumbs-custom box-transform-wrap context-dark">
            <div class="container">
                <h3 class="breadcrumbs-custom-title">{{ $news->title }}</h3>
                <div class="breadcrumbs-custom-decor"></div>
            </div>
            <div class="box-transform" style="background-image: url('{{ asset('frontend/images/bg-typography.jpg') }}');"></div>
        </div>
        <div class="container">
            <ul class="breadcrumbs-custom-path">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('news') }}">News</a></li>
                <li class="active">{{ $news->title }}</li>
            </ul>
        </div>
    </section> -->
    <!-- Grid Blog-->
    <section class="section section-lg bg-default">
        <div class="container">
            <div class="row row-60 row-xl-75">
                <div class="col-12">
                    <div class="single-post section-style-2 mb-5">
                        <h4 class="text-spacing-50 font-weight-normal text-transform-none"><b>{{ $news->title }}</b></h4>
                        <div class="group-md group-middle">
                            <time class="post-classic-time"
                                datetime="{{ \Carbon\Carbon::parse($news->published_date)->format('F d, Y') }}">
                                {{ \Carbon\Carbon::parse($news->published_date)->format('F d, Y') }}
                            </time>
                            @if (!empty($news->author))
                                <div>
                                    <ul class="list-inline list-inline-xl post-classic-info">
                                        <li class="post-classic-author"><span
                                                class="icon mdi mdi-account-outline"></span><span>by
                                                {{ @$news->author }}</span></li>
                                    </ul>
                                </div>
                            @endif
                        </div>
                        {!! $news->description !!}
                        <img src="{{ asset('storage/uploads/news/main_image/' . $news->main_image) }}" alt="qyec"
                            class="img-fluid" />

                    </div>
                    <h4 class="wow slideInUp"><b>Latest News</b></h4>
                    <div class="row row-lg row-30 justify-content-center">
                        @foreach ($newslist as $key => $news)
                            @if ($key < 3)
                                <div class="col-sm-6 col-lg-4 order-lg-1">
                                    <article class="post post-classic">
                                        <div class="post-classic-figure"><img
                                                src="{{ asset('storage/uploads/news/main_image/' . $news->main_image) }}"
                                                alt="qyec" width="370" height="210" />
                                        </div>
                                        <div class="post-classic-content">
                                            <p class="post-classic-title"><a
                                                    href="{{ route('news.details', $news->slug) }}">{{ $news->title }}</a>
                                            </p>
                                        </div>
                                        <time class="post-classic-time"
                                            datetime="{{ \Carbon\Carbon::parse($news->published_date)->format('F d, Y') }}">{{ \Carbon\Carbon::parse($news->published_date)->format('F d, Y') }}</time>
                                    </article>
                                </div>
                            @endif
                        @endforeach

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
