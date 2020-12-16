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
                      <input type="text" value="{{ Auth::user()->name }}" readonly="readonly" class="form-control" id="exampleInputName1" name="name" placeholder="Name">
                    </div>
                    <div class="form-group">
                    <label for="exampleFormControlSelect3">Type</label>
                    <input type="text" value="Aadhar Card Details" readonly="readonly" class="form-control" id="exampleInputName1" name="type" placeholder="Name">
                  
                  </div>
                  
                    <div class="form-group">
                      <label for="exampleInputPassword4">Aadhar Number</label>
                      <input type="text" class="form-control @error('aadhar_identification_number') is-invalid @enderror" value="{{ old('aadhar_identification_number') }}" autocomplete="aadhar_identification_number" autofocus id="aadhar_identification_number" name="aadhar_identification_number" min="12" max="12" required placeholder="Aadhar Number">
                      @error('aadhar_identification_number')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>                  
            
                    <div class="form-group">
                      <label>File upload</label>
                      <div class="input-group col-xs-12">
                        <input type="file" id="path" name='path[]' class="form-control file-upload-info @error('path') is-invalid @enderror"  value="{{ old('path') }}" autocomplete="path" autofocus required>
                      </div>
                      <p><font color="red"><strong>Supported file formats:</strong> .jpg,.jpeg,.pdf,.png</font></p>
                       @error('path')
                        <div class="alert alert-danger" role="alert">
                          {{ $message }}
                        </div>
                      @enderror
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