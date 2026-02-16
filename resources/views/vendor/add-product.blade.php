@extends('vendor.includes.main')
@push('title')
<title>Add Product</title>
@endpush

@section('content')
        
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <div class="card p-4 mt-4">
                    <form action="{{ url('vendor/add-product') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            @session('success')
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endsession
                            <div class="col-xl-8 col-md-8">
                                    <h4>Add Product</h4>

                                    <div class="row mt-3">
                                     
                                            <div class="col-lg-12 mb-3">
                                                <label class="form-label">Product Name</label>
                                                <input type="text" class="form-control" placeholder="Watch" name="p_name">
                                                @error('p_name')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="col-lg-12 mb-3">
                                                <label class="form-label">Price</label>
                                                <input type="text" class="form-control" placeholder="₹ 1499.00" name="p_price">
                                                @error('p_price')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="col-lg-12 mb-3">
                                                <label class="form-label">Category</label>
                                                    <select class="form-select" name="c_id">
                                                        @forelse($category as $cat)
                                                            <option value="{{ $cat->c_id }}">{{ $cat->c_name }}</option>
                                                        @empty
                                                            <option>No Category Found</option>
                                                        @endforelse
                                                    </select>
                                                @error('c_id')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="col-lg-12 mb-3">
                                                <label class="form-label">Stock Quantity</label>
                                                <input type="text" class="form-control" placeholder="25 pcs" name="p_stock">
                                                @error('p_stock')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="col-lg-12 mb-3">
                                                <label class="form-label">Product Description</label>
                                                <textarea class="form-control" placeholder="Fill product description here" id="floatingTextarea" name="p_description"></textarea>
                                                @error('p_description')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-lg-3">
                                                <button class="btn btn-primary" type="submit">Add Product</button>
                                            </div>
                                    </div>   
                            </div>

                            <div class="col-xl-4 col-md-4 mt-5">
                                <div class="text-center">
                                    <img src="{{asset('dashboard/assets/img/products/2.jpg')}}" style="width:155px;" class="rounded-circle">
                                    <div class="mt-3">
                                        <label for="image" class="form-label btn btn-dark">Choose Image</label>
                                        <input type="file" name="p_image" class="form-control d-none" id="image">
                                    </div>
                                    @error('p_image')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div> 
                    </form>
                </div>
        </main>
@endsection
                