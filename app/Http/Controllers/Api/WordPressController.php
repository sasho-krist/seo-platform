<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\WordpressConnection;
use App\Services\WordPressPublisher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WordPressController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $connection = $request->user()->wordpressConnection;

        if ($connection === null) {
            return response()->json(['connection' => null]);
        }

        return response()->json([
            'connection' => [
                'site_url' => $connection->site_url,
                'username' => $connection->username,
                'updated_at' => $connection->updated_at?->toIso8601String(),
            ],
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        $existing = $request->user()->wordpressConnection;

        $data = $request->validate([
            'site_url' => ['required', 'url', 'max:512'],
            'username' => ['required', 'string', 'max:255'],
            'app_password' => [$existing ? 'nullable' : 'required', 'string', 'max:512'],
        ]);

        $payload = [
            'site_url' => rtrim($data['site_url'], '/'),
            'username' => $data['username'],
        ];

        if (! empty($data['app_password'])) {
            $payload['app_password'] = $data['app_password'];
        }

        $connection = WordpressConnection::updateOrCreate(
            ['user_id' => $request->user()->id],
            $payload
        );

        return response()->json([
            'message' => 'WordPress връзката е запазена.',
            'connection' => [
                'site_url' => $connection->site_url,
                'username' => $connection->username,
                'updated_at' => $connection->updated_at?->toIso8601String(),
            ],
        ]);
    }

    public function publish(Request $request, BlogPost $blogPost, WordPressPublisher $publisher): JsonResponse
    {
        $connection = $request->user()->wordpressConnection;

        if (! $connection instanceof WordpressConnection) {
            return response()->json([
                'message' => 'Първо задайте WordPress връзка с application password.',
            ], 422);
        }

        try {
            if (! $publisher->validateConnection($connection)) {
                return response()->json(['message' => 'Невалидни данни за WordPress REST API.'], 422);
            }

            $publisher->publish($blogPost, $connection);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json(['message' => 'Публикувано в WordPress.']);
    }
}
