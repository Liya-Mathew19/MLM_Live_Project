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
               
                  <h4 class="card-title">Update KYC Document</h4><br>
                
                  <form class="forms-sample" action="{{route('updatekycimage',$kycs->id)}}" method="POST" enctype="multipart/form-data">
                  @csrf
                      <input type="hidden" value="{{ $kycs->id }}" class="form-control" id="exampleInputName1" name="id">
                    
                      <div class="form-group">
                                                <label>File upload</label>
                                                <div class="input-group col-xs-12">
                                                    <input type="file" class="form-control file-upload-info" name='path' class="form-control file-upload-info @error('path') is-invalid @enderror"  value="{{ old('path') }}" autocomplete="path" autofocus required>
                                                        <span class="input-group-append">
                                                        </span>
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