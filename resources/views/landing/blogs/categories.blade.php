@if ($categories->isNotEmpty())
    <nav class="mc-blog-categories" aria-label="فئات المقالات">
        <h2>الفئات</h2>
        <ul>
            <li>
                <a href="{{ route('blog.index') }}" @if (!isset($post) && !$currentCategory && ($search ?? '') === '') aria-current="page" @endif>كل المقالات</a>
            </li>
            @foreach ($categories as $categoryLink)
                <li>
                    <a href="{{ route('blog.category', $categoryLink->id) }}"
                        @if ($currentCategory?->is($categoryLink)) aria-current="{{ isset($post) ? 'location' : 'page' }}" @endif>
                        {{ $categoryLink->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>
@endif
