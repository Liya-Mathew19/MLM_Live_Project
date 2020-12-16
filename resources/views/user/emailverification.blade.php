@extends('layouts.user')
@section('content')

@if (session('error'))
  <div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong> {{ session('error') }}</strong>
  </div>
@endif	

@if (count($errors) > 0)
  <div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

@if ($message = Session::get('success'))
  <div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
  </div>
@endif
<script>

$(document).ready(function(){
	var counter = 120;
var interval = setInterval(function() {
    counter--;
    // Display 'counter' wherever you want to display it.
    if (counter <= 0) {
     		clearInterval(interval);
      	$('#resend').text("Resend OTP");  
		 $('#resend').prop('disabled', false);
        return;
    }else{
		 $('#resend').prop('disabled', true);
    	$('#resend').text(counter+" Seconds");
      console.log("Timer --> " + counter);
    }
}, 1000);
});

</script>  
<div class="container">
  <div class="row mt-4">
		<div class="col-lg-12 grid-margin stretch-card">
			<div class="card card-danger card-outline card-outline-danger">
				<div class="card-header">
					<h4 class="card-title">Email Verification</h4>
        </div>
        <div class="card-body">
        <div class="row content">
          <div class="col-md-4 order-1 order-md-2 "><br><br><br><br>
            <img src="{{env('APP_URL')}}/vendors/mainpage/assets/img/email.png" class="img-fluid" alt="">
          </div>
          <div class="col-md-7 pt-4">
            <div class="col-md-12">
              <div class="card card-danger card-outline card-outline-danger">
                <div class="card-body">
                  <h2 class="text-center">Email Verification</h2><br>
                  <center><p>Enter your OTP here</p><br>
                  <div class="panel-body">
                    <form id="register-form" action ="{{route('verifyemail')}}" role="form" autocomplete="off" class="forms-sample" method="post">
                      {{ csrf_field() }}

                      <div class="form-group col-lg-12">
                        <div class="input-group">
                          <span class="input-group-addon"></i></span>
                          <input id="text" name="email" class="form-control" readonly="readonly" type="email" value="{{ Auth::user()->email  }}" required>
                        </div>
                      </div>

                      <div class="form-group col-lg-12">
                        <div class="input-group">
                          <span class="input-group-addon"></i></span>
                          <input id="text" name="otp" placeholder="OTP" class="form-control"  type="otp" required>
                        </div>
                      </div>

                      <input type="hidden" class="hide" name="token" id="token" value=""> 
                      <div class="form-group row col-lg-12">
                        <div class="col-lg-6">
                          <input name="recover-submit" class="btn btn-lg btn-success btn-block" value="Verify OTP" type="submit">
                          </div>
                          <div class="col-lg-6">
                          <a href="{{route('resendemailOtp')}}"><button class="btn btn-lg btn-primary btn-block" id="resend" disabled type="button">Resend OTP</button></a>
                            </div>
                        </div>                     
                      <br><font color="red">Note : If you do not receive an OTP within 5 mins, please contact on <br>+91 9605082808.</font>  
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
  </div>
</div>
@endsection