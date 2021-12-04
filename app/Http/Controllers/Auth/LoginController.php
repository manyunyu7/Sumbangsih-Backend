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
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function proceedLogin(Request $request)
    {
        $this->validate($request, [
            'contact'   => 'required',
            'password' => 'required|min:6'
        ]);

        if (Auth::attempt(
            [
                'contact' => $request->contact,
                'password' => $request->password
            ],
            $request->get('remember')
        )) {
            return redirect()->intended('/home');
        } else {
            return redirect('login')->withErrors([
                'error' => 'Username Atau Password Salah (Admin)'
            ]);
        }

        return back()->withInput($request->only('uname', 'remember'));
    }

}
