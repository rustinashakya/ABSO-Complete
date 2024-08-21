@extends('frontend.layouts.master')

@section('content')
@php
        $html_title = $shared_site_setting->team_html_title ?? 'QYEC';
        $meta_description = $shared_site_setting->team_meta_description ?? 'QYEC';
        $meta_keyword = $shared_site_setting->team_meta_keyword ?? 'QYEC';
        $favicon_url = asset('frontend/images/QYEC-logo.png');
        $page_url = url()->current();
    @endphp
<!-- Breadcrumbs -->
<!-- <section class="bg-gray-7">
    <div class="breadcrumbs-custom box-transform-wrap context-dark">
        <div class="container">
            <h3 class="breadcrumbs-custom-title">Team Name</h3>
            <div class="breadcrumbs-custom-decor"></div>
        </div>
        <div class="box-transform" style="background-image: url('{{ asset('frontend/images/bg-typography.jpg') }}');"></div>
    </div>
    <div class="container">
        <ul class="breadcrumbs-custom-path">
            <li><a href="{{route('home')}}">Home</a></li>
            <li class="active">Team Name</li>
        </ul>
    </div>
</section> -->
@if(count($teams)>=1)
<section class="section section-xl bg-default text-md-left" id="teams">
    <div class="container">
        <div class="row row-30">
            <div class="col-md-5 col-lg-4 col-xl-3">
                <div class="box-team">
                    <h1 class="oh-desktop h4"><span class="d-inline-block wow slideInUp"><b>Our team</b></span></h1>
                    <h2 class="title-style-1 wow fadeInLeft h6" data-wow-delay=".1s">Professional Civil engineering</h2>
                    <p class="wow fadeInRight" data-wow-delay=".2s">We are a team of dedicated and professional
                        engineers and project managers ready to help.</p>
                    <div class="group-sm oh-desktop">
                        <div class="button-style-1 wow slideInLeft"><span
                                class="icon mdi mdi-email-outline"></span><span class="button-style-1-text"><a
                                    href="{{route('contact')}}" title="Contact us">Contact us</a></span></div>
                        <div class="wow slideInRight">
                            <div class="owl-custom-nav" id="owl-custom-nav-1"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7 col-lg-8 col-xl-9">
                <div class="owl-carousel owl-style-5" data-items="1" data-sm-items="2" data-lg-items="3"
                    data-margin="30" data-autoplay="false" data-animation-in="fadeIn" data-animation-out="fadeOut"
                    data-navigation-class="#owl-custom-nav-1">
                    @foreach ($teams as $team)
                        <article class="team-modern"><a class="team-modern-figure" href="{{ route('team.details', $team->slug) }}"><img class="lazy"
                                    data-src="{{ asset('/storage/uploads/teams/profile_image/' . $team->profile_image) }}" alt="{{ ucwords($team->name) }}"
                                    width="270" height="236" /></a>
                            <div class="team-modern-caption">
                                <h6 class="team-modern-name"><a href="#">{{ ucwords($team->name) }}</a></h6>
                                <div class="team-modern-status"> </div>
                                <ul class="list-inline team-modern-social-list">
                                    @if($team->facebook)
                                        <li><a class="icon mdi mdi-facebook" href="{{ $team->facebook }}"></a></li>
                                    @endif
                                    @if($team->twitter)
                                        <li><a class="icon mdi mdi-twitter" href="{{ $team->twitter }}"></a></li>
                                    @endif
                                    @if($team->instagram)
                                        <li><a class="icon mdi mdi-instagram" href="{{ $team->instagram }}"></a></li>
                                    @endif
                                </ul>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@else
    {{ view('frontend.coming_soon') }}
@endif

@endsection