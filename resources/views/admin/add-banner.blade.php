@extends('admin.includes.main')
@push('title')
<title>Add Banner</title>
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
                                    <h4>Add Website Banner</h4>

                                    
                                        <div class="row mt-3">
                                        <form action="{{ url('admin/add-banner') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                        <div class="col-lg-12 mb-3">
                                            <label class="form-label">Banner Image <div class="form-text">* Required Size (1900 X 650) Pixels</div></label>
                                            <input type="file" class="form-control" name="banner">
                                            @error('banner')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-lg-12 mb-3">
                                            <label class="form-label">Banner Alt Text</label>
                                            <input type="text" class="form-control" placeholder="Enter Banner Alt Text" name="alt">
                                            @error('alt')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        
                                        <div class="col-lg-3">
                                            <button class="btn btn-primary" type="submit">Add Banner</button>
                                        </div>
                                        </form>
                                        </div>
                                    
                            </div>

                            
                            </div>

                            
                        </div>
                </main>


                

@endsection
                