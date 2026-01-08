<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Cart;

echo "Listing carts and items:\n";

$carts = Cart::with('items.product')->get();
if ($carts->isEmpty()) {
    echo "No carts found\n";
    exit(0);
}

foreach ($carts as $c) {
    echo "Cart id={$c->id} user_id={$c->user_id} guest_token={$c->guest_token} items_count={$c->items->sum('qty')}\n";
    foreach ($c->items as $it) {
        echo " - item id={$it->id} product_id={$it->product_id} qty={$it->qty} price={$it->price}\n";
    }
}
