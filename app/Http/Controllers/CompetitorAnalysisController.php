<?php

namespace App\Http\Controllers;

use App\Models\CompetitorAnalysis;
use App\Services\AiContentService;
use App\Services\UrlSnippetFetcher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompetitorAnalysisController extends Controller
{
    public function index(Request $request): View
    {
        $items = $request->user()
            ->competitorAnalyses()
            ->latest()
            ->paginate(12);

        return view('competitors.index', compact('items'));
    }

    public function create(Request $request, AiContentService $ai): View
    {
        return view('competitors.create', [
            'aiConfigured' => $ai->isConfigured(),
        ]);
    }

    public function store(Request $request, AiContentService $ai, UrlSnippetFetcher $fetcher): RedirectResponse
    {
        $data = $request->validate([
            'your_url' => ['required', 'url', 'max:2048'],
            'competitor_url' => ['required', 'url', 'max:2048'],
            'language' => ['nullable', 'string', 'max:12'],
        ]);

        $yourExcerpt = $fetcher->fetchText($data['your_url']);
        $competitorExcerpt = $fetcher->fetchText($data['competitor_url']);

        if ($yourExcerpt === '' || $competitorExcerpt === '') {
            return back()->withErrors([
                'your_url' => 'Не успяхме да извлечем текст от един или двата адреса. Проверете URL адресите.',
            ])->withInput();
        }

        try {
            $analysis = $ai->analyzeCompetitors(
                $yourExcerpt,
                $competitorExcerpt,
                $data['language'] ?? 'bg'
            );
        } catch (\Throwable $e) {
            return back()->withErrors(['your_url' => $e->getMessage()])->withInput();
        }

        $record = CompetitorAnalysis::create([
            'user_id' => $request->user()->id,
            'your_url' => $data['your_url'],
            'competitor_url' => $data['competitor_url'],
            'your_excerpt' => $yourExcerpt,
            'competitor_excerpt' => $competitorExcerpt,
            'analysis' => $analysis,
        ]);

        return redirect()->route('competitors.show', $record)->with('status', 'Анализът е готов.');
    }

    public function show(Request $request, CompetitorAnalysis $competitor_analysis): View
    {
        abort_if($competitor_analysis->user_id !== $request->user()->id, 403);

        return view('competitors.show', ['item' => $competitor_analysis]);
    }
}
