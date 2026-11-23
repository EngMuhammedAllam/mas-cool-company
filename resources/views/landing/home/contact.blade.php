@php
    $channels = $contactSetting?->channels() ?? [];
    $whatsappUrl = $contactSetting?->whatsappUrl();
    $oldFields = array_filter(session()->getOldInput(), 'is_string');
@endphp

<section class="mc-contact" id="contact" aria-labelledby="contact-title">
    <span class="mc-contact-anchor" id="support" aria-hidden="true"></span>
    <div class="mc-shell mc-contact-layout">
        <div class="mc-contact-main">
            <div class="mc-contact-intro">
                <h2 id="contact-title">{{ $contactSetting?->title ?: 'تواصل معنا' }}</h2>
                <p>{{ $contactSetting?->description ?: 'احكِ لنا عن مشروعك أو استفسارك لنساعدك في اختيار حل التبريد أو التكييف المناسب.' }}</p>
            </div>

            <form class="mc-form" action="{{ route('contact.submit') }}" method="POST">
                @csrf
                @if (session('contact_sent'))
                    <p class="mc-form-feedback" role="status" tabindex="-1" data-form-feedback>
                        @include('landing.home.icon', ['icon' => 'check'])
                        تم إرسال رسالتك بنجاح.
                    </p>
                @elseif ($errors->contact->any())
                    <p class="mc-form-feedback mc-form-feedback-error" role="alert" tabindex="-1" data-form-feedback>راجع الحقول الموضّحة أدناه.</p>
                @endif

                <div class="mc-form-fields">
                    <div class="mc-form-mobile-wide">
                        <label for="fullname">الاسم الكامل</label>
                        <input id="fullname" name="fullname" type="text" autocomplete="name" maxlength="255" value="{{ $oldFields['fullname'] ?? '' }}" required
                            @error('fullname', 'contact') aria-invalid="true" aria-describedby="fullname-error" @enderror>
                        @error('fullname', 'contact') <p class="mc-form-error" id="fullname-error">{{ $message }}</p> @enderror
                    </div>
                    <div class="mc-form-mobile-wide">
                        <label for="email">البريد الإلكتروني</label>
                        <input id="email" name="email" type="email" autocomplete="email" maxlength="255" value="{{ $oldFields['email'] ?? '' }}" placeholder="name@company.com" required
                            @error('email', 'contact') aria-invalid="true" aria-describedby="email-error" @enderror>
                        @error('email', 'contact') <p class="mc-form-error" id="email-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="phone">رقم الهاتف <span>اختياري</span></label>
                        <input id="phone" name="phone" type="tel" autocomplete="tel" maxlength="20" value="{{ $oldFields['phone'] ?? '' }}"
                            @error('phone', 'contact') aria-invalid="true" aria-describedby="phone-error" @enderror>
                        @error('phone', 'contact') <p class="mc-form-error" id="phone-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="subject">عنوان الرسالة <span>اختياري</span></label>
                        <input id="subject" name="subject" type="text" maxlength="255" value="{{ $oldFields['subject'] ?? '' }}" placeholder="غرفة تبريد"
                            @error('subject', 'contact') aria-invalid="true" aria-describedby="subject-error" @enderror>
                        @error('subject', 'contact') <p class="mc-form-error" id="subject-error">{{ $message }}</p> @enderror
                    </div>
                    <div class="mc-form-wide">
                        <label for="message">الرسالة</label>
                        <textarea id="message" name="message" maxlength="2000" rows="3" placeholder="اذكر نوع الخدمة والموقع وأي تفاصيل تساعدنا." required
                            @error('message', 'contact') aria-invalid="true" aria-describedby="message-error" @enderror>{{ $oldFields['message'] ?? '' }}</textarea>
                        @error('message', 'contact') <p class="mc-form-error" id="message-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <button class="mc-button mc-button-primary" type="submit">
                    إرسال الرسالة
                    @include('landing.home.icon', ['icon' => 'left'])
                </button>
            </form>
        </div>

        @if ($channels || $whatsappUrl)
            <aside class="mc-contact-details" aria-labelledby="direct-contact-title">
                <div class="mc-contact-cover">
                    <img src="{{ asset('mas-cooling/images/contact-engineers.webp') }}" alt="" width="1180" height="472" loading="lazy" decoding="async">
                    <h3 id="direct-contact-title">التواصل المباشر</h3>
                </div>

                <div class="mc-contact-direct">
                    <dl class="mc-contact-channels">
                        @foreach ($channels as $icon => $channel)
                            <div class="mc-contact-channel">
                                <dt>
                                    <span class="mc-contact-channel-icon">@include('landing.home.icon', ['icon' => $icon])</span>
                                    {{ $channel['label'] }}
                                </dt>
                                <dd>
                                    @if ($channel['url'])
                                        <a href="{{ $channel['url'] }}" @if ($icon === 'pin') target="_blank" rel="noopener noreferrer" @endif>
                                            <bdi>{{ $channel['text'] }}</bdi>
                                            @include('landing.home.icon', ['icon' => 'diagonal'])
                                        </a>
                                    @else
                                        {{ $channel['text'] }}
                                    @endif
                                </dd>
                            </div>
                        @endforeach
                    </dl>
                    @if ($whatsappUrl)
                        <a class="mc-button mc-button-ice mc-contact-whatsapp" href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer">
                            @include('landing.home.icon', ['icon' => 'message'])
                            راسلنا على واتساب
                        </a>
                    @endif
                </div>
            </aside>
        @endif
    </div>
</section>
