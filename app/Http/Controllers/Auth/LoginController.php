<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function authenticate(Request $request)
    {
        $credentials = $request->only('cedula', 'password');
        dump($credentials);
        die();
        if (Auth::attempt($credentials)) {
            dump("buena");
            die();
            // Authentication passed...
            //var_dump("buena hp");
            return redirect()->intended('/');
        }
    }


    
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
}
