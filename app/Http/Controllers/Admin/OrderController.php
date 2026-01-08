<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    // 🔹 All Orders
   public function index()
{
    $orders = Order::with('items')
        ->latest()
        ->paginate(10);

    return view('admin.orders.index', compact('orders'));
}


    // 🔹 Order Details
    public function show(Order $order)
    {
        $order->load(['items.product', 'addresses']);
        return view('admin.orders.show', compact('order'));
    }

    // 🔹 Update Status
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Order status updated');
    }
}
