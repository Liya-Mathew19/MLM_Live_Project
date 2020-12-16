<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>AFPA General Traders (OPC) Pvt Ltd</title>
  <meta content="" name="descriptison">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{env('APP_URL')}}/vendors/mainpage/assets/img/logo.png" rel="icon">
  <link href="{{env('APP_URL')}}/vendors/mainpage/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
 
  <!-- Vendor CSS Files -->
  <link href="{{env('APP_URL')}}/vendors/mainpage/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{env('APP_URL')}}/vendors/mainpage/assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="{{env('APP_URL')}}/vendors/mainpage/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="{{env('APP_URL')}}/vendors/mainpage/assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="{{env('APP_URL')}}/vendors/mainpage/assets/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="{{env('APP_URL')}}/vendors/mainpage/assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{env('APP_URL')}}/vendors/mainpage/assets/css/style.css" rel="stylesheet">
  <script src="{{env('APP_URL')}}/vendors/mainpage/assets/vendor/jquery/jquery.min.js"></script>

  <!-- =======================================================
  * Template Name: Appland - v2.2.0
  * Template URL: https://bootstrapmade.com/free-bootstrap-app-landing-page-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>
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

    $(function() {
            $("#copy").click(function () {
                var url = window.location.href;
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val(url).select();
                document.execCommand("copy");
                $temp.remove();
                alert("URL Copied !!");
            });

        })
</script>      
                         
<div class="container">
    <div class="row content">
        <div class="col-md-12 pt-4" data-aos="fade-up">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header">{{ __('Special Registration Form') }}
                    <button type="button" style="float:right" id="copy" class="btn btn-outline-primary btn-fw">Copy URL</button>
                </div>
                    </div>
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
                                    <form  autocomplete="off" method="POST" action="{{ route('new_personal_register',$id) }}">
                                    @csrf
                                    <div class="form-group row" style="display:none">
                                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Account ID') }}</label>
                                                <div class="col-md-6">
                                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" readonly="readonly" name="acct_id" value="{{$id}}" required   autofocus>
                                                </div>
                                        </div>

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

                                        <div class="form-group row" style="display:none">
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
                                       
                                        <div class="form-group row" style="display:none">
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
                                    <form  autocomplete="off" method="POST" action="{{ route('new_corporate_register',$id) }}">
                                    @csrf
                                    <div class="form-group row" style="display:none">
                                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Account ID') }}</label>
                                                <div class="col-md-6">
                                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" readonly="readonly" name="acct_id" value="{{$id}}" required   autofocus>
                                                </div>
                                        </div>

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


                                        <div class="form-group row" style="display:none">
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
                                       

                                        <div class="form-group row" style="display:none">
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

<a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

<!-- Vendor JS Files -->

<script src="{{env('APP_URL')}}/vendors/mainpage/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{env('APP_URL')}}/vendors/mainpage/assets/vendor/jquery.easing/jquery.easing.min.js"></script>
<script src="{{env('APP_URL')}}/vendors/mainpage/assets/vendor/php-email-form/validate.js"></script>
<script src="{{env('APP_URL')}}/vendors/mainpage/assets/vendor/owl.carousel/owl.carousel.min.js"></script>
<script src="{{env('APP_URL')}}/vendors/mainpage/assets/vendor/venobox/venobox.min.js"></script>
<script src="{{env('APP_URL')}}/vendors/mainpage/assets/vendor/aos/aos.js"></script>

<!-- Template Main JS File -->
<script src="{{env('APP_URL')}}/vendors/mainpage/assets/js/main.js"></script>

</body>

</html>
