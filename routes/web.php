<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;   // FRONTEND
use App\Http\Controllers\ProductController;    // FRONTEND
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\CartController; 
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\HeroSectionController;
use App\Http\Controllers\Admin\AboutSectionController;
use App\Http\Controllers\Admin\TestimonialController;

/*
|--------------------------------------------------------------------------
| FRONTEND ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Category wise products
Route::get('/categories/{slug}', [CategoryController::class, 'show'])
    ->name('categories.show');

// Single product
Route::get('/product/{slug}', [ProductController::class, 'show'])
    ->name('product.show');

    Route::get('/search', [ProductController::class, 'search'])
    ->name('products.search');

    Route::get('/ajax/search-products', [\App\Http\Controllers\ProductController::class, 'ajaxSearch'])
    ->name('products.ajax.search');


Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/place-order', [OrderController::class, 'place'])
    ->name('order.place');


Route::get('/checkout/{order}', [OrderController::class, 'checkout'])
    ->name('checkout.show');

Route::post('/order-confirm/{order}', [OrderController::class, 'confirm'])
    ->name('order.confirm');


// debug: show DB vs current cart info (local troubleshooting)
Route::get('/cart/debug', [CartController::class, 'debug'])->name('cart.debug');


Route::get('/order-success/{order}', [OrderController::class, 'success'])
    ->name('order.success');


    Route::get('/ajax/products', [HomeController::class, 'ajaxProducts'])
    ->name('ajax.products');


// Route::get('/clear-cart', function () {
//     session()->forget('cart');
//     return 'Cart cleared';
// });

/*
|--------------------------------------------------------------------------
| USER DASHBOARD
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| ADMIN PANEL ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('categories', AdminCategoryController::class);
        Route::resource('products', AdminProductController::class);
         // product status toggle
        Route::patch(
            'products/{product}/status',
            [AdminProductController::class, 'updateStatus']
        )->name('products.status');

        
        Route::get('/orders', [AdminOrderController::class, 'index'])
            ->name('orders.index');

        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])
            ->name('orders.show');

        Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
            ->name('orders.status');

        // routes/web.php (admin group ke andar)
            Route::get('/hero-section', [HeroSectionController::class, 'edit'])
            ->name('hero.edit');

            Route::post('/hero-section', [HeroSectionController::class, 'update'])
             ->name('hero.update');



Route::get('/about-section', [AboutSectionController::class, 'edit'])
    ->name('about.edit');

Route::post('/about-section', [AboutSectionController::class, 'update'])
    ->name('about.update');

Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class)
    ->only(['index','create','store']);

 Route::resource('testimonials', TestimonialController::class)->except(['show']); 

    });



    /*
|--------------------------------------------------------------------------
| MY ORDERS (USER)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/my-orders', [OrderController::class, 'myOrders'])
        ->name('orders.my');

    Route::get('/my-orders/{order}', [OrderController::class, 'myOrderDetails'])
        ->name('orders.show');
});



/*
|--------------------------------------------------------------------------
| PROFILE ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';