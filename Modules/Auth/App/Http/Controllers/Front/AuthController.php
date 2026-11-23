<?php

namespace Modules\Auth\App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Modules\Auth\App\Http\Requests\LoginRequest;
use Modules\Auth\App\Http\Services\Blade\LoginService;
use Modules\Auth\App\Http\Services\Blade\LogoutService;

class AuthController extends Controller
{
    public function loginForm(): View
    {
        return view('auth::auth.login');
    }

    public function login(LoginRequest $request, LoginService $login): RedirectResponse
    {
        return $login($request);
    }

    public function logout(LogoutService $logout): RedirectResponse
    {
        return $logout();
    }
}
