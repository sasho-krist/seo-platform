<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CompetitorAnalysis;
use App\Services\AiContentService;
use App\Services\UrlSnippetFetcher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompetitorController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return response()->json(
            $request->user()
                ->competitorAnalyses()
                ->latest()
                ->paginate((int) min(max((int) $request->query('per_page', 12), 1), 50))
        );
    }

    public function store(Request $request, AiContentService $ai, UrlSnippetFetcher $fetcher): JsonResponse
    {
        $data = $request->validate([
            'your_url' => ['required', 'url', 'max:2048'],
            'competitor_url' => ['required', 'url', 'max:2048'],
            'language' => ['nullable', 'string', 'max:12'],
        ]);

        $yourExcerpt = $fetcher->fetchText($data['your_url']);
        $competitorExcerpt = $fetcher->fetchText($data['competitor_url']);

        if ($yourExcerpt === '' || $competitorExcerpt === '') {
            return response()->json([
                'message' => 'Не успяхме да извлечем текст от един или двата адреса. Проверете URL адресите.',
            ], 422);
        }

        try {
            $analysis = $ai->analyzeCompetitors(
                $yourExcerpt,
                $competitorExcerpt,
                $data['language'] ?? 'bg'
            );
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        $record = CompetitorAnalysis::create([
            'user_id' => $request->user()->id,
            'your_url' => $data['your_url'],
            'competitor_url' => $data['competitor_url'],
            'your_excerpt' => $yourExcerpt,
            'competitor_excerpt' => $competitorExcerpt,
            'analysis' => $analysis,
        ]);

        return response()->json($record, 201);
    }

    public function show(Request $request, CompetitorAnalysis $competitor_analysis): JsonResponse
    {
        return response()->json($competitor_analysis);
    }
}
