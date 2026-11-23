<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model
{
    protected $fillable = [
        'title',
        'description',
        'email',
        'phone',
        'address',
        'map_url',
        'facebook',
        'twitter',
        'instagram',
        'linkedin',
    ];

    public static function current(): ?self
    {
        return cache()->remember('contact_settings', 60, fn () => self::first());
    }

    public function channels(): array
    {
        $phone = trim($this->phone ?? '');
        $number = preg_replace('/\D/', '', $phone);
        $phoneUrl = $number !== '' ? 'tel:'.(str_starts_with($phone, '+') ? '+' : '').$number : null;

        return array_filter([
            'phone' => ['label' => 'الهاتف', 'text' => $phone, 'url' => $phoneUrl],
            'mail' => ['label' => 'البريد الإلكتروني', 'text' => $this->email, 'url' => $this->email ? 'mailto:'.$this->email : null],
            'pin' => ['label' => 'موقع المكتب', 'text' => $this->address, 'url' => self::webUrl($this->map_url)],
        ], fn ($channel) => filled($channel['text']));
    }

    public function whatsappUrl(): ?string
    {
        $number = preg_replace('/\D/', '', $this->phone ?? '');
        if (str_starts_with($number, '00')) {
            $number = substr($number, 2);
        }
        if (preg_match('/^01[0125]\d{8}$/', $number)) {
            $number = '20'.substr($number, 1);
        }

        return $number !== '' ? 'https://wa.me/'.$number : null;
    }

    public function socialLinks(): array
    {
        return array_filter([
            'facebook' => ['label' => 'فيسبوك', 'url' => self::webUrl($this->facebook)],
            'twitter' => ['label' => 'إكس', 'url' => self::webUrl($this->twitter)],
            'linkedin' => ['label' => 'لينكد إن', 'url' => self::webUrl($this->linkedin)],
            'instagram' => ['label' => 'إنستجرام', 'url' => self::webUrl($this->instagram)],
        ], fn ($link) => $link['url'] !== null);
    }

    private static function webUrl(?string $value): ?string
    {
        $url = trim($value ?? '');
        if (filter_var($url, FILTER_VALIDATE_URL) && in_array(strtolower(parse_url($url, PHP_URL_SCHEME)), ['http', 'https'], true)) {
            return $url;
        }

        return null;
    }
}
