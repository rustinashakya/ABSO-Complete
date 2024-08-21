@extends('frontend.layouts.master')

@section('content')
    @php
        $html_title = $team->html_title ?? 'QYEC';
        $meta_description = $team->meta_description ?? 'QYEC';
        $meta_keyword = $team->meta_keyword ?? 'QYEC';
        $favicon_url =
            asset('/storage/uploads/teams/profile_image/' . $team->profile_image) ??
            asset('frontend/images/QYEC-logo.png');
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
                <li><a href="{{ route('home') }}">Home</a></li>
                <li class="active">Team Name</li>
            </ul>
        </div>
    </section> -->
    <section class="section section-lg bg-default">
        <div class="container">
            <div class="row row-50 justify-content-center text-center text-md-left">
                <div class="col-12 col-md-4 text-center">
                    <div class="profile-background">
                        <img class="lazy"
                            data-src="{{ asset('/storage/uploads/teams/profile_image/' . $team->profile_image) }}"
                            alt="{{ ucwords($team->name) }}" width="270" height="236" />
                    </div>
                </div>
                <div class="col-12 col-md-8 ">
                    <h1 class="h4"><b>{{ $team->name ?? '' }}</b></h1>
                    <div>{{ $team->designation->title ?? '' }}, <span class="text-capitalize">{{ $team->type ?? '' }}</span>
                    </div>
                    <div class=" my-4">
                        {!! $team->description !!}
                        <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p> -->
                    </div>
                    <div class="info my-2">
                        <b>Experience:</b> {{ $team->experience }}
                    </div>
                    <div class="info my-2">
                        <b>Speciality:</b> {{ $team->speciality ?? '' }}
                    </div>

                    <ul class="list-inline team-modern-social-list text-md-left mt-4 mt-lg-2">
                        @if ($team->facebook)
                            <li><a class="text-center icon mdi mdi-facebook" href="{{ $team->facebook }}"></a></li>
                        @endif
                        @if ($team->twitter)
                            <li><a class="text-center icon mdi mdi-twitter" href="{{ $team->twitter }}"></a></li>
                        @endif
                        @if ($team->instagram)
                            <li><a class="text-center icon mdi mdi-instagram" href="{{ $team->instagram }}"></a></li>
                        @endif
                    </ul>
                </div>
            </div>

        </div>
    </section>
@endsection
