@extends('layouts.user')
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
<style>
/* Tabs*/

section .section-title {
    text-align: center;
    color: #007b5e;
    margin-bottom: 50px;
    text-transform: uppercase;
}
#tabs{

    color: #eee;
}
#tabs h6.section-title{
    color: #eee;
}

#tabs .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
    color: #f3f3f3;
    background-color: #e8eaf6;
    border-color: #f3f3f3;
    border-bottom: 4px solid !important;
    font-size: 20px;
    font-weight: bold;
}
#tabs .nav-tabs .nav-link {
    border: 1px solid transparent;
    border-top-left-radius: .25rem;
    border-top-right-radius: .25rem;
    color: #546E7A;
    font-size: 20px;
}
</style>

<section id="tabs">
<div class='container-fluid'>
				<div class="row mt-4">
					<div class="col-lg-12 grid-margin stretch-card">
        			<div class="card card-danger card-outline card-outline-danger">                
                <div class="card-header">
                <h4 class="card-title">Commission Withdrawals</h4><br>
                </div>                
                  <div class="card-body">
                  @if(Auth::user()->user_status !='Activated')
                                <center><h3><font color="red">Your account is not activated.. Please wait for your approval !!!</font></h3></center>
                                @elseif(\App\Models\Kyc::where('type', '=', 'Pan Card Details')->where('fk_user_id','=',Auth::user()->id)->first()==null)
                                <center><h4><font color="red">Note : To make commission request, you need to upload your PAN Card details..<br></font>
                                <br><a href="{{route('customerprofile')}}"> Click here to update your PAN Details ! </a></h4></center>
                                
                                @elseif(\App\Models\Kyc::where('type', '=', 'Pan Card Details')->where('status','!=','Activated')->where('fk_user_id','=',Auth::user()->id)->first())
                                <center><h4><font color="red">PAN Card approval is on progress.. Please wait for your approval or contact the administrator.<br></font>
                                @else
                               <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="mdi mdi-plus"></i>New Request</button>
                          <br>
                          <!-- Modal Content-->
                          <form class="forms-sample" action="{{route('send_new_commission_request')}}" method="POST" >
                          @csrf
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><font color="black">Send New Request</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <div class="form-group">
                                      <label for="exampleInputName1"><b>Amount</b></label>
                                      <input type="text" class="form-control" id="amount" name ="amount" placeholder="Enter the amount.." required  >
                                    </div>
                                   
                                    <div class="form-group">
                                      <label for="exampleInputName1"><b>Secondary Password</b></label>
                                      <input type="password" class="form-control" id="password" name ="password" placeholder="Enter your secondary password.." required  >
                                    </div>
                                  </div>
                                  
                                  
                          
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                                </div>
                              </div>
                            </div>
                          </form>
                          </div><br>
                           <!--End-->
                  
                  <nav>
					          <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
						          <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Requests</a>
						          <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Completed</a>
					          </div>
				          </nav>
                  <br>

                 

                    <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">

					            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                         

                        @foreach($commission_requests as $requests)
                        @endforeach
                        @if(empty($requests))
                          <center><font color="red"><h3>No Requests Found..!!</h3></font></center>
                        @else
                          <div class="table-responsive">
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                  <th><b> Sl No</th>
                                  <th><b> Amount</th>
                                  <th><b> Date</th>
                                  <th><b>  Status</th>
                                    @if($requests->status=="Rejected")
                                      <th><b>Remarks</b></th>
                                    @endif
                                </tr>
                              </thead>
                              <tbody>
                              @php $no=1 ; @endphp
                              @foreach($commission_requests as $requests)
                                <tr>
                                  <td >{{$no++}}</td>
                                  <td>&#x20B9;{{$requests->amount}}</td>
                                  <td>{{\App\Helper\PaymentHelper::convert_date_format($requests->date)}}</td>
                                  @if($requests->status=="Requested")
                                    <td><label class="badge badge-warning">{{$requests->status}}</label></td>
                                  @elseif($requests->status=="Approved")
                                    <td><label class="badge badge-success">{{$requests->status}}</label></td>
                                  @elseif($requests->status=="Rejected")
                                    <td><label class="badge badge-danger">{{$requests->status}}</label></td>
                                    <td><font color="red">{{$requests->remarks}}</font></td>
                                  @endif
                                </tr>
                              @endforeach     
                              </tbody>
                            </table>
                          </div>
                        @endif
                      </div>

					            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile">
                      

					            	@foreach($transferred_commission_requests as $t_requests) 
                        @endforeach
                        
                          @if(empty($t_requests))
                            <center><font color="red"><h3>No Requests Found..!!</h3></font></center>
                          @else
                            <div class="table-responsive">
                            <h3><b>Total Withdrawan Cash: &#x20B9;{{$total}}</b></h3>
                            <h3><b>Wallet Balance: &#x20B9;{{$wallet_balance}}</b></h3>
                              <table class="table table-bordered">
                                <thead>
                                  <tr>
                                    <th><b> Sl.No.</th>
                                    <th><b> Amount</th>
                                    <th><b> Date</th>
                                    <th><b>  Status</th>
                                    <th><b>Action</b></th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @php $no=1 ;@endphp
                                  @foreach($transferred_commission_requests as $t_requests)
                                    <tr>
                                      <td >{{$no++}}</td>
                                      <td>&#x20B9;{{$t_requests->amount}}</td>
                                      <td>{{\App\Helper\PaymentHelper::convert_date_format($t_requests->date)}}</td>
                                      <td><label class="badge badge-success">{{$t_requests->status}}</label></td>
                                      <td><a href="{{route('viewcommission_byid',$t_requests->request_id)}}" target="_blank"><button type="submit" class="btn btn-primary mr-2">Print</button> </a></td>
                                    </tr>
                                  @endforeach 
                                </tbody>
                              </table>
                            </div>
                          @endif
                          @endif
                      </div>
                      
                    </div>
                  
                  </div>
							</div>
            </div>
          </div>
        </div>
        </section>
@endsection