<?php

namespace Modules\Auth\App\Http\Services\Blade;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LogoutService
{

    public function __invoke(): RedirectResponse
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('loginform')->with('success', 'تم تسجيل الخروج بنجاح.');
    }
}
