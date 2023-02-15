@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4 border-bottom">
            <h1 class="h3 mb-0 text-gray-800">Profile</h1>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        {{-- Page Content --}}
        <div class="row">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <img class="rounded-circle mt-5" width="150px" src="{{ asset('admin/img/undraw_profile.svg') }}">
                    <span class="font-weight-bold">{{ @$user->company_name }}</span>
                    {{-- <span class="text-black-50"><i>CompanyUser</i></span> --}}
                    <span class="text-black-50">{{ @$user->email }}</span>
                </div>
            </div>
            <div class="col-md-9 border-right">
                {{-- Profile --}}
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Profile</h4>
                    </div>
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label class="labels">Company Name</label>
                                <input type="text" class="form-control @error('company_name') is-invalid @enderror"
                                    name="company_name" placeholder="Company Name"
                                    value="{{ old('company_name') ? old('company_name') : @$user->company_name }}">

                                @error('first_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="labels">Company Website</label>
                                <input type="text" name="company_website"
                                    class="form-control @error('company_website') is-invalid @enderror"
                                    value="{{ old('company_website') ? old('company_website') : @$user->company_website }}"
                                    placeholder="Company Website">

                                @error('company_website')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="labels">Company Licence Number</label>
                                <input type="text" class="form-control @error('company_licence_number') is-invalid @enderror" name="company_licence_number"
                                    value="{{ old('company_licence_number') ? old('company_licence_number') : @$user->company_licence_number }}"
                                    placeholder="Company Licence Number">
                                @error('company_licence_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="labels">Company Address</label>
                                <input type="text" name="company_address"
                                    class="form-control @error('company_address') is-invalid @enderror"
                                    value="{{ old('company_address') ? old('company_address') : @$user->company_address }}"
                                    placeholder="Company Address">

                                @error('company_address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="labels">Country</label>
                                <input type="text" name="country"
                                    class="form-control @error('country') is-invalid @enderror"
                                    value="{{ old('country') ? old('country') : @$user->country }}"
                                    placeholder="Country">

                                @error('country')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="labels">State</label>
                                <input type="text" name="state"
                                    class="form-control @error('state') is-invalid @enderror"
                                    value="{{ old('state') ? old('state') : @$user->state }}"
                                    placeholder="State">

                                @error('last_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="labels">City</label>
                                <input type="text" name="city"
                                    class="form-control @error('city') is-invalid @enderror"
                                    value="{{ old('city') ? old('city') : @$user->city }}"
                                    placeholder="City">

                                @error('city')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            <button class="btn btn-primary profile-button" type="submit">Update Profile</button>
                        </div>
                    </form>
                </div>

                <hr>
            </div>

        </div>



    </div>
@endsection
