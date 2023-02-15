@extends('layouts.app')

@section('title', 'Add Users')

@section('content')

<div class="container">

    {{-- Alert Messages --}}
    @include('common.alert')
   
    <!-- DataTales Example -->
    <div class="row">
        <div class="col-sm-12">
           <div class="card shadow mb-4">
              <div class="card-header py-3">
                 <h6 class="m-0 font-weight-bold text-primary">Company Register</h6>
              </div>
              <form method="POST" action="{{route('companies.store')}}">
                 @csrf
                 <div class="card-body">
                    <div class="form-group row">
                       <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                          <span style="color:red;">*</span>Company Name</label>
                          <input 
                             type="text" 
                             class="form-control form-control-user @error('company_name') is-invalid @enderror" 
                             id="companyname"
                             placeholder="Company Name" 
                             name="company_name" 
                             value="{{ old('company_name') }}">
                          @error('company_name')
                          <span class="text-danger">{{$message}}</span>
                          @enderror
                       </div>
                       {{-- Email --}}
                       <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                          <span style="color:red;">*</span>Company Email</label>
                          <input 
                             type="email" 
                             class="form-control form-control-user @error('email') is-invalid @enderror" 
                             id="email"
                             placeholder="Company Email" 
                             name="email" 
                             value="{{ old('email') }}">
                          @error('email')
                          <span class="text-danger">{{$message}}</span>
                          @enderror
                       </div>
                       <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                          <span style="color:red;">*</span>Password</label>
                          <input 
                             type="text" 
                             class="form-control form-control-user @error('password') is-invalid @enderror" 
                             id="password"
                             placeholder="Password" 
                             name="password" 
                             value="{{ old('password') }}">
                          @error('password')
                          <span class="text-danger">{{$message}}</span>
                          @enderror
                       </div>
                       {{-- Mobile Number --}}
                       <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                          <span style="color:red;">*</span>Company Website</label>
                          <input 
                             type="text" 
                             class="form-control form-control-user @error('company_website') is-invalid @enderror" 
                             id="website"
                             placeholder="Company Website" 
                             name="company_website" 
                             value="{{ old('company_website') }}">
                          @error('company_website')
                          <span class="text-danger">{{$message}}</span>
                          @enderror
                       </div>
                       <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                          <span style="color:red;">*</span>Company License number</label>
                          <input 
                             type="text" 
                             class="form-control form-control-user @error('company_licence_number') is-invalid @enderror" 
                             id="license_number"
                             placeholder="Company License number" 
                             name="company_licence_number" 
                             value="{{ old('company_licence_number') }}">
                          @error('company_licence_number')
                          <span class="text-danger">{{$message}}</span>
                          @enderror
                       </div>
                       <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                         <label>Company Address</label>
                          <input 
                             type="text" 
                             class="form-control form-control-user @error('company_address') is-invalid @enderror" 
                             id="exampleMobile"
                             placeholder="Company Address" 
                             name="company_address" 
                             value="{{ old('company_address') }}">
                          @error('company_address')
                          <span class="text-danger">{{$message}}</span>
                          @enderror
                       </div>
                       <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                        Country
                          <input 
                             type="text" 
                             class="form-control form-control-user @error('country') is-invalid @enderror" 
                             id="exampleMobile"
                             placeholder="Country" 
                             name="country" 
                             value="{{ old('country') }}">
                          @error('country')
                          <span class="text-danger">{{$message}}</span>
                          @enderror
                       </div>
                       <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                          State
                          <input 
                             type="text" 
                             class="form-control form-control-user @error('state') is-invalid @enderror" 
                             id="state"
                             placeholder="State" 
                             name="state" 
                             value="{{ old('state') }}">
                          @error('state')
                          <span class="text-danger">{{$message}}</span>
                          @enderror
                       </div>
                       <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                          City
                          <input 
                             type="text" 
                             class="form-control form-control-user @error('city') is-invalid @enderror" 
                             id="city"
                             placeholder="City" 
                             name="city" 
                             value="{{ old('city') }}">
                          @error('city')
                          <span class="text-danger">{{$message}}</span>
                          @enderror
                       </div>
                       {{-- Status --}}
                       {{-- <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                          <span style="color:red;">*</span>Status</label>
                          <select class="form-control form-control-user @error('status') is-invalid @enderror" name="status">
                             <option selected disabled>Select Status</option>
                             <option value="1" selected>Active</option>
                             <option value="0">Inactive</option>
                          </select>
                          @error('status')
                          <span class="text-danger">{{$message}}</span>
                          @enderror
                       </div> --}}
                    </div>
                 </div>
                 <div class="card-footer">
                    <button type="submit" class="btn btn-success btn-user float-right mb-3">Save</button>
                    <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('companies.index') }}">Cancel</a>
                 </div>
              </form>
           </div>
        </div>
     </div>
     </div>


@endsection