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
            'user_mail' => 'email',
            'approval_user_flag' => 'in:0,1',
            'file_share_approval_flag' => 'in:0,1',
            'ip_restriction_use_flag' => 'in:0,1',
            'language_id' => 'min:2|max:2',
            'auth_group_id' => "exist:auth_group_mst,auth_group_id",
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
