<?php

namespace App\Services\Landing;

use App\Models\Blog\BlogCategory;
use App\Models\Blog\BlogPost;
use App\Models\Setting\SeoSetting;

class BlogService
{
    public function getSingleBlogData($id): array
    {
        $post = BlogPost::with('category')->active()->published()->findOrFail($id);

        // Increment views
        $post->increment('views');

        // Related posts
        $relatedPosts = BlogPost::with('category')
            ->where('blog_category_id', $post->blog_category_id)
            ->where('id', '!=', $post->id)
            ->active()
            ->published()
            ->take(3)
            ->get();

        // Categories
        $categories = cache()->remember('blog_categories', 1800, fn() => BlogCategory::active()->get());

        // SEO data
        $seo = cache()->remember('seo_settings', 3600, fn() => SeoSetting::first());

        return compact('post', 'relatedPosts', 'categories', 'seo');
    }

    public function getBlogArchiveData(?string $categoryId = null, string $search = ''): array
    {
        $category = $categoryId === null ? null : BlogCategory::findOrFail($categoryId);
        $posts = BlogPost::with('category')
            ->active()
            ->published()
            ->when($category, fn ($query) => $query->where('blog_category_id', $category->id))
            ->when($search !== '', function ($query) use ($search) {
                $pattern = '%'.$search.'%';
                $query->where(fn ($matches) => $matches
                    ->where('title', 'like', $pattern)
                    ->orWhere('excerpt', 'like', $pattern)
                    ->orWhere('content', 'like', $pattern));
            })
            ->orderBy('published_at', 'desc')
            ->orderByDesc('id')
            ->paginate(10);
        if ($search !== '') {
            $posts->appends('q', $search);
        }

        $categories = cache()->remember('blog_categories', 1800, fn() => BlogCategory::active()->get());
        $seo = cache()->remember('seo_settings', 3600, fn() => SeoSetting::first());

        return compact('posts', 'category', 'categories', 'seo', 'search');
    }
}
