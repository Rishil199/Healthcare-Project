<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReceptionistRequest extends FormRequest
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
            'first_name' => 'required|regex: /^[A-Z]{2,30}+$/i',
            'last_name' => 'required|regex: /^[A-Z]{2,30}+$/i',
            'email' => 'required|email|unique:users,email',
            'phone_no' => 'required|min:10|max:16|regex:/^[+\-\d]+$/',
            'birth_date' => 'required|before:today|regex:/\d{1,2}\/\d{1,2}\/\d{4}/',
            'gender' => 'required',
            'qualification' => 'required',
            'experience' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Staff first name is required.',
            'first_name.regex'=> 'Staff first name is invalid.',
            'last_name.required' => ' Staff last name is required.',
            'last_name.regex'=> 'Staff last name is invalid.',
            'email.required'=> 'Staff email is required.',
            'email.unique'=> 'Staff email is already taken.',
            'phone_no.required'=> 'Staff contact number is required.',
            'birth_date.required'=> 'Staff birth date is required.',
            'birth_date.before'=>'Staff birth date must be date before today',
            'gender.required'=>'Staff gender is required.',
            'qualification.required'=>'Staff qualification is required.',
            'experience.required'=>'Staff experience is required.'

        ];
    }
}
