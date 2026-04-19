<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'posts_count' => $user->blogPosts()->count(),
            'keyword_lists_count' => $user->keywordSuggestions()->count(),
            'competitor_analyses_count' => $user->competitorAnalyses()->count(),
        ]);
    }
}
