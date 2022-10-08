<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;

class RegisterRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['string', 'nullable'],
            'password' => ['string', 'min:6', 'required', 'confirmed'],
            'email' => ['string', 'email', 'unique:users,email'],
            'role' => ['nullable'],
            'avatar' => ['image', 'nullable'],
        ];
    }
}
