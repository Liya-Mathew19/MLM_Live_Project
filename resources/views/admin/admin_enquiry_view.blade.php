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
<div class='container-fluid'>
					 <div class="row mt-4">
						<div class="col-lg-12 grid-margin stretch-card">
        				<div class="card card-danger card-outline card-outline-danger">                
               <div class="card-header">
                  <h4 class="card-title">User Enquiry</h4><br>
                  </div>
                  <div class="card-body">
                  @foreach($enquires as $enquiry)
                  @endforeach
                @if(empty($enquiry))
                    <center><font color="red"><h3>No Enquiries Found..!!</h3></font></center>
                @else
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th><b> Sl.No.</th>
                          <th><b> Name</th>
                          <th><b> Email</th>
                          <th><b>  Subject </th>
                          <th><b>  Message </th>
                          <th><b>  Action </th>
                        </tr>
                      </thead>
                      <tbody>
                      @php 
                        $no=1 ;
                    @endphp
              @foreach($enquires as $enquiry)
                        <tr>
                          <td >{{$no++}}</td>
                          <td>{{$enquiry->name}}</td>
                          <td>{{$enquiry->email}}</td>
                          <td>{{$enquiry->subject}}</td>
                          <td >{{$enquiry->message}}</td>
                          <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-add-{{ $enquiry->id }}">Send Reply</button></td></td>
                         
                         
<!-- Modal Content-->
<form class="forms-sample" action="{{route('enquiry_reply',$enquiry->id)}}" method="POST" >
                    @csrf
<div class="modal fade" id="modal-add-{{ $enquiry->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Send Enquiry Message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="form-group">
                      <label for="exampleInputName1">Message</label>
                      <input type="text" class="form-control" id="message" name ="message" placeholder="Enter the reply message.." required  >
                    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" >Submit</button>
      </div>
    </div>
  </div>
</div>
</form>
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