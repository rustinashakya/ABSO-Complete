<!-- Page Header-->
<header class="section page-header {{ @$headnav == 'home' ? '':'my-other-header' }}">
    <!-- RD Navbar-->
    <div class="rd-navbar-wrap">
        <nav class="rd-navbar rd-navbar-modern" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-fixed" data-lg-device-layout="rd-navbar-fixed" data-xl-layout="rd-navbar-static" data-xl-device-layout="rd-navbar-static" data-xxl-layout="rd-navbar-static" data-xxl-device-layout="rd-navbar-static" data-lg-stick-up-offset="150px" data-xl-stick-up-offset="150px" data-xxl-stick-up-offset="150px" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true">
            <div class="rd-navbar-inner-outer">
                <!-- <div class="rd-navbar-aside">
                <div class="rd-navbar-aside-inner">
                  <ul class="rd-navbar-contacts-2">
                    <li>
                      <div class="unit unit-spacing-xs">
                        <div class="unit-left"><span class="icon mdi mdi-phone"></span></div>
                        <div class="unit-body"><a class="phone" href="tel:#">+86 28 8739 7141</a></div>
                      </div>
                    </li>
                    <li>
                      <div class="unit unit-spacing-xs">
                        <div class="unit-left"><span class="icon mdi mdi-map-marker"></span></div>
                        <div class="unit-body"><a class="address" href="javascript:void(0)">
                          9 CaotangRoad, Qingyang Disctirct, Chengdu, Sichuan, China 610072
                        </a></div>
                      </div>
                    </li>
                  </ul>
                  <ul class="list-share-2">
                    <li><a class="icon mdi mdi-facebook" href="javascript:void(0)"></a></li>
                    <li><a class="icon mdi mdi-twitter" href="javascript:void(0)"></a></li>
                    <li><a class="icon mdi mdi-instagram" href="javascript:void(0)"></a></li>
                  </ul>
                </div>
              </div> -->
                <div class="rd-navbar-inner">
                    <!-- RD Navbar Panel-->
                    <div class="rd-navbar-panel py-0">
                        <!-- RD Navbar Toggle-->
                        <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
                        <!-- RD Navbar Brand-->
                        <div class="rd-navbar-brand"><a class="brand" href="{{route('home')}}"><img class="brand-logo-dark lazy" data-src="{{ asset('frontend/images/QYEC-logo.png') }}" alt="" width="219" height="39" /></a></div>
                    </div>
                    <div class="rd-navbar-right rd-navbar-nav-wrap">
                        <div class="rd-navbar-aside d-xl-none pr-2">
                            <div class="rd-navbar-aside-inner">
                                <ul class="rd-navbar-contacts-2">
                                    <li>
                                        <div class="unit unit-spacing-xs">
                                            <div class="unit-left"><span class="icon mdi mdi-phone"></span></div>
                                            <div class="unit-body"><a class="phone" href="tel:{{$shared_site_setting->phone_no}}" title="Call {{$shared_site_setting->phone_no}}">{{$shared_site_setting->phone_no}}</a> <br/>
                                            <a class="phone" href="tel:+86 28 87397141" title="Call +86 28 87397141">+86 28 87397141</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="unit unit-spacing-xs mt-2">
                                            <div class="unit-left"><span class="icon mdi mdi-email"></span></div>
                                            <div class="unit-body"><a class="mail" href="mailto:{{$shared_site_setting->email}}" title="Mail to {{$shared_site_setting->email}}">{{$shared_site_setting->email}}</a></div>
                                        </div>
                                    </li>
                                    <!-- <li>
                                        <div class="unit unit-spacing-xs mt-2">
                                            <div class="unit-left"><span class="icon mdi mdi-map-marker"></span></div>
                                            <div class="unit-body">
                                                <a class="phone" href="javascript:void(0)" title="{{$shared_site_setting->address}}">{{$shared_site_setting->address}}</a><br/>
                                                <a class="phone" href="javascript:void(0)" title="9 Caotang Road, Chengdu, Sichuan, P.R.China">9 Caotang Road, Chengdu, Sichuan, P.R.China</a>
                                            </div>
                                        </div>
                                    </li> -->
                                </ul>
                                <ul class="list-share-2">
                                    @if(!empty($shared_site_setting->facebook))
                                        <li><a class="icon mdi mdi-facebook" title="View on facebook" target="_blank" href="{{$shared_site_setting->facebook}}"></a></li>
                                    @endif
                                    @if(!empty($shared_site_setting->twitter))
                                        <li><a class="icon mdi mdi-twitter" title="View on twitter" target="_blank" href="{{$shared_site_setting->twitter}}"></a></li>
                                    @endif
                                    @if(!empty($shared_site_setting->instagram))
                                        <li><a class="icon mdi mdi-instagram" title="View on instagram" target="_blank" href="{{$shared_site_setting->instagram}}"></a></li>
                                    @endif
                                    @if(!empty($shared_site_setting->google_plus))
                                        <li><a class="icon mdi mdi-google-plus" title="View on google plus" target="_blank" href="{{$shared_site_setting->google_plus}}"></a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="rd-navbar-main">
                            <!-- RD Navbar Nav-->
                            <ul class="rd-navbar-nav">
                                <li class="rd-nav-item {{ @$headnav == 'about' ? 'active':'' }}"><a class="rd-nav-link" href="javascript:void(0)">About</a>
                                    <ul class="rd-menu rd-navbar-megamenu">
                                        <li class="rd-megamenu-item menu-display">

                                            <img src="{{ asset('frontend/images/menu_building.jpg') }}" alt="">
                                            <!-- <h6 class="rd-megamenu-title">Services</h6> -->
                                            <ul class="rd-megamenu-list">
                                                <li class="rd-megamenu-list-item"><a href="{{ route('page', 'about-qyec') }}" class="rd-megamenu-list-link pr-1">About QYEC</a></li>
                                                <li class="rd-megamenu-list-item"><a href="{{ route('team') }}" class="rd-megamenu-list-link pr-1">Our Team</a></li>
                                                <li class="rd-megamenu-list-item"><a href="{{ route('page', 'organisational-chart') }}" class="rd-megamenu-list-link pr-1">Organisational chart</a></li>
                                                <li class="rd-megamenu-list-item"><a href="{{ route('gallery') }}" class="rd-megamenu-list-link pr-1">Legal Documents</a></li>
                                            </ul>
                                        </li>
                                        <li class="rd-megamenu-item menu-display">
                                            <img src="{{ asset('frontend/images/career-page-bg.jpg') }}" alt="">
                                            <ul class="rd-megamenu-list">
                                                <!-- <li class="rd-megamenu-list-item"><a href="{{ route('history') }}" class="rd-megamenu-list-link">Our History</a></li> -->
                                                <li class="rd-megamenu-list-item"><a href="{{ route('clientele') }}" class="rd-megamenu-list-link">Our Clientèle</a></li>
                                                <li class="rd-megamenu-list-item"><a href="{{ route('contact') }}" class="rd-megamenu-list-link">Contact Us</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li class="rd-nav-item {{ @$headnav == 'sectors' ? 'active':'' }}"><a class="rd-nav-link" href="javascript:void(0)">Sectors</a>
                                    <!-- RD Navbar Megamenu-->
                                    <ul class="rd-menu rd-navbar-dropdown">
                                        @foreach ($shared_sectors as $sector)
                                            <li class="rd-dropdown-item"><a href="{{ route('sector', $sector->slug) }}" class="rd-dropdown-link pr-1">{{ $sector->name }}</a></li>
                                        @endforeach
                                    </ul>
                                    <!-- <ul class="rd-menu rd-navbar-megamenu">
                                        <li class="rd-megamenu-item">
                                            <ul class="rd-megamenu-list">
                                                <li class="rd-megamenu-list-item"><a href="{{ route('sector', 'hydropower') }}" class="rd-megamenu-list-link">Hydropower</a></li>
                                                <li class="rd-megamenu-list-item"><a href="{{ route('sector', 'water-conservancy') }}" class="rd-megamenu-list-link">Water Conservancy</a></li>
                                            </ul>
                                        </li>
                                        <li class="rd-megamenu-item">
                                            <ul class="rd-megamenu-list">
                                                <li class="rd-megamenu-list-item"><a href="{{ route('sector', 'transmission-line-substation') }}" class="rd-megamenu-list-link">Transmission Line Substation</a></li>
                                                <li class="rd-megamenu-list-item"><a href="{{ route('sector', 'other-renewable-energy') }}" class="rd-megamenu-list-link">Renewable Energy: Solar, Wind, Waste, etc.</a></li>
                                            </ul>
                                        </li>
                                    </ul> -->
                                </li>
                                <li class="rd-nav-item {{ @$headnav == 'services' ? 'active':'' }}"><a class="rd-nav-link" href="javascript:void(0)">Services</a>
                                    <!-- RD Navbar Megamenu-->
                                    <ul class="rd-menu rd-navbar-dropdown">
                                        @foreach ($shared_services as $service)
                                            <li class="rd-dropdown-item"><a href="{{ route('service', $service->slug) }}" class="rd-dropdown-link pr-1">{{ $service->name }}</a></li>
                                        @endforeach
                                        {{-- <li class="rd-dropdown-item"><a href="{{ route('service', 'engineering-design') }}" class="rd-dropdown-link">Engineering Design</a></li> --}}
                                        {{-- <li class="rd-dropdown-item"><a href="{{ route('service', 'epc') }}" class="rd-dropdown-link">EPC</a></li>
                                        <li class="rd-dropdown-item"><a href="{{ route('service', 'design-review') }}" class="rd-dropdown-link">Design Review</a></li>
                                        <li class="rd-dropdown-item"><a href="{{ route('service', 'consultation') }}" class="rd-dropdown-link">Consultation</a></li>
                                        <li class="rd-dropdown-item"><a href="{{ route('service', 'office-buildings') }}" class="rd-dropdown-link">Office Buildings</a></li> --}}
                                    </ul>
                                </li>
                                <li class="rd-nav-item {{ @$headnav == 'projects' ? 'active':'' }}"><a class="rd-nav-link" href="{{ route('project') }}">Projects</a>
                                <li class="rd-nav-item {{ @$headnav == 'investments' ? 'active':'' }}"><a class="rd-nav-link" href="{{ route('investment') }}">Investment Portfolio</a>
                                </li>
                                <!-- <li class="rd-nav-item"><a class="rd-nav-link" href="{{ route('career') }}">Career</a>
                                </li> -->
                                <!-- <li class="rd-nav-item"><a class="rd-nav-link">Investment</a></li> -->
                                <!-- <li class="rd-nav-item"><a class="rd-nav-link">News</a> -->
                                    <!-- RD Navbar Dropdown-->
                                </li>
                                <!-- <li class="rd-nav-item {{ @$headnav == 'contact' ? 'active':'' }}"><a class="rd-nav-link" href="{{ route('contact') }}">Contact Us</a> -->
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- <div class="rd-navbar-project-hamburger rd-navbar-project-hamburger-open rd-navbar-fixed-element-1" data-multitoggle=".rd-navbar-inner" data-multitoggle-blur=".rd-navbar-wrap" data-multitoggle-isolate="data-multitoggle-isolate">
                        <div class="project-hamburger"><span class="project-hamburger-arrow"></span><span class="project-hamburger-arrow"></span><span class="project-hamburger-arrow"></span>
                        </div>
                    </div>
                    <div class="rd-navbar-project">
                        <div class="rd-navbar-project-header">
                            <h5 class="rd-navbar-project-title">Latest Projects</h5>
                            <div class="rd-navbar-project-hamburger rd-navbar-project-hamburger-close" data-multitoggle=".rd-navbar-inner" data-multitoggle-blur=".rd-navbar-wrap" data-multitoggle-isolate="data-multitoggle-isolate">
                                <div class="project-close"><span></span><span></span></div>
                            </div>
                        </div>
                        <div class="rd-navbar-project-content rd-navbar-content">
                            <div>
                                <div class="row gutters-20" data-lightgallery="group">
                                    <div class="col-6">
                                        <article class="thumbnail thumbnail-creative"><a href="{{ asset('frontend/images/Wuyiqiao-Hydropower-Station.jpg') }}" data-lightgallery="item">
                                                <div class="thumbnail-creative-figure"><img class="lazy" data-src="{{ asset('frontend/images/Wuyiqiao-Hydropower-Station-small.png') }}" alt="" width="195" height="164" />
                                                </div>
                                                <div class="thumbnail-creative-caption"><span class="icon thumbnail-creative-icon linearicons-magnifier"></span></div>
                                            </a></article>
                                    </div>
                                    <div class="col-6">
                                        <article class="thumbnail thumbnail-creative"><a href="{{ asset('frontend/images/Hekou-Hydropower-Station_11zon.jpg') }}" data-lightgallery="item">
                                                <div class="thumbnail-creative-figure"><img class="lazy" data-src="{{ asset('frontend/images/Hekou-Hydropower-Station_.png') }}" alt="" width="195" height="164" />
                                                </div>
                                                <div class="thumbnail-creative-caption"><span class="icon thumbnail-creative-icon linearicons-magnifier"></span></div>
                                            </a></article>
                                    </div>
                                    <div class="col-6">
                                        <article class="thumbnail thumbnail-creative"><a href="{{ asset('frontend/images/Erdaogiao Hydropower Station.jpg') }}" data-lightgallery="item">
                                                <div class="thumbnail-creative-figure"><img class="lazy" data-src="{{ asset('frontend/images/Erdaogiao Hydropower-small.png')}}" alt="" width="195" height="164" />
                                                </div>
                                                <div class="thumbnail-creative-caption"><span class="icon thumbnail-creative-icon linearicons-magnifier"></span></div>
                                            </a></article>
                                    </div>
                                    <div class="col-6">
                                        <article class="thumbnail thumbnail-creative"><a href="{{ asset('frontend/images/Taka-Hydropower-Station.jpg') }}" data-lightgallery="item">
                                                <div class="thumbnail-creative-figure"><img class="lazy" data-src="{{ asset('frontend/images/Taka-Hydropower-Station-small.png')}} " alt="" width="195" height="164" />
                                                </div>
                                                <div class="thumbnail-creative-caption"><span class="icon thumbnail-creative-icon linearicons-magnifier"></span></div>
                                            </a></article>
                                    </div>
                                    <div class="col-6">
                                        <article class="thumbnail thumbnail-creative"><a href="{{ asset('frontend/images/Bipenggou-Hydropower-Station_11zon-980x524%20(1).jpg') }}" data-lightgallery="item">
                                                <div class="thumbnail-creative-figure"><img class="lazy" data-src="{{ asset('frontend/images/Bipenggou-Hydropower-Station_.png') }}" alt="" width="195" height="164" />
                                                </div>
                                                <div class="thumbnail-creative-caption"><span class="icon thumbnail-creative-icon linearicons-magnifier"></span></div>
                                            </a></article>
                                    </div>
                                    <div class="col-6">
                                        <article class="thumbnail thumbnail-creative"><a href="{{ asset('frontend/images/Hongba-Hydropower-Station_11zon.jpg') }}" data-lightgallery="item">
                                                <div class="thumbnail-creative-figure"><img class="lazy" data-src="{{ asset('frontend/images/Hongba-Hydropower-Station-small (1).png') }}" alt="" width="195" height="164" />
                                                </div>
                                                <div class="thumbnail-creative-caption"><span class="icon thumbnail-creative-icon linearicons-magnifier"></span></div>
                                            </a></article>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </nav>
    </div>
</header>