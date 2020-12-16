@extends('layouts.app')
@section('content')
<main id="main" style="margin-top: 170px;">
<section class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2>Sign In</h2>
          <ol>
            <li><a href="{{env('APP_URL')}}/">Home</a></li>
            <li>Login</li>
          </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs Section -->

    <section class="inner-page">
       
<div class="container">
    <div class="row content">
        <div class="col-md-4" data-aos="fade-right">
            <img src="{{env('APP_URL')}}/vendors/mainpage/assets/img/details-3.png" class="img-fluid" alt="">
        </div>
        <div class="col-md-8 pt-5" data-aos="fade-up">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>
                <div class="card-body">
                    <div class="panel-body">
                        @if(Session::has('message'))
                            <div class="alert alert-success">
                            {{ Session::get('message') }}
                            @php
                                Session::forget('message');
                            @endphp
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">
                            {{ session('error') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('login') }}">
                        @csrf
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                </div>
                            </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                        </form>
                        <center><br><a href="{{route('register')}}">New member ? Click here to register..</a></center>
                    
                </div>
            </div>
        </div>
    </div>
</div>
    </section>

  </main><!-- End #main -->
@endsection
