@extends('frontend.layouts.master')

@section('content')
    @php
        $html_title = $sector->html_title ?? 'QYEC';
        $meta_description = $sector->meta_description ?? 'QYEC';
        $meta_keyword = $sector->meta_keyword ?? 'QYEC';
        $favicon_url =
            asset('storage/uploads/sectors/main_image/' . $sector->main_image) ??
            asset('frontend/images/QYEC-logo.png');
        $page_url = url()->current();
    @endphp
    @if (empty($sector))
        {{ view('frontend.coming_soon') }}
    @else
        <!-- Breadcrumbs -->
        <!-- <section class="bg-gray-7">
            <div class="breadcrumbs-custom box-transform-wrap context-dark">
                <div class="container">
                    <h3 class="breadcrumbs-custom-title">{{ $sector->name }}</h3>
                    <div class="breadcrumbs-custom-decor"></div>
                </div>
                <div class="box-transform" style="background-image: url('{{ asset('frontend/images/bg-typography.jpg') }}');"></div>
            </div>
            <div class="container">
                <ul class="breadcrumbs-custom-path">
                    <li><a href="index.html">Home</a></li>
                    <li class="active">{{ $sector->name }}</li>
                </ul>
            </div>
        </section> -->
        <!-- Services 2-->
        <section class="section section-sm section-first bg-default text-left" id="sticky-sidebar-div">
            <div class="container">
                <div class="row flex-md-row-reverse">
                    <div class="col-md-5 col-xl-4 d-none d-md-block">
                        <div class="aside aside-services">
                            <div class="row row-60" id="sticky-sidebar">
                                <div class="aside-item col-12">
                                    <h2 class="aside-services-title h5">{{ $sector->sub_title }}</h2>
                                    <ul class="list-category">
                                        @foreach ($shared_sectors as $index => $other_sector)
                                            <li class="list-category-item wow fadeInRight" data-wow-duration="1s"
                                                data-wow-delay="{{ $index * 0.1 }}s"><a
                                                    class="{{ $sector->slug == $other_sector->slug ? 'active' : '' }}"
                                                    href="{{ route('sector', $other_sector->slug) }}">{{ $other_sector->name }}</a>
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- <aside id="sticky-sidebar" class="row-60">
                    <div class="aside aside-services">
                        <div class="row ">
                            <div class="aside-item col-12">
                                <h2 class="aside-services-title h5">{{ $sector->sub_title }}</h2>
                                <ul class="list-category">
                                    @foreach ($shared_sectors as $index => $other_sector)
    <li class="list-category-item wow fadeInRight" data-wow-duration="1s" data-wow-delay="{{ $index * 0.1 }}s"><a class="{{ $sector->slug == $other_sector->slug ? 'active' : '' }}" href="{{ route('sector', $other_sector->slug) }}">{{ $other_sector->name }}</a></li>
    @endforeach
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                    </aside> -->
                    </div>
                    <div class="col-md-7 col-xl-8">
                        <div class="single-service">
                            <img class="lazy wow customFadeIn" data-wow-duration="1s" data-wow-delay=".5s"
                                src="{{ asset('/storage/uploads/sectors/main_image/' . $sector->main_image) }}"
                                alt="qyec" title="{{ $sector->main_image }}" />
                            <div class="mt-4 wow slideInUp" data-wow-duration="1s" data-wow-delay=".2s">
                                <h1 class="h4"><b>{{ $sector->name }}</b></h1 class="h4">
                                <div class="description-custom"> {!! $sector->description !!} </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @if ($projects->isNotEmpty())
            <h2 class="wow slideInUp h5"><b>List Of {{ $sector->name }} Projects</b></h2>


            <section class="section section-lg bg-default">
                <div class="container">
                    <div class="isotope-wrap">
                        <!-- <div class="isotope-filters isotope-filters-horizontal">
                            <button class="isotope-filters-toggle button button-sm button-icon button-icon-right button-gray-3" data-custom-toggle=".isotope-filters-list" data-custom-toggle-disable-on-blur="true"><span class="icon mdi mdi-chevron-down"></span>Filter</button>
                            <ul class="isotope-filters-list">
                                <li><a class="active" href="#" data-isotope-filter="*" data-isotope-group="gallery">All</a></li>
                                <li><a href="#" data-isotope-filter="Type 1" data-isotope-group="gallery">Hydropower</a></li>
                                <li><a href="#" data-isotope-filter="Type 2" data-isotope-group="gallery">Water Conservancy</a></li>
                            </ul>
                        </div> -->
                        <div class="row isotope" data-isotope-layout="masonry" data-column-class=".col-1">
                            <div class="col-1 isotope-item isotope-sizer"></div>


                            @foreach ($projects as $project)
                                @php
                                    $image = App\Models\ProjectImage::where('project_id', $project->id)
                                        ->where('main_image', '!=', 'null')
                                        ->first()->main_image;
                                @endphp
                                <div class="col-md-6 col-lg-4 isotope-item wow slideInUp">
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

                        </div>
                    </div>
                </div>
            </section>
        @endif

    @endif

@endsection

@section('scripts')
    <script>
        $(function() {
            // var headerHt = $('.rd-navbar-wrap').outerHeight()
            var headerHt = $('.rd-navbar-panel').outerHeight()
            // Select the sidebar element
            var sidebar = document.getElementById('sticky-sidebar');
            // Select the sidebar element's parent section
            var sidebarDiv = document.getElementById('sticky-sidebar-div');

            // Get the initial position of the sidebar
            var sidebarTopOffset = sidebar.offsetTop;

            // Function to handle scroll event
            function stickySidebar() {
                var scrollTop = window.pageYOffset;
                var sidebarDivBottom = sidebarDiv.offsetTop + sidebarDiv.offsetHeight;

                // Check if the window has scrolled past the sidebar and is inside the sidebar's parent section
                if (scrollTop > sidebarTopOffset && scrollTop < sidebarDivBottom - sidebar.offsetHeight -
                    headerHt) {
                    sidebar.classList.add('sticky');
                    sidebar.style.position = 'fixed';
                    sidebar.style.top = headerHt + 'px';
                    sidebar.style.bottom = ''; // Reset bottom style
                }

                // Check if the window has scrolled past the sidebar's parent section
                else if (scrollTop >= sidebarDivBottom - sidebar.offsetHeight - headerHt) {
                    sidebar.classList.remove('sticky');
                    sidebar.style.position = 'absolute';
                    sidebar.style.top = ''; // Reset top style
                    sidebar.style.bottom = '0'; // Fix to bottom of the parent
                } else if (scrollTop <= sidebarDiv.offsetTop) {
                    sidebar.classList.remove('sticky');
                    sidebar.style.position = '';
                    sidebar.style.top = '';
                    sidebar.style.bottom = '';
                }
            }

            // Attach scroll event listener
            window.addEventListener('scroll', stickySidebar);
            stickySidebar(); // Call the function on page load

        })
    </script>
@endsection
