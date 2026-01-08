<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 📦 Total Orders
        $totalOrders = Order::count();

        // 📅 Today Orders
        $todayOrders = Order::whereDate('created_at', Carbon::today())->count();

        // 💰 Total Revenue (only confirmed / delivered)
        $totalRevenue = Order::whereIn('status', ['confirmed', 'delivered'])
            ->sum('total');

        // ⏳ Pending Orders
        $pendingOrders = Order::where('status', 'pending')->count();

        return view('admin.dashboard', compact(
            'totalOrders',
            'todayOrders',
            'totalRevenue',
            'pendingOrders'
        ));
    }
}
