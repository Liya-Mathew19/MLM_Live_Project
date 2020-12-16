@extends('layouts.app')
@section('content')
<main id="main" style="margin-top: 170px;">
<section class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2>Verification</h2>
          <ol>
            <li><a href="{{env('APP_URL')}}/">Home</a></li>
            <li>Verify</li>
          </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs Section -->
      

    <section class="inner-page">
      
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

</main><!-- End #main -->    
@endsection
