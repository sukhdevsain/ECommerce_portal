<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;   

class ProductdetailController extends Controller
{
    public function detail($category,$sub_category,$product_detail){

        $product_detail = Product::where('p_name',$product_detail)->first();

        // dd($product_detail);

        return view('product-detail',['product'=>$product_detail]);
    }
}