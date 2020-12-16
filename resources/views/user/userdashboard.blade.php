@extends('layouts.user')
@section('content')
@if (session('status'))
  <div class="alert alert-success">
    {{ session('status') }}
  </div>
@endif	


<div class="row">
	<div class="col-sm-12 flex-column d-flex stretch-card">
		<div class="row">
			<div class="col-lg-4 d-flex grid-margin stretch-card">
				<div class="card sale-diffrence-border">
					<div class="card-body">
						<h2 class="text-dark mb-2 font-weight-bold">Total Wallet Balance</h2>
						<h4 class="card-title mb-2">₹ {{$total_wallet_balance}}</h4>
						As on {{date('d-M, Y')}}
					</div>
				</div>
			</div>

			<div class="col-lg-4 d-flex grid-margin stretch-card">
				<div class="card sale-visit-statistics-border">
					<div class="card-body">
						<h2 class="text-dark mb-2 font-weight-bold">Total Withdrawals</h2>
						<h4 class="card-title mb-2">₹ {{\App\Helper\PaymentHelper::getTotalWithdrawals(Auth::user()->id)}}</h4>
						As on {{date('d-M, Y')}}
					</div>
				</div>
			</div>

			<div class="col-lg-4 d-flex grid-margin stretch-card">
				<div class="card card sale-new-border">
					<div class="card-body">
						<h2 class="text-dark mb-2 font-weight-bold">Total Commission Earned</h2>
						<small><b>Total earnings from all accounts</b></small><br><br>
						<h4 class="card-title mb-2">₹ {{\App\Helper\PaymentHelper::total_commission_earned(Auth::user()->id)}}</h4>
						As on {{date('d-M, Y')}}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
				
