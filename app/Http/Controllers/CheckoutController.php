<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Support\Facades\DB;

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
            'payment_intent_id' => 'nullable|string',
        ]);

        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }

        DB::beginTransaction();

        try {

            // 🔹 Calculate Total
            $total = 0;
            foreach ($request->cart as $item) {
                $total += $item['product_price'] * $item['quantity'];
            }

            $paymentStatus = 'pending';

            // 🔹 Stripe Payment Verification
            if ($request->payment_mode !== 'Cash on Delivery') {

                if (!$request->payment_intent_id) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Payment ID missing'
                    ]);
                }

                Stripe::setApiKey(config('services.stripe.secret'));
                $intent = PaymentIntent::retrieve($request->payment_intent_id);

                if ($intent->status !== 'succeeded') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Payment not successful'
                    ]);
                }

                $paymentStatus = 'paid';
            }

            // 🔹 Generate Order Number
            $year = now()->format('Y');

            $lastOrder = Order::whereYear('created_at', $year)
                ->orderBy('order_id', 'desc')
                ->first();

            $lastNumber = $lastOrder
                ? intval(substr($lastOrder->order_no, -3))
                : 0;

            $orderNo = 'ORD' . $year . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

            // 🔹 Create Order
            $order = Order::create([
                'user_id' => $user->id,
                'order_no' => $orderNo,
                'status' => $paymentStatus,
                'payment_mode' => $request->payment_mode,
                'total' => $total,
            ]);

            // 🔹 Create Order Items
            foreach ($request->cart as $item) {
                OrderItem::create([
                    'order_id'   => $order->order_id,
                    'product_id' => $item['product_id'] ?? null, // ✅ product_id save
                    'image'      => $item['image_url'] ?? null,
                    'name'       => $item['product_name'] ?? $item['name'],
                    'price'      => $item['product_price'],
                    'qty'        => $item['quantity'],
                    'total'      => $item['product_price'] * $item['quantity'],
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'order_id' => $order->order_id
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }


    public function paymentSuccess(Request $request)
    {
        $paymentIntentId = $request->get('payment_intent');

        if (!$paymentIntentId) {
            return redirect('/')->with('error', 'Payment failed');
        }

        Stripe::setApiKey(config('services.stripe.secret'));
        $intent = PaymentIntent::retrieve($paymentIntentId);

        if ($intent->status !== 'succeeded') {
            return redirect('/')->with('error', 'Payment not successful');
        }

        $cart = json_decode(session('cart_data'), true);

        if (!$cart) {
            return redirect('/')->with('error', 'Cart not found');
        }

        $user = auth()->user();

        DB::beginTransaction();

        try {

            $total = 0;
            foreach ($cart as $item) {
                $total += $item['product_price'] * $item['quantity'];
            }

            $year = now()->format('Y');

            $lastOrder = Order::whereYear('created_at', $year)
                ->orderBy('order_id', 'desc')
                ->first();

            $lastNumber = $lastOrder
                ? intval(substr($lastOrder->order_no, -3))
                : 0;

            $orderNo = 'ORD' . $year . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

            $order = Order::create([
                'user_id'      => $user->id,
                'order_no'     => $orderNo,
                'status'       => 'paid',
                'payment_mode' => 'stripe',
                'total'        => $total,
            ]);

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id'   => $order->order_id,
                    'product_id' => $item['product_id'] ?? null, // ✅ product_id save
                    'image'      => $item['image_url'] ?? null,
                    'name'       => $item['product_name'] ?? $item['name'],
                    'price'      => $item['product_price'],
                    'qty'        => $item['quantity'],
                    'total'      => $item['product_price'] * $item['quantity'],
                ]);
            }

            DB::commit();

            session()->forget('cart_data');

            return redirect('/')->with('success', 'Order placed successfully');

        } catch (\Exception $e) {

            DB::rollBack();
            return redirect('/')->with('error', $e->getMessage());
        }
    }
}