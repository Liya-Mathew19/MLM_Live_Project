@extends('layouts.app')
@section('content')
<script>
$(document).ready(function(){
    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if(activeTab){
        $('#nav-tab a[href="' + activeTab + '"]').tab('show');
    }
});
</script>
<main id="main" style="margin-top: 170px;">
<section class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2>Sign Up</h2>
          <ol>
            <li><a href="{{env('APP_URL')}}/">Home</a></li>
            <li>Registration</li>
          </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs Section -->
    <section class="inner-page">
      
<div class="container">
    <div class="row content">
        <div class="col-md-4 order-1 order-md-2 " data-aos="fade-left" >
            <img src="{{env('APP_URL')}}/vendors/mainpage/assets/img/details-4.png" class="img-fluid" alt="">
        </div>
        <div class="col-md-8 pt-4" data-aos="fade-up">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Registration Form') }}</div>
                        <div class="card-body">
                            <nav>
					          <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist"  >
						          <a class="nav-item nav-link active " id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Personal</a>
						          <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Corporate</a>
					          </div>
				            </nav>
                         
<!--************************************************Personal Registration**********************************************************************-->

                            <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
					            <div class="tab-pane fade show active " id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <form  autocomplete="off" method="POST" action="{{ route('personal_register') }}">
                                    @csrf
                                        <div class="form-group row">
                                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                                                <div class="col-md-6">
                                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required   autofocus>
                                                        @error('name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                                            <div class="col-md-6">
                                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required  >
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                        <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone Number') }}</label>
                                                       <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                                    +91
                                                        </div>
                                                    </div> 
                                                    <input id="phone" maxlength="10" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required   autofocus>
                                                @error('phone')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                    </div>
                                                </div>
                                            </div>


                                        

                                        <div class="form-group row">
                                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                                            <div class="col-md-6">
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required  >
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                                                <div class="col-md-6">
                                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required  >
                                                </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="referral_id" class="col-4 col-form-label text-md-right">Referral ID</label> 
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                             AFPA-
                                                        </div>
                                                    </div> 
                                                    @if(request('ref')==null )
                                                        <input id="referral_id" type="text" class="form-control @error('referral_id') is-invalid @enderror"  value="{{ old('referral_id') }}"name="referral_id" autocomplete="referral_id">
                                                    @else
                                                        <input id="referral_id" type="text" class="form-control @error('referral_id') is-invalid @enderror" readonly="reaadonly" name="referral_id" value="{{ request('ref') }}"   >
                                                    @endif
                                                    <div class="input-group-append">
                                                        <div class="input-group-text" data-toggle="tooltip" data-placement="right" title="Enter the Account ID of your referred person !!"><b>?</b>
                                                            <i class="fas fa-question-circle"></i>
                                                        </div>
                                                    </div>
                                                    @error('referral_id')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror 
                                                </div>
                                            </div>
                                        </div> 
                                       
                                        <div class="form-group row">
                                            <label for="spill_over_id" class="col-md-4 col-form-label text-md-right">{{ __('Spill Over ID') }}</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            AFPA-
                                                        </div>
                                                    </div> 
                                                    <input id="spill_over_id" type="text" class="form-control @error('spill_over_id') is-invalid @enderror" name="spill_over_id" value="{{ old('spill_over_id') }}"  >
                                                        <div class="input-group-append">      
                                                            <div class="input-group-text"  data-toggle="tooltip" data-placement="right" title="Account ID / Referral ID of the person whom you want as your parent !!"><b>?</b>
                                                                <i class="fas fa-question-circle"></i>
                                                            </div>
                                                        </div>
                                                        @error('spill_over_id')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                </div>
                                            </div>
                                        </div>
                        
                                        <div class="form-group row mb-0">
                                            <div class="col-md-6 offset-md-4">
                                                <button type="submit" class="btn btn-primary">{{ __('Register') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>


<!--************************************************Corporate Registration**********************************************************************-->

					            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile">
                                    <form  autocomplete="off" method="POST" action="{{ route('corporate_register') }}">
                                    @csrf
                                        <div class="form-group row">
                                            <label for="corporate_name" class="col-md-4 col-form-label text-md-right">{{ __('Company Name') }}</label>
                                            <div class="col-md-6">
                                                <input id="corporate_name" type="text" class="form-control @error('corporate_name') is-invalid @enderror" name="corporate_name" value="{{ old('corporate_name') }}" required   autofocus>
                                                @error('corporate_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="corporate_email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                                            <div class="col-md-6">
                                                <input id="corporate_email" type="text" class="form-control @error('corporate_email') is-invalid @enderror" name="corporate_email" value="{{ old('corporate_email') }}" required  >
                                                @error('corporate_email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>



                                        <div class="form-group row">
                                        <label for="corporate_phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone Number') }}</label>
                                                <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                                    +91
                                                        </div>
                                                    </div> 
                                                    <input id="corporate_phone" maxlength="10" type="text" class="form-control @error('corporate_phone') is-invalid @enderror" name="corporate_phone" value="{{ old('corporate_phone') }}" required  autofocus>
                                                @error('corporate_phone')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                    </div>
                                                </div>
                                            </div>


                                        <div class="form-group row">
                                            <label for="corporate_password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                                            <div class="col-md-6">
                                                <input id="corporate_password" type="password" class="form-control @error('corporate_password') is-invalid @enderror" name="corporate_password" required  >
                                                @error('corporate_password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="corporate_password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                                            <div class="col-md-6">
                                                <input id="corporate_password-confirm" type="password" class="form-control" name="corporate_password_confirmation" required  >
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="corporate_gstin" class="col-md-4 col-form-label text-md-right">{{ __('GSTIN') }}</label>
                                            <div class="col-md-6">
                                                <input id="corporate_gstin" type="text" class="form-control @error('corporate_gstin') is-invalid @enderror" name="corporate_gstin"    required autofocus>
                                                @error('corporate_gstin')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label for="referral_id" class="col-4 col-form-label text-md-right">Referral ID</label> 
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            AFPA-
                                                        </div>
                                                    </div> 
                                                    @if(request('ref')==null )
                                                        <input id="corporate_referral_id" type="text" class="form-control @error('corporate_referral_id') is-invalid @enderror"  name="corporate_referral_id" autocomplete="corporate_referral_id" autofocus>
                                                    @else
                                                        <input id="corporate_referral_id" type="text" class="form-control @error('corporate_referral_id') is-invalid @enderror" readonly="reaadonly" name="corporate_referral_id" value="{{ request('ref') }}"  autocomplete="corporate_referral_id" autofocus>
                                                    @endif
                                              
                                                    <div class="input-group-append">
                                                        <div class="input-group-text" data-toggle="tooltip" data-placement="right" title="Enter the Account ID of your referred person !!"><b>?</b>
                                                            <i class="fas fa-question-circle"></i>
                                                        </div>
                                                    </div>
                                                    @error('corporate_referral_id')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>   
                                        </div> 
                                       

                                        <div class="form-group row">
                                            <label for="spill_over_id" class="col-md-4 col-form-label text-md-right">{{ __('Spill Over ID') }}</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                                    AFPA-
                                                        </div>
                                                    </div> 
                                                    <input id="corporate_spill_over_id" type="text" class="form-control @error('corporate_spill_over_id') is-invalid @enderror" name="corporate_spill_over_id"  autocomplete="corporate_spill_over_id" autofocus>
                                                        <div class="input-group-append">
                                                            <div class="input-group-text"  data-toggle="tooltip" data-placement="right" title="Account ID / Referral ID of the person whom you want as your parent !!"><b>?</b>
                                                                <i class="fas fa-question-circle"></i>
                                                            </div>
                                                        </div>
                                                        @error('corporate_spill_over_id')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                        <div class="form-group row mb-0">
                                            <div class="col-md-6 offset-md-4">
                                                <button type="submit" class="btn btn-primary">
                                                    {{ __('Register') }}
                                                </button>
                                                 </div>
                                        </div>
                                    </form>
                                    
                                </div>
                                
                            </div>
                            <center><br><a href="{{route('login')}}">Already have an account ? Click here to login..</a></center>
                    
                            </div>
                            </div>
                </div>
            </div>
        </div>
    </div>
</div>  

                        
                                          

    </section>

  </main><!-- End #main -->  
  <script>  
  $(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
</script>
@endsection
