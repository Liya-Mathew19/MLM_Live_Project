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
.fileUpload {
    position: relative;
    overflow: hidden;
    margin: 10px;
}
.fileUpload input.upload {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 20px;
    cursor: pointer;
    opacity: 0;
    filter: alpha(opacity=0);
}
</style>
                                 
@if(Auth::user()->secondary_password==null)
<div class="alert alert-danger">

<li>Update your secondary password!!</li>

</div>
@elseif (\App\Models\Kyc::where('type', '=', 'Aadhar Card Details')->where('fk_user_id','=',Auth::user()->id)->first()==null)
<div class="alert alert-danger">

<li>Update your Aadhar details</li>

</div>
@elseif (\App\Models\Kyc::where('type', '=', 'Pan Card Details')->where('fk_user_id','=',Auth::user()->id)->first()==null)
<div class="alert alert-danger">

<li>Update your PAN details</li>

</div>
@elseif (\App\Models\Kyc::where('type', '=', 'Bank Details')->where('fk_user_id','=',Auth::user()->id)->first()==null)
<div class="alert alert-danger">

<li>Update your Bank details</li>

</div>
@elseif (\App\Models\Kyc::where('type', '=', 'Cancelled Cheque / Passbook FrontPage')->where('fk_user_id','=',Auth::user()->id)->first()==null)
<div class="alert alert-danger">

<li>Update your Cheque details</li>

</div>
@elseif(Auth::user()->bank_name==null)
<div class="alert alert-danger">

<li>Update your bank details !!</li>

</div>

