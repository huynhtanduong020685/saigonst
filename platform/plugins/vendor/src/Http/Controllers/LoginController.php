<?php

namespace Botble\Vendor\Http\Controllers;

use App\Http\Controllers\Controller;
use Botble\ACL\Traits\LogoutGuardTrait;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use SeoHelper;
use URL;

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

    use AuthenticatesUsers, LogoutGuardTrait {
        attemptLogin as baseAttemptLogin;
    }

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    public $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @return void
     *
     */
    public function __construct()
    {
        session(['url.intended' => URL::previous()]);
        $pages = [route('public.vendor.login'), route('public.single'), route('public.vendor.register')];

        if (in_array(session()->get('url.intended'), $pages)) {
            $this->redirectTo = route('public.vendor.dashboard');
        } else {
            $this->redirectTo = session()->get('url.intended');
        }
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     *
     */
    public function showLoginForm()
    {
        SeoHelper::setTitle(trans('plugins/vendor::vendor.login'));
        return view('plugins/vendor::auth.login');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     *
     */
    protected function guard()
    {
        return Auth::guard('vendor');
    }

    /**
     * @param  \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Illuminate\Validation\ValidationException
     *
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return bool
     * @throws ValidationException
     *
     */
    protected function attemptLogin(Request $request)
    {
        if ($this->guard()->validate($this->credentials($request))) {
            $vendor = $this->guard()->getLastAttempted();

            if (config('plugins.vendor.general.verify_email') && empty($vendor->confirmed_at)) {
                throw ValidationException::withMessages([
                    'confirmation' => [
                        trans('plugins/vendor::vendor.not_confirmed', [
                            'resend_link' => route('public.vendor.resend_confirmation', ['email' => $vendor->email]),
                        ]),
                    ],
                ]);
            }

            return $this->baseAttemptLogin($request);
        }
        return false;
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $activeGuards = 0;
        $this->guard()->logout();

        foreach (config('auth.guards', []) as $guard => $guardConfig) {
            if ($guardConfig['driver'] !== 'session') {
                continue;
            }
            if ($this->isActiveGuard($request, $guard)) {
                $activeGuards++;
            }
        }

        if (!$activeGuards) {
            $request->session()->flush();
            $request->session()->regenerate();
        }

        return $this->loggedOut($request) ?: redirect('/');
    }
}
