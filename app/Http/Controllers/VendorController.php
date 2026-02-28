<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Order;

class VendorController extends Controller
{
    public function signup(){
        return view('vendor/signup');
    }

    public function register(Request $request){
        $request->validate([
            'fullname' => 'required',
            'phone' => 'required|regex:/^[0-9]{10}/|unique:vendors,phone',
            'email' => 'required|email|unique:vendors,email',
            'password' => 'required|min:6',
            'address' => 'required',
        ]);

        Vendor::create([
            'fullname' => $request->fullname,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'address' => $request->address,
        ]);

        return redirect('vendor/signup')->with('success','Registration successful!.');
    }

    public function login(){
        return view('vendor/login');
    }

    public function login_create(Request $request){
        $request->validate([
            'phone' => 'required',
            'password' => 'required',
        ]);

        $vendor = Vendor::where('phone', $request->phone)->first();

        if($vendor && \Hash::check($request->password, $vendor->password)){

            if($vendor->status == 'verified'){
            session(['vendor_id' => $vendor->id]);
            session(['vendorName' => $vendor->fullname]);
            session(['vendorId' => $vendor->v_id]);
            return redirect('vendor/');            
            }else{
                return redirect('vendor/login')->with('error','Your account is not verified yet.');
            }

            session(['vendor_id' => $vendor->id]);
            return redirect('vendor/');
        }else{
            return redirect('vendor/login')->with('error','Invalid phone or password.');
        }
    }

    public function logout(){
        session()->forget('vendor_id');
        return redirect('vendor/login');
    }

    public function forget(){
        return view('vendor/forget');
    }

    public function index(){
        $vendorId = session('vendorId');

        $orderIds = \App\Models\OrderItem::pluck('order_id')->unique();

        $orders = Order::whereIn('order_id', $orderIds)
                    ->with(['orderItems', 'billing'])
                    ->latest()
                    ->get();

        $allOrders = Order::whereIn('order_id', $orderIds)->get();  

        $totalOrders = $allOrders->count();
        $totalSale = $allOrders->sum('total');
        $pendingOrders = $allOrders->where('status', 'pending')->count();  

        return view('vendor.index', compact('orders', 'totalOrders', 'totalSale', 'pendingOrders'));
    }

    public function orders(){
        return view('vendor/orders');
    }

    public function orderdetail($id){
        $vendorId = session('vendorId');
        
        $order = Order::with(['billing', 'orderItems', 'user'])->findOrFail($id);
        
        $orderItems = $order->orderItems;
        
        return view('vendor/order-detail', compact('order', 'orderItems'));
    }

    public function updateStatus(Request $request, $order_id){
        $order = Order::findOrFail($order_id);
        
        $routeName = $request->route()->getName();
        
        $status = match($routeName) {
            'order.processing' => 'processing',
            'order.ontheway'   => 'ontheway',
            'order.delivered'  => 'delivered',
        };
        
        $order->status = $status;
        $order->save();
        
        return redirect()->back()->with('success', 'Order status updated!');
    }

    public function users(){
        return view('vendor/users');
    }

    public function profile(){
        $v_id = session('vendorId');
        $vendor = Vendor::find($v_id);
        return view('vendor/profile', compact('vendor'));
    }

    public function updateprofile(Request $request){
        $v_id = session('vendorId');
        $vendor = Vendor::find($v_id);

        $request->validate([
        'fullname' => 'required',
        'phone' => 'required',
        'email' => 'required',
        'address' => 'required',
        'id_number' => 'required',
        'business_name' => 'required',
        'business_type' => 'required',
        'gst_number' => 'required',
        'business_category' => 'required',
        'bank_account_no' => 'required',
        'payment_method' => 'required',
        'image' => 'required',
    ]);
    
        $image = $vendor->image;
        if($request->hasFile('image')){
            $image = $request->file('image')->store('vendors', 'public');
        }

    $vendor->update([
        'fullname' => $request->fullname,  
        'phone' => $request->phone,
        'email' => $request->email,
        'address' => $request->address,
        'id_number' => $request->id_number,
        'business_name' => $request->business_name,
        'business_type' => $request->business_type,
        'gst_number' => $request->gst_number,
        'business_category' => $request->business_category,
        'bank_account_no' => $request->bank_account_no,
        'payment_method' => $request->payment_method,
        'image' => $request->image,
    ]);


        return redirect('vendor/profile')->with('success','Profile updated successfully!');
    }

    public function verified($id){
        $vendor = Vendor::findOrFail($id);
        $vendor->status = 'verified';
        $vendor->save();

        return redirect()->back()->with('success', 'Vendor Verified Successfully');
    }

    public function unverified($id){
        $vendor = Vendor::findOrFail($id);
        $vendor->status = 'unverified';
        $vendor->save();

        return redirect()->back()->with('success', 'Vendor Unverified Successfully');
    }

}