<?php

namespace Modules\Auth\App\Http\Services\Blade;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\App\Http\Requests\LoginRequest;

class LoginService
{
    public function __invoke(LoginRequest $request): RedirectResponse
    {
        if (! Auth::attempt($request->validated())) {
            return redirect()->route('loginform')
                ->withErrors(['credentials' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة.'])
                ->withInput($request->only('email'));
        }

        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('success', 'تم تسجيل الدخول بنجاح.');
    }
}
