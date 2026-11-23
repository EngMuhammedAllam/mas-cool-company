@extends('landing.layouts.site', ['isBlog' => true])
@use('App\Services\Landing\LandingMedia')

@php
    $cover = LandingMedia::article($post->image);
    $articleUrl = route('blog.show', $post->id);
    $shareUrl = rawurlencode($articleUrl);
    $published = $post->published_at ? \Carbon\Carbon::parse($post->published_at)->locale('ar') : null;
    $subImages = $post->sub_images ?? [];
@endphp

@section('title', $post->title.' | '.config('app.name'))
@section('canonical', $articleUrl)
@section('og_type', 'article')
@section('og_title', $post->title)
@section('twitter_title', $post->title)
@section('social_image', $cover)

@if ($post->excerpt)
    @section('meta_description', $post->excerpt)
    @section('og_description', $post->excerpt)
    @section('twitter_description', $post->excerpt)
@endif

@section('content')
<main class="mc-shell mc-blog" id="main-content" tabindex="-1">
    @include('landing.blogs.breadcrumbs', ['breadcrumbCategory' => null, 'articlePage' => true])

    <article aria-labelledby="post-title">
        <header class="mc-post-hero">
            <div class="mc-post-intro">
                @if ($post->category)
                    <a class="mc-post-topic" href="{{ route('blog.category', $post->category->id) }}">{{ $post->category->name }}</a>
                @endif
                <h1 id="post-title">{{ $post->title }}</h1>
                @if ($post->excerpt)
                    <p>{{ $post->excerpt }}</p>
                @endif
                @if ($post->author || $published)
                    <ul class="mc-post-meta" aria-label="بيانات النشر">
                        @if ($post->author)
                            <li>@include('landing.home.icon', ['icon' => 'user']) <bdi>{{ $post->author }}</bdi></li>
                        @endif
                        @if ($published)
                            <li>@include('landing.home.icon', ['icon' => 'calendar']) <time datetime="{{ $published->toDateString() }}">{{ $published->translatedFormat('j F Y') }}</time></li>
                        @endif
                    </ul>
                @endif
            </div>
            <div class="mc-post-cover">
                <img src="{{ $cover }}" alt="{{ $post->title }}" width="1160" height="653" fetchpriority="high">
            </div>
        </header>

        <div class="mc-post-layout">
            <div>
                <div class="mc-post-surface">
                    <div class="mc-post-prose">{!! nl2br(e($post->content)) !!}</div>
                    @if ($subImages && is_iterable($subImages))
                        <div class="mc-post-gallery">
                            @foreach ($subImages as $image)
                                <img src="{{ secure_asset($image) }}" alt="" loading="lazy" decoding="async">
                            @endforeach
                        </div>
                    @endif

                    <footer class="mc-post-share">
                        <h2>شارك المقال</h2>
                        <ul>
                            <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener noreferrer">فيسبوك</a></li>
                            <li><a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}" target="_blank" rel="noopener noreferrer">إكس</a></li>
                            <li><a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}" target="_blank" rel="noopener noreferrer">لينكد إن</a></li>
                        </ul>
                    </footer>
                </div>

                @if ($relatedPosts->isNotEmpty())
                    <section class="mc-blog-related" aria-labelledby="related-title">
                        <div class="mc-blog-section-head">
                            <h2 id="related-title">مقالات ذات صلة</h2>
                            <a class="mc-button mc-button-outline" href="{{ route('blog.index') }}">
                                كل المقالات @include('landing.home.icon', ['icon' => 'left'])
                            </a>
                        </div>
                        <div class="mc-article-grid">
                            @foreach ($relatedPosts as $related)
                                @include('landing.blogs.card', ['post' => $related])
                            @endforeach
                        </div>
                    </section>
                @endif
            </div>
            <aside class="mc-blog-sidebar" aria-label="تصفح المقالات">
                @include('landing.blogs.search')
                @include('landing.blogs.categories', ['currentCategory' => $post->category])
            </aside>
        </div>
    </article>
</main>
@endsection
