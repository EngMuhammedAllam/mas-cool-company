<svg class="mc-icon" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.65" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    @switch($icon)
        @case('left')
            <path d="M19 12H5m6-6-6 6 6 6"/>
            @break
        @case('right')
            <path d="M5 12h14m-6-6 6 6-6 6"/>
            @break
        @case('up')
            <path d="M12 19V5m-6 6 6-6 6 6"/>
            @break
        @case('play')
            <path d="m9 5 11 7-11 7Z"/>
            @break
        @case('check')
            <path d="m5 12 4 4L19 6"/>
            @break
        @case('snow')
            <path d="M12 2v20M3.3 7l17.4 10M3.3 17 20.7 7M9 4l3 3 3-3M9 20l3-3 3 3M4.1 9.9l4.1-1.1-1.1-4.1M19.9 14.1l-4.1 1.1 1.1 4.1M4.1 14.1l4.1 1.1-1.1 4.1M19.9 9.9l-4.1-1.1 1.1-4.1"/>
            @break
        @case('user')
            <circle cx="12" cy="8" r="3.2"/>
            <path d="M5 20v-1a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v1"/>
            @break
        @case('moon')
            <path d="M20.9 14.7A9.2 9.2 0 0 1 9.3 3.1a9.2 9.2 0 1 0 11.6 11.6Z"/>
            @break
        @case('sun')
            <circle cx="12" cy="12" r="4"/>
            <path d="M12 2v2m0 16v2M2 12h2m16 0h2M5 5l1.5 1.5m11 11L19 19M5 19l1.5-1.5m11-11L19 5"/>
            @break
        @case('menu')
            <path d="M4 6h16M4 12h16M4 18h16"/>
            @break
        @case('phone')
            <path d="M6 3h3l2 5-2.5 2a15 15 0 0 0 5.5 5.5l2-2.5 5 2v3a3 3 0 0 1-3 3A17 17 0 0 1 3 6a3 3 0 0 1 3-3Z"/>
            @break
        @case('mail')
            <rect x="3" y="5" width="18" height="14" rx="2"/>
            <path d="m4 7 8 6 8-6"/>
            @break
        @case('pin')
            <path d="M19 10c0 5-7 10-7 10S5 15 5 10a7 7 0 0 1 14 0Z"/>
            <circle cx="12" cy="10" r="2"/>
            @break
        @case('message')
            <path d="M20.5 11.5a8.5 8.5 0 0 1-8.5 8.5 9 9 0 0 1-3.6-.8L4 20l.9-4.2a8.5 8.5 0 1 1 15.6-4.3ZM8.5 11.5h7"/>
            @break
        @case('search')
            <circle cx="10.75" cy="10.75" r="5.75"/>
            <path d="m15 15 4.5 4.5"/>
            @break
        @case('calendar')
            <rect x="4" y="6" width="16" height="14" rx="2"/>
            <path d="M8 4v4m8-4v4M4 11h16"/>
            @break
        @case('eye')
            <path d="M2.5 12s3.4-5.5 9.5-5.5 9.5 5.5 9.5 5.5-3.4 5.5-9.5 5.5S2.5 12 2.5 12Z"/>
            <circle cx="12" cy="12" r="2.5"/>
            @break
        @case('eye-off')
            <path d="M3 3 21 21M10 6.7a10.7 10.7 0 0 1 2-.2c6.1 0 9.5 5.5 9.5 5.5a15.5 15.5 0 0 1-3 3.1M6 8.5A15.6 15.6 0 0 0 2.5 12s3.4 5.5 9.5 5.5a10.7 10.7 0 0 0 4.3-.9"/>
            @break
        @case('diagonal')
            <path d="M6 18 18 6M9 6h9v9"/>
            @break
        @case('facebook')
            <path fill="currentColor" stroke="none" d="M14 22v-9h3l.5-3.5H14V7.3c0-1 .3-1.8 1.8-1.8h1.9V2.4a23 23 0 0 0-2.8-.2c-2.8 0-4.7 1.7-4.7 4.8v2.5H7V13h3.2v9H14Z"/>
            @break
        @case('twitter')
            <path fill="currentColor" stroke="none" d="M17.3 3h3.1l-6.8 7.8L21.6 21h-6.3l-4.9-6.4L4.8 21H1.6l7.3-8.4L1.2 3h6.5l4.4 5.8L17.3 3Zm-1.1 16.2h1.7L6.8 4.7H5l11.2 14.5Z"/>
            @break
        @case('linkedin')
            <path fill="currentColor" stroke="none" d="M5.1 8.2a2.1 2.1 0 1 0 0-4.2 2.1 2.1 0 0 0 0 4.2ZM3.4 10.1h3.4V21H3.4V10.1Zm5.7 0h3.3v1.5h.1a3.6 3.6 0 0 1 3.2-1.8c3.5 0 4.2 2.3 4.2 5.3V21h-3.5v-5.3c0-1.3 0-2.9-1.8-2.9s-2.1 1.4-2.1 2.8V21H9.1V10.1Z"/>
            @break
        @case('instagram')
            <rect x="3.2" y="3.2" width="17.6" height="17.6" rx="5"/>
            <circle cx="12" cy="12" r="4"/>
            <circle cx="17.2" cy="6.9" r=".85" fill="currentColor" stroke="none"/>
            @break
    @endswitch
</svg>
