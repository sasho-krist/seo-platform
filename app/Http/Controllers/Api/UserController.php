<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AiContentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(Request $request, AiContentService $ai): JsonResponse
    {
        return response()->json([
            'user' => $request->user(),
            'ai_configured' => $ai->isConfigured(),
        ]);
    }
}
