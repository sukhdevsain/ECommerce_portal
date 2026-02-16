@extends('layouts.main')

@push('title')
<title>Sub-Category</title>
@endpush

@section('content')

<div class="container-fluid bg-light p-5">
    <h1 class="text-center text-secondary">
        <i class="fa-solid fa-list"></i> 
        {{ $category }} / {{ $sub_category }}
    </h1>
</div>

<section class="my-5">
    <div class="container">
        <div class="row theme-product">
            @if($subcat && $subcat->products->count() > 0)
                @foreach($subcat->products as $product)
                    <div class="col-lg-3 mb-4">
                        <div class="card">
                            <a href="#">
                                <img src="{{ asset('storage/'.$product->p_image) }}" class="card-img-top">
                            </a>
                            <div class="card-body">
                                <h6 class="text-center">
                                    {{ $product->p_name }}
                                </h6>
                                <h5 class="text-center">
                                    ₹ {{ $product->p_price }}.00
                                </h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    <h3 class="text-center text-secondary">
                        Data not found!
                    </h3>
                </div>
            @endif

        </div>
    </div>
</section>

@endsection
