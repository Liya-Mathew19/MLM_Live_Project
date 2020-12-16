@extends('layouts.user')
@section('content')
<div class='container-fluid'>
					 <div class="row mt-4">
						<div class="col-lg-12 grid-margin stretch-card">
        				<div class="card card-danger card-outline card-outline-danger">                
               <div class="card-header">
                  <h4 class="card-title">Receipt Details</h4><br>
                  </div>
                  <div class="card-body">
                @if($transactions==null)
                    <center><font color="red"><h3>No Receipts Found..!!</h3></font></center>
                @else
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th><b> Sl.No.</th>
                          <th><b> Invoice Number</th>
                          <th><b> Date</th>
                          <th> <b> Subscription Fee</th>
                          <th><b>  GST</th>
                          <th><b>  Total</th>
                          <th><b>  Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                      @php 
                        $no=1 ;
                    @endphp
              @foreach($transactions as $transaction)
                        <tr>
                          <td >{{$no++}}</td>
                          <td>{{$transaction->invoice_number}}</td>
                          <td>{{\App\Helper\PaymentHelper::convert_date_format($transaction->date)}}</td>
                          <td>&#x20B9;{{$transaction->subscription_fee}}</td>
                          <td>{{$transaction->gst}}</td>
                          <td>&#x20B9;{{$transaction->amount}}</td>
                          <td><a href="{{route('viewreceipt_byid',$transaction->transaction_id)}}" target="_blank"><button type="submit" class="btn btn-primary mr-2">View</button> </a></td>
                         @endforeach 
                      </form>
                 
                        </tr>
                      </tbody>
                    </table>
                  </div>
@endif

                 

                </div>
              </div>
            </div>
							</div>
						</div>
					</div>
          </div>
@endsection