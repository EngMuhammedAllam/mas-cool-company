<?php

namespace Tests\Feature;

use App\Models\Auth\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_can_open_the_login_form(): void
    {
        $this->get(route('dashboard'))->assertRedirect(route('loginform'));
        $this->get(route('loginform'))
            ->assertOk()
            ->assertSee('login-plant.webp')
            ->assertSee(route('dashboard.login'))
            ->assertSeeText('تسجيل الدخول');
    }

    public function test_invalid_login_returns_feedback_without_authenticating(): void
    {
        $user = User::create([
            'name' => 'Dashboard test user',
            'email' => 'dashboard@example.test',
            'password' => 'sample-password',
        ]);

        $this->post(route('dashboard.login'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ])->assertRedirect(route('loginform'))
            ->assertSessionHasErrors('credentials')
            ->assertSessionHasInput('email', $user->email)
            ->assertSessionMissing('_old_input.password');

        $this->assertGuest();
        $this->get(route('loginform'))->assertOk()->assertSeeText('البريد الإلكتروني أو كلمة المرور غير صحيحة.');
    }

    public function test_validation_errors_render_even_when_the_email_is_not_a_string(): void
    {
        $this->post(route('dashboard.login'), ['email' => ['dashboard@example.test']])
            ->assertRedirect(route('loginform'))
            ->assertSessionHasErrors(['email', 'password']);

        $this->get(route('loginform'))->assertOk()->assertSeeText('أدخل بريدًا إلكترونيًا صالحًا.');
        $this->assertGuest();
    }

    public function test_existing_users_can_log_in_and_out(): void
    {
        $password = 'sample-password';
        $user = User::create([
            'name' => 'Dashboard test user',
            'email' => 'dashboard@example.test',
            'password' => $password,
        ]);

        $this->post(route('dashboard.login'), ['email' => $user->email, 'password' => $password])
            ->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
        $this->get(route('loginform'))->assertRedirect(route('dashboard'));
        $this->get(route('dashboard'))->assertOk();

        $this->get(route('dashboard.logout'))->assertRedirect(route('loginform'));
        $this->assertGuest();
        $this->get(route('loginform'))->assertOk()->assertSeeText('تم تسجيل الخروج بنجاح.');
    }
}
