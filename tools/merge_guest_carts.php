<?php
// Usage:
// php tools/merge_guest_carts.php --target-id=5 --source-ids=3,4 [--dry-run]

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

function parseArg($name) {
    global $argv;
    foreach ($argv as $arg) {
        if (strpos($arg, "--$name=") === 0) {
            return substr($arg, strlen("--$name="));
        }
    }
    return null;
}

$dryRun = false;
foreach ($argv as $a) { if ($a === '--dry-run') $dryRun = true; }

$targetId = parseArg('target-id');
$sourceIds = parseArg('source-ids');

if (!$targetId || !$sourceIds) {
    echo "Usage: php tools/merge_guest_carts.php --target-id=5 --source-ids=3,4 [--dry-run]\n";
    exit(1);
}

$sourceIds = array_filter(array_map('trim', explode(',', $sourceIds)));

$target = Cart::with('items')->find($targetId);
if (!$target) {
    echo "Target cart id $targetId not found.\n";
    exit(1);
}

echo "Target cart: id={$target->id} items_count={$target->items->sum('qty')}\n";
echo "Sources: " . implode(',', $sourceIds) . "\n";
if ($dryRun) echo "DRY RUN: no DB changes will be made\n";

$moved = 0;

DB::beginTransaction();
try {
    foreach ($sourceIds as $sid) {
        $source = Cart::with('items.product')->find($sid);
        if (!$source) {
            echo "Source cart $sid not found, skipping.\n";
            continue;
        }
        if ($source->id == $target->id) {
            echo "Source equals target ($sid), skipping.\n";
            continue;
        }

        echo "Processing source cart id={$source->id} items_count={$source->items->sum('qty')}\n";

        foreach ($source->items as $item) {
            $product = $item->product;
            $existing = $target->items()->where('product_id', $item->product_id)->first();
            $available = $product ? $product->stock : null;
            $incomingQty = $item->qty;

            if ($existing) {
                $newQty = $existing->qty + $incomingQty;
                if (!is_null($available)) {
                    $newQty = min($newQty, $available);
                }
                echo " - Merge product {$item->product_id}: existing={$existing->qty} + incoming={$incomingQty} => new={$newQty}\n";
                if (!$dryRun) {
                    $existing->qty = $newQty;
                    $existing->save();
                }
            } else {
                $qtyToInsert = $incomingQty;
                if (!is_null($available)) $qtyToInsert = min($qtyToInsert, $available);
                echo " - Move product {$item->product_id}: qty={$qtyToInsert}\n";
                if (!$dryRun) {
                    $target->items()->create([
                        'product_id' => $item->product_id,
                        'qty' => $qtyToInsert,
                        'price' => $item->price ?? ($product->price ?? 0),
                    ]);
                }
            }

            if (!$dryRun) {
                $moved += $item->qty;
                $item->delete();
            }
        }

        // delete empty source cart
        $remaining = $source->items()->count();
        if ($remaining == 0) {
            echo " - Deleting empty source cart {$source->id}\n";
            if (!$dryRun) $source->delete();
        } else {
            echo " - Source cart {$source->id} still has {$remaining} items after move.\n";
        }
    }

    if ($dryRun) {
        DB::rollBack();
        echo "Dry run complete. No changes committed.\n";
    } else {
        DB::commit();
        echo "Merge complete. Moved approx $moved item entries.\n";
    }

} catch (Exception $e) {
    DB::rollBack();
    echo "Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
    exit(1);
}

exit(0);
