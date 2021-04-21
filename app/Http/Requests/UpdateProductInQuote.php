<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductInQuote extends FormRequest
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
            'count' => 'required|numeric|integer|min:0',
            'product_id' => 'required|exists:products,id',
        ];
    }

    public function messages()
    {
        return [
            'count.required' => 'Product count is required.',
            'count.numeric' => 'Product count must be a number.',
            'count.integer' => 'Product count must be a whole number.',
            'count.min' => 'Product count cannot be negative.',
            'product_id.required' => 'Product ID is required.',
            'product_id.exists' => 'Could not find product matching give product ID.',
        ];
    }
}
