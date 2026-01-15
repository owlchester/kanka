<?php

namespace App\Http\Controllers\Auth;

use App\Enums\ReferralEventType;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Referrals\JoinService;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class AuthController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected JoinService $referralService)
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the service authentication page.
     *
     * @param  string  $provider
     */
    public function redirectToProvider($provider)
    {
        if (! in_array($provider, ['facebook', 'twitter', 'google'])) {
            return redirect()->route('login');
        }
        try {
            return Socialite::driver($provider)->redirect();
        } catch (Exception $e) {
            return redirect()->route('login')->withErrors('Error contacting ' . ucfirst($provider) . '.');
        }
    }

    /**
     * Obtain the user information from provider.  Check if the user already exists in our
     * database by looking up their provider_id in the database.
     * If the user exists, log them in. Otherwise, create a new user then log them in. After that
     * redirect them to the authenticated user's homepage.
     *
     * @param  string  $provider
     */
    public function handleProviderCallback($provider)
    {
        try {
            // Twitter uses Oauth1 and doesn't support stateless
            if ($provider == 'twitter') {
                $user = Socialite::driver($provider)->user();
            } else {
                // @phpstan-ignore-next-line
                $user = Socialite::driver($provider)->stateless()->user();
            }

            $authUser = $this->findOrCreateUser($user, $provider);
            Auth::login($authUser, true);

            return redirect()->route('home');
        } catch (Exception $ex) {
            // Send the exception to Sentry
            //            if (app()->bound('sentry')) {
            //                app('sentry')->captureException($ex);
            //            }

            if ($ex->getCode() == '1') {
                return redirect()->route('login')->with('error', __('auth.register.errors.email_already_taken'));
            } else {
                return redirect()->route('register')->with('error', __('auth.register.errors.general_error'));
            }
        }
    }

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     *
     * @param  mixed  $user  Socialite user object
     * @param  mixed  $provider  Social auth provider
     * @return User
     */
    public function findOrCreateUser(mixed $user, mixed $provider)
    {
        $authUser = User::where('provider_id', $user->id)->first();
        if ($authUser) {
            return $authUser;
        }

        // Make sure the email doesn't already exist
        $emailExists = User::where('email', $user->email)->first();
        if ($emailExists) {
            throw new Exception('', 1);
        }

        // Only allow creating if it's set that way
        if (! config('auth.register_enabled')) {
            throw new AccessDeniedHttpException('ACCOUNT REGISTRATION DISABLED');
        }

        $referrer = $this->referralService->referrer();
        $authUser = User::create([
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->email,
            'provider' => $provider,
            'provider_id' => $user->id,
            'referred_by' => $referrer,
        ]);
        $this->referralService->event($authUser, ReferralEventType::register);

        // Call the registered event
        event(new Registered($authUser));

        return $authUser;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // We also need to flush the session (campaign_id and other things) since this could cause
        // weird behaviour if the user registers a new account.

        $request->session()->flush();

        return redirect()->route('login');
    }
}
