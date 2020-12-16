@extends('layouts.admin')
@section('content')

<div class="row mt-4">
				<div class="col-lg-12 grid-margin stretch-card">
					<div class="card card-danger card-outline card-outline-danger">
						<div class="card-header">
							<h4 class="card-title">Customer Requests</h4>
						</div>
                <div class="card-body">
                
          
            @if($users==null)
              <center><b><font color="red">{{__('No Requests Found !!')}}</font></b></center>
            @else
            <div class="table-responsive" >
              <table class="table table">

                  <tr>
                    <th>Sl.No.</th>
                    <th> Name</th>
                    <th> Email</th>
                    <th> Phone</th>
                    <th>Others</th>
                  </tr>
                
                  <tbody>
                    @php $no = 1; @endphp
                      <tbody>
                        @foreach($users as $user)
                          <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->phone}}</td>
                            <td><a href="{{route('admincustomerview',$user->id) }}"><button type="button" class="btn btn-primary">View Full Profile</button></a></td>
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