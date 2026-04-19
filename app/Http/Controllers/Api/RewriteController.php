<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AiContentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RewriteController extends Controller
{
    public function process(Request $request, AiContentService $ai): JsonResponse
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
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json(['result' => $result]);
    }
}
