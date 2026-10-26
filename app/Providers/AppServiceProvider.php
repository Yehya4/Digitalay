<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Global Security Headers
        if (!app()->runningInConsole()) {
            header('X-Frame-Options: SAMEORIGIN');
            header('X-Content-Type-Options: nosniff');
            header('X-XSS-Protection: 1; mode=block');
            header('Referrer-Policy: strict-origin-when-cross-origin');
            header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net; font-src 'self' https://fonts.gstatic.com; img-src 'self' data: https:; connect-src 'self';");
        }

        view()->composer('layouts.footer', function ($view) {
            $view->with('categories', \App\Models\Category::all());
        });
        
        view()->composer('layouts.navbar', function ($view) {
            $view->with('categories', \App\Models\Category::all());
        });

        view()->composer('components.upsell-modal', function ($view) {
            $productId = null;
            if (request()->routeIs('products.show')) {
                $productId = request()->route('id');
            }

            $query = \App\Models\Product::where('is_active', true);
            if ($productId) {
                $query->where('id', '!=', $productId);
            }

            $upsell = (clone $query)->where('is_featured', true)
                ->inRandomOrder()
                ->first();
            
            // Fallback to any active product if no featured one found
            if (!$upsell) {
                $upsell = $query->inRandomOrder()
                    ->first();
            }
            
            $view->with('globalUpsellProduct', $upsell);
        });

        view()->composer('layouts.admin', function ($view) {
            $view->with('unreadMessagesCount', \App\Models\ContactMessage::where('is_read', false)->count());
        });
    }
}
