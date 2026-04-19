<?php

namespace App\Http\Controllers;

use App\Models\KeywordSuggestion;
use App\Services\AiContentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KeywordToolController extends Controller
{
    public function index(Request $request, AiContentService $ai): View
    {
        $history = $request->user()
            ->keywordSuggestions()
            ->with('blogPost')
            ->latest()
            ->take(15)
            ->get();

        $posts = $request->user()->blogPosts()->latest()->take(50)->get(['id', 'title']);

        return view('keywords.index', [
            'history' => $history,
            'posts' => $posts,
            'aiConfigured' => $ai->isConfigured(),
        ]);
    }

    public function store(Request $request, AiContentService $ai): RedirectResponse
    {
        $data = $request->validate([
            'seed_topic' => ['nullable', 'string', 'max:500'],
            'seed_text' => ['nullable', 'string', 'max:8000'],
            'blog_post_id' => ['nullable', 'exists:blog_posts,id'],
            'language' => ['nullable', 'string', 'max:12'],
        ]);

        $post = null;
        if (! empty($data['blog_post_id'])) {
            $post = $request->user()->blogPosts()->whereKey($data['blog_post_id'])->firstOrFail();
        }

        try {
            $keywords = $ai->suggestKeywords(
                $data['seed_topic'] ?? null,
                $data['seed_text'] ?? null,
                $data['language'] ?? 'bg',
                24
            );
        } catch (\Throwable $e) {
            return back()->withErrors(['seed_topic' => $e->getMessage()])->withInput();
        }

        KeywordSuggestion::create([
            'user_id' => $request->user()->id,
            'blog_post_id' => $post?->id,
            'seed_topic' => $data['seed_topic'] ?? null,
            'keywords' => $keywords,
        ]);

        return back()->with('status', 'Ключовите думи са записани.');
    }
}