@endif
      <div class="row mt-4">
				<div class="col-lg-8">
					<div class="card card-danger card-outline card-outline-danger">
						<div class="card-header">
							<h4 class="card-title">PROFILE</h4>
						</div>
					  <div class="card-body">



							<div class="row">
								<div class="col-lg-4">
		              <div class="col-lg-8">
										<div class="position-relative">
                    <form class="forms-sample" action="upload_user_image/{{Auth::user()->id}}" method="POST" enctype="multipart/form-data" >
                    @csrf
                    @if(Auth::user()->user_image==null)
                    <img src="{{env('APP_URL')}}/vendors/admin/images/dashboard/user.png" class="w-100" alt="">
                    @else
                    <img src="{{asset('uploads/kyc/'.Auth::user()->user_image)}}" class="w-100" alt=""><br><br>
                    @endif
                      <input type="file" name="user_image" required><br><br>
                       <button type="submit" name="submit" class="btn btn-info"><i class="mdi mdi-camera"></i>Upload</button>
                       
                      </form>
										</div>
									</div>
								</div>
								<div class="col-lg-4">
									<h4 class="card-title">Basic Details</h4><br>
									<div class="row">
										<div class="col-sm-12">
											<ul class="graphl-legend-rectangle">
												<li><span class="bg-danger"></span><b>Name </b>: {{(Auth::user()->name)}}</li>
												<li><span class="bg-warning"></span><b>Email </b>: {{(Auth::user()->email)}}</li>
                        <li><span class="bg-info"></span><b>Phone Number</b> : {{(Auth::user()->phone)}}</li>
                        @if((Auth::user()->address)==null)
                        <li><span class="bg-info" ></span><b>Address</b> : <font color="red"> Not Provided yet</font></li> 
                        @else
                        <li><span class="bg-info"></span><b>Address</b> : <pre style="background: white;padding: 15px;font-size: 14px;">{{(Auth::user()->address)}}</pre></li>
                        @endif

                        @if((Auth::user()->secondary_password)==null)
                        <li><span class="bg-info"></span><b>Secondary Password</b> : <font color="red"> Not Provided yet</font></li> 
                        @else
                        <li><span class="bg-info"></span><b>Secondary Password</b> : {{\App\Helper\Helper::maskpassword(Auth::user()->secondary_password)}}</li>
                        @endif
                        @if((Auth::user()->user_status)=='Activated')
                        <li><span class="bg-info"></span><b>Profile Status </b> : <font color="red">  Active </font></li> 
                        @else
                        <li style="display:none;"></li>
                        @endif
                      </ul>
										</div>
                    @if(Auth::user()->user_status=='Activated')
                    <a href="customerprofileupdate"><button type="button" style="display:none" class="btn btn-primary">Edit Profile</button></a>
									@else
                  <a href="customerprofileupdate"><button type="button" class="btn btn-primary">Edit Profile</button></a>
								@endif	
                </div>
								</div>
                <div class="col-lg-4">
                  <div class="card card-primary card-outline card-outline-primary">
									  <br><h4 class="card-title">Total Referrals : {{$active_referral_count}}</h4><br><br>
                    <h4 class="card-title">Total Children : {{$active_parent_count}}</h4><br>
                  </div>
                </div>
							</div>
						</div>
					</div>
        </div>
        
        
        
				<div class="col-lg-4 mb-3 mb-lg-0">
					<div class="card congratulation-bg text-center">
						<div class="card-body pb-0">
							
              @if(Auth::user()->user_image==null)
                    <img src="{{env('APP_URL')}}/vendors/admin/images/dashboard/user.png"  width="100px" height="100px" alt="">
                    @else
                    <img src="{{asset('uploads/kyc/'.Auth::user()->user_image)}}" width="100px" height="100px" alt=""><br><br>
                    @endif
							<h2 class="mt-2 text-white mb-3 font-weight-bold">Congratulations
                  {{(Auth::user()->name)}}
							</h2>
							<p>{{__('Your Referral link is ')}} </p>
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-prepend">
									  <button onclick=myFunction() class=" btn btn-outline-primary btn-fw">
                      <i class="mdi mdi-content-copy"></i>  
                    </button>
                  </div>
                 @if(isset($acct1))
                
                  <input id="referral" type="text" class="form-control col-md-12" name="referral" readonly="readonly" value="{{ url('/register?ref=' . $acct1) }}">
             
                  @endif
                </div>
              </div>
            </div>
					</div>
				</div>
      </div>
      
      <div class="row mt-0">
				<div class="col-lg-8 grid-margin stretch-card">
					<div class="card card-danger card-outline card-outline-danger">
						<div class="card-header">
							<h4 class="card-title">DOCUMENTS</h4>
            </div>
						<div class="card-body">
           
            @if (\App\Models\Kyc::where('type', '=', 'Aadhar Card Details')
            ->where('status','=','Activated')
            ->where('fk_user_id','=',Auth::user()->id)->first())
            <a href="{{route('aadharupload')}}"><button type="button" style="display:none;" name="status" value="Aadhar card" class="btn btn-primary">Upload Aadhar Card Details</button></a>
             @else
              <a href="{{route('aadharupload')}}"><button type="button" name="status" value="Aadhar card" class="btn btn-primary">Upload Aadhar Card Details</button></a>
              @endif

              @if (\App\Models\Kyc::where('type', '=', 'Pan Card Details')
            ->where('status','=','Activated')
            ->where('fk_user_id','=',Auth::user()->id)->first())
            <a href="{{route('panupload')}}"><button type="button" style="display:none;"  name="status" value="PAN Card" class="btn btn-secondary">Upload Pan Card Details</button></a>
              @else
              <a href="{{route('panupload')}}"><button type="button" name="status" value="PAN Card" class="btn btn-secondary">Upload Pan Card Details</button></a>
              @endif

              @if (\App\Models\Kyc::where('type', '=', 'Bank Details')
            ->where('status','=','Activated')
            ->where('fk_user_id','=',Auth::user()->id)->first())
            <a href="{{route('bankupload')}}"><button type="button" style="display:none;" name="status" value="Bank Details" class="btn btn-success">Upload Bank Details</button></a>
              @else
              <a href="{{route('bankupload')}}"><button type="button" name="status" value="Bank Details" class="btn btn-success">Upload Bank Details</button></a>
              @endif

              @if (\App\Models\Kyc::where('type', '=', 'Cancelled Cheque / Passbook FrontPage')
            ->where('status','=','Activated')
            ->where('fk_user_id','=',Auth::user()->id)->first())
              <a href="{{route('chequeupload')}}"><button type="button" style="display:none;"  name="status" value="Cheque" class="btn btn-warning">Upload Cheque Details</button></a>
              @else
              <a href="{{route('chequeupload')}}"><button type="button" name="status" value="Cheque" class="btn btn-warning">Upload Cheque Details</button></a>
           @endif
           
              <br><br> 
              <div class="table-responsive">
              @if($kycs==null)
                <center><b><font color="red">{{__("No Files uploaded yet !!")}}</font></b></center>
              @else
                <table class="table table-bordered">
                  <thead>
                    @php $no = 1; @endphp
                    @foreach($kycs as $kyc)
                    @endforeach
                      <tr>
                        <th><b>Sl.No.</b></th>
                        <th><b> Name</b></th>
                        <th> <b>Identification Number</b></th>
                        <th><b> Document</b></th>
                        <th><b>Status</b></th>
                        @if($kyc->status=="Activated")
                        <th style="display:none;" ><b>Edit</b></th>
                        <th style="display:none;" ><b>Delete</b></th>
                        @else
                        <th><b>Edit</b></th>
                        <th ><b>Delete</b></th>
                        @endif
                        <th style="display:none;" id="remarkhead"><b>Remarks</b></th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach($kycs as $kyc)
                      <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{$kyc->type}}</td>
                        <td>{{$kyc->identification_number}}</td>
                        <td>
                        @php
                          $image=json_decode($kyc->path);
                          $nos=1;
                          @endphp
                          @foreach($image as $img)
                         <div class="btn-group btn-block" role="group" aria-label="Basic example">
                          <a href ="{{env('APP_URL')}}/uploads/kyc/{{$img}}" class="btn btn-primary btn-xs " target="_blank">View file {{$nos++}}</a>
                          @if(Auth::user()->user_status=='Activated')
                           <a href="{{route('deletekycimage',[$kyc->id,$img])}}" style="width:10px;display:none" class="btn btn-danger btn-xs" onclick="return confirm('are you sure want to delete?'); " title="Delete" ><i class="mdi mdi-close" ></i></a>
                          @else
                          <a href="{{route('deletekycimage',[$kyc->id,$img])}}" style="width:10px;" class="btn btn-danger btn-xs" onclick="return confirm('are you sure want to delete?'); " title="Delete" ><i class="mdi mdi-close" ></i></a>
                          @endif
                          </div>
						  @endforeach
                          <br><br>
                          
                          
                          @if(Auth::user()->user_status !='Activated')
                          <button type="button" style="float:right" class="btn btn-success btn-xs" data-toggle="modal" data-target="#myModal1-{{ $kyc->id }}">+ Add More</button>
                    <br>

