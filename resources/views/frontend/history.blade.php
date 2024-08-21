@extends('frontend.layouts.master')

@section('content')
@php
    $html_title = $shared_site_setting->history_html_title ?? null;
    $meta_description = $shared_site_setting->history_meta_description ?? null;
    $meta_keyword = $shared_site_setting->history_meta_keyword ?? null;
@endphp
      <!-- Our History-->
      <section class="section section-lg bg-gray-100 text-left section-relative">
        <div class="container">
          <div class="row row-60 justify-content-center justify-content-xxl-between">
            <div class="col-lg-6 col-xxl-5 position-static">
              <h4><b>Our history</b></h4>
              <div class="tabs-custom mt-3" id="tabs-5">
                <div class="tab-content tab-content-1">
                  <div class="tab-pane fade" id="tabs-5-1">
                    <h5 class="font-weight-normal text-transform-none text-spacing-75">Establishment of Civil Group & first successful projects</h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Suspendisse interdum consectetur</p>
                  </div>
                  <div class="tab-pane fade" id="tabs-5-2">
                    <h5 class="font-weight-normal text-transform-none text-spacing-75">Partnering with national construction companies</h5>
                    <p>Scelerisque mauris pellentesque pulvinar pellentesque habitant morbi. Blandit cursus risus at ultrices mi tempus imperdiet. A cras semper auctor neque vitae. </p>
                  </div>
                  <div class="tab-pane fade" id="tabs-5-3">
                    <h5 class="font-weight-normal text-transform-none text-spacing-75">First governmental projects and engineering solutions awards</h5>
                    <p>Eu scelerisque felis imperdiet proin fermentum leo vel orci. Vulputate enim nulla aliquet porttitor lacus luctus accumsan tortor posuere. </p>
                  </div>
                  <div class="tab-pane fade show active" id="tabs-5-4">
                    <h5 class="font-weight-normal text-transform-none text-spacing-75">Celebrating 25 years of Civil Group’s success</h5>
                    <p>Cursus eget nunc scelerisque viverra mauris in aliquam sem fringilla. Viverra nibh cras pulvinar mattis nunc sed. Amet consectetur adipiscing </p>
                  </div>
                </div>
                <div class="list-history-wrap">
                  <ul class="nav list-history">
                    <li class="list-history-item" role="presentation"><a href="#tabs-5-1" data-toggle="tab">
                        <div class="list-history-circle"></div>1994</a></li>
                    <li class="list-history-item" role="presentation"><a href="#tabs-5-2" data-toggle="tab">
                        <div class="list-history-circle"></div>2002</a></li>
                    <li class="list-history-item" role="presentation"><a href="#tabs-5-3" data-toggle="tab">
                        <div class="list-history-circle"></div>2010</a></li>
                    <li class="list-history-item" role="presentation"><a class="active" href="#tabs-5-4" data-toggle="tab">
                        <div class="list-history-circle"></div>2021</a></li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-md-9 col-lg-6 position-static index-1">
              <div class="bg-image-right-1 bg-image-right-lg"><img src="{{ asset('frontend/images/about-5-1110x710.jpg') }}" alt="qyec" width="1110" height="710" title="history"/>
                <!-- <div class="link-play-modern"><a class="icon mdi mdi-play" data-lightbox="iframe" href="https://www.youtube.com/watch?v=1UWpbtUupQQ"></a>
                  <div class="link-play-modern-title">How we<span>Work</span></div>
                  <div class="link-play-modern-decor"></div>
                </div> -->
                <div class="box-transform" style="background-image: url('{{ asset('frontend/images/about-5-1110x710.jpg') }}');"></div>
              </div>
            </div>
          </div>
        </div>
      </section>

@endsection