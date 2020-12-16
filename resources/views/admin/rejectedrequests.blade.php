@extends('layouts.admin')
@section('content')
<div class="row mt-4">
				<div class="col-lg-12 grid-margin stretch-card">
					<div class="card card-danger card-outline card-outline-danger">
						<div class="card-header">
							<h4 class="card-title">Rejected Customer Requests</h4>
						</div>
                <div class="card-body">
                  @if($users==null)
                  <center><b><font color="red">{{__('No Rejected Users Found !!')}}</font></b></center>
                          @else
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th> Name</th>
                          <th> Phone</th>
                          <th> Email</th>
                          <th>Address</th>
                          <th>Other Details</th>
                        </tr>
                      </thead>
                      <tbody>
                      <tbody>
                          @foreach($users as $user)
                            <tr>
                              <td>{{$user->id}}</td>
                              <td>{{$user->name}}</td>
                              <td>{{$user->phone}}</td>
                              <td>{{$user->email}}</td>
                              <td>{{$user->address}}</td>
                              <td><a href="{{route('adminuserview',$user->id)}}"><button type="button" class="btn btn-primary">View Profile</button></a></td></tr>
                            @endforeach
                          </tbody>
                    </table>
                  </div>
                  @endif
                </div>
              </div>
            </div>
                  
                 
</div>

         @endsection