<!-- Modal Content-->
<form class="forms-sample" action="{{route('addmorekycimage',$kyc->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
<div class="modal fade" id="myModal1-{{ $kyc->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
@else
                          <button type="button" style="float:right; display:none;" class="btn btn-success btn-xs" data-toggle="modal" data-target="#myModal1-{{ $kyc->id }}">+ Add More</button>
                 
               
                          @endif
                    
                          <br><br>
                          @if($kyc->status=='Activated')
                          <!--<i class="mdi mdi-folder-image" style="display:none;" ></i> <a href="{{route('editkycimage',$kyc->id)}}" style="display:none;">Change</a></td>-->
                            <td><label class="badge badge-success">Approved</label></td>
                            <td style="display:none;"><a href ="{{route('edituploadedkyc',$kyc->id)}}" title="Edit"><i class="mdi mdi-border-color" style="padding:15px"></i></a></td>
                            <td style="display:none;"><a href ="{{route('deleteuploadedkyc',$kyc->id)}}" title="Delete" onclick="return confirm('Do you want to delete??')"><i style="padding:12px" class="mdi mdi-delete-forever"></i></a></td>
                           
                        @elseif($kyc->status=='Deactivated')
                        <!--<i class="mdi mdi-folder-image" ></i> <a href="{{route('editkycimage',$kyc->id)}}">Change</a></td>-->
                            <td><label class="badge badge-warning">Rejected</label></a></td>
                            <td><a href ="{{route('edituploadedkyc',$kyc->id)}}" title="Edit"><i class="mdi mdi-border-color" style="padding:15px"></i></a></td>
                            <td><a href ="{{route('deleteuploadedkyc',$kyc->id)}}" title="Delete" onclick="return confirm('Do you want to delete??')"><i style="padding:12px" class="mdi mdi-delete-forever"></i></a></td>
                           
                        @else
                        <!--<i class="mdi mdi-folder-image"></i> <a href="{{route('editkycimage',$kyc->id)}}">Change</a></td>-->
                            <td><label class="badge badge-info">Pending</label></a></td>
                            <td><a href ="{{route('edituploadedkyc',$kyc->id)}}" title="Edit"><i class="mdi mdi-border-color" style="padding:15px"></i></a></td>
                            <td><a href ="{{route('deleteuploadedkyc',$kyc->id)}}" title="Delete" onclick="return confirm('Do you want to delete??')"><i style="padding:12px" class="mdi mdi-delete-forever"></i></a></td>
                           
                        @endif
                       
                             @if($kyc->status=="Deactivated")
                            <td><font color="red">{{$kyc->remarks}}</font></td>
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

      <div class=" col-lg-4 mb-3 mb-lg-0">
        <div class="card card-success card-outline card-outline-danger">
          <div class="card-header">
					  <h4 class="card-title">Secondary Password</h4>
          </div>
          <div class="card-body">
            <form class="forms-sample" action="{{ route('updatesecondarypassword') }}" method="POST" >
            @csrf
              <div class="form-group row">
                <b><label for="secondary_pwd" class="col-md-12 col-form-label  " >{{ __('Secondary Password') }}</label></b>
                  <div class="col-md-6">
                    <input id="secondary_pwd" type="password" class="form-control @error('secondary_pwd') is-invalid @enderror" placeholder="Secondary password" name="secondary_pwd" required  >
                                                @error('secondary_pwd')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                  </div>
              </div>
            
              <div class="form-group row">
                <b><label for="confirm_secondary_pwd" class="col-md-12 col-form-label  " >{{ __('Confirm Password') }}</label></b>
                  <div class="col-md-6 ">
                    <input id="confirm_secondary_pwd" style="margin:17px" type="password" class="form-control" name="confirm_secondary_pwd"  placeholder="Confirm password" required>
                  </div>
              </div>

                  <button type="submit" class="btn btn-primary" style="float:right">Submit</button>
               
             
            </form>
          </div>     
			  </div>
		  </div>     
    </div>
    
    <div class="row mt-0">
			<div class="col-lg-8 grid-margin stretch-card">
				<div class="card card-danger card-outline card-outline-danger">
					<div class="card-header">
						<h4 class="card-title">Bank Details</h4>
          </div>
					<div class="card-body">
            @foreach($users as $user)
              @if($user->bank_name==null)
                <a href="{{route('bankdetails')}}"><button type="button" class="btn btn-primary">Update Bank Details</button></a>   
                <br><br> 
                <center><b><font color="red">{{__("No Data uploaded yet !!")}}</font></b></center>
              @else 
                <div class="table-responsive">  
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                      <th><b> Account Holder</b></th>
                        <th><b> Bank Name</b></th>
                        <th><b> Branch</b></th>
                        <th> <b>Account Number</b></th>
                        <th><b> IFSC Code</b></th>
                        @if(Auth::user()->user_status=='Activated')
                        <th style="display:none;"><b> Edit</b></th> 
                        @else
                        <th><b> Edit</b></th> 
                        @endif
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                      <td>{{$user->account_holder_name}}</td>
                        <td>{{$user->bank_name}}</td>
                        <td>{{$user->branch_name}}</td>
                        <td>{{$user->acct_no}}</td>
                        <td>{{$user->ifsc_code}}</td>
                        <td>
                        @if(Auth::user()->user_status=='Activated')
                        <a href ="{{ route('edituploadedbank') }}"  style="display:none;" title="Edit"><i class="mdi mdi-border-color" style="padding:15px; display:none;"></i></a></td> 
                        @else
                        <a href ="{{ route('edituploadedbank') }}" title="Edit"><i class="mdi mdi-border-color" style="padding:15px"></i></a></td> 
                        @endif
                      </tr>
                      <button type="button" style="display:none" class="btn btn-primary">Update Bank Details</button>
                @endif
            @endforeach
                    </tbody>
                  </table>
                </div>
                
              </div>
              
            </div>
            </div>
          </div>
          <div class="row mt-0">
        <div class="col-lg-6"></div>
          <div class="col-lg-2">
          @foreach($profile as $p)
          @if($user->user_status=="requested")
            <a href="{{route('userdatarequest')}}"><button type="button" disabled class="btn btn-success btn-lg">Submit</button>
            @elseif($user->user_status=="Activated")
         <button type="button"  style="display:none;" class="btn btn-warning btn-lg">Account Activated</button>
          
          @elseif($p->percentage ==100 || ($p->percentage==90 && \App\Models\Kyc::where('type', '=', 'Pan Card Details')
            ->where('fk_user_id','=',Auth::user()->id)->first()==null))
            <a href="{{route('userdatarequest')}}"><button type="button" class="btn btn-success btn-lg">Submit</button>
          @endif	
          
          @endforeach
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

<script>
function myFunction1() {
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