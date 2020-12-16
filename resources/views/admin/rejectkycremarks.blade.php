@extends('layouts.admin')
@section('content')

<div class="container">
<!--Profile Card-->
  
    <div class="row mt-4">
			<div class="col-lg-12 grid-margin stretch-card">
				<div class="card card-danger card-outline card-outline-danger">
					<div class="card-header">
						<h4 class="card-title">PROFILE</h4>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-lg-4">
		            <div class="col-lg-8">
									<div class="position-relative">
										<img src="images/dashboard/user.png" class="w-100" alt="">
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<h4 class="card-title">Basic Details</h4><br>
									<div class="row">
                    <div class="col-sm-12">
											<ul class="graphl-legend-rectangle">
												<li><span class="bg-danger"></span><b>Name </b>: </li>
												<li><span class="bg-warning"></span><b>Email </b>: </li>
                        <li><span class="bg-info"></span><b>Phone Number</b> : </li>
                        <li><span class="bg-info"></span><b>Address</b> : </li>              
                      </ul>
										</div>
                  </div>
							</div>
						</div>
					</div>
				</div>
			</div>
    </div>

    <div class="row mt-10">
			<div class="col-lg-12 grid-margin stretch-card">
				<div class="card card-danger card-outline card-outline-danger">
					<div class="card-header">
						<h4 class="card-title">Rejection Remarks</h4>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-lg-12">
									<div class="row">
                                    <form class="forms-sample" method="POST" action="{{route('rejectkycinput',$kycs->id)}}">
                        @csrf
                        <div class="form-group">
                      <label for="exampleTextarea1">Remarks</label>
                      <textarea class="form-control" id="remarks" name="remarks" ></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                  </form>
                                    </div>
							</div>
						</div>
					</div>
				</div>
			</div>
    </div>
</div>


@endsection