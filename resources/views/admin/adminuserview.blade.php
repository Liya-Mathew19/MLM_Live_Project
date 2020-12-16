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

@php
$accounts=$results['account'];
$kyc=$results['kyc'];
@endphp
<style>
fieldset.scheduler-border {
    border: 1px groove #ddd !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 1.5em 1.5em 0 !important;
   
    -webkit-box-shadow:  0px 0px 0px 0px #000;
            box-shadow:  0px 0px 0px 0px #000;
}

    legend.scheduler-border {
        font-size: 1.2em !important;
        font-weight: bold !important;
        text-align: left !important;
        width:auto;
        padding:0 10px;
        border-bottom:none;
    }
    </style>

<!--Profile Card-->
  
    <div class="row mt-4">
			<div class="col-lg-12 grid-margin stretch-card">
				<div class="card card-danger card-outline card-outline-danger">
					<div class="card-header">
						<h4 class="card-title">PROFILE</h4>
            <a href="{{route('admin_subscription_payment',$users->id)}}"><button type="button" style="float:right"  class="btn btn-warning" title="Make Subscription Payment">Make Subscription Payment</button></a>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-lg-4">
		            <div class="col-lg-8">
									<div class="position-relative">
                  @if($users->user_image==null)
                    <img src="images/dashboard/user.png" class="w-100" alt="">
                    @else
                    <img src="{{asset('uploads/kyc/'.$users->user_image)}}" class="w-100" alt=""><br><br>
                    @endif
									</div>
								</div>
              </div>
              
							<div class="col-lg-4">
								<h4 class="card-title">Basic Details</h4><br>
									<div class="row">
                    <div class="col-sm-12">
											<ul class="graphl-legend-rectangle">
												<li><span class="bg-danger"></span><b>Name </b>:{{$users->name}} </li>
												<li><span class="bg-warning"></span><b>Email </b>: {{$users->email}}</li>
                                                
                        <li><span class="bg-info"></span><b>Phone Number</b> : {{$users->phone}}</li>
                        @if($users->address==null)
                        <li><span class="bg-info"></span><b>Address</b> : <font color="red"> Not Provided yet</font></li> 
                        @else
                        <li><span class="bg-info"></span><b>Address</b> : <pre style="background: white;padding: 15px;font-size: 14px;">{{$users->address}}</pre></li>  
                        @endif    
                        @if($users->user_status=='Activated')
                        <li><span class="bg-info"></span><b>Account Status </b> : <font color="red"> &nbsp;<b>Active</b></font></li> 
                        @else
                        <li style="display:none"></li>  
                        @endif          
                      </ul>
										</div>
                  </div>
              </div>
              
              <div class="col-lg-4">
									<div class="row">
                    <div class="col-sm-12">
                      <div class="card card-primary card-outline card-outline-primary">
										    <h4 style="padding: 17px; color:black"><b>Total Earnings : 	&#x20B9;{{\App\Helper\PaymentHelper::total_commission_earned($users->id)}}</b></h4>
                        <h4 style="padding: 17px; color:black"><b>Total Withdrawals : 	&#x20B9;{{\App\Helper\PaymentHelper::getTotalWithdrawals($users->id)}} </b> </h4>
                        <h4 style="padding: 17px; color:black"><b>Total Payments : 	&#x20B9;{{$trans_amount}} </b> </h4>
                     
                      </div>
                      <br>
                      <button type="button"  class="btn btn-danger" data-toggle="modal" data-target="#myModalpayment-{{ $users->id }}" title="Subscription Payment Report">View Subscription Payment Details</button>
               
                    <form class="forms-sample" action="{{route('subscription_payment_reports',$users->id)}}" target="_blank" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="modal fade" id="myModalpayment-{{ $users->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                            <h4 class="card-title">Subscription Payments</h4><br>
                              <div class="form-group">
                                
                                <input type="hidden" value="{{ $users->id }}" class="form-control" id="exampleInputName1" name="id">
                                <div class="form-group">
                                  <fieldset class="scheduler-border col-lg-10">
                                    <legend class="scheduler-border ">Start Date</legend>
                                    <input type="date" class="col-lg-6" name="start_date" id="start_date" required>    
                                  </fieldset>
                
                                  <fieldset class="scheduler-border col-lg-10" >
                                    <legend class="scheduler-border ">End Date</legend>
                                    <input type="date" class="col-lg-6" name="end_date"  id="end_date" required>  
                                  </fieldset>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary" >Submit</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>  
                      </div> 
                    </form>
                    
                    </div>
                   
                  </div>
                 
              </div>
             
            </div>
            
            <hr style="height:1px;border-width:0;color:gray;background-color:gray">
          
    @if($users->user_status=='Activated')
      @if($transactions->isEmpty())
      <td><a href="{{route('rejectcustomer',$users->id)}}" onclick="return confirm('Reject the request??')"><button type="button" class="btn btn-danger btn-rounded btn-fw col-lg-2 ">Reject</button></a></td>
      <td><a href="{{route('admincustomerprofileupdate',$users->id)}}"><button type="button"  class="btn btn-info btn-rounded btn-fw col-lg-2 ">Edit</button></a></td>
      <td><a href="{{route('terminatecustomer',$users->id)}}" onclick="return confirm('Are you sure,want to block the user??')"><button type="button"  class="btn btn-dark btn-rounded btn-fw col-lg-2 ">Terminate</button></a></td>
      <td><a href="{{route('deletecustomer',$users->id)}}" onclick="return confirm('Are you sure,want to delete the user??')"><button type="button"  class="btn btn-warning btn-rounded btn-fw col-lg-2 ">Delete</button></a></td>
      @else 
      <td><a href="{{route('admincustomerprofileupdate',$users->id)}}"><button type="button"  class="btn btn-info btn-rounded btn-fw col-lg-2 ">Edit</button></a></td>
      <td><a href="{{route('terminatecustomer',$users->id)}}" onclick="return confirm('Are you sure,want to block the user??')"><button type="button"  class="btn btn-dark btn-rounded btn-fw col-lg-2 ">Terminate</button></a></td>
      @endif
    @elseif($users->user_status=='requested')
      <td><a href="{{route('approvecustomer',$users->id)}}" onclick="return confirm('Approve the request??')" ><button type="button" class="btn btn-success btn-rounded btn-fw col-lg-2 ">Approve</button></a></td>
      <td><a href="{{route('rejectcustomer',$users->id)}}" onclick="return confirm('Reject the request??')"><button type="button"  class="btn btn-danger btn-rounded btn-fw col-lg-2 ">Reject</button></a></td>
      <td><a href="{{route('admincustomerprofileupdate',$users->id)}}"><button type="button"  class="btn btn-info btn-rounded btn-fw col-lg-2 ">Edit</button></a></td>
      <td><a href="{{route('terminatecustomer',$users->id)}}" onclick="return confirm('Are you sure,want to block the user??')"><button type="button"  class="btn btn-dark btn-rounded btn-fw col-lg-2 ">Terminate</button></a></td>
      <td><a href="{{route('deletecustomer',$users->id)}}" onclick="return confirm('Are you sure,want to delete the user??')"><button type="button"  class="btn btn-warning btn-rounded btn-fw col-lg-2 ">Delete</button></a></td>

     @elseif($users->user_status=='Terminated')
      <td><button type="button" disabled class="btn btn-success btn-rounded btn-fw col-lg-2 ">Approve</button></td>
      <button type="button" disabled class="btn btn-danger btn-rounded btn-fw col-lg-2 ">Reject</button>
      <button type="button"  disabled class="btn btn-info btn-rounded btn-fw col-lg-2 ">Edit</button>
      <a href="{{route('unblockcustomer',$users->id)}}" onclick="return confirm('Are you sure,want to unblock the user??')"><button type="button" class="btn btn-dark btn-rounded btn-fw col-lg-2 ">Unblock</button></a>
      <button type="button" disabled  class="btn btn-warning btn-rounded btn-fw col-lg-2 ">Delete</button>
 

      @elseif($users->user_status=='Unblocked')
      <td><button type="button" disabled class="btn btn-success btn-rounded btn-fw col-lg-2 ">Approve</button></td>
      <td><a href="{{route('rejectcustomer',$users->id)}}" onclick="return confirm('Reject the request??')"><button type="button"  class="btn btn-danger btn-rounded btn-fw col-lg-2 ">Reject</button></a></td>
      <td><a href="{{route('admincustomerprofileupdate',$users->id)}}"><button type="button"  class="btn btn-info btn-rounded btn-fw col-lg-2 ">Edit</button></a></td>
      <a href="{{route('terminatecustomer',$users->id)}}" onclick="return confirm('Are you sure,want to block the user??')"><button type="button" class="btn btn-dark btn-rounded btn-fw col-lg-2 ">Terminate</button></a>
      <a href="{{route('deletecustomer',$users->id)}}" onclick="return confirm('Are you sure,want to delete the user??')"><button type="button"  class="btn btn-warning btn-rounded btn-fw col-lg-2 ">Delete</button></a>
     

    @elseif($users->user_status=='Deactivated')
      <td><button type="button" disabled class="btn btn-success btn-rounded btn-fw col-lg-2 ">Approve</button></td>
      <td><button type="button" class="btn btn-danger btn-rounded btn-fw col-lg-2 ">Rejected</button></td></td>
      <td><button type="button"  class="btn btn-info btn-rounded btn-fw col-lg-2 ">Edit</button></td>
      <td><button type="button"  class="btn btn-dark btn-rounded btn-fw col-lg-2 ">Terminate</button></td>
      <td><button type="button"  class="btn btn-warning btn-rounded btn-fw col-lg-2 ">Delete</button></td>
    @endif	
          
          </hr>
          </div>
          
				</div>
			</div>
    </div>


