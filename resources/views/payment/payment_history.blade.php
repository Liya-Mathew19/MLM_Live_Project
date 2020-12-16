@extends('layouts.user')
@section('content')
<style>
.td-right{
   text-align:right;
   border-color:black;
}
.td-left{
   text-align:left;
   border-color:black;
}
.td-center{
   text-align:center;
   border-color:black;
}
th{
   text-align:center;
   border-color:black;
}
</style>
<div class='container-fluid'>
					 <div class="row mt-4">
						<div class="col-lg-12 grid-margin stretch-card">
        				<div class="card card-danger card-outline card-outline-danger">                
               <div class="card-header">
                  <h4 class="card-title">Payment History</h4><br>
                  </div>
                  <div class="card-body">
                @if($transactions==null)
                    <center><font color="red"><h3>No Payments Found..!!</h3></font></center>
                @else
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th><b> Sl.No.</th>
                          <th><b> Invoice Number</th>
                          <th><b> Payment Date</th>
                          <th> <b> Subscription Fee</th>
                          <th><b>  CGST (%)</th>
                          <th><b>  SGST (%)</th>
                          <th><b>  Total GST</th>
                          <th><b>  KFC (%)</th>
                          <th><b>  Total Amount</th>
                          <th><b>  Paid From</th>
                          <th><b>  Payment Number</th>
                          <th><b>  Status</th>
                        </tr>
                      </thead>
                      <tbody>
                      @php 
                        $no=1 ;
                                           @endphp
                        @foreach($transactions as $transaction)
                        <tr>
                          <td class="td-center">{{$no++}}</td>
                          <td class="td-center">{{$transaction->invoice_number}}</td>
                          <td class="td-center">{{\App\Helper\PaymentHelper::convert_date_format($transaction->date)}}</td>
                          <td class="td-right">&#x20B9;{{\App\Helper\PaymentHelper::currency($transaction->subscription_fee)}}</td>
                          <td class="td-center">{{$transaction->cgst}}</td>
                          <td class="td-center">{{$transaction->sgst}}</td>
                          <td class="td-right">&#x20B9;{{\App\Helper\PaymentHelper::currency($transaction->gst)}}</td>
                          <td class="td-center">{{$transaction->cess}}</td>

                          <td class="td-right">&#x20B9;{{\App\Helper\PaymentHelper::currency($transaction->amount)}}</td>
                          <td class="td-center">{{$transaction->paid_from}}</td>
                          <td class="td-center">{{$transaction->reference_no}}</td>
                          <td class="td-center"><label class="badge badge-success">{{$transaction->status}}</label></td>
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