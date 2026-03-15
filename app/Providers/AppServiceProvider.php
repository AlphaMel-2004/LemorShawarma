<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\SiteSetting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
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
        Paginator::useBootstrapFive();

        View::composer('components.footer', function ($view): void {
            if (Schema::hasTable('site_settings')) {
                $view->with('contactSettings', SiteSetting::getContactSettings());
            } else {
                $view->with('contactSettings', SiteSetting::CONTACT_DEFAULTS);
            }

            if (Schema::hasTable('products') && Schema::hasColumn('products', 'category')) {
                $footerMenuCategories = Product::query()
                    ->where('is_active', true)
                    ->whereNotNull('category')
                    ->selectRaw('category, COUNT(*) as total_products')
                    ->groupBy('category')
                    ->orderByDesc('total_products')
                    ->orderBy('category')
                    ->limit(5)
                    ->pluck('category');
            } else {
                $footerMenuCategories = collect();
            }

            $view->with('footerMenuCategories', $footerMenuCategories);
        });
    }
}
