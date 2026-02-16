@extends('vendor.layouts.main')
@push('title')
<title>Vendor Register</title>
@endpush

@section('content')
<section>
    <div class="container position-absolute top-50 start-50 translate-middle">
        <div class="row">
            <div class="col-lg-10">
                <div class="row">
                    <div class="col-lg-6">
                        <div>
                        <img src="{{asset('dashboard/assets/img/vendor.jpg')}}" class="rounded-3 img-fluid">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        @session('success')
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endsession
                        <div>
                            <form method="POST" action="{{ url('vendor/signup') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12 mb-3">
                                    <label  class="form-label">Full Name</label>
                                        <input value="{{ old('fullname') }}" type="text" class="form-control" placeholder="John Doe" name="fullname">
                                        @error('fullname')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6 mb-3">
                                    <label  class="form-label">Phone Number</label>
                                        <input value="{{ old('phone') }}" type="tel" class="form-control" name="phone" placeholder="+91 ">
                                        @error('phone')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6 mb-3">
                                    <label  class="form-label">Email</label>
                                        <input value="{{ old('email') }}" type="email" class="form-control" name="email" placeholder="john@gmail.com">
                                        @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-lg-12 mb-3">
                                    <label  class="form-label">Password</label>
                                        <input value="{{ old('password') }}" type="password" class="form-control" name="password" placeholder="******">
                                        @error('password')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-lg-12 mb-3">
                                    <label  class="form-label">Address</label>
                                        <textarea class="form-control" placeholder="Enter your address" id="floatingTextarea2" style="height: 100px" name="address">{{ old('address') }}</textarea>
                                        @error('address')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                               
                                <button type="submit" class="btn btn-primary text-light form-control form-control-lg">Signup</button>
                                <div class="text-center p-2">Have an account? <a href="{{url('vendor/login')}}" class="text-decoration-none">Login</a></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection