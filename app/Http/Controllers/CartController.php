<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
public function cart()
{
    // ✅ LOGGED IN USER
    if (auth()->check()) {
        $cart = Cart::firstOrCreate([
            'user_id' => auth()->id(),
        ]);

        // eager-load items + product to avoid N+1 in views/controllers
        $cart->load('items.product');

        return $cart;
    }

    // ✅ GUEST USER
    $guestToken =
        request()->header('X-GUEST-TOKEN')
        ?? request()->cookie('guest_token');

    // 🔥 VERY IMPORTANT
    if (!$guestToken) {
        $guestToken = guestToken(); // generate only once
    }

    $cart = Cart::firstOrCreate([
        'guest_token' => $guestToken,
    ]);

    // eager-load items + product for guest carts as well
    $cart->load('items.product');

    return $cart;
}

    // ---------------------------
    // ADD TO CART
    // ---------------------------
    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $qty = max(1, (int) $request->qty);

        if ($qty > $product->stock) {
            return response()->json([
                'success' => false,
                'message' => 'Out of stock'
            ]);
        }

        $cart = $this->cart();

        // ensure mobile clients receive the guest token to persist between requests
        $responseGuestToken = null;
        if (!auth()->check()) {
            $responseGuestToken = guestToken();
        }

        $item = CartItem::firstOrNew([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
        ]);

        $item->qty = min(($item->qty ?? 0) + $qty, $product->stock);
        $item->price = $product->price;
        $item->save();

        $cartItems = $cart->items()->with('product')->get();

        $guestToSet = null;
        if (!auth()->check()) {
            // prefer token we just generated or the header/cookie
            $guestToSet = $responseGuestToken ?? (request()->header('X-GUEST-TOKEN') ?? request()->cookie('guest_token'));
        }

        $resp = response()->json([
            'success' => true,
            'count' => $cart->items()->sum('qty'),
            'guest_token' => $responseGuestToken,
            'side_cart_html' => view('partials.side-cart', compact('cartItems'))->render(),
        ]);

        if ($guestToSet) {
            $resp->withCookie(cookie('guest_token', $guestToSet, 60 * 24 * 30));
        }

        return $resp;
    }

    // ---------------------------
    // UPDATE QTY
    // ---------------------------
    public function update(Request $request)
    {
        $cart = $this->cart();

        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $request->product_id)
            ->firstOrFail();

        $product = Product::findOrFail($item->product_id);

        if ($request->qty > $product->stock) {
            return response()->json(['success' => false]);
        }

        $item->qty = $request->qty;
        $item->save();

        $subtotal = $cart->items()->sum(DB::raw('qty * price'));

        $guestToSet = null;
        if (!auth()->check()) {
            $guestToSet = request()->header('X-GUEST-TOKEN') ?? request()->cookie('guest_token');
        }

        $resp = response()->json([
            'success' => true,
            'productId' => $item->product_id,
            'qty' => $item->qty,
            'stock' => $product->stock,
            'rowTotal' => $item->qty * $item->price,
            'subtotal' => $subtotal,
            'count' => $cart->items()->sum('qty'),
            'side_cart_html' => view('partials.side-cart', ['cartItems' => $cart->items()->with('product')->get()])->render(),
        ]);

        if ($guestToSet) {
            $resp->withCookie(cookie('guest_token', $guestToSet, 60 * 24 * 30));
        }

        return $resp;
    }

    // ---------------------------
    // REMOVE
    // ---------------------------
    public function remove(Request $request)
    {
        $cart = $this->cart();

        CartItem::where('cart_id', $cart->id)
            ->where('product_id', $request->product_id)
            ->delete();

        $cartItems = $cart->items()->with('product')->get();

        $guestToSet = null;
        if (!auth()->check()) {
            $guestToSet = request()->header('X-GUEST-TOKEN') ?? request()->cookie('guest_token');
        }

        $resp = response()->json([
            'success' => true,
            'count' => $cart->items()->sum('qty'),
            'side_cart_html' => view('partials.side-cart', compact('cartItems'))->render(),
        ]);

        if ($guestToSet) {
            $resp->withCookie(cookie('guest_token', $guestToSet, 60 * 24 * 30));
        }

        return $resp;
    }

    // ---------------------------
    // CART PAGE
    // ---------------------------
    public function index()
    {
        $cart = $this->cart();
        $cartItems = $cart->items()->with('product')->get();
        // expose current guest token and cart id for quick debugging in the view
        $guestToken = request()->header('X-GUEST-TOKEN') ?? request()->cookie('guest_token') ?? null;

        $view = view('cart.index', compact('cartItems'))
            ->with('debug_guest_token', $guestToken)
            ->with('debug_cart_id', $cart->id ?? null);

        // ensure guest_token cookie exists for full-page GETs
        if (!auth()->check() && $guestToken) {
            return response($view)->withCookie(cookie('guest_token', $guestToken, 60 * 24 * 30));
        }

        return $view;
    }

    // Debug helper to compare DB cart_items vs current web cart
    public function debug()
    {
        if (!config('app.debug')) {
            abort(404);
        }

        $totalItems = \App\Models\CartItem::count();
        $totalCarts = \App\Models\Cart::count();

        $cart = $this->cart();

        $currentCartId = $cart->id ?? null;
        $currentCartItemsCount = $cart ? $cart->items()->sum('qty') : 0;

        $guestToken = request()->header('X-GUEST-TOKEN') ?? request()->cookie('guest_token');

        $guestCarts = [];
        if ($guestToken) {
            $guestCarts = \App\Models\Cart::where('guest_token', $guestToken)->with('items')->get()->map(function($c){
                return [
                    'id' => $c->id,
                    'items_count' => $c->items->sum('qty'),
                    'items' => $c->items->map(function($i){ return ['product_id'=>$i->product_id,'qty'=>$i->qty,'price'=>$i->price]; })
                ];
            });
        }

        // also list recent carts and counts (limit 10)
        $recentCarts = \App\Models\Cart::with('items')->latest()->limit(10)->get()->map(function($c){
            return ['id'=>$c->id,'user_id'=>$c->user_id,'guest_token'=>$c->guest_token,'items_count'=>$c->items->sum('qty')];
        });

        return response()->json([
            'total_carts' => $totalCarts,
            'total_cart_items' => $totalItems,
            'current_cart_id' => $currentCartId,
            'current_cart_items_count' => $currentCartItemsCount,
            'guest_token' => $guestToken,
            'guest_carts' => $guestCarts,
            'recent_carts' => $recentCarts,
        ]);
    }
}