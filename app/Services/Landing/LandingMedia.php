<?php

namespace App\Services\Landing;

final class LandingMedia
{
    private const SEED_ILLUSTRATIONS = [
        'hero/home.jpeg' => 'hero.webp',
        'about/About1.jpeg' => 'about-team.webp',
        'about/About2.jpeg' => 'about-installation.webp',
        'about/About3.jpeg' => 'about-detail.webp',
        'projects/project1.jpeg' => 'project-hospital.webp',
        'projects/project2.jpeg' => 'project-mall.webp',
        'projects/project3.jpg' => 'project-warehouse.webp',
        'projects/project4.jpg' => 'project-maintenance.webp',
        'blogs/blog-01.png' => 'article-industrial-tech.webp',
        'blogs/blog-02.png' => 'article-energy.webp',
        'blogs/blog-03.png' => 'article-ac-care.webp',
        'blogs/blog-04.png' => 'article-smart-controls.webp',
        'blogs/blog-05.png' => 'article-cold-room-design.webp',
        'blogs/blog-06.png' => 'article-preventive-maintenance.webp',
        'blogs/blog-07.png' => 'article-selection.webp',
        'blogs/blog-08.png' => 'article-insulation.webp',
        'blogs/blog-09.png' => 'article-food.webp',
    ];

    public static function uploaded(?string $path): ?string
    {
        if ($path && is_file(public_path('storage/'.$path))) {
            return asset('storage/'.$path);
        }

        return null;
    }

    public static function design(string $filename): string
    {
        return asset('mas-cooling/images/'.$filename);
    }

    public static function versionedAsset(string $path): string
    {
        $file = public_path($path);
        $url = asset($path);
        $hash = is_file($file) ? hash_file('sha256', $file) : false;

        return $hash === false ? $url : $url.'?v='.substr($hash, 0, 12);
    }

    /** @return array{url: string, illustration: bool} */
    public static function photo(?string $path, string $fallback): array
    {
        $replacement = self::SEED_ILLUSTRATIONS[$path] ?? null;
        $upload = $replacement === null ? self::uploaded($path) : null;

        return [
            'url' => $upload ?? self::design($replacement ?? $fallback),
            'illustration' => $upload === null,
        ];
    }

    public static function article(?string $path): string
    {
        if ($path && ! str_contains($path, '/')) {
            $path = 'blogs/'.$path;
        }

        return self::photo($path, 'article-selection.webp')['url'];
    }
}
