@extends('frontend.layouts.master')

@section('content')
    @php
        $html_title = $project->html_title ?? 'QYEC';
        $meta_description = $project->meta_description ?? 'QYEC';
        $meta_keyword = $project->meta_keyword ?? 'QYEC';
        $favicon_url =
            asset('/storage/uploads/project/main_image/' . $project->main_image) ??
            asset('frontend/images/QYEC-logo.png');
        $page_url = url()->current();
    @endphp
    <!-- Breadcrumbs -->
    <!-- <section class="bg-gray-7">
                    <div class="breadcrumbs-custom box-transform-wrap context-dark">
                        <div class="container">
                            <h3 class="breadcrumbs-custom-title">Project Detail Page</h3>
                            <div class="breadcrumbs-custom-decor"></div>
                        </div>
                        <div class="box-transform" style="background-image: url('{{ asset('frontend/images/bg-typography.jpg') }}');"></div>
                    </div>
                    <div class="container">
                        <ul class="breadcrumbs-custom-path">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li class="active">Project Detail Page</li>
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
                            <h4><b>{{ $project->title }}</b></h4>

                            <div class="wow slideInUp mt-3">
                                <div class="description-custom">
                                    {!! $project->description !!}
                                </div>
                            </div>
                            @php
                                $image = App\Models\ProjectImage::where('project_id', $project->id)
                                    ->where('main_image', '!=', 'null')
                                    ->first()->main_image;
                            @endphp
                            <img class="lazy wow slideInUp" data-wow-duration="1s"
                                src="{{ asset('/storage/uploads/project/main_image/' . @$image) }}"
                                alt="{{ $project->title }}" width="835" height="418" title="" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-xl-3 slideInLeft">
                    <!-- <h5 class="text-spacing-200">KPIs</h5> -->
                    <ul
                        class="nav list-category list-category-down-md-inline-block custom-list-category text-center text-lg-left">
                        <li class="list-category-item wow fadeInRight" data-wow-duration="1s">
                            <a href="#"><b>Type of Service:</b> <br />{{ ucwords($project->service->name ?? '') }}
                            </a>
                        </li>
                        <li class="list-category-item wow fadeInRight" data-wow-duration="1s">
                            <a href="#"><b>Sector:</b> <br />{{ ucwords($project->page->name ?? '') }} </a>
                        </li>
                        <li class="list-category-item wow fadeInRight" data-wow-duration="1s">
                            <a href="#"><b>Stage:</b> <br />{{ ucwords($project->stage) }}</a>
                        </li>
                        <li class="list-category-item wow fadeInRight" data-wow-duration="1s">
                            <a href="#"><b>Location:</b>
                                <br />{{ ucwords($project->projectKpis->location ?? '') }}</a>
                        </li>
                        @if (@$project?->projectKpis->altitude)
                            <li class="list-category-item wow fadeInRight" data-wow-duration="1s" data-wow-delay=".2s"><a
                                    href="#"><b>Altitude:</b> <br />{{ $project->projectKpis->altitude ?? '' }}</a>
                            </li>
                        @endif
                        @if (@$project->projectKpis->circulation_rate)
                            <li class="list-category-item wow fadeInRight" data-wow-duration="1s" data-wow-delay=".2s"><a
                                    href="#"><b>Circulation Rate:</b> <br />
                                    {{ $project->projectKpis->circulation_rate ?? '' }}</a>
                            </li>
                        @endif
                        @if (@$project->projectKpis->kw_per_year)
                            <li class="list-category-item wow fadeInRight" data-wow-duration="1s" data-wow-delay=".2s"><a
                                    href="#"><b>KW per Year:</b> <br />
                                    {{ $project->projectKpis->kw_per_year ?? '' }}</a>
                            </li>
                        @endif
                        @if (@$project->projectKpis->full_load_hours)
                            <li class="list-category-item wow fadeInRight" data-wow-duration="1s" data-wow-delay=".2s"><a
                                    href="#"><b>Full Load Hours:</b> <br />
                                    {{ $project->projectKpis->full_load_hours ?? '' }}</a>
                            </li>
                        @endif
                        @if (@$project->projectKpis->plant_availability)
                            <li class="list-category-item wow fadeInRight" data-wow-duration="1s" data-wow-delay=".2s"><a
                                    href="#"><b>Plant Availability:</b> <br />
                                    {{ $project->projectKpis->plant_availability ?? '' }}</a>
                            </li>
                        @endif
                        <li class="list-category-item wow fadeInRight" data-wow-duration="1s" data-wow-delay=".2s"><a
                                href="#"><b>Capacity:</b> <br /> {{ $project->projectKpis->capacity ?? '' }}</a>
                        </li>
                        <li class="list-category-item wow fadeInRight" data-wow-duration="1s" data-wow-delay=".4s"><a
                                href="#"><b>Cost:</b> <br /> {{ $project->projectKpis->cost ?? '' }}</a></li>
                        <li class="list-category-item wow fadeInRight" data-wow-duration="1s" data-wow-delay=".4s"><a
                                href="#"><b>Funding By:</b> <br /> {{ $project->projectKpis->funding_by ?? '' }}</a>
                        </li>

                        @if (@$project?->projectKpis->source)
                            <li class="list-category-item wow fadeInRight" data-wow-duration="1s" data-wow-delay=".2s"><a
                                    href="#"><b>Source:</b> <br /> {{ $project->projectKpis->source ?? '' }}</a>
                            </li>
                        @endif
                        @if (@$project->projectKpis->subbasin)
                            <li class="list-category-item wow fadeInRight" data-wow-duration="1s" data-wow-delay=".2s"><a
                                    href="#"><b>Subbasin:</b> <br /> {{ $project->projectKpis->subbasin ?? '' }}</a>
                            </li>
                        @endif
                        <li class="list-category-item wow fadeInRight" data-wow-duration="1s" data-wow-delay=".4s"><a
                                href="#"><b>Start Date:</b> <br />
                                {{ $project->projectKpis->construction_begins ?? '' }}</a></li>
                        <li class="list-category-item wow fadeInRight" data-wow-duration="1s" data-wow-delay=".4s"><a
                                href="#"><b>Completion Date:</b> <br />
                                {{ $project->projectKpis->end_date ?? '' }}</a></li>
                        <!-- <li class="list-category-item wow fadeInRight" data-wow-duration="1s" data-wow-delay=".4s"><a
                                    href="#"><b>Status:</b> <br /> {{ $project->projectKpis->status ?? '' }}</a></li> -->
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