<!-- partial -->
<div class="row mt-0">
	<div class="col-lg-7 grid-margin stretch-card">
		<div class="card card-danger card-outline card-outline-danger">
			<div class="card-header">
				<h4 class="card-title">{{__('Welcome ')}} <font color="red">{{ Auth::user()->name }}</font>{{ __(', you are logged in!') }}</h4>
            </div>
			<div class="card-body">
				<h5><font color="black">Profile Completion Status</font></h5>
				<div class="row col-lg-12">
                    @foreach($users as $user)   
                        <progress class="col-md-12" id="file"  value="{{$user->percentage}}" min="0" max="100"></progress>
                        <h3 class="font-weight-bold text-dark  mb-0">{{$user->percentage}}%</h3>
                     @endforeach

					<div class="col-lg-12"><br><br>
					@if($user->percentage =='100' && Auth::user()->user_status !='Activated' )
					<div class="alert alert-warning">
					{{__('Your account is complete..You can now send the account creation request for approval..')}}
					</div>
					@endif

                        <div class="alert alert-success">
							@if(Auth::user()->phone_status=='Progress' && Auth::user()->email_status=='Progress' )                
                                <font color="red">{{__('Your account is not verified yet..Please verify your Email Address and Mobile Number..')}}</font>
								<br><br>{{__('Verify your mobile number :   ')}}<a href="{{route('resendOtp')}}">Click Here</a>
								<br><br>{{__('Verify your email :  ')}}<a href="{{route('resendemailOtp')}}">Click Here</a>

							@elseif(Auth::user()->email_status=='Progress')
								<font color="red">{{__('Your account is not verified yet..Please verify your Email Address and Mobile Number..')}}</font>
								<br><br>{{__('Verify your email :  ')}}<a href="{{route('resendemailOtp')}}">Click Here</a>	

							@elseif(Auth::user()->phone_status=='Progress')
								<font color="red">{{__('Your account is not verified yet..Please verify your Email Address and Mobile Number..')}}</font>
								<br><br>{{__('Verify your mobile number :   ')}}<a href="{{route('resendOtp')}}">Click Here</a>		
								
							@elseif($user->percentage != '100')
							
								<font color="red"> {{__('Your account is not complete..Please update your profile..')}}</font>
								
							@elseif(Auth::user()->user_status=='Activated' && \App\Models\Kyc::where('type', '=', 'Pan Card Details')->where('fk_user_id','=',Auth::user()->id)->first()==null)
							<font color="red">{{__('Account is activated !! Pan Card details not uploaded yet !!')}}</font>
							
							@elseif($user->percentage='90' && \App\Models\Kyc::where('type', '=', 'Pan Card Details')->where('fk_user_id','=',Auth::user()->id)->first()==null)
							<font color="red">{{__(' Pan Card details not uploaded yet !!')}}</font>

							@elseif(\App\Models\Kyc::where('type', '=', 'Pan Card Details')->where('status','!=','Activated')->where('fk_user_id','=',Auth::user()->id)->first())
                            <font color="red">PAN Card approval is on progress.. Please wait for your approval or contact the administrator.</font>
							
							@elseif(Auth::user()->approval_status_notification=='Yes')
                                {{__('Your profile is activated...Click Ok to dismiss..')}}
								<br><br><a href="{{route('activationaccept')}}"><button type="button" class="btn btn-primary">Ok</button></a>
                            
							@elseif	(Auth::user()->user_status=='requested')	
								{{__('Request for approval sent successfully..Please wait for your approval..')}}

							@elseif	(Auth::user()->user_status=='Deactivated')	
								<font color="red">{{__('You account request is rejected !!!')}}</font>

                            
							@endif				
						</div>	

					@if(Auth::user()->user_status =="requested" )
						<a href="{{route('customerprofile')}}"><button type="button" class="btn btn-primary">Update Profile</button></a>
						<button type="button" disabled class="btn btn-danger">Send Request</button>

					@elseif(($user->percentage=='100' || ($user->percentage==90 && \App\Models\Kyc::where('type', '=', 'Pan Card Details')
            		->where('fk_user_id','=',Auth::user()->id)->first()==null)) && Auth::user()->user_status !="Activated")
						<a href="{{route('customerprofile')}}"><button type="button" class="btn btn-primary">Update Profile</button></a>
						<a href="{{route('userdatarequest')}}"><button type="button" class="btn btn-danger">Send Request</button></a>
					
					@elseif( Auth::user()->user_status =="Progress" || Auth::user()->user_status =="Verified" )
						<a href="{{route('customerprofile')}}"><button type="button" class="btn btn-primary">Update Profile</button></a>
					
					@else
						<a href="{{route('customerprofile')}}"><button type="button" class="btn btn-success">View Profile</button></a>
					
					@endif
				</div>		   
            </div>    
		</div> 
	</div>  

	<div class="col-lg-9 grid-margin stretch-card">
		<div class="card card-success card-outline card-outline-danger">
			<div class="card-header">
				<h4 class="card-title">Your Accounts</h4>
            </div>
			@php $no = 1; @endphp
			<div class="card-body">	
			@if($accounts==null)
			<br><br><br><br><h3><font color="red"><center>No account requests pending!!</font></h3>
			@else				
				@foreach($accounts as $account)
				
					<div class="alert alert-danger"><font color="black"><b><u>{{__('Account ')}}{{$no++}} </u></b> <br><br>
                        <b>Account Number :</b> {{\App\Helper\PaymentHelper::bind_account_number($account->acct_id)}}<br>
						<b>Account Type :</b> {{$account->acct_type}}<br>
						<b>Created On :</b> {{\App\Helper\PaymentHelper::convert_date_format($account->created_at)}}<br></font>	
						@if($account->status=='requested')
						<font color="red"><b>Status :</b>Your account is waiting for admin approval..!!</font><br><br>
						@elseif($account->status=='Progress' and $account->acct_type != "Primary")
						<font color="red"><b>Status :</b>Incomplete account creation..!!</font><br><br>
						<a href="{{ URL::to('/viewaccount',$account->acct_id) }}"><button type="button" class="btn btn-primary">View Account</button></a>
						@elseif($account->status=='Deactivated')
						<font color="red"><b>Status :</b>Account request Rejected !!</font><br><br>
						
						@endif
					
					</div>
				@endforeach
				@endif
			</div>
		</div>	
	</div>
</div>
</div>

<script>
    function myFunction() 
    {
        var copyText = document.getElementById("referral");
        copyText.select();
        copyText.setSelectionRange(0, 9999999999)
        document.execCommand("copy");
        alert("Copied the referral link !!!");
    }
</script>

@endsection