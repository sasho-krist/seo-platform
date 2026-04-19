<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\SeoMeta;
use App\Services\AiContentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BlogPostController extends Controller
{
    public function index(Request $request): View
    {
        $posts = $request->user()
            ->blogPosts()
            ->latest()
            ->paginate(12);

        return view('blog_posts.index', compact('posts'));
    }

    public function create(Request $request, AiContentService $ai): View
    {
        return view('blog_posts.create', [
            'aiConfigured' => $ai->isConfigured(),
        ]);
    }

    public function store(Request $request): RedirectResponse
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

        return redirect()->route('blog-posts.show', $post)->with('status', 'Публикацията е създадена.');
    }

    public function generateFromTopic(Request $request, AiContentService $ai): RedirectResponse
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
            return back()->withErrors(['topic' => $e->getMessage()])->withInput();
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

        return redirect()->route('blog-posts.show', $post)->with('status', 'Статията е генерирана с AI.');
    }

    public function show(Request $request, BlogPost $blogPost): View
    {
        $this->authorizePost($request, $blogPost);

        $blogPost->load('seoMeta');

        return view('blog_posts.show', [
            'post' => $blogPost,
            'aiConfigured' => app(AiContentService::class)->isConfigured(),
        ]);
    }

    public function edit(Request $request, BlogPost $blogPost, AiContentService $ai): View
    {
        $this->authorizePost($request, $blogPost);

        return view('blog_posts.edit', [
            'post' => $blogPost,
            'aiConfigured' => $ai->isConfigured(),
        ]);
    }

    public function update(Request $request, BlogPost $blogPost): RedirectResponse
    {
        $this->authorizePost($request, $blogPost);

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

        return redirect()->route('blog-posts.show', $blogPost)->with('status', 'Записано.');
    }

    public function destroy(Request $request, BlogPost $blogPost): RedirectResponse
    {
        $this->authorizePost($request, $blogPost);

        $blogPost->delete();

        return redirect()->route('blog-posts.index')->with('status', 'Изтрито.');
    }

    public function generateSeo(Request $request, BlogPost $blogPost, AiContentService $ai): RedirectResponse
    {
        $this->authorizePost($request, $blogPost);

        try {
            $meta = $ai->generateSeoMeta(
                $blogPost->title,
                mb_substr(strip_tags((string) $blogPost->body), 0, 4000),
                $blogPost->language ?? 'bg'
            );
        } catch (\Throwable $e) {
            return back()->withErrors(['seo' => $e->getMessage()]);
        }

        SeoMeta::updateOrCreate(
            ['blog_post_id' => $blogPost->id],
            [
                'meta_title' => $meta['meta_title'],
                'meta_description' => $meta['meta_description'],
                'focus_keyword' => $meta['focus_keyword'],
            ]
        );

        return back()->with('status', 'SEO метаданните са генерирани.');
    }

    private function authorizePost(Request $request, BlogPost $blogPost): void
    {
        abort_if($blogPost->user_id !== $request->user()->id, 403);
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
