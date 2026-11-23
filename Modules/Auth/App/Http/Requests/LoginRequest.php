<?php

namespace Modules\Auth\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    protected $redirectRoute = 'loginform';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'أدخل بريدك الإلكتروني.',
            'email.string' => 'أدخل بريدًا إلكترونيًا صالحًا.',
            'email.email' => 'أدخل بريدًا إلكترونيًا صالحًا.',
            'email.max' => 'البريد الإلكتروني أطول من الحد المسموح.',
            'password.required' => 'أدخل كلمة المرور.',
            'password.string' => 'أدخل كلمة مرور صالحة.',
        ];
    }
}
