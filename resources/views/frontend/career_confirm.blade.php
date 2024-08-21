@extends('frontend.layouts.master')

@section('content')

<section class="section section-lg bg-default text-left">
    <div class="container">
        <div class="row row-60 mt-0">
            <div class="col-lg-12 text-center">
                <!-- <h1 class="text-spacing-25 text-transform-none mb-3 wow fadeIn h4" data-wow-duration="1s" data-wow-delay=".7s"><b>Career Confirmation</b></h1> -->

                
                <div class="text-spacing-25 text-transform-none text-green h4"><b>Thankyou!</b></div>
                <div class=" text-transform-none text-green h4"> <span class="font-primary">You have Successfully Submitted Your Career Information.</span> 
                    <br/><b>Your Application Submission number is <span class="text-reg"> #{{ $applicant_details->id }}</b></span>
                </div>

                    <div className="text-email mb-md-5 pb-md-5 pb-lg-0 mb-lg-2 mt-2 h6 ">
                        For further details please contact us at <a class="mail" href="mailto:{{$shared_site_setting->email}}">{{$shared_site_setting->email}}</a>
                    </div>
                    <a href="{{route('home')}}" class="button button-primary">Back to Home</a>

                </div>
</section>

@endsection