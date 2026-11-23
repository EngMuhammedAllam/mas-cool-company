<?php

namespace Tests\Feature;

use App\Models\Setting\ContactSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactSectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_published_contact_channels_appear_on_the_homepage_and_public_footer(): void
    {
        ContactSetting::create([
            'title' => 'تواصل مع الفريق',
            'phone' => '010 1234 5678',
            'email' => 'service@example.test',
            'address' => 'القاهرة، مصر',
            'map_url' => 'https://example.test/office',
            'facebook' => '#',
            'linkedin' => 'https://example.test/company',
        ]);

        $this->get(route('landing'))
            ->assertOk()
            ->assertSee('mas-cooling/site.css?v='.substr(hash_file('sha256', public_path('mas-cooling/site.css')), 0, 12))
            ->assertSeeText('تواصل مع الفريق')
            ->assertSee('contact-engineers.webp')
            ->assertSee('href="tel:01012345678"', false)
            ->assertSee('href="mailto:service@example.test"', false)
            ->assertSee('href="https://wa.me/201012345678"', false)
            ->assertSee('href="https://example.test/office"', false)
            ->assertSee('href="https://example.test/company"', false)
            ->assertDontSee('aria-label="فيسبوك"', false);

        $this->get(route('loginform'))
            ->assertOk()
            ->assertSee('href="mailto:service@example.test"', false);
    }

    public function test_contact_form_accepts_a_message_with_optional_fields_omitted(): void
    {
        $message = [
            'fullname' => 'عميل تجريبي',
            'email' => 'customer@example.test',
            'message' => 'أرغب في استشارة بخصوص غرفة تبريد.',
        ];

        $this->post(route('contact.submit'), $message)
            ->assertRedirect(route('landing').'#contact')
            ->assertSessionHas('contact_sent', true);

        $this->assertDatabaseHas('contacts', $message + ['phone' => null, 'subject' => null]);
        $this->get(route('landing'))->assertOk()->assertSeeText('تم إرسال رسالتك بنجاح.');
    }

    public function test_validation_returns_to_contact_and_rendering_handles_malformed_input(): void
    {
        $this->post(route('contact.submit'), [
            'fullname' => 'عميل تجريبي',
            'email' => ['bad-input'],
        ])->assertRedirect(route('landing').'#contact')
            ->assertSessionHasErrorsIn('contact', ['email', 'message']);

        $this->get(route('landing'))
            ->assertOk()
            ->assertSeeText('راجع الحقول الموضّحة أدناه.')
            ->assertSee('value="عميل تجريبي"', false);
        $this->assertDatabaseCount('contacts', 0);
    }
}
