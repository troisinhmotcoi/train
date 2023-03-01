<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function show(Request $request)
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->getCredentials();

        $authenticated = Auth::attempt($credentials);

        if ($authenticated) {
            $user = Auth::getProvider()->retrieveByCredentials($credentials);

            $this->authenticated($request, $user);
        }
        Session::flash('error', 'The login information is incorrect');


        return redirect()->route('login');
    }

    public function get_token(LoginRequest $request)
    {
        $credentials = $request->getCredentials();

        $authenticated = Auth::attempt($credentials);

        if ($authenticated) {
            $user = Auth::getProvider()->retrieveByCredentials($credentials);

            $token = $user->createToken($request->login_code)->plainTextToken;
            return response()->json(
                [
                    'access_token' => $token
                ], 200
            );
        } else
            return 'not authenticated';


    }

    /**
     * Handle response after user authenticated
     *
     * @param Request $request
     * @param Auth $user
     *
     * @return \Illuminate\Http\Response
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect()->intended();
    }
}
