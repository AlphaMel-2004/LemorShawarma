<?php

namespace App\Providers;

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
        });
    }
}
