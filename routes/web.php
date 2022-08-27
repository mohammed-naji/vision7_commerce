<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\SiteController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// Route::group(['prefix' => LaravelLocalization::setLocale()], function()
// {

Route::prefix(LaravelLocalization::setLocale())->group(function() {

    Route::prefix('admin')->name('admin.')->middleware(['auth', 'check_user'])->group(function() {
        Route::get('/', [AdminController::class, 'index'])->name('index');

        // Categories Routes
        Route::get('categories/trash', [CategoryController::class, 'trash'])->name('categories.trash');
        Route::get('categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
        Route::get('categories/{id}/forcedelete', [CategoryController::class, 'forcedelete'])->name('categories.forcedelete');
        Route::resource('categories', CategoryController::class);

        // Products Routes
        Route::get('products/trash', [ProductController::class, 'trash'])->name('products.trash');
        Route::get('products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
        Route::get('products/{id}/forcedelete', [ProductController::class, 'forcedelete'])->name('products.forcedelete');
        Route::resource('products', ProductController::class);

    });


    Route::get('/', [SiteController::class, 'index'])->name('site.index');

    Route::get('/shop', [SiteController::class, 'shop'])->name('site.shop');

    Route::get('/about', [SiteController::class, 'about'])->name('site.about');

    Route::get('/contact', [SiteController::class, 'contact'])->name('site.contact');

    Route::get('/search', [SiteController::class, 'search'])->name('site.search');

    Route::get('/product/{id}', [SiteController::class, 'product'])->name('site.product');

    Route::post('/product/{id}/add-to-cart', [SiteController::class, 'add_to_cart'])->name('site.add_to_cart');

    Route::post('/product/{id}/review', [SiteController::class, 'product_review'])->name('site.product_review');

    Route::get('/category/{id}', [SiteController::class, 'category'])->name('site.category');


    // Route::get('/', function() {
    //     return view('welcome');
    // });

    // Route::view('/', 'welcome')->name('site.index');


    Auth::routes();

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::view('not-allowed', 'not_allowed');

});
