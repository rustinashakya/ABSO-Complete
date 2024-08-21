@extends('frontend.layouts.master')

@section('content')
    @php
        $html_title = $shared_site_setting->legal_document_html_title ?? 'QYEC';
        $meta_description = $shared_site_setting->legal_document_meta_description ?? 'QYEC';
        $meta_keyword = $shared_site_setting->legal_document_meta_keyword ?? 'QYEC';
        $favicon_url = asset('frontend/images/QYEC-logo.png');
        $page_url = url()->current();
    @endphp
    <!-- <section class="bg-gray-7">
            <div class="breadcrumbs-custom box-transform-wrap context-dark">
                <div class="container">
                    <h3 class="breadcrumbs-custom-title">Gallery</h3>
                    <div class="breadcrumbs-custom-decor"></div>
                </div>
                <div class="box-transform" style="background-image: url('{{ asset('frontend/images/bg-typography.jpg') }}');"></div>
            </div>
            <div class="container">
                <ul class="breadcrumbs-custom-path">
                    <li><a href="index.html">Home</a></li>
                    <li class="active">Gallery</li>
                </ul>
            </div>
        </section> -->

    <!-- Mining machinery-->
    @if (count($galleries) >= 1)
        <section class="section section-xl bg-default text-center">
            <div class="container">
                <h1 class="oh-desktop h4"><span class="d-inline-block wow slideInUp"><b>Legal Documents</b></span></h1>
            </div>
            <div class="container-fluid container-inset-0">
                <div class="row row-30 row-desktop-8 gutters-8 hoverdir" data-lightgallery="group">
                    @foreach ($galleries as $gallery)
                        <div class="col-sm-6 col-lg-4 col-xxl-3">
                            <div class="oh-desktop">
                                <article class="thumbnail thumbnail-modern wow slideInUp hoverdir-item"
                                    data-hoverdir-target=".thumbnail-modern-caption">
                                    <a class="thumbnail-modern-figure"
                                        href="{{ asset('/storage/uploads/gallery/main_image/' . $gallery->main_image) }}"
                                        alt="qyec" title="{{ $gallery->caption ?? 'Legal Document' }}"
                                        data-lightgallery="item">
                                        <img src="{{ asset('/storage/uploads/gallery/main_image/thumbnail/list_' . $gallery->main_image) }}"
                                            alt="qyec" title="{{ $gallery->caption ?? 'Legal Document' }}"
                                            width="474" height="355" />
                                    </a>
                                </article>
                            </div>
                        </div>
                    @endforeach
                    <!-- <div class="col-sm-6 col-lg-4 col-xxl-3">
                        <div class="oh-desktop">
                            <article class="thumbnail thumbnail-modern wow slideInUp hoverdir-item" data-hoverdir-target=".thumbnail-modern-caption"><a class="thumbnail-modern-figure" href="{{ asset('frontend/images/Certificates-07.jpg') }}" data-lightgallery="item"><img src="{{ asset('frontend/images/Certificates-07.jpg') }}" alt="" width="474" height="355" /></a>
                            </article>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4 col-xxl-3">
                        <div class="oh-desktop">
                            <article class="thumbnail thumbnail-modern wow slideInDown hoverdir-item" data-hoverdir-target=".thumbnail-modern-caption"><a class="thumbnail-modern-figure" href="{{ asset('frontend/images/Certificates-07.jpg') }}" data-lightgallery="item"><img src="{{ asset('frontend/images/Certificates-07.jpg') }}" alt="" width="474" height="355" /></a>
                            </article>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4 col-xxl-3">
                        <div class="oh-desktop">
                            <article class="thumbnail thumbnail-modern wow slideInUp hoverdir-item" data-hoverdir-target=".thumbnail-modern-caption"><a class="thumbnail-modern-figure" href="{{ asset('frontend/images/Certificates-08.jpg') }}" data-lightgallery="item"><img src="{{ asset('frontend/images/Certificates-08.jpg') }}" alt="" width="474" height="355" /></a>
                            </article>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4 col-xxl-3">
                        <div class="oh-desktop">
                            <article class="thumbnail thumbnail-modern wow slideInDown hoverdir-item" data-hoverdir-target=".thumbnail-modern-caption"><a class="thumbnail-modern-figure" href="{{ asset('frontend/images/Certificates-09.jpg') }}" data-lightgallery="item"><img src="{{ asset('frontend/images/Certificates-09.jpg') }}" alt="" width="474" height="355" /></a>
                            </article>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4 col-xxl-3">
                        <div class="oh-desktop">
                            <article class="thumbnail thumbnail-modern wow slideInDown hoverdir-item" data-hoverdir-target=".thumbnail-modern-caption"><a class="thumbnail-modern-figure" href="{{ asset('frontend/images/Certificates-10.jpg') }}" data-lightgallery="item"><img src="{{ asset('frontend/images/Certificates-10.jpg') }}" alt="" width="474" height="355" /></a>
                                
                            </article>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4 col-xxl-3">
                        <div class="oh-desktop">
                            <article class="thumbnail thumbnail-modern wow slideInUp hoverdir-item" data-hoverdir-target=".thumbnail-modern-caption"><a class="thumbnail-modern-figure" href="{{ asset('frontend/images/Certificates-11.jpg') }}" data-lightgallery="item"><img src="{{ asset('frontend/images/Certificates-11.jpg') }}" alt="" width="474" height="355" /></a>
                            </article>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4 col-xxl-3">
                        <div class="oh-desktop">
                            <article class="thumbnail thumbnail-modern wow slideInDown hoverdir-item" data-hoverdir-target=".thumbnail-modern-caption"><a class="thumbnail-modern-figure" href="{{ asset('frontend/images/Certificates-12.jpg') }}" data-lightgallery="item"><img src="{{ asset('frontend/images/Certificates-12.jpg') }}" alt="" width="474" height="355" /></a>
                            </article>
                        </div>
                    </div> -->

                </div>
            </div>
        </section>
    @else
        {{ view('frontend.coming_soon') }}
    @endif
@endsection
