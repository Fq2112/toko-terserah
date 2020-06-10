<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Support\Facades\GlobalAuth;
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectTo()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard')->with('signed', 'Anda telah masuk.Username/email atau password Anda salah.');
        } else {
            return back()->with('signed', 'Anda telah masuk.');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['guest:admin', 'guest:web'])->except('logout');
    }

    /**
     * Perform login process for users & admins
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        if (GlobalAuth::login(['useremail' => $request->useremail, 'password' => $request->password], $request)) {
            if (session()->has('intended')) {
                session()->forget('intended');
            }

            return $this->redirectTo();
        }

        return back()->withInput($request->all())->with([
            'error' => 'Username/email atau password Anda salah.'
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request->session()->invalidate();

        GlobalAuth::logout();

        return redirect()->route('beranda')->with('logout', 'Anda telah keluar.');
    }
}
