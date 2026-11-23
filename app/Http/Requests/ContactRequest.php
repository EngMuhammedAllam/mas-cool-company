<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    protected $errorBag = 'contact';

    /**
    * Determine if the user is authorized to make this request.
    */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fullname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:2000',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute مطلوب.',
            'string' => 'أدخل قيمة نصية صالحة في حقل :attribute.',
            'email.email' => 'أدخل بريدًا إلكترونيًا صالحًا.',
            'max' => 'الحد الأقصى لحقل :attribute هو :max حرفًا.',
        ];
    }

    public function attributes(): array
    {
        return [
            'fullname' => 'الاسم الكامل',
            'email' => 'البريد الإلكتروني',
            'phone' => 'رقم الهاتف',
            'subject' => 'عنوان الرسالة',
            'message' => 'نص الرسالة',
        ];
    }

    protected function getRedirectUrl(): string
    {
        return route('landing').'#contact';
    }
}
