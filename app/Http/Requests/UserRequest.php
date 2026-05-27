<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            "username"=>["required","unique:users,username","min:4","max:50"],
            "first_name" => ["required","min:3","max:50"],
            "last_name" => ["required","min:3","max:50"],
            "email"=>["required","email"],
            "password"=>["required","min:8"],
            "user_type"=>["required","min:4"],
        ];
    }
}
