@use('App\Services\Landing\LandingMedia')

@php
    $heading = $heading ?? 'h3';
    $published = $post->published_at ? \Carbon\Carbon::parse($post->published_at)->locale('ar') : null;
@endphp

<article class="mc-article">
    <a href="{{ route('blog.show', $post->id) }}" class="mc-article-link">
        <div class="mc-article-media">
            <img src="{{ LandingMedia::article($post->image) }}" alt="" width="820" height="460" loading="lazy" decoding="async">
        </div>
        <div class="mc-article-copy">
            @if ($post->category || $published || $post->author)
                <div class="mc-article-meta">
                    @if ($post->category)
                        <span>{{ $post->category->name }}</span>
                    @endif
                    @if ($published)
                        <time datetime="{{ $published->toDateString() }}">{{ $published->translatedFormat('j F Y') }}</time>
                    @endif
                    @if ($post->author)
                        <bdi>{{ $post->author }}</bdi>
                    @endif
                </div>
            @endif
            <{{ $heading }} class="mc-article-title">{{ $post->title }}</{{ $heading }}>
            @if ($post->excerpt)
                <p>{{ $post->excerpt }}</p>
            @endif
            <span class="mc-article-read">اقرأ المقال @include('landing.home.icon', ['icon' => 'left'])</span>
        </div>
    </a>
</article>
