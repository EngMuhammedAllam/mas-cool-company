@extends('landing.layouts.site')

@section('title', 'تسجيل الدخول | '.config('app.name'))
@section('canonical', route('loginform'))
@section('robots', 'noindex,follow')

@section('content')
<main class="mc-shell mc-login" id="main-content" tabindex="-1">
    <div class="mc-login-panel">
        <section class="mc-login-content" aria-labelledby="login-title">
            <header>
                <p class="mc-section-label">@include('landing.home.icon', ['icon' => 'user']) لوحة الإدارة</p>
                <h1 id="login-title">تسجيل الدخول</h1>
            </header>

            @error('credentials')
                <p class="mc-login-feedback mc-login-feedback-error" role="alert" tabindex="-1" data-form-feedback>{{ $message }}</p>
            @enderror
            @if (session('success'))
                <p class="mc-login-feedback" role="status" tabindex="-1" data-form-feedback>{{ session('success') }}</p>
            @endif

            @php $email = old('email'); @endphp
            <form class="mc-login-form" action="{{ route('dashboard.login') }}" method="POST">
                @csrf
                <div class="mc-login-field">
                    <label for="email">البريد الإلكتروني</label>
                    <input id="email" name="email" type="email" dir="ltr" value="{{ is_string($email) ? $email : '' }}"
                        autocomplete="username" autocapitalize="none" spellcheck="false" maxlength="255" required
                        @error('email') aria-invalid="true" aria-describedby="login-email-error" data-form-feedback @enderror>
                    @error('email')
                        <p class="mc-form-error" id="login-email-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mc-login-field">
                    <label for="password">كلمة المرور</label>
                    <div class="mc-login-password">
                        <input id="password" name="password" type="password" dir="ltr" autocomplete="current-password" required
                            @error('password')
                                aria-invalid="true" aria-describedby="login-password-error"
                                @unless ($errors->has('email')) data-form-feedback @endunless
                            @enderror>
                        <button type="button" class="mc-icon-button mc-password-toggle" data-password-toggle
                            aria-controls="password" aria-label="إظهار كلمة المرور" aria-pressed="false" hidden>
                            <span class="mc-eye-open">@include('landing.home.icon', ['icon' => 'eye'])</span>
                            <span class="mc-eye-closed">@include('landing.home.icon', ['icon' => 'eye-off'])</span>
                        </button>
                    </div>
                    @error('password')
                        <p class="mc-form-error" id="login-password-error">{{ $message }}</p>
                    @enderror
                </div>
                <button class="mc-button mc-button-primary" type="submit">
                    تسجيل الدخول
                    @include('landing.home.icon', ['icon' => 'left'])
                </button>
            </form>

            <p class="mc-login-support">تحتاج مساعدة في الدخول؟ <a href="{{ route('landing') }}#contact">تواصل معنا</a></p>
        </section>
        <div class="mc-login-visual">
            <img src="{{ asset('mas-cooling/images/login-plant.webp') }}" alt="" width="1165" height="1275" fetchpriority="high">
        </div>
    </div>
</main>
@endsection
