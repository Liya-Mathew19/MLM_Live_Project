@extends('layouts.admin')
@section('content')

    <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Uploaded Files</h4>
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>Sl.No.</th>
                          <th> Name</th>
                          <th> Identification Number</th>
                          <th> Image</th>
                          <th>Approve</th>
                          <th>Reject</th>
                        </tr>
                      </thead>
                      @if (session('status'))
                    <div class="alert alert-success">
                     {{ session('status') }}
                     </div>
                    @endif	
                      <tbody>
                          @foreach($kycs as $kyc)
                            <tr>
                              <td>{{$kyc->id}}</td>
                              <td>{{$kyc->type}}</td>
                              <td>{{$kyc->identification_number}}</td>
                              <td><a href ="{{asset('uploads/kyc/'.$kyc->path)}}" ><img src="{{asset('uploads/kyc/'.$kyc->path)}}" width="200px" height="200px" alt=""></a></td>
                              @if($kyc->status=='Activated')
                              <td><label class="badge badge-info">Approved</label></td>
                              @else
                              <td><a href="/approvekyc/{{$kyc->id}}"><label class="badge badge-success">Approve</label></a></td>
                              @endif
                              @if($kyc->status=='Deactivated')
                              <td><label class="badge badge-warning">Rejected</label></a></td>
                              @else
                              <td><a href="/rejectkyc/{{$kyc->id}}"><label class="badge badge-danger">Reject</label></a></td>
                              @endif
                            </tr>
                            @endforeach
                          </tbody>
                    </table>
                  </div>
                </div>
</div>   
</div>  
</div>    

            @endsection