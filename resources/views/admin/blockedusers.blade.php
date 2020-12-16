@extends('layouts.admin')
@section('content')
<div class="row mt-4">
				<div class="col-lg-12 grid-margin stretch-card">
					<div class="card card-danger card-outline card-outline-danger">
						<div class="card-header">
							<h4 class="card-title">Blocked Users</h4>
						</div>
                <div class="card-body">
                  @if($users==null)
                  <center><b><font color="red">{{__('No Blocked users Found !!')}}</font></b></center>
                          @else
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>Sl.No.</th>
                          <th> Name</th>
                          <th> Phone</th>
                          <th> Email</th>
                          <th>Address</th>
                          <th>Other Details</th>
                        </tr>
                      </thead>
                      
                      <tbody>
                      @php $no = 1; @endphp
                      <tbody>
                          @foreach($users as $user)
                          
                            <tr>
                              <td>{{$no++}}</td>
                              <td>{{$user->name}}</td>
                              <td>{{$user->phone}}</td>
                              <td>{{$user->email}}</td>
                              <td>{{$user->address}}</td>
                              <td><a href="{{route('adminuserview',$user->id)}}"><button type="button" class="btn btn-primary">View Profile</button></a></td>
                            </tr>
                            
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