@extends('frontend.layouts.master')

@section('content')
    @php
        $html_title = $shared_site_setting->project_html_title ?? 'QYEC';
        $meta_description = $shared_site_setting->project_meta_description ?? 'QYEC';
        $meta_keyword = $shared_site_setting->project_meta_keyword ?? 'QYEC';
        $favicon_url = asset('frontend/images/QYEC-logo.png');
        $page_url = url()->current();
    @endphp
    <!-- <section class="bg-gray-7">
                <div class="breadcrumbs-custom box-transform-wrap context-dark">
                    <div class="container">
                        <h3 class="breadcrumbs-custom-title">Projects</h3>
                        <div class="breadcrumbs-custom-decor"></div>
                    </div>
                    <div class="box-transform" style="background-image: url('{{ asset('frontend/images/bg-typography.jpg') }}');">
                    </div>
                </div>
                <div class="container">
                    <ul class="breadcrumbs-custom-path">
                        <li><a href="index.html">Home</a></li>
                        <li class="active">Projects</li>
                    </ul>
                </div>
            </section> -->

    <!-- <section class="section section-lg bg-default">
                <div class="container">
                    <a href="{{ route('project.details', 1) }}">Go to project details</a>
                </div>
            </section> -->
    <!-- Services 2-->
    <section class="section section-lg bg-default">
        <div class="container">
            <div class="isotope-wrap">
                <div class="isotope-filters isotope-filters-horizontal">
                    <button class="isotope-filters-toggle button button-sm button-icon button-icon-right button-gray-3"
                        data-custom-toggle=".isotope-filters-list" data-custom-toggle-disable-on-blur="true"><span
                            class="icon mdi mdi-chevron-down"></span>Filter</button>
                    <ul class="isotope-filters-list">
                        <li><a class="active" href="#" data-isotope-filter="*" data-isotope-group="gallery">All</a>
                        </li>
                        @foreach ($sectors as $sector)
                            <li><a href="#" data-isotope-filter="{{ $sector->id }}"
                                    data-isotope-group="gallery">{{ ucwords($sector->name) }}</a></li>
                        @endforeach
                        {{-- <li><a href="#" data-isotope-filter="Type 2" data-isotope-group="gallery">Water COnservancy</a></li>
                    <li><a href="#" data-isotope-filter="Type 3" data-isotope-group="gallery">Transmission Line Substation</a></li>
                    <li><a href="#" data-isotope-filter="Type 4" data-isotope-group="gallery">Renewable Energy</a></li> --}}
                    </ul>
                </div>
                <div class="row isotope wow slideInFromBottom" data-wow-duration="2s" data-wow-delay=".3s"
                    data-isotope-layout="masonry" data-column-class=".col-1" data-lightgallery="group">
                    <div class="col-1 isotope-item isotope-sizer"></div>
                    @foreach ($projects as $project)
                        @php
                            $image = App\Models\ProjectImage::where('project_id', $project->id)
                                ->where('main_image', '!=', 'null')
                                ->first()->main_image;
                        @endphp
                        <div class="col-md-6 col-lg-4 isotope-item" data-filter="{{ $project->page_id }}">
                            <!-- Thumbnail Classic-->
                            <article class="thumbnail thumbnail-classic thumbnail-lg">
                                <a title="View details" class="thumbnail-classic-figure"
                                    href="{{ route('project.details', $project->slug) }}">
                                    <img src="{{ asset('/storage/uploads/project/main_image/thumbnail/home_r_' . @$image) }}"
                                        alt="{{ $project->title }}" />
                                </a>
                                <div class="thumbnail-classic-caption">
                                    <h6 class="thumbnail-classic-title"><a
                                            href="{{ route('project.details', $project->slug) }}">{{ $project->title }}</a>
                                    </h6>
                                    <div class="thumbnail-classic-time">
                                        {{ $project->service->name ?? '' }}
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                    {{-- <div class="col-md-6 col-lg-4 isotope-item" data-filter="Type 1">
                    <!-- Thumbnail Classic-->
                    <article class="thumbnail thumbnail-classic thumbnail-lg">
                        <a class="thumbnail-classic-figure" href="{{ route('project.details', 'project-one') }}">
                            <img src="{{ asset('frontend/images/project-1-570x299.jpg') }}" alt="" width="570" height="299" />
                        </a>
                        <div class="thumbnail-classic-caption">
                            <h6 class="thumbnail-classic-title"><a href="project-page.html">Project 1</a></h6>
                            <div class="thumbnail-classic-time">
                                <time datetime="2021-04-05">April 05, 2021</time>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="col-md-6 col-lg-4 isotope-item" data-filter="Type 2">
                    <!-- Thumbnail Classic-->
                    <article class="thumbnail thumbnail-classic thumbnail-lg">
                        <a class="thumbnail-classic-figure" href="{{ route('project.details', 'project-one') }}">
                            <img src="{{ asset('frontend/images/project-1-570x299.jpg') }}" alt="" width="570" height="299" />
                        </a>
                        <div class="thumbnail-classic-caption">
                            <h6 class="thumbnail-classic-title"><a href="project-page.html">Project 2</a></h6>
                            <div class="thumbnail-classic-time">
                                <time datetime="2021-04-05">April 05, 2021</time>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="col-md-6 col-lg-4 isotope-item" data-filter="Type 1">
                    <!-- Thumbnail Classic-->
                    <article class="thumbnail thumbnail-classic thumbnail-lg">
                        <a class="thumbnail-classic-figure" href="{{ route('project.details', 'project-one') }}">
                            <img src="{{ asset('frontend/images/project-1-570x299.jpg') }}" alt="" width="570" height="299" />
                        </a>
                        <div class="thumbnail-classic-caption">
                            <h6 class="thumbnail-classic-title"><a href="project-page.html">Project 1</a></h6>
                            <div class="thumbnail-classic-time">
                                <time datetime="2021-04-05">April 05, 2021</time>
                            </div>
                        </div>
                    </article>
                </div>

                <div class="col-md-6 col-lg-4 isotope-item" data-filter="Type ">
                    <!-- Thumbnail Classic-->
                    <article class="thumbnail thumbnail-classic thumbnail-lg">
                        <a class="thumbnail-classic-figure" href="{{ route('project.details', 'project-one') }}">
                            <img src="{{ asset('frontend/images/project-1-570x299.jpg') }}" alt="" width="570" height="299" />
                        </a>
                        <div class="thumbnail-classic-caption">
                            <h6 class="thumbnail-classic-title"><a href="project-page.html">Project 3</a></h6>
                            <div class="thumbnail-classic-time">
                                <time datetime="2021-04-05">April 05, 2021</time>
                            </div>
                        </div>
                    </article>
                </div><div class="col-md-6 col-lg-4 isotope-item" data-filter="Type 4">
                    <!-- Thumbnail Classic-->
                    <article class="thumbnail thumbnail-classic thumbnail-lg">
                        <a class="thumbnail-classic-figure" href="{{ route('project.details', 'project-one') }}">
                            <img src="{{ asset('frontend/images/project-1-570x299.jpg') }}" alt="" width="570" height="299" />
                        </a>
                        <div class="thumbnail-classic-caption">
                            <h6 class="thumbnail-classic-title"><a href="project-page.html">Project 4</a></h6>
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
                {{-- <nav aria-label="Page navigation">
                    <ul class="pagination"> --}}
                {{-- Previous Page Link --}}
                {{-- @if ($projects->onFirstPage())
                            <li class="page-item page-item-control disabled" aria-disabled="true"
                                aria-label="@lang('pagination.previous')">
                                <span class="page-link" aria-hidden="true"><span class="icon" aria-hidden="true"></span></span>
                            </li>
                        @else
                            <li class="page-item page-item-control">
                                <a class="page-link" href="{{ $projects->previousPageUrl() }}" rel="prev"
                                    aria-label="@lang('pagination.previous')"><span class="icon" aria-hidden="true"></span></a>
                            </li>
                        @endif --}}

                {{-- Pagination Elements --}}
                {{-- @foreach ($projects->links()->elements as $element) --}}
                {{-- "Three Dots" Separator --}}
                {{-- @if (is_string($element))
                                <li class="page-item disabled" aria-disabled="true"><span
                                        class="page-link">{{ $element }}</span></li>
                            @endif --}}

                {{-- Array Of Links --}}
                {{-- @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $projects->currentPage())
                                        <li class="page-item active" aria-current="page"><span
                                                class="page-link">{{ $page }}</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link"
                                                href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach --}}

                {{-- Next Page Link --}}
                {{-- @if ($projects->hasMorePages())
                            <li class="page-item page-item-control">
                                <a class="page-link" href="{{ $projects->nextPageUrl() }}" rel="next"
                                    aria-label="@lang('pagination.next')"><span class="icon" aria-hidden="true"></span></a>
                            </li>
                        @else
                            <li class="page-item page-item-control disabled" aria-disabled="true"
                                aria-label="@lang('pagination.next')">
                                <span class="page-link" aria-hidden="true"><span class="icon" aria-hidden="true"></span></span>
                            </li>
                        @endif
                    </ul>
                </nav> --}}
            </div>
        </div>
    </section>
@endsection
