<?php

namespace App\Http\Requests\Dashboard\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->type == 'admin';;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'nullable|numeric',
            'category_id' => 'required|numeric|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'discount_price'=>'nullable|numeric',
            'colors'=>'nullable|array',
            'colors.*'=>'nullable|string',
            'sizes'=>'nullable|array',
            'sizes.*'=>'nullable|string',
            'images'=>'nullable|array',
            'images.*'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
