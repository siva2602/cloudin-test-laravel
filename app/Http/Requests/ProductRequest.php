<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'code' => ['required', 'string', 'unique:products,code,' . $this->route('product')],
            'amount' => ['required', 'numeric'],
            'description' => ['sometimes', 'nullable', 'string'],
            'manufacturer' => ['sometimes', 'nullable', 'string'],
            'product_type' => ['sometimes', 'nullable', 'string'],
            'tax' => ['sometimes', 'nullable', 'numeric'],
        ];
    }
}
