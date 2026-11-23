@php
    $contactUrl = $homeLink.'#contact';
    $footerNavigation = array_slice($navigation, 1);
    unset($footerNavigation[$contactUrl]);
    $channels = $contactSetting?->channels() ?? [];
    $socialLinks = $contactSetting?->socialLinks() ?? [];
@endphp

<footer class="mc-footer">
    <div class="mc-shell mc-footer-main">
        <div class="mc-footer-brand">
            <a class="mc-footer-wordmark" href="{{ route('landing') }}">
                <span class="mc-footer-mark">
                    <img src="{{ asset('mas-cooling/images/mas-logo.png') }}" alt="" width="70" height="70" loading="lazy" decoding="async">
                </span>
                <span>ماس للتبريد والتكييف</span>
            </a>
            <p>تصميم وتنفيذ وصيانة أنظمة التبريد الصناعي والتكييف المركزي.</p>

            @if ($socialLinks)
                <ul class="mc-footer-social" aria-label="حسابات ماس كولينج">
                    @foreach ($socialLinks as $icon => $network)
                        <li>
                            <a href="{{ $network['url'] }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $network['label'] }}">
                                @include('landing.home.icon', ['icon' => $icon])
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <nav class="mc-footer-nav" aria-labelledby="footer-nav-title">
            <h2 id="footer-nav-title">استكشف الموقع</h2>
            <ul>
                @foreach ($footerNavigation as $href => $label)
                    <li><a href="{{ $href }}">{{ $label }}</a></li>
                @endforeach
            </ul>
        </nav>

        <div class="mc-footer-contact">
            <h2>تواصل معنا</h2>
            @if ($channels)
                <ul class="mc-footer-channels">
                    @foreach ($channels as $icon => $channel)
                        <li>
                            @include('landing.home.icon', ['icon' => $icon])
                            @if ($channel['url'])
                                <a href="{{ $channel['url'] }}" @if ($icon === 'pin') target="_blank" rel="noopener noreferrer" @endif><bdi>{{ $channel['text'] }}</bdi></a>
                            @else
                                <span>{{ $channel['text'] }}</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
            <a class="mc-footer-consultation" href="{{ $contactUrl }}">
                اطلب استشارة @include('landing.home.icon', ['icon' => 'left'])
            </a>
        </div>
    </div>
    <div class="mc-shell mc-footer-bottom">
        <p><bdi>{{ config('app.name') }}</bdi> &copy; {{ now()->year }} <span>جميع الحقوق محفوظة</span></p>
        <a class="mc-footer-top" href="#top">
            العودة للأعلى <span>@include('landing.home.icon', ['icon' => 'up'])</span>
        </a>
    </div>
</footer>
