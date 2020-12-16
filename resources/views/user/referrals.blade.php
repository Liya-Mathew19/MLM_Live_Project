@extends('layouts.user')
@section('content')
<div class="row mt-4">
						<div class="col-lg-12 grid-margin stretch-card">
							<div class="card card-danger card-outline card-outline-danger">
							<div class="card-header">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">My referrals</h4>
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th> Name</th>
                          <th> Phone</th>
                          <th> Email</th>
                          <th>Address</th>
                        </tr>
                      </thead>
                      <tbody>
                      <tbody>
                          @foreach($users as $user)
                            <tr>
                              <td>{{$user->id}}</td>
                              <td>{{$user->name}}</td>
                              <td>{{$user->email}}</td>
                              <td>{{$user->phone}}</td>
                              <td>{{$user->address}}</td>
                            </tr>
                            @endforeach
                          </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div> 
</div>
</div>             

            @endsection