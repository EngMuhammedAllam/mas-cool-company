@if ($paginator->hasPages())
    <nav class="mc-blog-pagination" aria-label="صفحات المقالات">
        <ul>
            @if (!$paginator->onFirstPage())
                <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="الصفحة السابقة">@include('landing.home.icon', ['icon' => 'right'])</a></li>
            @endif
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li><span>{{ $element }}</span></li>
                @else
                    @foreach ($element as $page => $url)
                        @if ($page === $paginator->currentPage())
                            <li><span aria-current="page">{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
            @if ($paginator->hasMorePages())
                <li><a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="الصفحة التالية">@include('landing.home.icon', ['icon' => 'left'])</a></li>
            @endif
        </ul>
    </nav>
@endif
