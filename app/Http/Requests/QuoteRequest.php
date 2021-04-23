<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuoteRequest extends FormRequest
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
            'customer_name' => 'required|string',
            'customer_email' => 'required|email',
        ];
    }

    /**
     * Messages to display when validation rules fail.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'customer_name.required' => 'Customer name must not be blank.',
            'customer_name.string' => 'Customer name should be text.',
            'customer_email.required' => 'Customer email must not be blank.',
            'customer_email.email' => 'Customer email is not a valid email address.',
        ];
    }
}
