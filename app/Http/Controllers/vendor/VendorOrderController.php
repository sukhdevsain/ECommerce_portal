<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;  

class VendorOrderController extends Controller
{
   public function index(){
        $vendorId = session('vendorId');

        $orderIds = \App\Models\OrderItem::where('order_id', '!=', null)
                    ->pluck('order_id')
                    ->unique();

        $orders = \App\Models\Order::whereIn('order_id', $orderIds)
                    ->with('orderItems', 'billing', 'user')
                    ->latest()
                    ->get();

        return view('vendor.orders', compact('orders'));
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
}