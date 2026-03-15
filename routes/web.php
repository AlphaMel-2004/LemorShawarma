<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::domain((string) config('app.root_domain'))->group(function (): void {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('/feedback', [HomeController::class, 'storeFeedback'])->name('home.feedback');

    Route::get('/menu', [\App\Http\Controllers\MobileMenuController::class, 'index'])->name('mobile.menu');
    Route::post('/menu/feedback', [\App\Http\Controllers\MobileMenuController::class, 'storeFeedback'])->name('mobile.feedback');

    Route::get('/sitemap.xml', function () {
        $lastModified = now()->toDateString();

        $urls = [
            route('home'),
            route('mobile.menu'),
        ];

        $xml = '<?xml version="1.0" encoding="UTF-8"?>\n';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">\n';

        foreach ($urls as $url) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>'.e($url)."</loc>\n";
            $xml .= '    <lastmod>'.$lastModified."</lastmod>\n";
            $xml .= "    <changefreq>weekly</changefreq>\n";
            $xml .= "    <priority>0.9</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml',
        ]);
    })->name('sitemap');
});
