<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\UserAuthenticatedService;
use App\User;
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

    public UserAuthenticatedService $userAuthService;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserAuthenticatedService $userAuthService)
    {
        $this->middleware('guest')->except('logout');
        $this->userAuthService = $userAuthService;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginAsUser(Request $request, User $user)
    {
        if (config('auth.user_list')) {
            Auth::login($user, true);

            return $this->sendLoginResponse($request);
        }
        return redirect()->route('login');
    }

    protected function authenticated(Request $request, $user)
    {
        $response = $this->userAuthService->authenticated($user);
        return $response;
    }

    protected function redirectTo(Request $request): string
    {
        return route('home');
    }
}
