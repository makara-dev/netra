<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

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

    public function showDashboardLogin()
    {
        session()->put('url.intended', url()->previous());
        return view('dashboard.auth.login');
    }

    /**
     * authenticate staff login
     * with user name
     */
    public function dashboardLogin(Request $request)
    {
        //prevent bruteforce attack (throttling) 
        if (
            method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)
        ) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        //authenticate
        $login = $this
            ->guard()
            ->attempt($request->only('name', 'password'), $request->filled('remember'));

        //success
        if ($login) {
            $url = session('url.intended');
            session()->forget('url.intended');

            //redirect to dashboard index
            if ($url == URL::route('home') || empty($url) || URL::route('dashboard_login')) {
                return redirect('dashboard')->with('success', 'Logged In.');
            }
            //redirect to intended path
            return redirect($url)->with('success', 'Logged In.');
        }

        //fail
        $this->incrementLoginAttempts($request);
        return redirect()->back()->with('error', 'Login fail, check username and password');
    }

    /**
     * Handle user login
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (
            method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)
        ) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            //restore cart session for customer
            $customer = auth()->user()->customer;
            if (!empty($customer)) {
                $customer->shoppingCart();
            }
            return $this->sendLoginResponse($request)->with('success', "Logged in successfully.");
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();


        return $this->loggedOut($request) ?: redirect()->route('home')->with('success', 'Logged out successfully.');
    }
}
