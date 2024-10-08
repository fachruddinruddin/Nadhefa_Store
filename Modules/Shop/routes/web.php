<?php

use Illuminate\Support\Facades\Route;
use Modules\Shop\Entities\Category;
use Modules\Shop\Http\Controllers\ShopController;
use Modules\Shop\Http\Controllers\ProductController;


route::get('/products', [ProductController::class, 'index'])->name('products.index');
route::get('/category/{categorySlug}', [ProductController::class, 'category'])->name('products.category');
route::get('/{categorySlug}/{productSlug}',[ProductController::class, 'show'])->name('products.show');

Route::prefix('shop')->group( function () {
    Route::get('/', 'ShopController@index');
});
