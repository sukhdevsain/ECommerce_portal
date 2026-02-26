@php
  use App\Models\Category;
  $category = Category::where('p_c_id', 0)->get();
  $user = auth()->user();
@endphp
<!DOCTYPE html>
<html lang="en">
  <head>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @stack('title')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
  </head>
  <body>

  <!-- Main Navbar -->
  <nav class="navbar navbar-expand-lg theme-navbar">
    <div class="container">
      <a class="navbar-brand" href="{{url('/')}}">
        <img src="{{asset('assets/images/logo/logo.png')}}" style="width:250px;">
      </a>

      <div>
        <form class="d-flex" role="search">
          <div class="input-group">
            <input class="form-control form-control-sm" style="width:350px;" type="search" placeholder="Search for Products" aria-label="Search">
            <button class="btn btn-light text-secondary btn-sm" type="submit">
              <i class="fa-solid fa-magnifying-glass"></i>
            </button>
          </div>
        </form>
      </div>

      <div class="position-relative d-flex align-items-center gap-2">
        <a href="{{url('vendor/signup')}}" target="_blank" class="text-decoration-none text-light">Become a Seller</a>
          @if(Auth::check())
            <a href="{{ url('user/') }}" class="btn theme-orange-btn btn-sm text-light rounded-pill px-3 py-2"><i class="fa-solid fa-user"></i> Dashboard</a>
            @else
            <a href="{{ url('login') }}" class="btn theme-orange-btn btn-sm text-light rounded-pill px-3 py-2"><i class="fa-solid fa-user"></i> Login </a>
          @endif
        <a href="{{url('cart-list/product')}}" class="position-relative">
          <i class="fa-solid fa-2x fa-cart-shopping text-white"></i>
          <span id="cart-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">0</span>
        </a>
      </div>
    </div>
  </nav>

  <!-- Category Nav -->
  <nav class="navbar navbar-expand-lg shadow p-3 bg-body-tertiary rounded">
    <div class="container">
      <div class="collapse navbar-collapse show justify-content-center" id="navbarNav">
        <ul class="nav">
          @foreach($category as $cat)
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-dark" href="#" role="button"
               data-bs-toggle="dropdown" aria-expanded="false">
              {{ $cat->c_name }}
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="{{route('category', $cat->c_name)}}">All</a></li>
              @if ($cat->subCategory->count() > 0)
                @foreach ($cat->subCategory as $subcat)
                <li>
                  <a class="dropdown-item" href="{{route('category.subcategory', ['category' => $cat->c_name, 'sub_category' => $subcat->c_name])}}">
                    {{ $subcat->c_name }}
                  </a>
                </li>
                @endforeach
              @endif
            </ul>
          </li>
          @endforeach
        </ul>
      </div>
    </div>
  </nav>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabqBhhFhDMWcGtFwZIBf" crossorigin="anonymous"></script>
  <script>
    function update_cart_count() {
      var cart = JSON.parse(localStorage.getItem("cart")) || [];
      let totalQty = cart.reduce((sum, item) => sum + item.quantity, 0);
      $("#cart-count").text(totalQty);
    }

    $(document).ready(function () {
      update_cart_count();
    });
  </script>