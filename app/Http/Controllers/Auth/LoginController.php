<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Rules\SocialLogin;
use App\Services\UserAuthenticatedService;
use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
        if (!config('auth.user_list')) {
            return redirect()->route('login');
        }

        Auth::login($user, true);
        return $this->sendLoginResponse($request);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginAs(Request $request)
    {
        if (!config('auth.user_list')) {
            return redirect()->route('login');
        }

        $user = User::where('id', $request->get('user'))->first();
        Auth::login($user, true);
        return $this->sendLoginResponse($request);
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

    /**
     * Make sure a social login can't log in with a password
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => [
                'required',
                'string',
                new SocialLogin()
            ],
            'password' => 'required|string',
        ]);
    }
}
