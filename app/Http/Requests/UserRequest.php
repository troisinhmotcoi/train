<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Contracts\Validation\Validator;


class UserRequest extends FormRequest

{

    public function rules()

    {

        return [
            'user_name' => 'required',
            'company_id' => 'required|digits:4',
            'auth_group_id' => 'required|digits:3',
            'password_change_date' => 'date',
            'login_code' => 'unique:user_mst'



        ];

    }


    public function failedValidation(Validator $validator)

    {

        throw new HttpResponseException(response()->json([

            'success' => false,

            'message' => 'Validation errors',

            'data' => $validator->errors()

        ]));

    }



//    public function messages()
//
//    {
//
//
//
//    }

}
