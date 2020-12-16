@extends('layouts.user')
@section('content')

    <!-- partial -->
    <head>
    <title> RazorPay Integration in PHP - phpexpertise.com </title>
    <meta name="viewport" content="width=device-width">
    <style>
      .razorpay-payment-button {
        margin-top: 10px;
        color: #fff;
    background-color: #464dee;
    border-color: #464dee;
    
      }
    </style>
  </head>

<div class="container">
    <div class="row mt-4">
		<div class="col-lg-12 grid-margin ">
			<div class="card card-danger card-outline card-outline-danger">
				<div class="card-header">
						<h4 class="card-title">Total Cash</h4>
        </div>
        @csrf
				<div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" >
                      <thead>
                        <tr>
                          <th><b> Name</th>
                          <th><b> Number of Terms</th>
                          <th><b> Accounts</th>
                          <th> <b> Subscription Fee</th>
                          <th><b>  GST</th>
                          <th><b>  KFC</th>
                          <th><b> Total Subscription Amount</th>
                          <th><b>  Total GST Amount</th>
                          <th><b>  Total Amount to be Paid</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                        <td>{{$subscription_data['name']}}</td>
                        <td>{{$subscription_data['no_of_term']}} </td>
                        <td>{{\App\Helper\PaymentHelper::bind_account_number($subscription_data['accountvalues'])}}</td>
                        <td>&#x20B9;{{$subscription_data['subscription_fee']}}</td>
                        <td>{{$subscription_data['gst_percentage']}}</td>
                        
                        <td>{{$subscription_data['cess_amount']}}</td>
                        <td>&#x20B9;{{$subscription_data['total_subscription_fee']}}</td>
                        <td>{{$subscription_data['total_gst_amount']}}</td>
                        <td>&#x20B9;{{$subscription_data['total_amount']}}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>  
                    </div>
                </div>
            </div>
        </div>
  

	<div class="row">				
		<div class="col-lg-6 d-flex grid-margin stretch-card">
			<div class="card sale-diffrence-border">
                <div class="card-body">
					<h2 class="text-dark mb-2 font-weight-bold">Wallet Pay Balance</h2>
                    <h4 class="card-title mb-3">{{$total_wallet_balance}}</h4>
                    @if($subscription_data['total_amount'] > $total_wallet_balance)
                    <button class='form-control btn btn-primary submit-button' disabled type='submit' style="margin-top: 10px;">Pay via your wallet balance >></button>
                    @else
                    <a href="{{route('walletconfirmation')}}">
                    <button class='form-control btn btn-primary submit-button'  type='submit' style="margin-top: 10px;">Pay via your wallet balance >></button>
                    </a>
                    @endif
                    </div>

			</div>
        </div>
        
		<div class="col-lg-6 d-flex grid-margin stretch-card">
			<div class="card sale-visit-statistics-border">    
                <div class="card-body">
                    <h2 class="text-dark mb-2 font-weight-bold">Card Payment</h2>
                    <h4 class="card-title mb-5"></h4>
					
					<button  class='form-control btn btn-primary submit-button' id="rzp-button1">Pay with Razorpay</button>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<form name='razorpayform' action="{{url('cardpaymentverify')}}" method="POST">
 {{ csrf_field() }}
    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
    <input type="hidden" name="razorpay_signature"  id="razorpay_signature" >
</form>
<script>
// Checkout details as a json
var options = <?php echo $json?>;

/**
 * The entire list of Checkout fields is available at
 * https://docs.razorpay.com/docs/checkout-form#checkout-fields
 */
options.handler = function (response){
    document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
    document.getElementById('razorpay_signature').value = response.razorpay_signature;
    document.razorpayform.submit();
};

// Boolean whether to show image inside a white frame. (default: true)
options.theme.image_padding = false;

options.modal = {
    ondismiss: function() {
        console.log("This code runs when the popup is closed");
    },
    // Boolean indicating whether pressing escape key 
    // should close the checkout form. (default: true)
    escape: true,
    // Boolean indicating whether clicking translucent blank
    // space outside checkout form should close the form. (default: false)
    backdropclose: false
};

var rzp = new Razorpay(options);

document.getElementById('rzp-button1').onclick = function(e){
    rzp.open();
    e.preventDefault();
}
</script>
					
					
				 
               
               
                    </div>
            </div>
		</div>
    
 

 </div>

    </div>
</div>
</div>
@endsection			