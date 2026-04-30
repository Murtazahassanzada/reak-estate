<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required','string','max:100'],
            'email' => ['required','email','max:150'],
            'subject' => ['nullable','string','max:200'],
            'message' => ['required','string','min:10'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('validation.name_required'),
            'email.required' => __('validation.email_required'),
            'message.required' => __('validation.message_required'),
            'message.min' => __('validation.message_min'),
        ];
    }
}
