<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\ContentExport;
use App\Models\SeoMeta;
use App\Services\AiContentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $posts = $request->user()
            ->blogPosts()
            ->latest()
            ->paginate((int) min(max((int) $request->query('per_page', 12), 1), 50));

        return response()->json($posts);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['nullable', 'string'],
            'tone' => ['nullable', 'string', 'max:120'],
            'language' => ['nullable', 'string', 'max:12'],
            'status' => ['nullable', 'in:draft,published'],
        ]);

        $slug = $this->uniqueSlug($request->user()->id, $data['title']);

        $post = $request->user()->blogPosts()->create([
            'title' => $data['title'],
            'slug' => $slug,
            'body' => $data['body'] ?? '',
            'tone' => $data['tone'] ?? null,
            'language' => $data['language'] ?? 'bg',
            'status' => $data['status'] ?? 'draft',
        ]);

        return response()->json($post->load('seoMeta'), 201);
    }

    public function show(Request $request, BlogPost $blogPost): JsonResponse
    {
        return response()->json($blogPost->load('seoMeta'));
    }

    public function update(Request $request, BlogPost $blogPost): JsonResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['nullable', 'string'],
            'tone' => ['nullable', 'string', 'max:120'],
            'language' => ['nullable', 'string', 'max:12'],
            'status' => ['nullable', 'in:draft,published'],
        ]);

        $slug = $blogPost->slug;
        if ($data['title'] !== $blogPost->title) {
            $slug = $this->uniqueSlug($request->user()->id, $data['title'], $blogPost->id);
        }

        $blogPost->update([
            'title' => $data['title'],
            'slug' => $slug,
            'body' => $data['body'] ?? '',
            'tone' => $data['tone'] ?? null,
            'language' => $data['language'] ?? 'bg',
            'status' => $data['status'] ?? 'draft',
        ]);

        return response()->json($blogPost->fresh()->load('seoMeta'));
    }

    public function destroy(Request $request, BlogPost $blogPost): JsonResponse
    {
        $blogPost->delete();

        return response()->json(['message' => 'Изтрито.']);
    }

    public function generateFromTopic(Request $request, AiContentService $ai): JsonResponse
    {
        $data = $request->validate([
            'topic' => ['required', 'string', 'max:500'],
            'tone' => ['nullable', 'string', 'max:120'],
            'language' => ['nullable', 'string', 'max:12'],
        ]);

        try {
            $generated = $ai->generateBlogPost(
                $data['topic'],
                $data['tone'] ?? 'информативен',
                $data['language'] ?? 'bg'
            );
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        $title = $generated['title'];
        $slug = $this->uniqueSlug($request->user()->id, $title);

        $post = $request->user()->blogPosts()->create([
            'title' => $title,
            'slug' => $slug,
            'body' => $generated['body'],
            'tone' => $data['tone'] ?? null,
            'language' => $data['language'] ?? 'bg',
            'status' => 'draft',
        ]);

        return response()->json($post->load('seoMeta'), 201);
    }

    public function generateSeo(Request $request, BlogPost $blogPost, AiContentService $ai): JsonResponse
    {
        try {
            $meta = $ai->generateSeoMeta(
                $blogPost->title,
                mb_substr(strip_tags((string) $blogPost->body), 0, 4000),
                $blogPost->language ?? 'bg'
            );
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        SeoMeta::updateOrCreate(
            ['blog_post_id' => $blogPost->id],
            [
                'meta_title' => $meta['meta_title'],
                'meta_description' => $meta['meta_description'],
                'focus_keyword' => $meta['focus_keyword'],
            ]
        );

        return response()->json($blogPost->fresh()->load('seoMeta'));
    }

    public function export(Request $request, BlogPost $blogPost): JsonResponse|Response
    {
        $format = strtolower((string) $request->query('format', 'json'));

        return match ($format) {
            'markdown' => $this->exportMarkdown($request, $blogPost),
            'html' => $this->exportHtml($request, $blogPost),
            'json' => $this->exportJson($request, $blogPost),
            default => response()->json(['message' => 'Неразрешено format. Използвайте json, markdown или html.'], 400),
        };
    }

    private function exportMarkdown(Request $request, BlogPost $blogPost): Response
    {
        $lines = [
            '# '.$blogPost->title,
            '',
            strip_tags((string) $blogPost->body),
        ];
        $payload = implode("\n", $lines);
        $this->logExport($request, $blogPost, 'markdown', $payload);

        return response($payload, 200, [
            'Content-Type' => 'text/markdown; charset=UTF-8',
        ]);
    }

    private function exportHtml(Request $request, BlogPost $blogPost): Response
    {
        $payload = view('exports.html_document', ['post' => $blogPost])->render();
        $this->logExport($request, $blogPost, 'html', $payload);

        return response($payload, 200, [
            'Content-Type' => 'text/html; charset=UTF-8',
        ]);
    }

    private function exportJson(Request $request, BlogPost $blogPost): JsonResponse
    {
        $blogPost->load('seoMeta');

        $data = [
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
        ];

        $this->logExport(
            $request,
            $blogPost,
            'json',
            (string) json_encode($data, JSON_UNESCAPED_UNICODE)
        );

        return response()->json($data);
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

    private function uniqueSlug(int $userId, string $title, ?int $exceptId = null): string
    {
        $base = Str::slug($title);
        if ($base === '') {
            $base = 'post';
        }

        $slug = $base;
        $i = 1;

        while (
            BlogPost::query()
                ->where('user_id', $userId)
                ->where('slug', $slug)
                ->when($exceptId, fn ($q) => $q->where('id', '!=', $exceptId))
                ->exists()
        ) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}
