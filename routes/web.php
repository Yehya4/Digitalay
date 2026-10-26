<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\AdminController;

// Frontend Routes
Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/produits', [FrontendController::class, 'products'])->name('products');
Route::get('/produits/{id}', [FrontendController::class, 'productShow'])->name('products.show');
Route::get('/panier', [FrontendController::class, 'cart'])->name('cart');
Route::get('/caisse', [FrontendController::class, 'checkout'])->name('checkout');
Route::post('/caisse', [FrontendController::class, 'processCheckout'])->name('checkout.process')->middleware('throttle:5,1'); // max 5 attempts per minute
Route::get('/commande-succes/{id}', [FrontendController::class, 'orderSuccess'])->name('order.success');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');

// Legal and Info Routes
Route::get('/faq', [FrontendController::class, 'faq'])->name('faq');
Route::get('/qui-sommes-nous', [FrontendController::class, 'about'])->name('about');
Route::get('/cgv', [FrontendController::class, 'terms'])->name('terms');
Route::get('/politique-confidentialite', [FrontendController::class, 'privacy'])->name('privacy');
Route::get('/mentions-legale', [FrontendController::class, 'legal'])->name('legal');

Route::post('/contact', [FrontendController::class, 'submitContact'])->name('contact.submit')->middleware('throttle:3,1'); // max 3 messages per minute
Route::get('/blog', [FrontendController::class, 'blog'])->name('blog');
Route::get('/blog/{slug}', [FrontendController::class, 'blogShow'])->name('blog.show');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->middleware('throttle:5,1'); // Limit login attempts
    
    Route::middleware([\App\Http\Middleware\AdminAuth::class])->group(function () {
        Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        Route::get('/commandes', [AdminController::class, 'orders'])->name('orders');
        Route::get('/commandes/{id}', [AdminController::class, 'showOrder'])->name('orders.show');
        Route::patch('/commandes/{id}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.status');
        Route::delete('/commandes/{id}', [AdminController::class, 'destroyOrder'])->name('orders.destroy'); // Need to add to controller
        
        Route::get('/produits', [AdminController::class, 'products'])->name('products');
        Route::get('/produits/nouveau', [AdminController::class, 'createProduct'])->name('products.create');
        Route::post('/produits', [AdminController::class, 'storeProduct'])->name('products.store');
        Route::get('/produits/{id}/edit', [AdminController::class, 'editProduct'])->name('products.edit');
        Route::put('/produits/{id}', [AdminController::class, 'updateProduct'])->name('products.update');
        Route::patch('/produits/{id}/toggle', [AdminController::class, 'toggleProduct'])->name('products.toggle');
        Route::delete('/produits/{id}', [AdminController::class, 'destroyProduct'])->name('products.destroy');
        
        Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
        Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
        Route::put('/categories/{id}', [AdminController::class, 'updateCategory'])->name('categories.update');
        Route::delete('/categories/{id}', [AdminController::class, 'destroyCategory'])->name('categories.destroy');

        Route::get('/messages', [AdminController::class, 'messages'])->name('messages');
        Route::patch('/messages/mark-all-read', [AdminController::class, 'markAllMessagesRead'])->name('messages.mark-all-read');
        Route::patch('/messages/{id}/read', [AdminController::class, 'toggleMessageRead'])->name('messages.toggle-read');
        Route::delete('/messages/{id}', [AdminController::class, 'destroyMessage'])->name('messages.destroy');
        
        Route::get('/parametres', [AdminController::class, 'settings'])->name('settings');
        Route::post('/parametres/password', [AdminController::class, 'updatePassword'])->name('settings.password');

        Route::get('/blog', [AdminController::class, 'blogIndex'])->name('blog');
        Route::get('/blog/nouveau', [AdminController::class, 'blogCreate'])->name('blog.create');
        Route::post('/blog', [AdminController::class, 'blogStore'])->name('blog.store');
        Route::get('/blog/{id}/edit', [AdminController::class, 'blogEdit'])->name('blog.edit');
        Route::put('/blog/{id}', [AdminController::class, 'blogUpdate'])->name('blog.update');
        Route::delete('/blog/{id}', [AdminController::class, 'blogDestroy'])->name('blog.destroy');
    });
});
