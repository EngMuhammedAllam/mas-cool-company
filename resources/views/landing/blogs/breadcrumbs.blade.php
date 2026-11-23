<nav class="mc-blog-breadcrumbs" aria-label="مسار التصفح">
    <ol>
        <li><a href="{{ route('landing') }}">الرئيسية</a></li>
        @if ($breadcrumbCategory || ($articlePage ?? false))
            <li><a href="{{ route('blog.index') }}">المقالات</a></li>
        @else
            <li><span aria-current="page">المقالات</span></li>
        @endif
        @if ($breadcrumbCategory)
            <li><span aria-current="page">{{ $breadcrumbCategory->name }}</span></li>
        @endif
    </ol>
</nav>
