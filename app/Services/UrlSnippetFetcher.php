<?php

namespace App\Services;

use App\Support\HttpClientSslOptions;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class UrlSnippetFetcher
{
    private const MAX_BYTES = 512_000;

    public function fetchText(string $url): string
    {
        $response = Http::withOptions(HttpClientSslOptions::guzzleVerifyOptions(
            (bool) config('services.outbound_http.verify_ssl'),
            config('services.outbound_http.cacert')
        ))
            ->timeout(15)
            ->withHeaders(['User-Agent' => 'SEOPlatformBot/1.0'])
            ->get($url);

        if (! $response->successful()) {
            return '';
        }

        $html = $response->body();
        if (strlen($html) > self::MAX_BYTES) {
            $html = substr($html, 0, self::MAX_BYTES);
        }

        $text = html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = preg_replace('/\s+/u', ' ', $text) ?? $text;

        return Str::limit(trim($text), 8000);
    }
}
