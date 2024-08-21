@extends('frontend.layouts.master')

@section('content')
    @php
        $html_title = $shared_site_setting->client_html_title ?? 'QYEC';
        $meta_description = $shared_site_setting->client_meta_description ?? 'QYEC';
        $meta_keyword = $shared_site_setting->client_meta_keyword ?? 'QYEC';
        $favicon_url = asset('frontend/images/QYEC-logo.png');
        $page_url = url()->current();
    @endphp
    @if (count($clients) >= 1)
        <section class="section section-xl bg-gray-100 text-md-left">
            <div class="container">
                <div class="row row-60 justify-content-center flex-lg-row-reverse">
                    <div class="col-12">
                        <h1 class="oh-desktop h4"><span class="d-inline-block wow slideInLeft">Our Clientele</span></h1>
                    </div>
                    <div class="col-12">
                        <!-- <div class="row">
                            <div class="col-sm-6 wow fadeInLeft">
                                <div class="clients-classic"><a class="clients-classic-figure" href="javascript:void(0)"><img class="lazy" data-src="{{ asset('frontend/images/qyec-our-clients-1.jpg') }}" alt="" width="200" height="90" /></a></div>
                            </div>
                            <div class="col-sm-6 wow fadeInRight">
                                <div class="clients-classic"><a class="clients-classic-figure" href="javascript:void(0)"><img class="lazy pl-3" data-src="{{ asset('frontend/images/qyec-our-clients-2.jpg') }}" alt="" width="200" height="90" /></a></div>
                            </div>
                            <div class="col-sm-6 wow fadeInLeft">
                                    <div class="clients-classic"><a class="clients-classic-figure" href="javascript:void(0)"><img class="lazy" data-src="{{ asset('frontend/images/qyec-our-clients-3.jpg') }}" alt="" width="200" height="90" /></a></div>
                                </div>
                                <div class="col-sm-6 wow fadeInRight">
                                    <div class="clients-classic"><a class="clients-classic-figure" href="javascript:void(0)"><img class="lazy pl-4" data-src="{{ asset('frontend/images/logo4.png') }}" alt="" width="200" height="90" /></a></div>
                                </div>
                                <div class="col-sm-6 wow fadeInLeft">
                                    <div class="clients-classic"><a class="clients-classic-figure" href="javascript:void(0)"><img class="lazy" data-src="{{ asset('frontend/images/logo5.png') }}" alt="" width="200" height="90" /></a></div>
                                </div>
                                <div class="col-sm-6 wow fadeInRight">
                                    <div class="clients-classic"><a class="clients-classic-figure" href="javascript:void(0)"><img class="lazy" data-src="{{ asset('frontend/images/qyec-our-clients-6.jpg') }}" alt="" width="200" height="90" /></a></div>
                                </div>
                        </div> -->
                        <div class="clients-classic-wrap">
                            @foreach ($clients as $index => $client)
                                @if ($index % 2 == 0)
                                    <div class="row no-gutters">
                                @endif
                                <div class="col-sm-6 wow fadeIn{{ $index % 2 == 0 ? 'Left' : 'Right' }}">
                                    <div class="clients-classic">
                                        <a class="clients-classic-figure" href="{{ $client->url ?? 'javascript:void(0)' }}"
                                            @if (isset($client->url)) target="_blank" @endif>
                                            <img class="lazy"
                                                data-src="{{ asset('/storage/uploads/clients/organisation_logo/' . $client->organisation_logo) }}"
                                                alt="qyec" width="200" height="90" title="{{ $client->name }}" />
                                        </a>
                                    </div>
                                </div>
                                @if ($index % 2 == 1)
                        </div>
    @endif
    @endforeach
    @if (count($clients) % 2 != 0)
        </div>
    @endif
    <!-- <div class="row no-gutters">
                                <div class="col-sm-6 wow fadeInLeft">
                                    <div class="clients-classic"><a class="clients-classic-figure" href="javascript:void(0)"><img class="lazy" data-src="{{ asset('frontend/images/qyec-our-clients-1.jpg') }}" alt="" width="200" height="90" /></a></div>
                                </div>
                                <div class="col-sm-6 wow fadeInRight">
                                    <div class="clients-classic"><a class="clients-classic-figure" href="javascript:void(0)"><img class="lazy pl-3" data-src="{{ asset('frontend/images/qyec-our-clients-2.jpg') }}" alt="" width="200" height="90" /></a></div>
                                </div>
                            </div>
                            <div class="row no-gutters">
                                <div class="col-sm-6 wow fadeInLeft">
                                    <div class="clients-classic"><a class="clients-classic-figure" href="javascript:void(0)"><img class="lazy" data-src="{{ asset('frontend/images/qyec-our-clients-3.jpg') }}" alt="" width="200" height="90" /></a></div>
                                </div>
                                <div class="col-sm-6 wow fadeInRight">
                                    <div class="clients-classic"><a class="clients-classic-figure" href="javascript:void(0)"><img class="lazy pl-4" data-src="{{ asset('frontend/images/logo4.png') }}" alt="" width="200" height="90" /></a></div>
                                </div>
                            </div>
                            <div class="row no-gutters">
                                <div class="col-sm-6 wow fadeInLeft">
                                    <div class="clients-classic"><a class="clients-classic-figure" href="javascript:void(0)"><img class="lazy" data-src="{{ asset('frontend/images/logo5.png') }}" alt="" width="200" height="90" /></a></div>
                                </div>
                                <div class="col-sm-6 wow fadeInRight">
                                    <div class="clients-classic"><a class="clients-classic-figure" href="javascript:void(0)"><img class="lazy" data-src="{{ asset('frontend/images/qyec-our-clients-6.jpg') }}" alt="" width="200" height="90" /></a></div>
                                </div>
                            </div> -->
    </div>
    </div>
    </div>
    </div>
    </section>
@else
    {{ view('frontend.coming_soon') }}
    @endif
@endsection
