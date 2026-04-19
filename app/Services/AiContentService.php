<?php

namespace App\Services;

use App\Support\HttpClientSslOptions;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class AiContentService
{
    public function isConfigured(): bool
    {
        $key = config('services.openai.key');

        return is_string($key) && $key !== '';
    }

    public function complete(string $system, string $user, ?float $temperature = 0.7): string
    {
        if (! $this->isConfigured()) {
            throw new RuntimeException('Задайте OPENAI_API_KEY в .env за AI функциите.');
        }

        $response = Http::withOptions(HttpClientSslOptions::guzzleVerifyOptions(
            (bool) config('services.openai.verify_ssl'),
            config('services.openai.cacert')
        ))
            ->withToken(config('services.openai.key'))
            ->timeout(120)
            ->acceptJson()
            ->post(config('services.openai.url'), [
                'model' => config('services.openai.model'),
                'messages' => [
                    ['role' => 'system', 'content' => $system],
                    ['role' => 'user', 'content' => $user],
                ],
                'temperature' => $temperature,
            ]);

        if (! $response->successful()) {
            throw new RuntimeException('AI грешка: '.$response->body());
        }

        $text = data_get($response->json(), 'choices.0.message.content');

        if (! is_string($text) || $text === '') {
            throw new RuntimeException('Празен отговор от AI.');
        }

        return trim($text);
    }

    /**
     * @return array{title: string, body: string}
     */
    public function generateBlogPost(string $topic, string $tone, string $language): array
    {
        $system = 'Ти си SEO копирайтър. Върни САМО валиден JSON обект с ключове title и body. Body е HTML с h2/h3/p/ul/li. Без markdown код огради.';
        $user = "Тема: {$topic}\nТон: {$tone}\nЕзик: {$language}\nНапиши полезен blog post (800-1200 думи).";

        $raw = $this->complete($system, $user, 0.85);
        $decoded = json_decode($this->extractJsonObject($raw), true);

        if (! is_array($decoded) || ! isset($decoded['title'], $decoded['body'])) {
            return [
                'title' => 'Генерирана статия',
                'body' => $raw,
            ];
        }

        return [
            'title' => (string) $decoded['title'],
            'body' => (string) $decoded['body'],
        ];
    }

    /**
     * @return array{meta_title: string, meta_description: string, focus_keyword: string}
     */
    public function generateSeoMeta(string $title, string $bodyExcerpt, string $language): array
    {
        $system = 'Върни САМО валиден JSON: meta_title (до 60 знака), meta_description (до 155 знака), focus_keyword (кратка фраза).';
        $user = "Език на изхода: {$language}\nЗаглавие: {$title}\nСъдържание (извадка):\n".$bodyExcerpt;

        $raw = $this->complete($system, $user, 0.5);
        $decoded = json_decode($this->extractJsonObject($raw), true);

        if (! is_array($decoded)) {
            return [
                'meta_title' => $title,
                'meta_description' => mb_substr(strip_tags($bodyExcerpt), 0, 155),
                'focus_keyword' => '',
            ];
        }

        return [
            'meta_title' => mb_substr((string) ($decoded['meta_title'] ?? $title), 0, 70),
            'meta_description' => mb_substr((string) ($decoded['meta_description'] ?? ''), 0, 512),
            'focus_keyword' => mb_substr((string) ($decoded['focus_keyword'] ?? ''), 0, 120),
        ];
    }

    /**
     * @return list<string>
     */
    public function suggestKeywords(?string $topic, ?string $seedText, string $language, int $count = 20): array
    {
        $system = 'Върни САМО JSON масив от низове – ключови думи/фрази за SEO. Без обяснения.';
        $user = "Език: {$language}\nБрой: {$count}\nТема: ".($topic ?? '')."\nКонтекст: ".mb_substr($seedText ?? '', 0, 4000);

        $raw = $this->complete($system, $user, 0.75);
        $decoded = json_decode($this->extractJsonArray($raw), true);

        if (! is_array($decoded)) {
            return array_filter(array_map('trim', preg_split('/[\n,]+/', $raw) ?: []));
        }

        $out = [];
        foreach ($decoded as $item) {
            if (is_string($item) && $item !== '') {
                $out[] = $item;
            }
        }

        return array_slice(array_values(array_unique($out)), 0, $count);
    }

    public function analyzeCompetitors(string $yourExcerpt, string $competitorExcerpt, string $language): string
    {
        $system = 'Ти си SEO стратег. Сравни двете страници: силни/слаби страни, ключови теми, препоръки за подобряване. Структурирай с ясни секции.';
        $user = "Език на отговора: {$language}\n--- Наша страница ---\n{$yourExcerpt}\n--- Конкурент ---\n{$competitorExcerpt}";

        return $this->complete($system, $user, 0.45);
    }

    public function rewriteImprove(string $text, string $instruction, string $language): string
    {
        $system = 'Подобри текста според инструкцията. Запази смисъла. Върни само финалния текст, без префикси.';
        $user = "Език: {$language}\nИнструкция: {$instruction}\n\nТекст:\n{$text}";

        return $this->complete($system, $user, 0.55);
    }

    private function extractJsonObject(string $text): string
    {
        if (preg_match('/\{[\s\S]*\}/', $text, $m)) {
            return $m[0];
        }

        return $text;
    }

    private function extractJsonArray(string $text): string
    {
        if (preg_match('/\[[\s\S]*\]/', $text, $m)) {
            return $m[0];
        }

        return $text;
    }
}
