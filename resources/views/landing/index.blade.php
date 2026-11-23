@extends('landing.layouts.site')
@use('App\Services\Landing\LandingMedia')

@section('title', $seo?->meta_title ?: 'ماس للتبريد والتكييف المركزي | غرف تبريد وتجميد | Mas Cooling')
@section('meta_description', $seo?->meta_description ?: 'شركة ماس للتبريد والتكييف المركزي - متخصصون في تصميم وتركيب وصيانة غرف التبريد وغرف التجميد وأنظمة التكييف المركزي. خبرة أكثر من 15 عاماً في مجال التبريد الصناعي والتجاري. اتصل بنا الآن للحصول على استشارة مجانية.')
@section('meta_keywords', $seo?->keyword ?: 'تبريد, غرف تبريد, غرف تجميد, تكييف مركزي, شركة تبريد, صيانة تكييف, تبريد صناعي, تبريد تجاري, أنظمة تبريد, ماس للتبريد, Mas Cooling, تركيب غرف تبريد, صيانة غرف تبريد, تكييف مركزي مصر, حلول تبريد, الماس لغرف التبريد, الماس للتبريد, الماس للغرف, تكييفات, mas لغرف التبريد, mas للتكييف')
@section('og_title', $seo?->meta_title ?: 'ماس للتبريد والتكييف المركزي | غرف تبريد وتجميد | Mas Cooling')
@section('og_description', $seo?->meta_description ?: 'شركة ماس للتبريد - خبراء تصميم وتركيب غرف التبريد والتجميد وأنظمة التكييف المركزي. خبرة +15 سنة. استشارة مجانية.')

@php
    $defaultHeroTitle = 'حلول متكاملة لأنظمة التبريد والتكييف المركزية';
    $heroTitle = $heroSection?->title ?: $defaultHeroTitle;
    $hero = LandingMedia::photo($heroSection?->image, 'hero.webp');
    $projectGroups = $projectcategories->filter(fn ($category) => $category->images->isNotEmpty());
@endphp

