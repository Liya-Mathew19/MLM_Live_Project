@extends('layouts.user')
@section('content')
    <!-- partial -->
              <div class='container'>
					 <div class="row mt-4">
						<div class="col-lg-12 grid-margin stretch-card">
        				<div class="card card-danger card-outline card-outline-danger">
              <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Upload KYC details</h4><br>
                  <form class="forms-sample" action="{{ route('storekyc') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                      <input type="hidden" value="{{ Auth::user()->id }}" class="form-control" id="exampleInputName1" name="id" placeholder="Name">
                    <div class="form-group">
                      <label for="exampleInputName1">User Name</label>
                      <input type="text" value="{{ Auth::user()->name }}" class="form-control" id="exampleInputName1" name="name" placeholder="Name">
                    </div>
                    <div class="form-group">
                    <label for="exampleFormControlSelect3">Type</label>
                    <select class="form-control form-control-sm" name="type" id="exampleFormControlSelect3" required>
                    <option>--Select--</option>
                      <option>Pan Card details</option>
                      <option>Aadhar Card details</option>
                      <option>Bank Details</option>
                    </select>
                  </div>
                  
                    <div class="form-group">
                      <label for="exampleInputPassword4">Identification Number</label>
                      <input type="text" class="form-control" id="exampleInputPassword4" name=identification_number  required placeholder="Identification Number">
                    </div>
            
                    <div class="form-group">
                      <label>File upload</label>
                      <div class="input-group col-xs-12">
                        <input type="file" class="form-control file-upload-info" name='path' required>
                        <span class="input-group-append">
                         
                        </span>
                      </div>
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
		
@endsection			