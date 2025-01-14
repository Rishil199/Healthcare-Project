<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeUserRequest extends FormRequest
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
            'first_name' => 'required|regex: /^[a-zA-Z ]{2,30}$/',
            'last_name' => 'required|regex: /^[a-zA-Z ]{2,30}$/',
            'email' => 'required|email|unique:users|regex: /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i',
            'roles_type' => 'required',
        ];
    }
}
