@extends('landing.layouts.site', ['isBlog' => true])

@php
    $archiveTitle = $category?->name ?? ($search === '' ? 'المقالات' : 'نتائج البحث');
    $archiveUrl = $category ? route('blog.category', $category->id) : route('blog.index');
@endphp

@section('title', $archiveTitle.' | '.config('app.name'))
@section('canonical', $archiveUrl)

@section('content')
<main class="mc-shell mc-blog" id="main-content" tabindex="-1">
    @include('landing.blogs.breadcrumbs', ['breadcrumbCategory' => $category])

    <div class="mc-archive-head">
        <div>
            <h1>{{ $archiveTitle }}</h1>
            @if ($search !== '')
                <p>نتائج البحث عن «<bdi>{{ $search }}</bdi>»</p>
            @endif
        </div>
        @include('landing.blogs.search')
    </div>

    @include('landing.blogs.categories', ['currentCategory' => $category])

    @if ($posts->isNotEmpty())
        <div class="mc-article-grid mc-archive-grid">
            @foreach ($posts as $post)
                @include('landing.blogs.card', ['heading' => 'h2'])
            @endforeach
        </div>
        {{ $posts->onEachSide(1)->links('landing.blogs.pagination') }}
    @else
        <div class="mc-archive-empty">
            <p>{{ $search === '' ? 'لا توجد مقالات هنا حاليًا.' : 'لم نجد مقالات تطابق بحثك.' }}</p>
            @if ($category || $search !== '')
                <a class="mc-button mc-button-outline" href="{{ route('blog.index') }}">عرض كل المقالات</a>
            @endif
        </div>
    @endif
</main>
@endsection
