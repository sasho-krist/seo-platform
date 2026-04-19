<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\CompetitorAnalysisController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\KeywordToolController;
use App\Http\Controllers\RewriteToolController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\WordPressIntegrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : view('home');
})->name('welcome');

Route::get('/sitemap.xml', [SitemapController::class, 'xml'])->name('sitemap.xml');

Route::get('/robots.txt', function () {
    $body = "User-agent: *\nAllow: /\n\nSitemap: ".url('/sitemap.xml')."\n";

    return response($body, 200)->header('Content-Type', 'text/plain; charset=UTF-8');
})->name('robots');

Route::view('/terms', 'pages.terms')->name('terms');
Route::view('/privacy', 'pages.privacy')->name('privacy');
Route::view('/faq', 'pages.faq')->name('faq');
Route::view('/sitemap', 'pages.sitemap-html')->name('sitemap.page');
Route::view('/docs/api', 'pages.api-guide')->name('docs.api');

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    Route::delete('profile/avatar', [ProfileController::class, 'destroyAvatar'])->name('profile.avatar.destroy');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('blog-posts/generate', [BlogPostController::class, 'generateFromTopic'])
        ->name('blog-posts.generate');
    Route::post('blog-posts/{blog_post}/seo', [BlogPostController::class, 'generateSeo'])
        ->name('blog-posts.seo');
    Route::get('blog-posts/{blog_post}/export/{format}', ExportController::class)
        ->where('format', 'markdown|html|json')
        ->name('blog-posts.export');

    Route::resource('blog-posts', BlogPostController::class);

    Route::get('keywords', [KeywordToolController::class, 'index'])->name('keywords.index');
    Route::post('keywords', [KeywordToolController::class, 'store'])->name('keywords.store');

    Route::get('competitors', [CompetitorAnalysisController::class, 'index'])->name('competitors.index');
    Route::get('competitors/create', [CompetitorAnalysisController::class, 'create'])->name('competitors.create');
    Route::post('competitors', [CompetitorAnalysisController::class, 'store'])->name('competitors.store');
    Route::get('competitors/{competitor_analysis}', [CompetitorAnalysisController::class, 'show'])
        ->name('competitors.show');

    Route::get('rewrite', [RewriteToolController::class, 'edit'])->name('rewrite.edit');
    Route::post('rewrite', [RewriteToolController::class, 'update'])->name('rewrite.update');

    Route::get('wordpress', [WordPressIntegrationController::class, 'edit'])->name('wordpress.edit');
    Route::put('wordpress', [WordPressIntegrationController::class, 'update'])->name('wordpress.update');
    Route::post('blog-posts/{blog_post}/wordpress', [WordPressIntegrationController::class, 'publish'])
        ->name('wordpress.publish');
});
