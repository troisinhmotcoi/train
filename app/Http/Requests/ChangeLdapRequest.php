<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;


class ChangeLdapRequest extends FormRequest

{

    public function rules()
    {

        return [
            'ldap_id' => ['required',
                'exists:ldap_mst,ldap_id',
            ],
            'ids.*' => 'exists:ldap_mst,ldap_id'

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
