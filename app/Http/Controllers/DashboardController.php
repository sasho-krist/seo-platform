<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        return view('dashboard', [
            'postCount' => $user->blogPosts()->count(),
            'keywordCount' => $user->keywordSuggestions()->count(),
            'competitorCount' => $user->competitorAnalyses()->count(),
        ]);
    }
}
