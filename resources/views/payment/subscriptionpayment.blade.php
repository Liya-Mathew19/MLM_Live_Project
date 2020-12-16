@extends('layouts.user')
@section('content')
<script>

$(document).ready(function(){
   
    CalculateSubscription();

    $("#payment-form").submit(function(){
    var checked = $(".accountids:checkbox:checked" ).length > 0;
    if (!checked){
        alert("Please check at least one checkbox");
        return false;
    }
});

    $("#no_of_term").change(function(){
        CalculateSubscription();
    });

    $(".accountids").change(function(){
        CalculateSubscription();
    });
    
    function CalculateSubscription(){

        var gst_amount=0;
        var  total_subscription=0;
        var total_amount=0;
        var cess_amount=0;
       
        // do caluation
        var no_of_term = $( "#no_of_term" ).val();
        //alert (no_of_term);
        var gst = $("#gst").val();
        var subscription_fee = $("#subscription_fee").val();
        var no_of_accounts = $(".accountids:checkbox:checked" ).length;
        
        var cess=$('#cess').val();
        //alert (no_of_accounts);
        
        total_subscription = ( no_of_term * subscription_fee ) * no_of_accounts;
        gst_amount = ( total_subscription * gst ) / 100;
        cess_amount=(cess*total_subscription)/100;
        total_amount = total_subscription + gst_amount+cess_amount;
        
        // assiging values to textbox
        $("#gst_amount").val(gst_amount);
        $("#total_subscription").val(total_subscription);
        $("#total_amount").val(total_amount);
        $("#cess_amount").val(cess_amount);
    }
 
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
           
                                @if(Auth::user()->user_status !='Activated')
                                <center><h3><font color="red">Your account is not activated.. Please wait for your approval !!!</font></h3></center>
                                @else

                                <div class="row content">
        <div class="col-md-4 order-1 order-md-2 ">
            <img src="{{env('APP_URL')}}/vendors/mainpage/assets/img/images.jpg" class="img-fluid" alt="">
        </div>
        <div class="col-md-8 pt-0" data-aos="fade-up">
                                
                                    <form accept-charset="UTF-8" action="{{route('payment')}}"  id="payment-form" method="post">
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
                                                <label class='control-label' style="font-size: 1.1rem;">Name</label> 
                                                    <input class='form-control' readonly="readonly" style="font-size: 1.1rem;" value="{{Auth::user()->name}}" name="name" type='text'>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class='col-lg-12 form-group required'>
                                                <label class='control-label' style="font-size: 1.1rem;">Number of Terms</label> 
                                                <select class="form-control" class="no_of_term" id="no_of_term" name="no_of_term" >
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col">
                                            <label class='control-label' style="font-size: 1.1rem;">Subscription Fee</label> 
                                                    <div id="the-basics">
                                                        <input autocomplete='off' class='form-control card-number' style="font-size: 1.1rem;" readonly="readonly" name="subscription_fee" value="{{$settings_amount}}" id="subscription_fee" size='20' required type='text'>
                                                    </div>
                                            </div>
                                            <div class="col">
                                            <label class='control-label' style="font-size: 1.1rem;">GST Percentage</label> 
                                                    <div id="bloodhound">
                                                        <input autocomplete='off' class='form-control card-number' style="font-size: 1.1rem;" readonly="readonly" name="gst" id="gst" value="{{$settings_gst}}" size='20' required type='text'>
                                                    </div>
                                            </div>
                                        </div>
                                        
                                        @if(!empty(Auth::user()->gstin))
                                        <div class="form-group row">
                                        <div class="col">
                                            <label class='control-label' style="font-size: 1.1rem;">Cess Percentage</label> 
                                                    <div id="bloodhound">
                                                        <input autocomplete='off' class='form-control card-number' style="font-size: 1.1rem;" readonly="readonly" name="cess" id="cess" value="0" size='20' required type='text'>
                                                    </div>
                                            </div>
                                     
                                        <div class="col">
                                            <label class='control-label' style="font-size: 1.1rem;">Cess Amount</label> 
                                                    <div id="bloodhound">
                                                        <input autocomplete='off' class='form-control card-number' style="font-size: 1.1rem;" readonly="readonly" name="cess_amount" id="cess_amount" value="" size='20' required type='text'>
                                                    </div>
                                            </div>
                                        </div>
                                        @else

                                        <div class="form-group row">
                                            <div class="col">
                                                <label class='control-label' style="font-size: 1.1rem;">Cess Percentage</label> 
                                                    <div id="bloodhound">
                                                        <input autocomplete='off' class='form-control card-number' style="font-size: 1.1rem;" readonly="readonly" name="cess" id="cess" value="{{$settings_cess}}" size='20' required type='text'>
                                                    </div>
                                            </div>
                                     
                                        <div class="col">
                                            <label class='control-label' style="font-size: 1.1rem;">Cess Amount</label> 
                                                    <div id="bloodhound">
                                                        <input autocomplete='off' class='form-control card-number' style="font-size: 1.1rem;" readonly="readonly" name="cess_amount" id="cess_amount" value="" size='20' required type='text'>
                                                    </div>
                                        </div>
                                        </div>
                                        
                                        @endif

                                        <div class="form-group row">
                                            <div class="col">
                                            <label class='control-label' style="font-size: 1.1rem;">Total Subscription Amount</label> 
                                                    <div id="the-basics">
                                                        <input autocomplete='off' class='form-control card-number' style="font-size: 1.1rem;" readonly="readonly" name="total_subscription" id="total_subscription" value="" size='20' required type='text'>
                                                    </div>
                                            </div>
                                            <div class="col">
                                            <label class='control-label' style="font-size: 1.1rem;">Total GST Amount</label> 
                                                    <div id="bloodhound">
                                                        <input autocomplete='off' class='form-control card-number' style="font-size: 1.1rem;" readonly="readonly" name="gst_amount" id="gst_amount" value="" size='20' required type='text'>
                                                    </div>
                                            </div>
                                        </div>

                                        <div class='form-row'>
                                            <div class='col-lg-12 form-group required'>
                                                <label class='control-label'style="font-size: 1.1rem;">Total Payment Amount</label> 
                                                <input autocomplete='off' class='form-control card-number' style="font-size: 1.1rem;" readonly="readonly" name="total_amount" id="total_amount" value="" size='20' required type='text'>
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
                                    @endif
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