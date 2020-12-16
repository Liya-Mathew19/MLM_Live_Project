@extends('layouts.admin')
@section('content')
<script>

$(document).ready(function(){

    $("#payment-form").submit(function(){
    var checked = $(".accountids:checkbox:checked" ).length > 0;
    if (!checked){
        alert("Please check at least one checkbox");
        return false;
    }
});   
});

</script>

    <!-- partial -->
    @if (session('status'))
                                                    <div class="alert alert-success">
                                                        <strong>{{ session('status') }}</strong>
                                                    </div>
                                                @endif
												 @if (session('error'))
                                                    <div class="alert alert-danger">
                                                        <strong>{{ session('error') }}</strong>
                                                    </div>
                                                @endif
												
		<div class="row mt-4">
			<div class="col-lg-12 grid-margin stretch-card">
        		<div class="card card-danger card-outline card-outline-danger">
                  
                        <div class="card-header">
                        <h4 class="card-title">Monthly Subscription Payment</h4><br>
						</div>
                            <div class="card-body">
                            @if ($errors->any())
<div class="alert alert-danger">
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>   
@endif   
           
                    

                                <div class="row content">
        <div class="col-md-4 order-1 order-md-2 ">
            <img src="{{env('APP_URL')}}/vendors/mainpage/assets/img/images.jpg" class="img-fluid" alt="">
        </div>
        <div class="col-md-8 pt-0" data-aos="fade-up">
                                
                                    <form accept-charset="UTF-8" action="{{route('admin_payment',$user->id)}}"  id="payment-form" method="post">
                                    {{ csrf_field() }}
                                    
                                    <div class='form-row'>
                                            <div class='col-lg-12 form-group required'>
                                                <label class='control-label' style="font-size: 1.1rem;">Select your Accounts</label> <br><br>
                                                @foreach($accounts as $account)
                                                    <label class="form-check-label col-lg-2">
                                                        <input type="checkbox"  name="accountids[]" style="font-size: 1.2rem;" style="font-size: 1.1rem;" value="{{$account->acct_id}}" class="form-check-input accountids ">{{\App\Helper\PaymentHelper::bind_account_number($account->acct_id)}}</input>
                                                    </label>
                                                @endforeach
                                               </div>
                                               </div>
                                        <div class='form-row'>
                                            <div class='col-lg-12 form-group required'>
                                                <label class='control-label' style="font-size: 1.1rem;">Customer Name</label> 
                                                    <input class='form-control' readonly="readonly" style="font-size: 1.1rem;" value="{{$user->name}}" name="name" type='text'>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-4">
                                            <label class='control-label' style="font-size: 1.1rem;">Subscription Fee</label> 
                                                    <div id="the-basics">
                                                        <input autocomplete='off' class='form-control card-number' style="font-size: 1.1rem;" readonly="readonly" name="subscription_fee" value="{{$settings_amount}}" id="subscription_fee" size='20' required type='text'>
                                                    </div>
                                            </div>
                                            <div class="col-lg-4">
                                            <label class='control-label' style="font-size: 1.1rem;">GST Percentage</label> 
                                                    <div id="bloodhound">
                                                        <input autocomplete='off' class='form-control card-number' style="font-size: 1.1rem;" readonly="readonly" name="gst" id="gst" value="{{$settings_gst}}" size='20' required type='text'>
                                                    </div>
                                            </div>
                                            @if(!empty($user->gstin))
                                            <div class="col-lg-4">
                                                <label class='control-label' style="font-size: 1.1rem;">Cess Percentage</label> 
                                                    <div id="bloodhound">
                                                        <input autocomplete='off' class='form-control card-number' style="font-size: 1.1rem;" readonly="readonly" name="cess" id="cess" value="0" size='20' required type='text'>
                                                    </div>
                                            </div>
                                            @else
                                            <div class="col-lg-4">
                                                <label class='control-label' style="font-size: 1.1rem;">Cess Percentage</label> 
                                                    <div id="bloodhound">
                                                        <input autocomplete='off' class='form-control card-number' style="font-size: 1.1rem;" readonly="readonly" name="cess" id="cess" value="{{$settings_cess}}" size='20' required type='text'>
                                                    </div>
                                            </div>
                                            @endif
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col">
                                            <label class='control-label' style="font-size: 1.1rem;">Paid Date</label> 
                                                    <div id="the-basics">
                                                        <input autocomplete='off' class='form-control card-number' style="font-size: 1.1rem;" name="date" id="total_subscription" size='20' required type='date'>
                                                    </div>
                                            </div>
                                            <div class="col-lg-6">
                                            <label class='control-label'style="font-size: 1.1rem;">Total Amount Paid</label> 
                                                    <div id="bloodhound">
                                                    <input autocomplete='off' class='form-control card-number' style="font-size: 1.1rem;" name="total_amount" id="total_amount" size='20' required type='text'>
                                            </div>
                                            </div>
                                        </div>

                                        <div class='form-row'>
                                            <div class='col-md-12 form-group'>
                                                <button class='form-control btn btn-primary submit-button' type='submit' style="margin-top: 10px;">Go »</button>
                                            </div>
                                        </div>

                                        <div class='form-row'>
                                            <div class='col-md-12 error form-group hide'>
                                               	
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
		
@endsection			