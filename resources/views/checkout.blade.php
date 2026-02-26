@extends('layouts.main')

@push('title')
<title>Checkout</title>
@endpush

@php
    $user = auth()->user();
    $billing = $user 
        ? \App\Models\Billing::where('user_id', $user->id)->first() : null;
@endphp
@section('content')
<div class="container-fluid bg-light p-5">
    <h1 class="text-center text-secondary"><i class="fa-solid fa-cart-shopping"></i> Checkout</h1>
</div>
<!-- Billing Information -->
<section>
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-1 mb-5">
                <a href="{{url('cart-list/product')}}" class="btn theme-orange-btn text-white"><i class="fa-solid fa-arrow-left"></i>&nbsp; Back</a>
            </div>
            <h2>Billing Details</h2>
            <div class="col-lg-12">
                <form id="billingForm">
                    <div class="row my-3">
                        <div class="col-lg-12 mb-3">
                            <input id="phone" name="phone" type="tel" class="form-control" maxlength="10" placeholder="Enter Your Phone No." value="{{ $user?->phone }}" 
                                @if(auth()->check())
                                    readonly
                                @endif>
                        </div>

                        <div class="col-lg-12 mb-3">
                        @php
                            $selectedCountry = $billing->country ?? '';
                        @endphp
                        <select class="form-select form-control" name="country" aria-label="Default select example" @if(auth()->check()) disabled @endif>
                            <option value="1" {{ $selectedCountry == 1 ? 'selected' : '' }}>India</option>
                            <option value="2" {{ $selectedCountry == 2 ? 'selected' : '' }}>Nepal</option>
                            <option value="3" {{ $selectedCountry == 3 ? 'selected' : '' }}>Australia</option>
                            <option value="4" {{ $selectedCountry == 4 ? 'selected' : '' }}>UK</option>
                            <option value="5" {{ $selectedCountry == 5 ? 'selected' : '' }}>USA</option>
                        </select>
                        </div>

                        <div class="col-lg-6 mb-3">
                        <input type="text" name="fullname" class="form-control " placeholder="Full Name" value="{{ $billing?->fullname }}" @if(auth()->check()) readonly @endif>
                        </div>

                        <div class="col-lg-6 mb-3">
                        <input type="email" name="email" class="form-control "  placeholder="Your Email" value="{{ $billing?->email ?? auth()->user()?->email }}" @if(auth()->check()) readonly @endif>
                        </div>

                        <div class="col-lg-6 mb-3">
                        <input type="text" name="pincode" class="form-control " placeholder="Pin Code" value="{{ $billing?->pincode }}" @if(auth()->check()) readonly @endif>
                        </div>

                        <div class="col-lg-6 mb-3">
                        <input type="text" name="landmark" class="form-control " placeholder="Landmark" value="{{ $billing?->landmark }}" @if(auth()->check()) readonly @endif>
                        </div>

                        <div class="col-lg-6 mb-3">
                            @php
                                $selectedCity = $billing->city ?? '';
                            @endphp

                            <select class="form-select form-control" name="city" @if(auth()->check()) disabled @endif>
                                <option value="">Select your City</option>
                                <option value="1" {{ $selectedCity == 1 ? 'selected' : '' }}>Ludhiana</option>
                                <option value="2" {{ $selectedCity == 2 ? 'selected' : '' }}>Moga</option>
                                <option value="3" {{ $selectedCity == 3 ? 'selected' : '' }}>Jalandhar</option>
                                <option value="4" {{ $selectedCity == 4 ? 'selected' : '' }}>Phagwara</option>
                                <option value="5" {{ $selectedCity == 5 ? 'selected' : '' }}>Malerkotla</option>
                            </select>
                        </div>

                        <div class="col-lg-6 mb-3">
                            @php
                                $selectedState = $billing->state ?? '';
                            @endphp
                            <select class="form-select form-control" name="state" @if(auth()->check()) disabled @endif>
                                <option value="">Select your State</option>
                                <option value="1" {{ $selectedState == 1 ? 'selected' : '' }}>Punjab</option>
                                <option value="2" {{ $selectedState == 2 ? 'selected' : '' }}>Gujarat</option>
                                <option value="3" {{ $selectedState == 3 ? 'selected' : '' }}>Goa</option>
                                <option value="4" {{ $selectedState == 4 ? 'selected' : '' }}>UP</option>
                                <option value="5" {{ $selectedState == 5 ? 'selected' : '' }}>Bihar</option>
                            </select>
                        </div>

                        <div class="col-lg-12 mb-3">
                        <textarea class="form-control " name="address" placeholder="Your Address" rows="4" @if(auth()->check()) readonly @endif>{{ $billing?->address }}</textarea>
                        </div>
                        @if(!auth()->check())                        
                        <div class="col-lg-12 mb-3 text-end">
                            <button type="submit" class="btn theme-green-btn text-white btn-lg">Submit</button>
                        </div>  
                        @endif
                </form>
            </div>
            <div class="modal fade" id="otpModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                    <form id="otpForm">
                    <div class="modal-header">
                        <h5 class="modal-title">Enter OTP</h5>
                    </div>

                    <div class="modal-body">
                        <input type="text" name="otp" id="otp" maxlength="4" class="form-control" placeholder="Enter 4-digit OTP">
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn theme-green-btn text-white">Verify OTP</button>
                    </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Payment -->