<!--Documents Card-->
          <div class="row mt-0">
						<div class="col-lg-12 grid-margin stretch-card">
						  <div class="card card-danger card-outline card-outline-danger">
							    <div class="card-header">
											<h4 class="card-title">DOCUMENTS</h4>
                  </div>

								<div class="card-body">
                @if (\App\Models\Kyc::where('type', '=', 'Pan Card Details')->where('fk_user_id','=',$users->id)->first()==null)
                <b><font color="red">{{__("PAN Card details not uploaded yet !!")}}</font></b>
                @endif

                  <div class="table-responsive">
                  @if($kycs==null)
                      <center><b><font color="red">{{__("No Files uploaded yet !!")}}</font></b></center>
                    @else
                    <table class="table table">
                      <thead>
                        @php $no = 1; @endphp
                        
                        <tr>
                          <th><b>Sl.No.</b></th>
                          <th><b> Name</b></th>
                          <th> <b>Identification Number</b></th>
                          <th><b> Document</b></th>
                          <th><b>Status</b></th>
                          <th><b>Edit</b></th>
                          @if($kyc ==null)
                          <th><b>Remarks</b></th>
                            @else
                            <th style="display:none;"><b>Remarks</b></th>
                            @endif
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($kycs as $kyc)
                          <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{$kyc->type}}</td>
                            <td>{{$kyc->identification_number}}</td>
                            <td>@php
                          $image=json_decode($kyc->path);
                          $nos=1;
                          @endphp
                          @foreach($image as $img)
                          <div class="btn-group btn-block" role="group" aria-label="Basic example">
                          <a href ="{{env('APP_URL')}}/uploads/kyc/{{$img}}" class="btn btn-primary btn-xs " target="_blank">View file {{$nos++}}</a>
                          <a href="{{route('admindeletekycimage',[$kyc->id,$img])}}" style="width:10px;" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure want to delete?'); " title="Delete" ><i class="mdi mdi-close" ></i></a>
                          </div>
                          @endforeach
                          <br><br>
                          <button type="button" style="float:right" class="btn btn-success btn-xs" data-toggle="modal" data-target="#myModaladd-{{ $kyc->id }}">+ Add More</button>
                    <br>

