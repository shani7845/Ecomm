<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\OrderAddress;
use App\Http\Controllers\CartController;

class OrderController extends Controller
{
    /**
     * PLACE ORDER
     */
    public function place(Request $request)
    {
        // Get current cart (guest or user)
        $cart = app(CartController::class)->cart();

        if (!$cart || $cart->items()->count() === 0) {
            return back()->with('error', 'Cart is empty');
        }

        $order = null;

        DB::transaction(function () use ($request, $cart, &$order) {

            $total = 0;

            foreach ($cart->items as $item) {
                $total += $item->qty * $item->price;
            }

            // 🧾 Create Order
            $order = Order::create([
                'user_id'     => auth()->id(),
                'guest_token' => $cart->guest_token,
                'total'       => $total,
                'status'      => 'pending',
            ]);



            // 📦 Order Items
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'qty'        => $item->qty,
                    'price'      => $item->price,
                ]);
            }

            // 🧹 Clear cart
            $cart->items()->delete();
        });

        // ✅ Redirect to checkout page
        return redirect()->route('checkout.show', $order->id);
    }

    /**
     * CHECKOUT PAGE
     */
    public function checkout(Order $order)
    {
        $order->load('items.product');
        return view('checkout.index', compact('order'));
    }

    /**
     * CONFIRM ORDER (COD / payment success)
     */
    public function confirm(Request $request, Order $order)
    {
        // validate billing data from checkout form
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'phone'   => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        // save billing address
        OrderAddress::create([
            'order_id' => $order->id,
            'type'     => 'billing',
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'address'  => $request->address,
            'city'     => $request->city ?? '',
            'pincode'  => $request->pincode ?? '',
        ]);

        // mark order completed (payment / COD confirmed)
        $order->update([
            'status' => 'completed',
        ]);

       return redirect()->route('order.success', $order->id);
    }


    /**
 * ORDER SUCCESS PAGE
 */
public function success(Order $order)
{
    $order->load('items.product', 'addresses');

    return view('order.success', compact('order'));
}

/**
 * USER ORDER LIST
 */
public function myOrders()
{
    $orders = Order::where('user_id', auth()->id())
        ->latest()
        ->get();

    return view('order.my-orders', compact('orders'));
}

/**
 * SINGLE ORDER DETAILS
 */
public function myOrderDetails(Order $order)
{
    // 🔐 Security check
    if ($order->user_id !== auth()->id()) {
        abort(403);
    }

    $order->load('items.product', 'addresses');

    return view('order.details', compact('order'));
}



}
