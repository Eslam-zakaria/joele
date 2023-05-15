<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'name' => ['required', 'max:60'],
            'username' => ['required', 'max:60'],
            'email' => ['required', 'email', 'max:100'],
            'password' => ['nullable', 'min:8', 'max:255', 'confirmed'],
        ];
    }
}
