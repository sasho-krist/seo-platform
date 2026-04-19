<?php

use App\Http\Controllers\Api\AuthTokenController;
use App\Http\Controllers\Api\BlogPostController;
use App\Http\Controllers\Api\CompetitorController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\KeywordController;
use App\Http\Controllers\Api\RewriteController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WordPressController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.v1.')->group(function (): void {
    Route::post('auth/token', [AuthTokenController::class, 'store']);

    Route::middleware('auth:sanctum')->group(function (): void {
        Route::delete('auth/token', [AuthTokenController::class, 'destroy']);

        Route::get('user', [UserController::class, 'show']);

        Route::get('dashboard/stats', DashboardController::class);

        Route::post('blog-posts/generate-from-topic', [BlogPostController::class, 'generateFromTopic']);
        Route::post('blog-posts/{blog_post}/seo', [BlogPostController::class, 'generateSeo']);
        Route::get('blog-posts/{blog_post}/export', [BlogPostController::class, 'export']);
        Route::apiResource('blog-posts', BlogPostController::class);

        Route::get('keywords/history', [KeywordController::class, 'index']);
        Route::post('keywords', [KeywordController::class, 'store']);

        Route::get('competitors', [CompetitorController::class, 'index']);
        Route::post('competitors', [CompetitorController::class, 'store']);
        Route::get('competitors/{competitor_analysis}', [CompetitorController::class, 'show']);

        Route::post('rewrite', [RewriteController::class, 'process']);

        Route::get('wordpress', [WordPressController::class, 'show']);
        Route::put('wordpress', [WordPressController::class, 'update']);
        Route::post('blog-posts/{blog_post}/wordpress/publish', [WordPressController::class, 'publish']);
    });
});
