<?php

namespace App\Services;

use App\Models\BlogPost;
use App\Models\WordpressConnection;
use App\Support\HttpClientSslOptions;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class WordPressPublisher
{
    public function publish(BlogPost $post, WordpressConnection $connection): array
    {
        $base = rtrim($connection->site_url, '/');
        $endpoint = $base.'/wp-json/wp/v2/posts';
        $token = base64_encode($connection->username.':'.$connection->app_password);

        $response = Http::timeout(60)
            ->withHeaders([
                'Authorization' => 'Basic '.$token,
                'Content-Type' => 'application/json',
            ])
            ->post($endpoint, [
                'title' => $post->title,
                'content' => $post->body ?? '',
                'status' => $post->status === 'published' ? 'publish' : 'draft',
                'slug' => $post->slug,
            ]);

        if (! $response->successful()) {
            throw new RuntimeException('WordPress: '.$response->body());
        }

        $json = $response->json();

        return is_array($json) ? $json : [];
    }

    public function validateConnection(WordpressConnection $connection): bool
    {
        $base = rtrim($connection->site_url, '/');
        $me = $base.'/wp-json/wp/v2/users/me';
        $token = base64_encode($connection->username.':'.$connection->app_password);

        $response = Http::withOptions(HttpClientSslOptions::guzzleVerifyOptions(
            (bool) config('services.outbound_http.verify_ssl'),
            config('services.outbound_http.cacert')
        ))
            ->timeout(20)
            ->withHeaders(['Authorization' => 'Basic '.$token])
            ->get($me);

        return $response->successful();
    }
}
