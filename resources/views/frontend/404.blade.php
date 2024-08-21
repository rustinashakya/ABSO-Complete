@extends('frontend.layouts.master')

@section('content')
@php $is404 = true; @endphp
<section class="section section-single box-transform-wrap novi-background novi-background context-dark custom-page-not-found">
  <div class="section-single-inner">
    <header class="section-single-header page-header">
      <div class="page-head-inner"><a href="./"><img src="{{ asset('frontend/images/QYEC-logo-transparent.png') }}" alt="" width="219" height="39" /></a></div>
    </header>

    <div class="section-single-main">
      <div class="container">
        <div class="title-modern">404</div>
        <h4 class="text-spacing-0 text-transform-none">Page Not Found</h4><a class="button button-lg button-primary button-winona" href="{{ route('home') }}">Go to home page</a>
      </div>
    </div>
    <div class="section-single-footer">
      <div class="container text-center">
        <!-- Rights-->
        <p class="rights">© 2024 QYEC. Privacy policy</p>
      </div>
    </div>

  </div>
  <div class="box-transform" style="background-image: url('{{ asset('frontend/images/bg-404.jpg') }}');"></div>
</section>

@endsection