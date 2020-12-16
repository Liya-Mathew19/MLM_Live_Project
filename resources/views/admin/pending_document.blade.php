@extends('layouts.admin')
@section('content')
@if (session('status'))
  <div class="alert alert-success">
    {{ session('status') }}
  </div>
@endif	

<!--Documents Card-->
<div class="row mt-0">
						<div class="col-lg-12 grid-margin stretch-card">
						  <div class="card card-danger card-outline card-outline-danger">
							    <div class="card-header">
											<h4 class="card-title">PENDING DOCUMENT REQUESTS</h4>
                  </div>

								<div class="card-body">
                  <div class="table-responsive">
                  @if($account->isEmpty())
                      <center><b><font color="red">{{__("No requests found !!")}}</font></b></center>
                    @else
                    <table class="table table">
                      <thead>
                        @php $no = 1; @endphp
                        <tr>
                          <th><b>Sl.No.</b></th>
                          <th><b>User Name</b></th>
                          <th><b> Document Type</b></th>
                          <th> <b>Identification Number</b></th>
                          <th><b> Document</b></th>
                          <th><b>Approve</b></th>
                          <th><b>Reject</b></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($account as $kyc)
                          <tr>
                            <td>{{ $no++ }}</td>
                            <td><a href="{{route('adminuserview',$kyc->uid)}}">{{$kyc->name}}</a></td>
                            <td>{{$kyc->type}}</td>
                            <td>{{$kyc->identification_number}}</td>
                            <td>@php
                          $image=json_decode($kyc->path);
                          $nos=1;
                          @endphp
                          @foreach($image as $img)
                          <button type="button" class="btn btn-outline-info">
                          <a href ="{{env('APP_URL')}}/uploads/kyc/{{$img}}" target="_blank">View file {{$nos++}}</a>
                          </button>
                          
                          @endforeach</td>
                          
                            @if($kyc->status=='Activated')
                            <td><label class="badge badge-success">Approved</label><br><br>
                            <i class="mdi mdi-close-box"></i><a href="{{route('changekycstatus',$kyc->id)}}">Cancel</a></td> 
                            <td><button type="button" disabled class="btn btn-danger">Reject</button></td>  
                                                       
                            @elseif($kyc->status=='Pending')
                            <td><a href="{{route('approvekyc',$kyc->id)}}" onclick="return confirm('Are you sure,want to approve the request??')" ><button type="button" class="btn btn-success">Approve</button></td>
                            
                            <td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal2">Reject</button></td>
                   

<!-- Modal Content-->
<form class="forms-sample" action="{{route('updateremarks',$kyc->id)}}" method="POST" >
                    @csrf
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Rejection Reason</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="form-group">
                      <label for="exampleInputName1">Reason</label>
                      <input type="text" class="form-control" id="remarks" name ="remarks" placeholder="Enter the reason.." required  >
                    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure, want to reject the request??')">Submit</button>
      </div>
    </div>
  </div>
</div>
</form>
                  
                            
                    
                            @endif
                        
                            @if($kyc->status=='Deactivated')
                            <td><button type="button" disabled class="btn btn-success">Approve</button></a></td>  
                            <td><label class="badge badge-warning">Rejected</label></a><br><br>
                            <i class="mdi mdi-close-box"></i><a href="{{route('changekycstatus',$kyc->id)}}">Cancel</a></td>
                            <td><label>{{$kyc->remarks}}</label></a></td>
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
@endsection