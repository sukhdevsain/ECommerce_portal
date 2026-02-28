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
                <a href="{{url('cart-list/product')}}" class="btn theme-orange-btn text-white">
                    <i class="fa-solid fa-arrow-left"></i>&nbsp; Back
                </a>
            </div>
            <h2>Billing Details</h2>
            <div class="col-lg-12">
                <form id="billingForm">
                    <div class="row my-3">

                        <div class="col-lg-12 mb-3">
                            <input id="phone" name="phone" type="tel" class="form-control" maxlength="10"
                                placeholder="Enter Your Phone No."
                                value="{{ $user?->phone }}"
                                @if(auth()->check()) readonly @endif>
                        </div>

                        <div class="col-lg-12 mb-3">
                            @php $selectedCountry = $billing->country ?? ''; @endphp
                            <select class="form-select form-control" name="country" @if(auth()->check()) disabled @endif>
                                <option value="1" {{ $selectedCountry == 1 ? 'selected' : '' }}>India</option>
                                <option value="2" {{ $selectedCountry == 2 ? 'selected' : '' }}>Nepal</option>
                                <option value="3" {{ $selectedCountry == 3 ? 'selected' : '' }}>Australia</option>
                                <option value="4" {{ $selectedCountry == 4 ? 'selected' : '' }}>UK</option>
                                <option value="5" {{ $selectedCountry == 5 ? 'selected' : '' }}>USA</option>
                            </select>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <input type="text" name="fullname" class="form-control" placeholder="Full Name"
                                value="{{ $billing?->fullname }}" @if(auth()->check()) readonly @endif>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Your Email"
                                value="{{ $billing?->email ?? auth()->user()?->email }}" @if(auth()->check()) readonly @endif>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <input type="text" name="pincode" class="form-control" placeholder="Pin Code"
                                value="{{ $billing?->pincode }}" @if(auth()->check()) readonly @endif>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <input type="text" name="landmark" class="form-control" placeholder="Landmark"
                                value="{{ $billing?->landmark }}" @if(auth()->check()) readonly @endif>
                        </div>

                        <div class="col-lg-6 mb-3">
                            @php $selectedCity = $billing->city ?? ''; @endphp
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
                            @php $selectedState = $billing->state ?? ''; @endphp
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
                            <textarea class="form-control" name="address" placeholder="Your Address" rows="4"
                                @if(auth()->check()) readonly @endif>{{ $billing?->address }}</textarea>
                        </div>

                        @if(!auth()->check())
                        <div class="col-lg-12 mb-3 text-end">
                            <button type="submit" class="btn theme-green-btn text-white btn-lg">Submit</button>
                        </div>
                        @endif

                    </div>
                </form>
            </div>

            <!-- OTP Modal -->
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

<!-- Payment Section (only for logged in users) -->
@if(auth()->check())
<section>
    <div class="container mb-5">
        <div class="row">
            <div class="col-lg-5">
                <h5 class="mb-3">Select Payment Method</h5>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="UPI" checked>
                    <label class="form-check-label" for="flexRadioDefault1"><h5>UPI</h5></label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="Credit/Debit Card">
                    <label class="form-check-label" for="flexRadioDefault2"><h5>Credit/Debit Card</h5></label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3" value="Cash on Delivery">
                    <label class="form-check-label" for="flexRadioDefault3"><h5>Cash on Delivery</h5></label>
                </div>

                <div>
                    <a id="placeOrderBtn" class="btn theme-orange-btn text-light rounded-pill my-4 px-3 py-2" style="cursor:pointer;">
                        Place Order <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endif


<script src="https://js.stripe.com/v3/"></script>

<script>
const placeOrderBtn = document.getElementById('placeOrderBtn');

if (placeOrderBtn) {

    const stripe = Stripe("{{ config('services.stripe.key') }}");

    placeOrderBtn.addEventListener('click', async function (e) {
        e.preventDefault();

        const cart = JSON.parse(localStorage.getItem('cart')) || [];

        if (cart.length === 0) {
            alert('Your cart is empty');
            return;
        }

        const paymentMode = document.querySelector('input[name="flexRadioDefault"]:checked')?.value;

        // ───────────── COD ─────────────
        if (paymentMode === 'Cash on Delivery') {
            await placeOrder(cart, paymentMode);
            return;
        }

        // ───────────── STRIPE (UPI / CARD) ─────────────
        let totalAmount = 0;
        cart.forEach(item => {
            totalAmount += item.product_price * item.quantity;
        });

        try {

            // 1️⃣ Create Payment Intent
            const intentRes = await fetch("{{ route('stripe.intent') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    amount: totalAmount,
                    cart: cart
                })
            });

            const intentData = await intentRes.json();

            if (!intentData.clientSecret) {
                alert('Payment initiation failed');
                return;
            }

            // 2️⃣ Confirm Payment WITHOUT redirect
            const { error, paymentIntent } =
            await stripe.confirmCardPayment(
            intentData.clientSecret,
        {
            payment_method: {
                card: { token: 'tok_visa' }
            }
        }
    );

if (error) {
    alert(error.message);
    return;
}

console.log("Stripe Result:", paymentIntent);

if (paymentIntent.status === "succeeded") {
    await placeOrder(cart, paymentMode, paymentIntent.id);
}

            if (paymentIntent.status === "succeeded") {

                // 3️⃣ Place Order after payment success
                await placeOrder(cart, paymentMode);

            }

        } catch (err) {
            alert('Payment error: ' + err.message);
        }

    });
}


// ───────────── PLACE ORDER FUNCTION ─────────────
async function placeOrder(cart, paymentMode, paymentIntentId = null) {

    const res = await fetch('{{ route("place.order") }}', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            cart: cart,
            payment_mode: paymentMode,
            payment_intent_id: paymentIntentId
        })
    });

    const data = await res.json();

    if (data.success) {
        localStorage.removeItem('cart');
        alert('Order placed successfully!');
        window.location.href = '{{ url("/") }}';
    } else {
        alert(data.message);
    }
}
</script>

@endsection