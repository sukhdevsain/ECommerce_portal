<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class CategoryController extends Controller
{
    public function detail($category, $sub_category = null){

        $category = Category::where('c_name', $category)->first();

        return view('category', [
            'category' => $category,
            'sub_category' => $sub_category,
            'products' => $category->products
        ]);
    }
}
