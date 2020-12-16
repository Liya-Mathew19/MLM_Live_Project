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
               
                  <h4 class="card-title">Edit KYC details</h4><br>
                  @if(isset($kycs->id))
                  <form class="forms-sample" action="{{route('updateuploadedkyc',$kycs->id)}}" method="POST" enctype="multipart/form-data">
                  @csrf
                      <input type="hidden" value="{{ $kycs->id }}" class="form-control" id="exampleInputName1" name="id">
                    
                      <div class="form-group">
                      <label for="exampleInputName1">Type</label>
                      <input type="text" value="{{ $kycs->type }}" readonly="readonly" class="form-control" id="exampleInputName1" name="type">
                    </div>
                  
                  @if($kycs->type=='Aadhar Card Details')

                    <div class="form-group">
                      <label for="exampleInputPassword4">Aadhar Number</label>
                      <input type="text" value="{{ $kycs->identification_number }}"  class="form-control @error('aadhar_identification_number') is-invalid @enderror" value="{{ old('aadhar_identification_number') }}" autocomplete="aadhar_identification_number" autofocus id="aadhar_identification_number" name="aadhar_identification_number" min="12" max="12" required placeholder="Aadhar Number">
                      @error('aadhar_identification_number')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>  
  
                    @elseif($kycs->type=='Pan Card Details')
                    <div class="form-group">
                      <label for="exampleInputPassword4">PAN Number</label>
                      <input type="text" id="exampleInputPassword4" value="{{ $kycs->identification_number }}" name=pan_identification_number  class="form-control @error('pan_identification_number') is-invalid @enderror" value="{{ old('identification_number') }}" autocomplete="identification_number" autofocus id="pan_identification_number" required placeholder="PAN Number">
                      @error('pan_identification_number')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>

                    @elseif($kycs->type=='Bank Details')
                    <div class="form-group">
                      <label for="exampleInputPassword4">Account Number</label>
                      <input type="text" id="exampleInputPassword4" value="{{ $kycs->identification_number }}" name=bank_identification_number  class="form-control @error('bank_identification_number') is-invalid @enderror" value="{{ old('bank_identification_number') }}" autocomplete="bank_identification_number" autofocus id="bank_identification_number" required  placeholder="Account Number">
                      @error('bank_identification_number')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>

                    @elseif($kycs->type=='Cancelled Cheque / Passbook FrontPage')
                    <div class="form-group">
                          <label for="exampleInputPassword4">Cheque Number</label>
                         <input type="text" value="{{ $kycs->identification_number }}" class="form-control @error('identification_number') is-invalid @enderror" id="identification_number" name=identification_number   value="{{ old('identification_number') }}" autocomplete="identification_number" autofocus id="identification_number"  placeholder="Cheque Number">
                         @error('identification_number')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                      </div> 
                      @endif
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <a href="{{route('customerprofile')}}"><button type="button" class="btn btn-danger mr-2">Cancel</button></a>
                  </form>
                  @else
                  <center><font color="red">{{'No data found !!!'}}</font>
                  @endif

                </div>
              </div>
            </div>
							</div>
						</div>
					</div>
          </div>
		
@endsection			