<?php

namespace Rafni\Auth\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Rafni\Auth\Exceptions\ForbiddenUserException;

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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth::auth.login');
    }
    
    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }
    
    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     * 
     * @throws \App\Exceptions\Auth\ForbiddenUserException
     */
    protected function attemptLogin(Request $request)
    {
        $attemp = $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
        $guard = $this->guard();
        if ($attemp && ! $guard->user()->enabled_access) {
            $guard->logout();
            throw new ForbiddenUserException('Forbidden user', $guard);
        }
        return $attemp;
    }
    
    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        return back()->getTargetUrl();
    }
}
