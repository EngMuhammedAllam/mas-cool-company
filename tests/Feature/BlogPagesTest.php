<?php

namespace Tests\Feature;

use App\Models\Blog\BlogCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_article_and_category_render_the_published_articles(): void
    {
        $category = BlogCategory::create(['name' => 'تقنيات التبريد']);
        $publishedAt = now()->subDay()->toDateString();
        $article = $category->posts()->create([
            'title' => 'اختيار نظام التبريد',
            'content' => 'نص المقال عن اختيار وحدات التبريد.',
            'published_at' => $publishedAt,
            'image' => 'blog-07.png',
        ]);
        $category->posts()->create([
            'title' => 'العزل الحراري',
            'content' => 'نص المقال المرتبط.',
            'published_at' => $publishedAt,
        ]);
        $category->posts()->create([
            'title' => 'مقال غير منشور',
            'content' => 'نص المسودة.',
        ]);

        $this->get(route('blog.show', $article))
            ->assertOk()
            ->assertSee('mas-cooling/site.css')
            ->assertSee('mas-cooling/blog.css')
            ->assertSee('article-selection.webp')
            ->assertSeeText($article->content)
            ->assertSeeText($category->name)
            ->assertSeeText('العزل الحراري')
            ->assertDontSeeText('مقال غير منشور');

        $this->get(route('blog.category', $category))
            ->assertOk()
            ->assertSeeText($article->title)
            ->assertSeeText('العزل الحراري')
            ->assertDontSeeText('مقال غير منشور');
    }

    public function test_search_matches_article_content_and_paginates_only_public_results(): void
    {
        $category = BlogCategory::create(['name' => 'تقنيات التبريد']);
        $search = 'عزل حراري';
        $published = ['content' => 'يحتاج المشروع إلى عزل حراري.', 'published_at' => now()->subDay()->toDateString()];
        $first = $category->posts()->create(['title' => 'أول نتيجة'] + $published);
        for ($index = 1; $index <= 10; $index++) {
            $category->posts()->create(['title' => "نتيجة منشورة $index"] + $published);
        }
        $category->posts()->create(['title' => 'مقال مخفي', 'is_active' => false] + $published);
        $category->posts()->create([
            'title' => 'مقال مجدول',
            'published_at' => now()->addDay()->toDateString(),
        ] + $published);
        $category->posts()->create(['title' => 'مقال عن موضوع آخر', 'content' => 'صيانة التكييف.'] + $published);

        $nextPage = route('blog.index', ['q' => $search, 'page' => 2]);
        $this->get(route('blog.index', ['q' => $search]))
            ->assertOk()
            ->assertSeeText('نتيجة منشورة 10')
            ->assertSee($nextPage)
            ->assertDontSeeText($first->title)
            ->assertDontSeeText('مقال مخفي')
            ->assertDontSeeText('مقال مجدول')
            ->assertDontSeeText('مقال عن موضوع آخر');

        $this->get($nextPage)->assertOk()->assertSeeText($first->title);
    }
}
