<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\ContentExport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ExportController extends Controller
{
    public function __invoke(Request $request, BlogPost $blogPost, string $format): Response
    {
        abort_if($blogPost->user_id !== $request->user()->id, 403);

        $format = strtolower($format);

        return match ($format) {
            'markdown' => $this->markdown($request, $blogPost),
            'html' => $this->html($request, $blogPost),
            'json' => $this->json($request, $blogPost),
            default => abort(404),
        };
    }

    private function markdown(Request $request, BlogPost $blogPost): Response
    {
        $lines = [
            '# '.$blogPost->title,
            '',
            strip_tags((string) $blogPost->body),
        ];
        $payload = implode("\n", $lines);

        $this->logExport($request, $blogPost, 'markdown', $payload);

        $filename = $blogPost->slug.'.md';

        return response($payload, 200, [
            'Content-Type' => 'text/markdown; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }

    private function html(Request $request, BlogPost $blogPost): Response
    {
        $payload = view('exports.html_document', ['post' => $blogPost])->render();

        $this->logExport($request, $blogPost, 'html', $payload);

        return response($payload, 200, [
            'Content-Type' => 'text/html; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$blogPost->slug.'.html"',
        ]);
    }

    private function json(Request $request, BlogPost $blogPost): Response
    {
        $blogPost->load('seoMeta');

        $payload = json_encode([
            'title' => $blogPost->title,
            'slug' => $blogPost->slug,
            'body_html' => $blogPost->body,
            'language' => $blogPost->language,
            'status' => $blogPost->status,
            'seo' => $blogPost->seoMeta ? [
                'meta_title' => $blogPost->seoMeta->meta_title,
                'meta_description' => $blogPost->seoMeta->meta_description,
                'focus_keyword' => $blogPost->seoMeta->focus_keyword,
            ] : null,
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $this->logExport($request, $blogPost, 'json', (string) $payload);

        return response($payload, 200, [
            'Content-Type' => 'application/json; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$blogPost->slug.'.json"',
        ]);
    }

    private function logExport(Request $request, BlogPost $blogPost, string $type, string $payload): void
    {
        ContentExport::create([
            'user_id' => $request->user()->id,
            'blog_post_id' => $blogPost->id,
            'export_type' => $type,
            'payload' => mb_substr($payload, 0, 65000),
        ]);
    }
}
