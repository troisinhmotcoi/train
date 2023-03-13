<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Contracts\Validation\Validator;


class UserNonCreateRequest extends FormRequest

{

    public function rules(Request $request)

    {
        return [
            'start_eq' => 'date',
            'end_eq' => 'date',
            'login_code' => 'exists:user_mst,login_code',
            'user_regist_date' => 'date',
            'user_id' => 'exists:user_mst,user_id',
            'password_re' => 'same:password'

        ];

    }


    public function failedValidation(Validator $validator)

    {

        throw new HttpResponseException(response()->json([

            'message' => 'Validation errors',

            'data' => $validator->errors()

        ],422));

    }



//    public function messages()
//
//    {
//
//
//
//    }

}