<!-- Modal Content-->
<form class="forms-sample" action="{{route('adminaddmorekycimage',$kyc->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
<div class="modal fade" id="myModaladd-{{ $kyc->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Document Upload</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="form-group">
      <input type="hidden" class="form-control" id="id" name ="id" value="{{ $kyc->id }}" required  >
                   
                      <label for="exampleInputName1">Document</label>
                      <input type="file" class="form-control" id="path" name ="path" placeholder="Upload the document" required  >
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
                          </td>

                            @if($kyc->status=='Activated')
                            <td><label class="badge badge-success">Approved</label><br><br>          
                            @elseif($kyc->status=='Pending')
                            <td><label class="badge badge-warning">Pending</label><br><br> 
                            @elseif($kyc->status=='Deactivated')
                            <td><label class="badge badge-danger">Rejected</label></a><br><br>
                            <td><label>{{$kyc->remarks}}</label></a></td>
                            @endif 
                            <td><button type="button"  class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal1-{{ $kyc->id }}">Edit</button></td>
               

<!-- Modal Content-->
@if(isset($kyc->id))
<form class="forms-sample" action="{{route('adminupdateuploadedkyc',$kyc->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
<div class="modal fade" id="myModal1-{{ $kyc->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="form-group">
      <h4 class="card-title">Edit KYC details</h4><br>
                 
                      <input type="hidden" value="{{ $kyc->id }}" class="form-control" id="exampleInputName1" name="id">
                    
                      <div class="form-group">
                      <label for="exampleInputName1">Type</label>
                      <input type="text" value="{{ $kyc->type }}" readonly="readonly" class="form-control" id="exampleInputName1" name="type">
                    </div>
                  
                  @if($kyc->type=='Aadhar Card Details')

                    <div class="form-group">
                      <label for="exampleInputPassword4">Aadhar Number</label>
                      <input type="text" value="{{ $kyc->identification_number }}"  class="form-control @error('aadhar_identification_number') is-invalid @enderror" value="{{ old('aadhar_identification_number') }}" autocomplete="aadhar_identification_number" autofocus id="aadhar_identification_number" name="aadhar_identification_number" min="12" max="12" required placeholder="Aadhar Number">
                      @error('aadhar_identification_number')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>  
  
                    @elseif($kyc->type=='Pan Card Details')
                    <div class="form-group">
                      <label for="exampleInputPassword4">PAN Number</label>
                      <input type="text" id="exampleInputPassword4" value="{{ $kyc->identification_number }}" name=pan_identification_number  class="form-control @error('pan_identification_number') is-invalid @enderror" value="{{ old('identification_number') }}" autocomplete="identification_number" autofocus id="pan_identification_number" required placeholder="PAN Number">
                      @error('pan_identification_number')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>

                    @elseif($kyc->type=='Bank Details')
                    <div class="form-group">
                      <label for="exampleInputPassword4">Account Number</label>
                      <input type="text" id="exampleInputPassword4" value="{{ $kyc->identification_number }}" name=bank_identification_number  class="form-control @error('bank_identification_number') is-invalid @enderror" value="{{ old('bank_identification_number') }}" autocomplete="bank_identification_number" autofocus id="bank_identification_number" required  placeholder="Account Number">
                      @error('bank_identification_number')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>

                    @elseif($kyc->type=='Cancelled Cheque / Passbook FrontPage')
                    <div class="form-group">
                          <label for="exampleInputPassword4">Cheque Number</label>
                         <input type="text" value="{{ $kyc->identification_number }}" class="form-control @error('identification_number') is-invalid @enderror" id="identification_number" name=identification_number   value="{{ old('identification_number') }}" autocomplete="identification_number" autofocus id="identification_number"  placeholder="Cheque Number">
                         @error('identification_number')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                      </div> 
                      @endif
                    
                  @else
                  <center><font color="red">{{'No data found !!!'}}</font>
                  @endif

                </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>
