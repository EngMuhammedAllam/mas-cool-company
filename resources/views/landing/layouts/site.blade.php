@use('App\Services\Landing\LandingMedia')

@php
    $isBlog = $isBlog ?? false;
    $isHome = request()->routeIs('landing');
    $isLogin = request()->routeIs('loginform');
    $contactSetting = $contactSetting ?? \App\Models\Setting\ContactSetting::current();
    $homeLink = $isHome ? '' : route('landing');
    $articlesLink = $isHome ? '#news' : route('blog.index');
    $currentLink = $isHome ? '#top' : ($isBlog ? $articlesLink : null);
    $navigation = [
        ($homeLink ?: '#top') => 'الرئيسية',
        ...(!$isHome || $services->isNotEmpty() || $features->isNotEmpty() ? [$homeLink.'#services' => 'خدماتنا'] : []),
        $homeLink.'#about' => 'من نحن',
        $homeLink.'#projects' => 'المشاريع',
        $articlesLink => 'المقالات',
        $homeLink.'#contact' => 'تواصل معنا',
    ];
    $accountUrl = auth()->check() ? route('dashboard') : route('loginform');
    $accountLabel = auth()->user()?->name ?? 'تسجيل الدخول';
@endphp

@push('head_scripts')
    <link rel="preload" href="{{ asset('mas-cooling/fonts/cairo-arabic.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="{{ LandingMedia::versionedAsset('mas-cooling/site.css') }}">
    @if ($isBlog)
        <link rel="stylesheet" href="{{ LandingMedia::versionedAsset('mas-cooling/blog.css') }}">
    @elseif ($isLogin)
        <link rel="stylesheet" href="{{ LandingMedia::versionedAsset('mas-cooling/login.css') }}">
    @endif
    <script>
        try {
            if (localStorage.getItem('darkMode') === 'true') {
                document.documentElement.dataset.theme = 'dark';
            }
        } catch {}
    </script>
    <script defer src="{{ LandingMedia::versionedAsset('mas-cooling/site.js') }}"></script>
@endpush

@include('landing.layouts.head', ['usesCoolingLayout' => true])

<a class="mc-skip" href="#main-content">تخطّ إلى المحتوى</a>
<header class="mc-header">
    <div class="mc-shell mc-header-inner">
        <a class="mc-brand" href="{{ route('landing') }}" aria-label="ماس كولينج الرئيسية">
            <img class="mc-logo-light" src="{{ asset('mas-cooling/images/mas-logo.png') }}" alt="ماس كولينج" width="85" height="52">
            <img class="mc-logo-dark" src="{{ asset('mas-cooling/images/mas-logo-dark.png') }}" alt="" width="85" height="52">
        </a>

        <nav class="mc-nav" id="site-navigation" aria-label="القائمة الرئيسية" @if ($isHome) data-section-navigation @endif>
            <ul>
                @foreach ($navigation as $href => $label)
                    <li><a href="{{ $href }}" @if ($href === $currentLink) aria-current="page" @endif>{{ $label }}</a></li>
                @endforeach
            </ul>
            <a class="mc-button mc-mobile-login" href="{{ $accountUrl }}" @if ($isLogin) aria-current="page" @endif>
                @include('landing.home.icon', ['icon' => 'user'])
                {{ $accountLabel }}
            </a>
        </nav>

        <div class="mc-header-actions">
            <button type="button" class="mc-icon-button mc-theme-button" data-theme-toggle aria-label="الوضع الداكن" aria-pressed="false">
                <span class="mc-theme-moon">@include('landing.home.icon', ['icon' => 'moon'])</span>
                <span class="mc-theme-sun">@include('landing.home.icon', ['icon' => 'sun'])</span>
            </button>
            <a class="mc-button mc-desktop-login" href="{{ $accountUrl }}" @if ($isLogin) aria-current="page" @endif>
                @include('landing.home.icon', ['icon' => 'user'])
                {{ $accountLabel }}
            </a>
            <button type="button" class="mc-icon-button mc-menu-button" data-menu-toggle aria-label="القائمة" aria-controls="site-navigation" aria-expanded="false">
                @include('landing.home.icon', ['icon' => 'menu'])
            </button>
        </div>
    </div>
</header>

@yield('content')

@include('landing.layouts.site-footer')

</body>
</html>
