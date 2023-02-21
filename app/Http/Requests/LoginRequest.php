<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;

class LoginRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'login_code' => 'required',
            'password' => 'required'
        ];
    }

    public function getCredentials()
    {
        // The form field for providing username or password
        // have name of "username", however, in order to support
        // logging users in with both (username and email)
        // we have to check if user has entered one or another
        $email = $this->get('login_code');
//        if ($this->isEmail($email)) {
//            return [
//                'email' => $email,
//                'password' => $this->get('password')
//            ];
//        }

        return $this->only('login_code', 'password');
    }

    /**
     * Validate if provided parameter is valid email.
     *
     * @param $param
     * @return bool
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function isEmail($param)
    {
        $factory = $this->container->make(ValidationFactory::class);

        return ! $factory->make(
            ['login_code' => $param],
            ['login_code' => 'login_code']
        )->fails();
    }
}
