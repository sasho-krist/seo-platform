<?php

namespace App\Http\Controllers;

use App\Services\AiContentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RewriteToolController extends Controller
{
    public function edit(Request $request, AiContentService $ai): View
    {
        return view('rewrite', [
            'aiConfigured' => $ai->isConfigured(),
            'inputText' => old('text'),
            'instruction' => old('instruction'),
            'result' => session('rewrite_result'),
            'error' => session('rewrite_error'),
        ]);
    }

    public function update(Request $request, AiContentService $ai): RedirectResponse
    {
        $data = $request->validate([
            'text' => ['required', 'string', 'max:20000'],
            'instruction' => ['required', 'string', 'max:1000'],
            'language' => ['nullable', 'string', 'max:12'],
        ]);

        try {
            $result = $ai->rewriteImprove(
                $data['text'],
                $data['instruction'],
                $data['language'] ?? 'bg'
            );
        } catch (\Throwable $e) {
            return redirect()
                ->route('rewrite.edit')
                ->withInput($request->only(['text', 'instruction', 'language']))
                ->with('rewrite_error', $e->getMessage());
        }

        return redirect()
            ->route('rewrite.edit')
            ->withInput($request->only(['text', 'instruction', 'language']))
            ->with('rewrite_result', $result);
    }
}
