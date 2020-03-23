<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthorizationRequest extends FormRequest
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
        $rules = [
            'account' => 'required|string',
            'password' => 'required|alpha_dash|min:3',
        ];

        if (config('app.image_captcha')) {
            $rules['captcha_key'] = 'required|string';
            $rules['captcha_code'] = 'required|string';
        }

        return $rules;
    }

}
