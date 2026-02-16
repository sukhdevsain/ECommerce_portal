@extends('vendor.includes.main')
@push('title')
<title>Edit Product</title>
@endpush

@section('content')
        
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <div class="card p-4 mt-4">
                        <form action="{{ url('vendor/edit-product/' . $product->p_id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                
                                <div class="col-xl-8 col-md-8">
                                        <h4>Edit Product</h4>

                                        
                                        <div class="row mt-3">
                                            <div class="col-lg-12 mb-3">
                                                <label class="form-label">Product Name</label>
                                                <input type="text" name="p_name" class="form-control" value="{{ $product->p_name }}">
                                            </div>

                                            <div class="col-lg-12 mb-3">
                                                <label class="form-label">Price</label>
                                                <input type="text" name="p_price" class="form-control" value="{{ $product->p_price }}">
                                            </div>

                                            <div class="col-lg-12 mb-3">
                                                <label class="form-label">Category</label>
                                                    <select class="form-select" name="c_id" aria-label="Default select example">
                                                        <option >Select Category</option>   
                                                        @foreach($category as $cat)
                                                            <option value="{{ $cat->c_id }}" {{ $cat->c_id == $product->c_id ? 'selected' : '' }}>{{ $cat->c_name }}</option>
                                                        @endforeach                                                  
                                                    </select>
                                            </div>

                                            <div class="col-lg-12 mb-3">
                                                <label class="form-label">Stock Quantity</label>
                                                <input type="text" name="p_stock" class="form-control" value="{{ $product->p_stock }}">
                                            </div>

                                            <div class="col-lg-12 mb-3">
                                                <label class="form-label">Product Description</label>
                                                <textarea class="form-control" name="p_description" placeholder="Fill product description here" id="floatingTextarea">{{ $product->p_description }}</textarea>
                                            </div>
                                            <div class="col-lg-3">
                                                <button class="btn btn-primary" type="submit">Edit Product</button>
                                            </div>
                                        </div>
                                        
                                </div>

                                <div class="col-xl-4 col-md-4 mt-5">
                                    <div class="text-center">
                                        <img src="{{asset('storage/'.$product->p_image)}}" style="width:155px;" class="rounded-circle">
                                        <div class="mt-3">
                                            <label for="image" class="form-label btn btn-dark">Choose Image</label>
                                            <input type="file" name="p_image" class="form-control d-none" id="image">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>        
                </div>
            </main>


                

@endsection
                