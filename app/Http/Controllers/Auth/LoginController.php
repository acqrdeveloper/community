<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['guest'])->except('logout');
    }

    public function fnDoLogin(Request $request)
    {
        // Session super-admin = false
//        session(['super_admin' => false]);

        // Process login
        $credentials = $request->only(['email', 'password']);
        $rememberme = $request->has('rememberme') ? true : false;
        if ($this->guard()->attempt($credentials, $rememberme)) {
            if (auth()->once($credentials)) {
                switch (auth()->user()->estado) {
                    case 'I':
                        $this->guard()->logout();
                        $request->session()->invalidate();
                        return redirect()->to('/login')->withInput()->withErrors('Your session has expired because your account is deactivated.');
                        break;
                    default:

                        $request->session()->regenerate();
                        $this->clearLoginAttempts($request);
/*
                        // Load tipo usuario
                        $type_user = (new User)->join('type_user', 'type_user.id', '=', 'users.id_type_user')->where('users.id_type_user', auth()->user()->id_type_user)->first(['type_user.id', 'type_user.name', 'type_user.roles']);
                        // Process session
                        if (count(json_decode($type_user->roles))) {
                            $rols = $type_user->roles;
                        } else {
                            $rols = '{}';
                        }
                        $session_roles = json_decode($rols);
                        // Create sessions
                        session(['session_roles' => $session_roles]);
                        session(['session_type_user' => $type_user]);

                        // Session super-admin = true
                        if ($type_user->id == 1)
                            session(['super_admin' => true]);
*/
                        // Redirect page login
                        return $this->authenticated($request, $this->guard()->user()) ?: redirect()->to($this->redirectTo);
                        break;
                }
            }
        }
        return redirect()->back()->withInput()->withErrors(trans('auth.failed'));
    }

    public function fnDoLogout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        return redirect()->to('/login');
    }
}
