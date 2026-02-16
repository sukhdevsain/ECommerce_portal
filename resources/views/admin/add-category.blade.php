@extends('admin.includes.main')
@push('title')
<title>Add Category</title>
@endpush

@section('content')
        
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                    <div class="card p-4 mt-4">
                            <div class="row">
                            
                            <div class="col-xl-8 col-md-8">
                                @session('success')
                                <div class="alert alert-success">{{ session('success') }}</div>
                                @endsession
                                    <h4>Add Category</h4>

                                    
                                        <div class="row mt-3">
                                        <form action="{{ url('admin/add-category') }}" method="POST">
                                            @csrf
                                        <div class="col-lg-12 mb-3">
                                            <label class="form-label">Parent Category</label>
                                            <select class="form-select" name="p_c_id">
                                                <option value="0">Select Parent Category</option>
                                                @foreach ($category as $cat)
                                                <option value="{{ $cat->c_id }}">{{ $cat->c_name }}</option>
                                                @endforeach 
                                            </select>
                                            @error('c_parent')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                         <div class="col-lg-12 mb-3">
                                            <label class="form-label">Category Name</label>
                                            <input type="text" class="form-control" placeholder="Electronics" name="c_name">
                                            @error('c_name')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-lg-12 mb-3">
                                            <label class="form-label">Commission (%)</label>
                                            <input type="text" class="form-control" placeholder="20" name="c_commission">
                                            @error('c_commission')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        
                                        <div class="col-lg-3">
                                            <button class="btn btn-primary" type="submit">Add Category</button>
                                        </div>
                                        </form>
                                        </div>
                                    
                            </div>

                            
                            </div>

                            
                        </div>
                </main>


                

@endsection
                