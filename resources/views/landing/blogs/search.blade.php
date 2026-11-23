<form class="mc-blog-search" action="{{ route('blog.index') }}" method="GET" role="search">
    <label for="article-search">ابحث في المقالات</label>
    <div class="mc-blog-search-field">
        <input id="article-search" name="q" type="search" value="{{ $search ?? '' }}" placeholder="عنوان أو كلمة من المقال" maxlength="120">
        <button class="mc-icon-button" type="submit" aria-label="بحث">
            @include('landing.home.icon', ['icon' => 'search'])
        </button>
    </div>
</form>
