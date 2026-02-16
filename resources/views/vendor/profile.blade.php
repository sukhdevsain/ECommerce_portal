@extends('vendor.includes.main')
@push('title')
<title>Profile</title>
@endpush

@section('content')
        
            <div id="layoutSidenav_content">
                <main>
                    <form action="{{ url('vendor/profile') }}" method="POST" enctype="multipart/form-data"> 
                        @csrf 
                        @method('PUT')
                        <div class="container-fluid px-4">
                            <div class="container p-4">
                                @session('success')
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endsession
                                    <div class="card p-4">
                                        <div class="row">
                                        
                                            <div class="col-xl-8 col-md-8">
                                                    <h4>Basic Information</h4>

                                                    
                                                        <div class="row mt-3">

                                                        <div class="col-lg-12 mb-3">
                                                            <label class="form-label">Identification Number</label>
                                                            <input type="text" name="id_number" class="form-control" placeholder="PAN/Aadhar no." value="{{$vendor->id_number}}">
                                                            @error('id_number')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>

                                                        <div class="col-lg-6 mb-3">
                                                            <label class="form-label">Business Name</label>
                                                            <input type="text" name="business_name" class="form-control" placeholder="ABC PVT. LTD." value="{{$vendor->business_name}}">
                                                            @error('business_name')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>

                                                        <div class="col-lg-6 mb-3">
                                                            <label class="form-label">Username</label>
                                                            <input type="text" name="fullname" class="form-control" value="{{$vendor->fullname}}" placeholder="John Doe"> 
                                                            @error('fullname')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>

                                                        <div class="col-lg-6 mb-3">
                                                            <label class="form-label">Email</label>
                                                            <input type="email" name="email" class="form-control" placeholder="john@gmail.com" value="{{$vendor->email}}">
                                                            @error('email')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>

                                                        <div class="col-lg-6 mb-3">
                                                            <label class="form-label">Phone Number</label>
                                                            <input type="tel" name="phone" class="form-control" placeholder="+91 " value="{{$vendor->phone}}">
                                                            @error('phone')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>

                                                        <div class="col-lg-12 mb-3">
                                                            <label class="form-label">Address</label>
                                                            <textarea name="address" class="form-control">{{$vendor->address}}</textarea>
                                                            @error('address')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                        
                                                        </div>
                                                    
                                            </div>

                                            <div class="col-xl-4 col-md-4 mt-5">
                                                <div class="text-center">
                                                    <img src="{{asset('vendors/'.$vendor->image)}}" style="width:155px;">
                                                    <div class="mt-3">
                                                        <label for="image" class="form-label btn btn-dark">Choose Image</label>
                                                        <input type="file" name="image" class="form-control d-none" id="image" value="{{$vendor->image}}">
                                                        @error('image')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        
                                    </div>

                                    <div class="card p-4 mt-4">
                                        <div class="row">
                                        
                                        <div class="col-xl-12 col-md-12">
                                                <h4>Business Information</h4>

                                                
                                                    <div class="row mt-3">
                                                        <div class="col-lg-12 mb-3">
                                                            <label class="form-label">Business Type</label>
                                                                <select class="form-select" name="business_type" aria-label="Default select example" value="{{$vendor->business_type}}">
                                                                    <option @if($vendor->business_type == 'Sole Proprietor') selected @endif value="Sole Proprietor">Sole Proprietor</option>
                                                                    <option @if($vendor->business_type == 'Partnership') selected @endif value="Partnership">Partnership</option>
                                                                    <option @if($vendor->business_type == 'Corporation') selected @endif value="Corporation">Corporation</option>
                                                                </select>
                                                                @error('business_type')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                        
                                                        <div class="col-lg-6 mb-3">
                                                            <label class="form-label">GST No.</label>
                                                            <input type="text" name="gst_number" class="form-control" placeholder="ABC123ZXA456Cl" value="{{$vendor->gst_number}}">
                                                            @error('gst_number')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>

                                                        <div class="col-lg-6 mb-3">
                                                            <label class="form-label">Business Category</label>
                                                            <input type="text" name="business_category" class="form-control" placeholder="Deal in Clothes" value="{{$vendor->business_category}}">
                                                            @error('business_category')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>

                                                        
                                                    </div>
                                                
                                        </div>

                                        
                                        </div>

                                        
                                    </div>

                                    <div class="card p-4 mt-4">
                                        <div class="row">
                                        
                                        <div class="col-xl-12 col-md-12">
                                                <h4>Payment Information</h4>

                                                
                                                    <div class="row mt-3">
                                                        <div class="col-lg-6 mb-3">
                                                            <label class="form-label">Bank Account Number</label>
                                                            <input type="text" name="bank_account_no" class="form-control" placeholder="0785623021454" value="{{$vendor->bank_account_no}}">
                                                            @error('bank_account_no')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>

                                                        <div class="col-lg-6 mb-3">
                                                            <label class="form-label">Prefer Payment Method</label>
                                                                <select class="form-select" name="payment_method" aria-label="Default select example" value="{{$vendor->payment_method}}">
                                                                    <option @if($vendor->payment_method == 'PayPal') selected @endif value="PayPal">PayPal</option>
                                                                    <option @if($vendor->payment_method == 'Bank Transfer') selected @endif value="Bank Transfer">Bank Transfer</option>
                                                                    <option @if($vendor->payment_method == 'E Wallet') selected @endif value="E Wallet">E Wallet</option>
                                                                </select>
                                                                @error('payment_method')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>

                                                        <div class="col-lg-3">
                                                            <button class="btn btn-primary" type="submit">Save Changes</button>
                                                        </div>
                                                        
                                                    </div>
                                                
                                        </div>

                                        
                                        </div>

                                        
                                    </div>
                                
                            </div>
                   </form>
                </main>
            
                

@endsection
                