@section('content')
<main id="main-content" tabindex="-1">
    <section class="mc-hero mc-wide" aria-labelledby="hero-title">
        <picture class="mc-hero-media">
            @if ($hero['illustration'])
                <source media="(max-width: 720px)" srcset="{{ LandingMedia::design('hero-mobile.webp') }}">
            @endif
            <img src="{{ $hero['url'] }}" alt="وحدات تبريد صناعية" width="1760" height="880" fetchpriority="high">
        </picture>

        <div class="mc-hero-inner">
            <div class="mc-hero-copy">
                <p class="mc-kicker">@include('landing.home.icon', ['icon' => 'snow']) تصميم، تنفيذ وصيانة</p>
                <h1 id="hero-title">
                    @if ($heroTitle === $defaultHeroTitle)
                        <span>حلول متكاملة</span>
                        <span>لأنظمة التبريد</span>
                        <span>والتكييف المركزية</span>
                    @else
                        {{ $heroTitle }}
                    @endif
                </h1>
                <p class="mc-hero-description">{{ $heroSection?->description ?: 'نصمّم وننفّذ غرف التبريد والتجميد وأنظمة التكييف المركزي للمنشآت الصناعية والتجارية.' }}</p>
                <div class="mc-hero-actions">
                    <a class="mc-button mc-button-ice" href="#contact">
                        اطلب استشارة مجانية
                        @include('landing.home.icon', ['icon' => 'left'])
                    </a>
                    @if ($projectGroups->isNotEmpty())
                        <a class="mc-button mc-button-glass" href="#projects">استكشف المشاريع</a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    @if ($services->isNotEmpty() || $features->isNotEmpty())
        <section class="mc-section mc-shell" id="services" aria-labelledby="services-title">
            <div class="mc-section-head mc-section-head-row">
                <h2 id="services-title">
                    {{ $serviceSection?->title && $serviceSection->title !== $heroTitle ? $serviceSection->title : 'خدمات التبريد والتكييف' }}
                </h2>
                @if ($serviceSection?->description && $serviceSection->description !== $heroSection?->description)
                    <p>{{ $serviceSection->description }}</p>
                @endif
            </div>
            @if ($services->isNotEmpty())
                <div class="mc-services-layout">
                    <div class="mc-services-photo">
                        <img src="{{ LandingMedia::design('services.webp') }}" alt="فحص ضغوط دائرة تبريد صناعية" width="760" height="760" loading="lazy" decoding="async">
                    </div>
                    <div class="mc-services-grid">
                        @foreach ($services as $service)
                            <article class="mc-service">
                                <span class="mc-service-icon">
                                    @if ($icon = LandingMedia::uploaded($service->icon))
                                        <img src="{{ $icon }}" alt="" width="24" height="24" loading="lazy">
                                    @else
                                        @include('landing.home.icon', ['icon' => 'snow'])
                                    @endif
                                </span>
                                <h3>{{ $service->title }}</h3>
                                <p>{{ $service->description }}</p>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endif
            @if ($features->isNotEmpty())
                <div class="mc-feature-grid" id="features">
                    @foreach ($features as $feature)
                        <article class="mc-service">
                            <span class="mc-service-icon">
                                @if ($icon = LandingMedia::uploaded($feature->image))
                                    <img src="{{ $icon }}" alt="" width="24" height="24" loading="lazy">
                                @else
                                    @include('landing.home.icon', ['icon' => 'check'])
                                @endif
                            </span>
                            <h3>{{ $feature->title }}</h3>
                            <p>{{ $feature->description }}</p>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>
    @endif

    @php
        $aboutPhotos = [
            ['photo' => LandingMedia::photo($aboutSection?->image1, 'about-team.webp'), 'alt' => 'مهندسان يتفقدان معدات التبريد الصناعية'],
            ['photo' => LandingMedia::photo($aboutSection?->image2, 'about-installation.webp'), 'alt' => 'باب معزول لغرفة تجميد صناعية'],
            ['photo' => LandingMedia::photo($aboutSection?->image3, 'about-detail.webp'), 'alt' => 'أنابيب وصمامات ضمن نظام تبريد'],
        ];
    @endphp
    <section class="mc-section mc-about" id="about" aria-labelledby="about-title">
        <div class="mc-shell mc-about-layout">
            <div class="mc-about-copy">
                <p class="mc-section-label">{{ $aboutSection?->title ?: 'من نحن' }}</p>
                <div class="mc-section-head">
                    <h2 id="about-title">{{ $aboutSection?->subtitle ?: 'خبرة في أنظمة التبريد والتكييف المركزي' }}</h2>
                    @if ($aboutSection?->description)
                        <p>{{ $aboutSection->description }}</p>
                    @endif
                </div>
                @if ($aboutSection?->points->isNotEmpty())
                    <ul class="mc-about-points">
                        @foreach ($aboutSection->points as $point)
                            <li>@include('landing.home.icon', ['icon' => 'check']) <span>{{ $point->content }}</span></li>
                        @endforeach
                    </ul>
                @endif
                @if ($aboutSection?->video_url)
                    <a class="mc-button mc-button-outline" href="{{ $aboutSection->video_url }}" data-fslightbox>
                        @include('landing.home.icon', ['icon' => 'play'])
                        شاهد كيف نعمل
                    </a>
                    @push('head_scripts')
                        <script defer fetchpriority="low" src="https://cdnjs.cloudflare.com/ajax/libs/fslightbox/3.0.9/index.min.js"></script>
                    @endpush
                @endif
            </div>
            <figure class="mc-about-figure">
                <div class="mc-about-photos">
                    @foreach ($aboutPhotos as $aboutPhoto)
                        <img src="{{ $aboutPhoto['photo']['url'] }}" alt="{{ $aboutPhoto['alt'] }}"
                            width="{{ $loop->first ? 650 : 420 }}" height="{{ $loop->first ? 810 : 260 }}"
                            loading="lazy" decoding="async">
                    @endforeach
                </div>
                @if (collect($aboutPhotos)->contains(fn ($item) => $item['photo']['illustration']))
                    <figcaption>صور توضيحية لأنظمة التبريد</figcaption>
                @endif
            </figure>
        </div>
    </section>

    <section class="mc-section mc-shell" id="projects" aria-labelledby="projects-title">
        <div class="mc-section-head mc-section-head-row">
            <h2 id="projects-title">{{ $projectSection?->title ?: 'مشاريع التبريد والتكييف' }}</h2>
            @if ($projectSection?->description)
                <p>{{ $projectSection->description }}</p>
            @endif
        </div>
        @if ($projectGroups->isNotEmpty())
            <div class="mc-project-filters" data-project-filters role="group" aria-label="تصفية المشاريع" hidden>
                <button type="button" data-filter="all" aria-pressed="true" aria-controls="project-gallery">جميع المشاريع</button>
                @foreach ($projectGroups as $category)
                    <button type="button" data-filter="{{ $category->id }}" aria-pressed="false" aria-controls="project-gallery">{{ $category->name }}</button>
                @endforeach
            </div>
            <div class="mc-project-grid" id="project-gallery">
                @foreach ($projectGroups as $category)
                    @foreach ($category->images as $image)
                        @php $project = LandingMedia::photo('projects/'.$image->image, 'project-warehouse.webp'); @endphp
                        <figure class="mc-project" data-project-category="{{ $category->id }}">
                            <img src="{{ $project['url'] }}" alt="" width="1000" height="565" loading="lazy" decoding="async">
                            <figcaption>
                                @if ($project['illustration'])
                                    <p class="mc-project-credit">صورة توضيحية</p>
                                @endif
                                <h3>{{ $image->title ?: $category->name }}</h3>
                                @if ($description = $image->description ?? $image->decription)
                                    <p class="mc-project-description">{{ $description }}</p>
                                @endif
                            </figcaption>
                        </figure>
                    @endforeach
                @endforeach
            </div>
        @endif
    </section>

    @if ($clients->isNotEmpty())
        <section class="mc-section mc-partners" aria-labelledby="partners-title">
            <div class="mc-shell">
                <div class="mc-section-head">
                    <h2 id="partners-title">شركاء النجاح</h2>
                </div>
                <ul class="mc-partner-grid">
                    @foreach ($clients as $client)
                        <li>
                            @if ($client->link)
                                <a href="{{ $client->link }}" target="_blank" rel="noopener">
                            @endif
                            @if ($logo = LandingMedia::uploaded($client->image))
                                <img src="{{ $logo }}" alt="" width="120" height="60" loading="lazy">
                            @endif
                            <span>{{ $client->name }}</span>
                            @if ($client->link)
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
    @endif

    @if ($testimonials->isNotEmpty())
        <section class="mc-section mc-testimonials" aria-labelledby="testimonials-title">
            <div class="mc-shell mc-testimonial-layout">
                <div class="mc-section-head">
                    <h2 id="testimonials-title">{{ $testimonialSection?->title ?: 'آراء عملائنا' }}</h2>
                    @if ($testimonialSection?->subtitle)
                        <p>{{ $testimonialSection->subtitle }}</p>
                    @endif
                    @if ($testimonialSection?->description)
                        <p>{{ $testimonialSection->description }}</p>
                    @endif
                    @if ($testimonials->count() > 1)
                        <div class="mc-quote-actions" data-quote-actions hidden>
                            <button class="mc-icon-button" type="button" data-quote-previous aria-label="الرأي السابق" aria-controls="client-quotes">
                                @include('landing.home.icon', ['icon' => 'right'])
                            </button>
                            <button class="mc-icon-button" type="button" data-quote-next aria-label="الرأي التالي" aria-controls="client-quotes">
                                @include('landing.home.icon', ['icon' => 'left'])
                            </button>
                        </div>
                    @endif
                </div>

                <div id="client-quotes" aria-live="polite">
                    @foreach ($testimonials as $testimonial)
                        <figure class="mc-quote" data-quote>
                            <span class="mc-quotation" aria-hidden="true">”</span>
                            <blockquote>{{ $testimonial->message }}</blockquote>
                            <figcaption>
                                <strong>{{ $testimonial->name }}</strong>
                                @if ($testimonial->position)
                                    <span>{{ $testimonial->position }}</span>
                                @endif
                            </figcaption>
                        </figure>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($counters->isNotEmpty())
        <dl class="mc-shell mc-stats" style="--metric-count: {{ $counters->count() }}">
            @foreach ($counters as $counter)
                <div class="mc-stat">
                    <dt>{{ $counter->title }}</dt>
                    <dd><bdi>{{ $counter->number }}</bdi></dd>
                </div>
            @endforeach
        </dl>
    @endif

    <section class="mc-section mc-shell" id="news" aria-labelledby="news-title">
        <div class="mc-section-head mc-section-head-row">
            <h2 id="news-title">{{ $blogSection?->title ?: 'أحدث المقالات والأخبار' }}</h2>
            @if ($blogSection?->description)
                <p>{{ $blogSection->description }}</p>
            @endif
        </div>
        @if ($posts->isNotEmpty())
            <div class="mc-article-grid">
                @foreach ($posts as $post)
                    @include('landing.blogs.card', ['post' => $post])
                @endforeach
            </div>
            <a class="mc-button mc-button-outline mc-home-blog-browse" href="{{ route('blog.index') }}">
                كل المقالات @include('landing.home.icon', ['icon' => 'left'])
            </a>
        @endif
    </section>

    <section class="mc-cta mc-shell" aria-labelledby="cta-title">
        <img src="{{ LandingMedia::photo($ctaSection?->image, 'cta.webp')['url'] }}" alt="" width="1440" height="480" loading="lazy" decoding="async">
        <div class="mc-cta-copy">
            <h2 id="cta-title">{{ $ctaSection?->title ?: 'ابدأ مشروع التبريد أو التكييف معنا' }}</h2>
            @if ($ctaSection?->description)
                <p>{{ $ctaSection->description }}</p>
            @endif
            <a class="mc-button mc-button-ice" href="#contact">
                تحدث مع فريقنا
                @include('landing.home.icon', ['icon' => 'left'])
            </a>
        </div>
    </section>

    @include('landing.home.contact')
</main>
@endsection
