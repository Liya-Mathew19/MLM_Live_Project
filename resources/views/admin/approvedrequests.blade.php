@extends('layouts.admin')
@section('content')




<div class="row mt-4">
				<div class="col-lg-12 grid-margin stretch-card">
					<div class="card card-danger card-outline card-outline-danger">
						<div class="card-header">
							<h4 class="card-title">Approved Customer Requests</h4>
						</div>
            <div class="card-body">
                <div class="form-group col-lg-12">
                <form action="" method="GET">
                  <div class="input-group ">
                    <div class="input-group-prepend">
                      <select class="btn btn-sm btn-outline-primary dropdown-toggle" required name="search_type" id="exampleFormControlSelect2">
                        <option value="name">Name</option>
                        <option value="account_id">Account ID</option>
                      </select>
                    </div>
                    <input type="text" name="search_text" class="form-control" placeholder="Search users" aria-label="Search users">
                    <div class="input-group-append">
                      <button class="btn btn-sm btn-primary" type="submit"><i class="mdi mdi-account-search"></i></button>
                    </div>
                  </div>
                    
                    </form>
                </div>
            


            @if($users==null)
              <center><b><font color="red">{{__('No Approved Requests Found !!')}}</font></b></center>
            @else
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                         <th> <b>Sl.No. </b></th>
                          <th> <b> Name </b></th>
                          <th> <b> Phone </b></th>
                          <th> <b> Email </b></th>
                          <th> <b>Address </b></th>
                          <th> <b>Other Details </b></th>
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
                              <td><a href="{{route('adminuserview',$user->id)}}" ><button type="button" class="btn btn-primary">View Profile</button></a></td>
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