<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    public function checkout()
    {
        return view('checkout');
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'cart' => 'required|array|min:1',
            'payment_mode' => 'required|string',
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Not logged in']);
        }

        $cart = $request->cart;
        $total = 0;

        foreach ($cart as $item) {
            if (!isset($item['product_price'], $item['quantity'])) {
                return response()->json(['success' => false, 'message' => 'Invalid cart item data']);
            }
            $total += $item['product_price'] * $item['quantity'];
        }

        $year = now()->format('Y');
        $lastOrder = Order::whereYear('created_at', $year)
                          ->orderBy('order_id', 'desc')
                          ->first();
        $lastNumber = $lastOrder ? intval(substr($lastOrder->order_no, -3)) : 0;
        $orderNo = 'ORD' . $year . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        $order = Order::create([
            'user_id'      => $user->id,
            'order_no'     => $orderNo,
            'status'       => 'pending',
            'payment_mode' => $request->payment_mode,
            'total'        => $total,
        ]);

        foreach ($cart as $item) {
            if (!isset($item['product_price'], $item['quantity'], $item['image_url'], $item['name'])) {
                continue;
            }

            OrderItem::create([
                'order_id' => $order->order_id, 
                'image'    => $item['image_url'],
                'name'     => $item['name'],     
                'price'    => $item['product_price'],
                'qty'      => $item['quantity'],
                'total'    => $item['product_price'] * $item['quantity'],
            ]);
        }

        return response()->json(['success' => true, 'order_id' => $order->order_id]);
    }
}