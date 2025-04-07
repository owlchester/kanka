<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\AccountEmail;
use App\Rules\AccountName;
use App\Rules\Recaptcha;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    use RegistersUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('login.redirect');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255', 'min:2', new AccountName],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users', new AccountEmail],
            'password' => ['required', 'string', 'min:8'],
        ];
        if (config('auth.recaptcha.enabled')) {
            $rules['g-recaptcha-response'] = ['required', 'string', new Recaptcha];
        }

        return Validator::make($data, $rules);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    protected function redirectTo(): string
    {
        return route('home');
    }
}
