@extends('frontend.layouts.master')

@section('content')

<section class="section section-lg bg-default text-left">
    <div class="container">
        <div class="row row-60 mt-0">
            <div class="col-lg-12 text-center">
            <h1 class="text-spacing-25 text-transform-none mb-3 wow fadeIn h4" data-wow-duration="1s" data-wow-delay=".7s"><b>Contact Confirmation</b></h1>

                <div class=" text-transform-none h5 text-green"> <span class="font-primary">Thankyou for submitting your contact information.</span><br>
                    <a href="{{route('home')}}" class="button button-primary">Back to Home</a>

                </div>

            </div>
        </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection