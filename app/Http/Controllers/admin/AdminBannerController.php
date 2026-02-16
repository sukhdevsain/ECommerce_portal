<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;

class AdminBannerController extends Controller
{
   
    public function addbanner(){
        return view('admin/add-banner');
    }

    public function viewbanner(){
        $banners = Banner::all();
        return view('admin/view-banner', compact('banners'));
    }

    public function createbanner(Request $request){

        $request->validate([
            "banner" => "required",
            "alt" => "required"
        ]);

        Banner::create([
            "b_image" => $request->file('banner')->store('banners', 'public'),
            "b_alt" => $request->alt
        ]);

        return redirect('admin/add-banner')->with('success', 'Banner created successfully!');
    }

    public function deletebanner($b_id){
        $banner = Banner::find($b_id);
        $banner->delete();

        return redirect('admin/view-banner')->with('success', 'Banner deleted successfully!');
    }
}