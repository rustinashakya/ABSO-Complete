{{-- <x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ml-3">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout> --}}
@extends('auth.layout')
@section('content')
<div class="text-center">
    @if( session('reset-password-msg'))
<div class="alert alert-success  alert-dismissible fade show" id="success-alert">{{session('reset-password-msg')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
<img style="width:50%; margin-bottom: 16px" src="{{asset('assets/images/Logos/Logo_big-removebg-preview.png')}}" alt="qyec" class="img-fluid">
{{-- <h5>Hoper </h5> --}}
</div>
 <h5 class="login-box-msg">Sign in</h5>
 @if( session('message'))
                    <div class="alert alert-success  alert-dismissible fade show">{{session('message')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
<form action="{{route('admin.login')}}" method="post">
  @csrf
  <div class="input-group mb-3">
    <input type="email" class="form-control @if ($errors->has('email'))  is-invalid @endif" placeholder="Email" name="email" autocomplete="off">
    <div class="input-group-append">
      <div class="input-group-text">
        <span class="fas fa-envelope"></span>
      </div>
    </div>
  </div>
  <div class="input-group mb-3">
    <input type="password" class="form-control @if ($errors->has('password')) is-invalid @endif" placeholder="Password" name="password" autocomplete="off">
    <div class="input-group-append">
      <div class="input-group-text">
        <span class="fas fa-lock"></span>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="form-group mt-1 ml-1 pl-1">
        <div class="captcha">
            <span>{!! app('captcha')->display() !!}</span>
            {{-- <button type="button" class="btn btn-success refresh-cpatcha"><i class="fa fa-refresh"></i></button> --}}
        </div>

        {{-- @error('g-recaptcha-response')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror --}}
    </div>
    {{-- <div class="col-8">
      <div class="icheck-primary">
        <input type="checkbox" id="remember" name="remember" value="1">
        <label for="remember">
          Remember Me
        </label>
      </div>
    </div> --}}

    <!-- /.col -->
    <div class="col-4">
      <button type="submit" class="btn btn-primary btn-block">Sign In</button>
    </div>
    <!-- /.col -->
  </div>
</form>
<!-- /.social-auth-links -->
<p class="mb-1">
  <a href="{{route('admin.password.request')}}">I forgot my password</a>

    {{-- @if (Route::has('password.request'))
    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
        {{ __('Forgot your password?') }}
    </a> --}}
{{-- @endif --}}
</p>
@endsection


