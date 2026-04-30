<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePropertyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
public function rules()
{
    return [
        'title' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'location' => 'required|string|max:255',

        'bedrooms' => 'required|integer|min:0',
        'bathrooms' => 'required|integer|min:0',
        'area' => 'required|integer|min:0',

        'images' => 'nullable|array',
        'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:4096',

        'purpose' => 'required|in:sale,rent,mortgage', // 🔥 بهتر شد
        'type' => 'required|in:house,apartment,villa', // 🔥 بهتر شد
    ];
}
}