@if(auth()->check())                        
<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked>
                    <label class="form-check-label" for="flexRadioDefault1">
                        <h5>UPI</h5>
                    </label>
                    </div>
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" >
                    <label class="form-check-label" for="flexRadioDefault2">
                    <h5>Credit/Debit Card</h5>
                    </label>
                    </div>

                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" >
                    <label class="form-check-label" for="flexRadioDefault2">
                    <h5>Cash on Delivery</h5>
                    </label>
                    </div>

                    <div>
                        <a id="placeOrderBtn" class="btn theme-orange-btn text-light rounded-pill my-4 px-3 py-2">Place Order <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
            </div>
        </div>
        
    </div>
</section>
@endif
<script>
    document.getElementById('billingForm').addEventListener('submit', function(e){

        e.preventDefault();

        let formData = new FormData(this);
        let plainForm = Object.fromEntries(formData.entries());

        fetch('{{ route("submit.phone.billing") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(plainForm)
        })
        .then(response => response.json())
        .then(data => {

            if(data.otp_sent){
                $('#otpModal').modal('show');
            } 
            else if(data.error === 'phone_exists'){
                alert('Phone number already registered.');
            }

        });

    });

    document.getElementById('otpForm').addEventListener('submit', function(e){
        e.preventDefault();

        const phone = document.getElementById('phone').value;
        const otp = document.getElementById('otp').value;

         fetch('{{ route("verify.otp") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ 
                phone: phone,
                otp: otp 
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.verified){
                alert("User Created & Billing Saved!");
                location.reload()
            }else{
                alert('Invalid OTP');
            }
        });
    });


    document.getElementById('placeOrderBtn').addEventListener('click', function(e){

    e.preventDefault(); // page reload rokne ke liye

    const cart = JSON.parse(localStorage.getItem('cart')) || [];

    if(cart.length === 0){
        alert('Your cart is empty');
        return;
    }

    const paymentMode = document.querySelector('input[name="flexRadioDefault"]:checked')?.nextElementSibling?.innerText.trim();

    fetch('{{ route("place.order") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ 
            cart: cart,
            payment_mode: paymentMode 
        })
    })
    .then(response => response.json())
    .then(data => {
        if(data.success){
            alert("Order placed successfully!");
            localStorage.removeItem('cart');
            window.location.href = '{{ url("/") }}'; 
        }else{
            alert('Failed to place order');
        }
    });

});
</script>

@endsection