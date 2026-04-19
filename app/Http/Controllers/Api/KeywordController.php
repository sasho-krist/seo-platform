<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KeywordSuggestion;
use App\Services\AiContentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KeywordController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = $request->user()->keywordSuggestions()->latest();

        return response()->json($query->paginate((int) min(max((int) $request->query('per_page', 15), 1), 50)));
    }

    public function store(Request $request, AiContentService $ai): JsonResponse
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
            return response()->json(['message' => $e->getMessage()], 422);
        }

        $record = KeywordSuggestion::create([
            'user_id' => $request->user()->id,
            'blog_post_id' => $post?->id,
            'seed_topic' => $data['seed_topic'] ?? null,
            'keywords' => $keywords,
        ]);

        return response()->json($record, 201);
    }
}
