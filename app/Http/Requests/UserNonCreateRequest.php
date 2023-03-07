<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Contracts\Validation\Validator;


class UserNonCreateRequest extends FormRequest

{

    public function rules()

    {

        return [
            'start_eq' => 'date',
            'end_eq' => 'date',
            'login_code' => 'exists:user_mst,login_code',
            'user_regist_date' => 'date',




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
