<?php

use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LegalPageController;
use App\Http\Controllers\MobileMenuController;
use Illuminate\Support\Facades\Route;

Route::domain((string) config('app.root_domain'))->group(function (): void {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('/feedback', [HomeController::class, 'storeFeedback'])
        ->middleware('throttle:10,1')
        ->name('home.feedback');
    Route::get('/privacy-policy', [LegalPageController::class, 'privacy'])->name('legal.privacy');
    Route::get('/terms-of-service', [LegalPageController::class, 'terms'])->name('legal.terms');
    Route::get('/cookie-policy', [LegalPageController::class, 'cookies'])->name('legal.cookies');

    Route::post('/chatbot/message', [ChatbotController::class, 'reply'])
        ->middleware('throttle:15,1')
        ->name('chatbot.reply');

    Route::get('/menu', [MobileMenuController::class, 'index'])->name('mobile.menu');
    Route::post('/menu/feedback', [MobileMenuController::class, 'storeFeedback'])
        ->middleware('throttle:10,1')
        ->name('mobile.feedback');

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
