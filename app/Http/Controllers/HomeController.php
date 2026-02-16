<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
   public function index(){
      $banners = Banner::all();
      $products = Product::limit(4)->get();
      $popular = Product::latest()->limit(4)->get();
      $recent = Product::latest()->limit(4)->get();
      $electronics = Product::where('c_id', 1)->limit(4)->get();
       return view('home', compact('banners', 'products', 'popular', 'recent', 'electronics'));
   }


}
