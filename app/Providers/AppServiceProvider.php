<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Cart;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrap();

        View::composer('*', function ($view) {

            /* =========================
               🛒 CART ITEMS (Page use)
            ========================= */
            if (auth()->check()) {
                // Logged-in user → DB cart
                $cartModel = Cart::where('user_id', auth()->id())
                    ->with('items.product')
                    ->first();

                $cartItems = $cartModel ? $cartModel->items : collect();
                $cartCount = $cartItems->sum('qty');

            } else {
                // Guest user → try DB guest cart (uses guest_token from cookie or header),
                // fallback to session for compatibility
                $guestToken = request()->header('X-GUEST-TOKEN') ?? request()->cookie('guest_token');

                if ($guestToken) {
                    $cartModel = Cart::where('guest_token', $guestToken)
                        ->with('items.product')
                        ->first();

                    $cartItems = $cartModel ? $cartModel->items : collect();
                    $cartCount = $cartItems->sum('qty');
                } else {
                    // fallback to legacy session-based cart
                    $cartItems = session()->get('cart', []);
                    $cartCount = collect($cartItems)->sum('qty');
                }
            }

            $view->with('cartItems', $cartItems);
            $view->with('cartCount', $cartCount);

            /* =========================
               📂 MENU CATEGORIES
            ========================= */
            $menuCategories = Category::withCount([
                'products' => function ($query) {
                    $query->where('status', 1);
                }
            ])
            ->with([
                'products' => function ($query) {
                    $query->where('status', 1);
                }
            ])
            ->get();

            $view->with('menuCategories', $menuCategories);
        });
    }
}