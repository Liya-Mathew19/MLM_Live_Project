@extends('layouts.admin')
@section('content')

@if (session('status'))
  <div class="alert alert-success">
    {{ session('status') }}
  </div>
@endif
@if (session('error'))
  <div class="alert alert-danger">
    {{ session('error') }}
  </div>
@endif

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
                      @php $no=1; @endphp
                        <tr>
                        <th><b>Sl.No</th>
                          <th><b> Customer Name</th>
                          <th> <b> Amount</th>
                          <th> <b> Date</th>
                        </tr>
                      </thead>
                      <tbody>
                      
                      @foreach($commission_requests as $request)
                        <tr>
                        <td>{{$no++}}</td>
                        <td>{{$request->name}}</td>
                        <td>&#x20B9;{{$request->amount}} </td>
                        <td>{{\App\Helper\PaymentHelper::convert_date_format($request->date)}}</td>
                        </tr>
                       @endforeach
                      </tbody>
                      
                    </table>
                    
                  </div> <br><br> 
                  <label style="color:black;" >Total Amount : </lable>
                  <input type="text"  readonly="readonly" value="	&#x20B9;{{$commission_data['totals']}}" >
                  <a href="{{route('commission_payment')}}"><button type="button" class="btn btn-primary">Pay Now</button>
                  <a href="{{route('approved_commission_requests')}}"><button type="button" class="btn btn-danger">Cancel</button></a><br><br>
                  <font color="red">*Note: Once confirmed your payment, you can't revert back. So, check before confirming your payment.</font>
                  </div>
                    </div>
                </div>
            </div>
        </div>
  
@endsection