</form>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>



            <!--Bank Card-->
            <div class="row mt-0">
						  <div class="col-lg-12 grid-margin stretch-card">
							  <div class="card card-danger card-outline card-outline-danger">
							    <div class="card-header">
								    <h4 class="card-title">Bank Details</h4>
                  </div>
								  <div class="card-body">
                    <div class="table-responsive">
                    @if($users->bank_name==null)
                      <center><b><font color="red">{{__("No bank details uploaded yet !!")}}</font></b></center>
                    @else
                      <table class="table table">
                        <thead>
                        @php $no = 1; @endphp
                          <tr>
                            <th><b>Sl.No.</b></th>
                            <th><b> Account Holder</b></th>
                            <th><b> Bank Name</b></th>
                            <th><b> Branch Name</b></th>
                            <th> <b>Account Number</b></th>
                            <th><b> IFSC Code</b></th>
                            <th><b> Edit</b></th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{$users->account_holder_name}}</td>
                            <td>{{$users->bank_name}}</td>
                            <td>{{$users->branch_name}}</td>
                            <td>{{$users->acct_no}}</td>
                            <td>{{$users->ifsc_code}}</td>
                            <td><button type="button"  class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal2-{{ $users->id }}">Edit</button></td>
                    
<form class="forms-sample" action="{{route('adminedituploadedbankdetails',$users->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
<div class="modal fade" id="myModal2-{{ $users->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Document Upload</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="form-group">
                      <label for="exampleInputName1">Account Holder Name</label>
                      <input type="text" class="form-control" id="holder_name" name ="holder_name" class="form-control @error('holder_name') is-invalid @enderror" value="{{$users->account_holder_name}}" autocomplete="holder_name" autofocus  required  >
                      @error('holder_name')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>

                    <div class="form-group row">
                      <div class="col">
                      <label for="exampleInputName1">Bank Name</label>
                            <div id="the-basics">
                              <input type="text" class="form-control" id="bank_name" name ="bank_name" class="form-control @error('bank_name') is-invalid @enderror" value="{{$users->bank_name}}" autocomplete="bank_name" autofocus  required  >  
                              @error('bank_name')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                            </div>
                      </div>
                      <div class="col">
                      <label for="exampleInputName1">Branch Name</label>
                          <div id="bloodhound">
                          <input type="text" class="form-control" id="branch_name" name ="branch_name" class="form-control @error('branch_name') is-invalid @enderror" value="{{$users->branch_name}}" autocomplete="branch_name" autofocus  required  >
                          @error('branch_name')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                        </div>
                      </div>
                  </div>

                  <div class="form-group row">
                      <div class="col">
                      <label for="exampleInputEmail3">Account Number</label>
                            <div id="the-basics">
                            <input type="password" class="form-control" id="acct_no" name="acct_no" class="form-control @error('acct_no') is-invalid @enderror" value="{{$users->acct_no}}" autocomplete="acct_no" autofocus required>
                            @error('acct_no')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                            </div>
                            
                      </div>
                      <div class="col">
                        <label for="exampleInputEmail3">Confirm Account Number</label>
                          <div id="the-basics">
                            <input type="text" class="form-control" id="acct_no_confirm" name="acct_no_confirmation" class="form-control @error('acct_no_confirmation') is-invalid @enderror" value="{{$users->acct_no}}" autocomplete="acct_no" autofocus required>
                          </div>
                      </div>
                     </div> 
                      <div class="form-group row">
                      <div class="col">
                      <label for="exampleInputPassword4">IFSC Code</label>
                          <div id="bloodhound">
                          <input type="text" class="form-control" id="ifsc_code" name ="ifsc_code" class="form-control @error('ifsc_code') is-invalid @enderror" value="{{$users->ifsc_code}}" autocomplete="ifsc_code" autofocus  required >
                          @error('ifsc_code')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                        </div>
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
                          </tr>
                        </tbody>
                      </table>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>



            
