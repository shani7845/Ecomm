<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();
    $request->session()->regenerate();

    // ✅ Guest → User cart merge (identifier based)
    $this->mergeGuestCartToUser();

    return redirect()->intended('/');
}




private function mergeGuestCartToUser(): void
{
    $guestCart = Cart::where('guest_token', guestToken())->first();
    if (!$guestCart) return;

    $userCart = Cart::firstOrCreate([
        'user_id' => auth()->id(),
    ]);

    foreach ($guestCart->items as $item) {
        $existing = CartItem::firstOrNew([
            'cart_id' => $userCart->id,
            'product_id' => $item->product_id,
        ]);

        $existing->qty = ($existing->qty ?? 0) + $item->qty;
        $existing->price = $item->price;
        $existing->save();
    }

    // 🔥 cleanup
    $guestCart->items()->delete();
    $guestCart->delete();
}




   public function destroy(Request $request): RedirectResponse
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
}


}