<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Contracts\Validation\Validator;


class DesignRequest extends FormRequest

{

    public function rules()

    {

        return [
            'logo_login_ext' => 'required',
            'logo_login_e_ext' => 'required',
            'logo_header_ext' => 'required',
            'top_background_color' => 'required',
            'header_background_color' => 'required',



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
