<!-- Page Footer-->
<footer class="section footer-classic context-dark footer-classic-2">
    <div class="footer-classic-content">
        <div class="container">
            <div class="row row-50 row-lg-0 no-gutters">
                <div class="col-sm-6 col-lg-4 wow fadeInRight" data-wow-delay="0s">
                    <div class="footer-classic-header">
                        <h6 class="footer-classic-title">Quick links</h6>
                    </div>
                    <div class="footer-classic-body">
                        <ul class="footer-classic-list d-inline-block d-sm-block">
                            <li><a href="{{route('page','about-qyec')}}">About QYEC</a></li>
                            <li><a href="{{route('team')}}">Our Team</a></li>
                            <li><a href="{{route('project')}}">Projects</a></li>
                            <li><a href="{{ route('investment') }}">Investment Portfolio</a></li>
                            <li><a href="{{route('career')}}">Career</a></li>
                            <li><a href="{{ route('news') }}">News</a></li>
                            <li><a href="{{ route('gallery') }}">Legal Documents</a></li>
                            <li><a href="{{ route('clientele') }}">Our Clientele</a></li>
                        </ul>
                        <ul class="list-inline footer-social-list">
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
                <div class="col-sm-6 col-lg-4 wow fadeInRight" data-wow-delay=".1s">
                    <div class="footer-classic-header">
                        <div class="box-width-230">
                            <h6 class="footer-classic-title">HEADQUARTERS</h6>
                        </div>
                    </div>
                    <div class="footer-classic-body">
                        <div class="box-width-230">
                            <div class="footer-classic-contacts">
                                <div class="footer-classic-contacts-item">
                                    <div class="unit unit-spacing-sm align-items-center">
                                        <div class="unit-left"><span class="icon icon-24 mdi mdi-map-marker"></span></div>
                                        <div class="unit-body"><a class="phone" href="javascript:void(0)" title="9 Caotang Road, Chengdu, Sichuan, P.R.China">9 Caotang Road, Chengdu, Sichuan, P.R.China</a></div>
                                    </div>
                                </div>
                                <div class="footer-classic-contacts-item">
                                    <div class="unit unit-spacing-sm align-items-center">
                                        <div class="unit-left"><span class="icon icon-24 mdi mdi-phone"></span></div>
                                        <div class="unit-body"><a class="phone" href="tel:+86 28 87397141" title="Call +86 28 87397141">+86 28 87397141</a></div>
                                    </div>
                                </div>
                                <div class="footer-classic-contacts-item">
                                    <div class="unit unit-spacing-sm align-items-center">
                                        <div class="unit-left"><span class="icon mdi mdi-email"></span></div>
                                        <div class="unit-body"><a class="mail" href="mailto:{{$shared_site_setting->email}}" title="Mail to {{$shared_site_setting->email}}">{{$shared_site_setting->email}}</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 position-static">
                    <div class="footer-classic-header border-0_">
                        <div class="box-width-230">
                            <h6 class="footer-classic-title">Nepal Office</h6>
                        </div>
                    </div>
                    <div class="footer-classic-body">
                        <div class="box-width-230">
                            <div class="footer-classic-contacts">
                                <div class="footer-classic-contacts-item">
                                    <div class="unit unit-spacing-sm align-items-center">
                                        <div class="unit-left"><span class="icon icon-24 mdi mdi-map-marker"></span></div>
                                        <div class="unit-body"><a class="phone" href="javascript:void(0)" title="{{$shared_site_setting->address}}">{{$shared_site_setting->address}}</a></div>
                                    </div>
                                </div>
                                <div class="footer-classic-contacts-item">
                                    <div class="unit unit-spacing-sm align-items-center">
                                        <div class="unit-left"><span class="icon icon-24 mdi mdi-phone"></span></div>
                                        <div class="unit-body"><a class="phone" href="tel:{{$shared_site_setting->phone_no}}" title="Call {{$shared_site_setting->phone_no}}">{{$shared_site_setting->phone_no}}</a></div>
                                    </div>
                                </div>
                                <!-- <div class="footer-classic-contacts-item">
                                    <div class="unit unit-spacing-sm align-items-center">
                                        <div class="unit-left"><span class="icon mdi mdi-email"></span></div>
                                        <div class="unit-body"><a class="mail" href="mailto:{{$shared_site_setting->email}}" title="Mail to {{$shared_site_setting->email}}">{{$shared_site_setting->email}}</a></div>
                                    </div>
                                </div> -->
                            </div>
                            <a class="button button-sm button-primary button-winona" href="{{route('contact')}}">Contact Us</a>
                        </div>
                    </div>
                    <!-- <div class="map-padding">
                        <iframe class="my-map w-100" src="{{$shared_site_setting->google_map}}" width="600px" height="250px" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <div class="overlay"></div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <div class="footer-classic-panel">
        <div class="container">
            <!-- Rights-->
            <p class="rights text-white"><span>&copy;&nbsp;</span><span class="copyright-year"></span><span>&nbsp;</span><span>QYEC</span><span>.&nbsp;</span><a href="{{route('page','privacy-policy')}}">Privacy policy</a></p>
        </div>
    </div>
</footer>