<!--Other Accounts Card-->
<div class="row mt-0">
						  <div class="col-lg-12 grid-margin stretch-card">
							  <div class="card card-danger card-outline card-outline-danger">
							    <div class="card-header">
								    <h4 class="card-title">Your Subscription Accounts</h4>
                  </div>
								  <div class="card-body">
                    <div class="table-responsive">
                    @if($account==null)
                      <center><b><font color="red">{{__("No Other Accounts Found !!")}}</font></b></center>
                    @else
                      <table class="table table">
                        <thead>
                        @php $no = 1; @endphp
                          <tr>
                            <th><b>Sl.No.</b></th>
                            <th><b>Account ID</b></th>
                            <th> <b>Referral ID</b></th>
                            <th> <b>Parent ID</b></th>
                            <th> <b>Created On</b></th>
                            <th> <b>Activated On</b></th>
                            <th> <b>Total Earnings</b></th>
                            <th> <b>Status</b></th>
                            
                            @if($accounts !=null)
                            <th style="display:none;"><b>Remarks</b></th>
                            @else
                            <th><b>Remarks</b></th>
                            @endif
                            <th > <b>Network Tree</b></th>
                            <th > <b>Report</b></th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach($account as $accounts)
                          <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{\App\Helper\PaymentHelper::bind_account_number($accounts->acct_id)}}<br><br>
                            @if($accounts->acct_type=='Primary')
                              <center><label class="badge badge-success">{{$accounts->acct_type}}</label></center>
                              @elseif($accounts->acct_type=='Secondary')
                              <center><label class="badge badge-danger">{{$accounts->acct_type}}</label></center>
                              @endif</td>

                              @if($accounts->fk_referral_id==null)
                            <td><font color="red">Referral ID not specified</font></td>
                            @else
                            <td>{{\App\Helper\PaymentHelper::bind_account_number($accounts->fk_referral_id)}}</td>
                            @endif

                            
                            @if($accounts->fk_parent_id==null)
                            <td><font color="red">Parent ID not specified</font></td>
                            @else
                            <td>{{\App\Helper\PaymentHelper::bind_account_number($accounts->fk_parent_id)}}</td>
                            @endif
                            
                            <td>{{\App\Helper\PaymentHelper::convert_date_format($accounts->created_at)}}</td>
                            <td>{{\App\Helper\PaymentHelper::convert_date_format($accounts->account_activation_date)}}</td>
                            <td>&#x20B9;{{\App\Helper\PaymentHelper::total_earnings($accounts->acct_id)}}</td>
                            @if($accounts->status=='Activated')
                            <td><label class="badge badge-success">Approved</label><br><br>                       
                            @elseif($accounts->status=='requested')
                            <td><label class="badge badge-warning">Requested</label></td>   
                            @elseif($accounts->status=='Cancelled')
                            <td><label class="badge badge-primary">Cancelled</label></td>  
                            @elseif($accounts->status=='Terminated')
                            <td><label class="badge badge-danger">Terminated</label></td>  
                            @elseif($accounts->status=='Deactivated')
                            <td><label class="badge badge-danger">Rejected</label></td>   
                            <td><label>{{$accounts->remarks}}</label></a></td>
                            @endif 
                            @if($accounts->status !='Cancelled')
                            <td><a href="{{route('admin_usernetworktree',$accounts->acct_id)}}" target="_blank"><button type="button" class ="btn btn-primary" >View Tree</button></a></td>
                     <td> <button type="button"  class="btn btn-warning" data-toggle="modal" data-target="#myModaltree-{{ $accounts->acct_id }}" title="Downline Report">View Report</button>
               </td>
               <form class="forms-sample" action="{{route('get_network_tree',$accounts->acct_id)}}" target="_blank" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="modal fade" id="myModaltree-{{ $accounts->acct_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
							<h4 class="card-title">DOWNLINE REPORT</h4><br>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
							
                            <div class="modal-body">
                            
                              <div class="form-group">
                                
                                <input type="hidden" value="{{ $accounts->acct_id }}" class="form-control" id="exampleInputName1" name="id">
                                <div class="form-group">
                                  <fieldset class="scheduler-border col-lg-10">
                                    <legend class="scheduler-border ">Date</legend>
                                    <select name="month" id="month" required>
									<option value="">--Select Month--</option>
                                      <option value="1">January</option>
                                      <option value="2">February</option>
                                      <option value="3">March</option>
                                      <option value="4">April</option>
                                      <option value="5">May</option>
                                      <option value="6">June</option>
                                      <option value="7">July</option>
                                      <option value="8">August</option>
                                      <option value="9">September</option>
                                      <option value="10">October</option>
                                      <option value="11">November</option>
                                      <option value="12">December</option>
                                    </select>

                                    <select id="year" name="year" required>
                                      <option value="">--Select Year--</option>
                                          {{ $year = date('Y') }}
                                      @for ($y = $year; $y <= $year; $y++)
                                        <option value="{{ $y }}">{{ $y }}</option>
                                           @endfor
                                      </select>
                                    </fieldset>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary" >Submit</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>  
                      </div> 
                    </form>
                    @endif
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>




<script>
function myFunction() {
  var x = document.getElementById("remarks");
  var y = document.getElementById("submit");
  var z = document.getElementById("remarkhead");
  if (x.style.display === "none") {
    x.style.display = "block";
    y.style.display = "block";
    z.style.display = "block";
  } else {
    x.style.display = "none";
    y.style.display = "none";
    z.style.display = "none";
  }
}

</script>
@endsection