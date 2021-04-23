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
        // product price is intentionally allowed to be zero (could check using not_in:0)
        return [
            'name' => 'required',
            'price_pence' => 'required|numeric|integer|min:0',
        ];
    }

    /**
     * Messages to display if a validation rule is broken.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Product name is required.',
            'price_pence.required' => 'Product price is required.',
            'price_pence.numeric' => 'Product price should be a number.',
            'price_pence.integer' => 'Product price should not contain fractions of pence.',
            'price_pence.min' => 'Product price must be positive.',
        ];
    }
}
