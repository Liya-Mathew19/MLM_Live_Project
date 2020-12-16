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
                    <h4 class="card-title">User requests on progress</h4><br>
                </div>
                <div class="card-body">
                    @if($users->isEmpty())
                        <center><font color="red"><h3>No Users Found..!!</h3></font></center>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th><b>Sl.No.</th>
                                        <th><b>Name</th>
                                        <th><b>Phone</th>
                                        <th><b>Email</th>
                                        <th><b>Phone OTP</th>
                                        <th><b>Email OTP</th>
                                        <th><b>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php 
                                        $no=1 ;
                                    @endphp
                                    @foreach($users as $user)
                                        <tr>
                                            <td >{{$no++}}</td>
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->phone}}</td>
                                            <td>{{$user->email}}</td>
                                            <td >{{$user->phone_otp}}</td>
                                            <td >{{$user->email_otp}}</td>
                                            <td><a href="{{route('terminatecustomer',$user->id)}}" onclick="return confirm('Are you sure,want to cancel the request??')" ><button type="button" class="btn btn-warning">Cancel</button></td>
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
</div>      
@endsection